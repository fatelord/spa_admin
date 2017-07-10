$(function () {
    var $salon_id = $('#salon_id').val();
    var $url = 'modules/services.php?salon_id=' + $salon_id;
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
            {name: "SERVICE_ID", type: "text", visible: false},
            {name: "SALON_NAME", title: "Salon/Spa Name", type: "text"},
            {name: "SERVICE_NAME", title: "Service", type: "text"},
            {name: "SERVICE_COST", title: "Cost", type: "number"},
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

    $("#detailsDialog").dialog({
        autoOpen: false,
        draggable: true,
        //position: 'center',
        width: 500,
        height: 'auto',
        modal: true,
        open: function (event, ui) {
            $('#detailsDialog').css('overflow', 'hidden'); //this line does the actual hiding
            $("#SALON_ID").val($salon_id);
        },
        close: function () {
            $("#detailsForm").validate().resetForm();
            $("#detailsForm").find(".error").removeClass("error");
        }
    });

    $("#detailsForm").validate({
        rules: {
            SERVICE_NAME: "required",
            SERVICE_COST: "required",
        },
        submitHandler: function () {
            formSubmitHandler();
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function (dialogType, client) {
        $("#SALON_ID").val(client.SALON_ID);
        $("#SALON_NAME").val(client.SALON_NAME);
        $("#SERVICE_NAME").val(client.SERVICE_NAME);
        $("#SERVICE_COST").val(client.SERVICE_COST);


        formSubmitHandler = function () {
            saveClient(client, dialogType === "Add");
        };


        $("#detailsDialog").dialog("option", "title", dialogType + " Service")
            .dialog("open");
        //$("#detailsDialog").modal("show");

    };

    var saveClient = function (client, isNew) {

        $.extend(client, {
            SALON_ID: $("#SALON_ID").val(),
            SERVICE_NAME: $("#SERVICE_NAME").val(),
            SERVICE_COST: $("#SERVICE_COST").val(),
        })
        ;

        $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

        $("#detailsDialog").dialog("close");
        // $("#detailsDialog").modal("hide");
    };
});
