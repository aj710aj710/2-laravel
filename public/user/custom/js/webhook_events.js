(function ($) {
    "use strict";
    $("#webHookEventsTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: {
            breakpoints: [
                { name: "desktop", width: Infinity },
                { name: "tablet", width: 1400 },
                { name: "fablet", width: 768 },
                { name: "phone", width: 480 },
            ],
        },
        searching: false,
        ajax: {
            url: $('#webhookEventTableRoute').val(),
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
            {"data": "event_id", "name": "event_id"},
            {"data": "webhook_url", "name": "webhook_url"},
            {"data": "event_type", "name": "event_type"},
            {"data": "product_name", "name": "product_name"},
            {"data": "plan_name", "name": "plan_name"},
            {"data": "status", "name": "status"},
            {"data": "created_at", "name": "created_at"},
        ],
    });

    $('#product-id').on('change', function () {
        commonAjax('GET', $('#plan-route').val(), planResByProId, planResByProId, {'id': $(this).val()});
    });

    function planResByProId(response) {
        console.log(response);
        if (response.status) {
            $("#plan-filter").html(response.data);
            $("#webHookEventsTable").DataTable().ajax.reload();
        } else {
            $("#plan-filter").html();
        }
    }
    $(document).on('change', '#plan-filter', function () {
        $("#webHookEventsTable").DataTable().ajax.reload();
    });

})(jQuery)

