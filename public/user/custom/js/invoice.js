(function ($) {
    "use strict";
    $("#invoiceDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: false,
        ajax: {
            url: $('#invoice-list-route').val(),
            data: function (d) {
                d.product_id = $('#product-id').val();
                d.plan_id = $('#plan-filter').val();
            }
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',

        columns: [
            { "data": "invoice_id", "name": "invoice_id", responsivePriority: 1 },
            { "data": "subscription_id_name", "name": "subscription_id_name" },
            { "data": "customer_email", "name": "customer_email" },
            { "data": "product_name", "name": "product_name" },
            { "data": "plan_name", "name": "plan_name" },
            { "data": "amount", "name": "amount" },
            { "data": "created_at", "name": "created_at" },
            { "data": "status", "name": "status" },
            { "data": "action", "name": "action", responsivePriority: 2 },
        ],
    });
    $('#product-id').on('change', function () {
        commonAjax('GET', $('#plan-route').val(), planResByProId, planResByProId, { 'id': $(this).val() });
    });

    function planResByProId(response) {
        if (response.status) {
            $("#plan-filter").html(response.data);
            $("#invoiceDataTable").DataTable().ajax.reload();
        } else {
            $("#plan-filter").html();
        }
    }

    $(document).on('change', '#plan-filter', function () {
        $("#invoiceDataTable").DataTable().ajax.reload();
    });

    $(document).on('click', '.invoice-view-action', function () {
        commonAjax('GET', $('#invoice-view-route').val(), invoiceViewResponse, invoiceViewResponse, { id: $(this).data('id') });
    });

    function invoiceViewResponse(response) {
        if (response.status) {
            $("#invoice-data-view").html(response.data);
        } else {
            $("#invoice-data-view").html();
        }
    }

})(jQuery)
