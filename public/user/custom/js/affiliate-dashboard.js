(function ($) {
    ("use strict");
    var affiliateHistoryDataTable;
    affiliateHistoryDataTable = $("#affiliateHistoryDataTable").DataTable({
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
        ajax: $('#affiliateHistoryRoute').val(),
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
            { data: 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false, searchable: false },
            { data: "product", name: "products.name" },
            { data: "plan", name: "plans.name" },
            { data: "date", name: "date" },
            { data: "plan_price", name: "plans.price" },
            { data: "amount", name: "affiliate_histories.amount" },
        ],
    });
})(jQuery);
