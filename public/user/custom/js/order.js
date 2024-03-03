(function ($) {
    "use strict";

    $(document).ready(function () {
        allOrderDataTable('all')
    });


    $(document).on('click', '.order-action', function (e) {
        var status = $(this).data('order');
        allOrderDataTable(status)
    });

    function allOrderDataTable(status) {
        $("#orderDataTable" + status).DataTable({
            pageLength: 10,
            ordering: false,
            serverSide: true,
            processing: true,
            searching: false,
            responsive: {
                breakpoints: [
                    { name: "desktop", width: Infinity },
                    { name: "tablet", width: 1400 },
                    { name: "fablet", width: 768 },
                    { name: "phone", width: 480 },
                ],
            },
            ajax: {
                url: $('#ordersAllRoute').val(),
                data: function (d) {
                    d.status = status;
                }
            },
            language: {
                paginate: {
                    previous: "<i class='fa-solid fa-angles-left'></i>",
                    next: "<i class='fa-solid fa-angles-right'></i>",
                },
                searchPlaceholder: "Search pending event",
                search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
            },
            dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
            columns: [
                { "data": "customer_name" },
                { "data": "email" },
                { "data": "product_name" },
                { "data": "plan_name" },
                { "data": "gateway" },
                { "data": "amount" },
                { "data": "created_at" },
                { "data": "status" },
                { "data": "action", responsivePriority: 2 },
            ],
            stateSave: true,
            "bDestroy": true
        });

    }

})(jQuery)
