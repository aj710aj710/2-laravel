(function ($) {
    "use strict";
    $("#subscriptionDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: false,
        ajax: {
            url: $('#subscription-list-route').val(),
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
            {"data": "email", "name": "email", responsivePriority: 1},
            {"data": "product_name", "name": "product_name"},
            {"data": "plan", "name": "plan"},
            {"data": "start_date", "name": "start_date"},
            {"data": "end_date", "name": "end_date"},
            {"data": "status", "name": "status"},
            {"data": "amount", "name": "amount", responsivePriority: 2},
        ],
    });

    $('#product-id').on('change', function () {
        commonAjax('GET', $('#plan-route').val(), planResByProId, planResByProId, {'id': $(this).val()});
    });

    function planResByProId(response) {
        if (response.status) {
            $("#plan-filter").html(response.data);
            $("#subscriptionDataTable").DataTable().ajax.reload();
        } else {
            $("#plan-filter").html();
        }
    }

    $(document).on('change', '#plan-filter', function () {
        $("#subscriptionDataTable").DataTable().ajax.reload();
    });

})(jQuery)
