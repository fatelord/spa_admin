$(function () {
    var $url = 'modules/spa.php';

    $("#jsGrid").jsGrid({
        width: "100%",
        height: "auto",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 20,
        pageButtonCount: 5,
        deleteConfirm: function(item) {
            return "The SPA \"" + item.SPA_NAME + "\" will be removed. Are you sure?";
        },
        rowClick: function(args) {
            showDetailsDialog("Edit", args.item);
            // console.log(args.item);
        },
        controller: {
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
        },
        fields: [
            //{name: "SPA_ID", title: "ID", type: "number", width: 50, filtering: false},
            {name: "SPA_NAME", title: "Spa Name", type: "text", width: 150},
            {name: "SPA_TEL", title: "Telephone",filtering: false, type: "text", width: 150},
            {name: "SPA_LOCATION", title: "Location", filtering: false, type: "text", width: 200},
            {name: "SPA_WEBSITE", title: "Website", filtering: false, type: "text", width: 150},
            //{name: "SPA_ID", type: "checkbox", title: "Is Married", sorting: false, filtering: false},
            //{type: "control"}
            {
                type: "control",
                modeSwitchButton: false,
                editButton: false,
                headerTemplate: function() {
                    return $("<button>").attr("type", "button").text("Add")
                        .on("click", function () {
                            showDetailsDialog("Add", {});
                        });
                }
            }
        ]
    });

//dialogs for editing and addition of spas

    $("#detailsDialog").dialog({
        autoOpen: false,
        width: 400,
        close: function() {
            $("#detailsForm").validate().resetForm();
            $("#detailsForm").find(".error").removeClass("error");
        }
    });

    $("#detailsForm").validate({
        rules: {
            name: "required",
            age: { required: true, range: [18, 150] },
            address: { required: true, minlength: 10 },
            country: "required"
        },
        messages: {
            name: "Please enter name",
            age: "Please enter valid age",
            address: "Please enter address (more than 10 chars)",
            country: "Please select country"
        },
        submitHandler: function() {
            formSubmitHandler();
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function(dialogType, client) {
        console.log(client);
        $("#name").val(client.SPA_NAME);
        $("#age").val(client.SPA_TEL);
        $("#address").val(client.SPA_LOCATION);
        $("#country").val(client.SPA_WEBSITE);
        //$("#married").prop("checked", client.Married);

        formSubmitHandler = function() {
            saveClient(client, dialogType === "Add");
        };

        $("#detailsDialog").dialog("option", "title", dialogType + " Client")
            .dialog("open");
    };

    var saveClient = function(client, isNew) {
        $.extend(client, {
            Name: $("#name").val(),
            Age: parseInt($("#age").val(), 10),
            Address: $("#address").val(),
            Country: parseInt($("#country").val(), 10),
            Married: $("#married").is(":checked")
        });

        $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

        $("#detailsDialog").dialog("close");
    };
});