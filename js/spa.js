$(function () {
    var $url = 'modules/spa.php';
    var $delete_url = 'modules/spa_delete.php';
    var db = {
        loadData: function (filter) {
            return $.ajax({
                type: "GET",
                url: $url,
                data: filter
            });
        },
        insertItem: function (item) {
            return $.ajax({
                type: "POST",
                url: $url,
                data: item
            });
        },
        updateItem: function (item) {
            return $.ajax({
                type: "POST",
                url: $url,
                data: item
            });
        },
        deleteItem: function (item) {
            return $.ajax({
                type: "POST",
                url: $delete_url,
                data: item
            });
        }
    };

    $("#jsGrid").jsGrid({
        height: "auto",
        width: "100%",
        editing: true,
        autoload: true,
        paging: true,
        deleteConfirm: function (item) {
            return "The Entry for \"" + item.SALON_NAME + "\" will be removed. Are you sure?";
        },
        rowClick: function (args) {
            //showDetailsDialog("Edit", args.item);
        },
        controller: db,
        fields: [
            {name: "SALON_ID", type: "text", visible: false},
            {
                name: "SALON_IMAGE",
                title: "Image",
                itemTemplate: function (val, item) {
                    return $("<img>").attr("src", val).css({height: 50, width: 50}).on("click", function () {
                        $("#imagePreview").attr("src", item.SALON_IMAGE);
                        $("#dialog").dialog("open");
                    });
                },
                align: "center",
                //width: 120
            },
            {name: "SALON_NAME", title: "Name", type: "text"},
            {name: "SALON_TEL", title: "Telephone", type: "text"},
            {name: "SALON_EMAIL", title: "Email", type: "text"},
            {name: "SALON_WEBSITE", title: "Website", type: "text"},
            {name: "SALON_LOCATION", title: "Location", type: "text"},
            //{name: "SALON_IMAGE", title: "Image", type: "text"},
            {name: "SALON_MAP_COORD", title: "Map", type: "text", visible: false},
            {
                type: "control",
                modeSwitchButton: false,
                editButton: false,
                deleteButton: false,
                itemTemplate: function (value, item) {
                    return $("<button>")
                        .attr("type", "button")
                        .attr("class","btn btn-warning btn-xs btn-block")
                        .text("Edit")
                        .on("click", function () {
                            showDetailsDialog("Edit", item);
                        });
                }
            },
            {
                type: "control",
                modeSwitchButton: false,
                deleteButton: false,
                editButton: false,
                itemTemplate: function (value, item) {
                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                    var $customButton = '<a class="btn btn-success btn-xs btn-block" href="spa_services.php?id=' + item.SALON_ID + '">Services</a>';
                    return $result.add($customButton);
                }
            },
            {
                type: "control",
                modeSwitchButton: false,
                editButton: false,
                headerTemplate: function () {
                    return $("<button>").attr("type", "button").text("Add")
                        .on("click", function () {
                            showDetailsDialog("Add", {});
                        });
                }
            }
        ]
    });

    $("#dialog").dialog({
        modal: true,
        autoOpen: false,
        height: 'auto',
        open: function (event, ui) {
            $('#dialog').css('overflow', 'hidden'); //this line does the actual hiding
        },
    });

    $("#detailsDialog").dialog({
        autoOpen: false,
        draggable: true,
        //position: 'center',
        width: 500,
        height: 'auto',
        modal: true,
        open: function (event, ui) {
            $('#detailsDialog').css('overflow', 'hidden'); //this line does the actual hiding
        },
        close: function () {
            $("#detailsForm").validate().resetForm();
            $("#detailsForm").find(".error").removeClass("error");
        }
    });

    $("#detailsForm").validate({
        rules: {
            SALON_NAME: "required",
            SALON_LOCATION: "required",
            SALON_TEL: "required",
            //age: {required: true, range: [18, 150]},
            //address: {required: true, minlength: 10},
        },
        messages: {
            SALON_NAME: "Please enter a valid Spa/Salon name",
            SALON_LOCATION: "Please indicate location",
            SALON_TEL: "Please provide a telephone number",
        },
        submitHandler: function () {
            formSubmitHandler();
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function (dialogType, client) {
        $("#SALON_NAME").val(client.SALON_NAME);
        $("#SALON_EMAIL").val(client.SALON_EMAIL);
        $("#SALON_LOCATION").val(client.SALON_LOCATION);
        $("#SALON_TEL").val(client.SALON_TEL);
        $("#SALON_WEBSITE").val(client.SALON_WEBSITE);
        $("#SALON_IMAGE").val(client.SALON_IMAGE);
        $("#SALON_MAP_COORD").val(client.SALON_MAP_COORD);


        formSubmitHandler = function () {
            saveClient(client, dialogType === "Add");
        };


        $("#detailsDialog").dialog("option", "title", dialogType + " Salon/Spa")
            .dialog("open");
        //$("#detailsDialog").modal("show");

    };

    var saveClient = function (client, isNew) {
        var data = {
            SALON_NAME: $("#SALON_NAME").val(),
            SALON_EMAIL: $("#SALON_EMAIL").val(),
            SALON_LOCATION: $("#SALON_LOCATION").val(),
            SALON_TEL: $("#SALON_TEL").val(),
            SALON_WEBSITE: $("#SALON_WEBSITE").val(),
            SALON_IMAGE: $("#SALON_IMAGE").val(),
            SALON_MAP_COORD: $("#SALON_MAP_COORD").val()
        };
        $.extend(client, data);

        $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

        $("#detailsDialog").dialog("close");
        // $("#detailsDialog").modal("hide");
    };
});
