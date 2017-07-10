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
                url: "/clients/",
                data: item
            });
        },
        updateItem: function (item) {
            return $.ajax({
                type: "PUT",
                url: "/clients/",
                data: item
            });
        },
        deleteItem: function (item) {
            return $.ajax({
                type: "DELETE",
                url: "/clients/",
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
            return "The Entry for \"" + item.SPA_NAME + "\" will be removed. Are you sure?";
        },
        rowClick: function (args) {
            showDetailsDialog("Edit", args.item);
        },
        controller: db,
        fields: [
            {name: "SPA_ID", type: "text", visible: false},
            {name: "SPA_NAME", title: "Name", type: "text"},
            {name: "SPA_TEL", title: "Telephone", type: "text"},
            {name: "SPA_EMAIL", title: "Email", type: "text"},
            {name: "SPA_WEBSITE", title: "Website", type: "text"},
            {name: "SPA_LOCATION", title: "Location", type: "text"},
            {name: "SPA_IMAGE", title: "Image", type: "text"},
            {name: "SPA_MAP_COORD", title: "Map", type: "text",visible:false},
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

    /*$("#detailsDialog").dialog({
     autoOpen: false,
     width: 400,
     close: function() {
     $("#detailsForm").validate().resetForm();
     $("#detailsForm").find(".error").removeClass("error");
     }
     });*/

    $("#detailsForm").validate({
        rules: {
            name: "required",
            age: {required: true, range: [18, 150]},
            address: {required: true, minlength: 10},
            country: "required"
        },
        messages: {
            name: "Please enter name",
            age: "Please enter valid age",
            address: "Please enter address (more than 10 chars)",
            country: "Please select country"
        },
        submitHandler: function () {
            formSubmitHandler();
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function (dialogType, client) {
        $("#SPA_NAME").val(client.SPA_NAME);
        $("#SPA_EMAIL").val(client.SPA_EMAIL);
        $("#SPA_LOCATION").val(client.SPA_LOCATION);
        $("#SPA_TEL").val(client.SPA_TEL);
        $("#SPA_WEBSITE").val(client.SPA_WEBSITE);
        $("#SPA_IMAGE").val(client.SPA_IMAGE);
        $("#SPA_MAP_COORD").val(client.SPA_MAP_COORD);


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

});
