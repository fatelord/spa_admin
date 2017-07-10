$(function () {
    var $url = 'modules/spa.php';
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
                type: "PUT",
                url: $url,
                data: item
            });
        },
        deleteItem: function (item) {
            return $.ajax({
                type: "DELETE",
                url: $url,
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
            showDetailsDialog("Edit", args.item);
        },
        controller: db,
        fields: [
            {name: "SALON_ID", type: "text", visible: false},
            {name: "SALON_NAME", title: "Name", type: "text"},
            {name: "SALON_TEL", title: "Telephone", type: "text"},
            {name: "SALON_EMAIL", title: "Email", type: "text"},
            {name: "SALON_WEBSITE", title: "Website", type: "text"},
            {name: "SALON_LOCATION", title: "Location", type: "text"},
            {name: "SALON_IMAGE", title: "Image", type: "text"},
            {name: "SALON_MAP_COORD", title: "Map", type: "text", visible: false},
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

    /*$("#detailsForm").validate({
        rules: {
            SALON_NAME: "required",
            SALON_LOCATION: "required",
            SALON_TEL: "required",
            //age: {required: true, range: [18, 150]},
            //address: {required: true, minlength: 10},
        },
        messages: {
            SALON_NAME: "Please enter a valid Sa/Salon name",
            SALON_LOCATION: "Please indicate location",
            SALON_TEL: "Please provide a telephone number",
        },
        submitHandler: function () {
            formSubmitHandler();
        }
    });*/

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

        //$("#detailsDialog").dialog("option", "title", dialogType + " Client").dialog("open");
        $("#detailsDialog").modal("show");

    };

    var saveClient = function (client, isNew) {

        $.extend(client, {
            Name: $("#name").val(),
            Age: parseInt($("#age").val(), 10),
            Address: $("#address").val(),
            Country: parseInt($("#country").val(), 10),
            Married: $("#married").is(":checked")
        });

        $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

        //$("#detailsDialog").dialog("close");
        $("#detailsDialog").modal("hide");
    };

    //bootstrap modal calllbcaks
    $("#detailsDialog").on('hidden.bs.modal', function () {
        $("#detailsForm").validate().resetForm();
        $("#detailsForm").find(".error").removeClass("error");
    });
});
