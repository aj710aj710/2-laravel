(function( $ ){
    ("use strict");
    $("#planDetailsTable").DataTable({
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
        ajax: $('#plan-list-route').val(),
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
            { data: "name", name: "name", searchable: false, orderable: false },
            { data: "code", name: "code", searchable: false, orderable: false },
            { data: "price", name: "price", searchable: false, orderable: false },
            { data: "billing_cycle", name: "billing_cycle", searchable: false, orderable: false },
            { data: "status", name: "status", searchable: false, orderable: false },
            { data: "action", name: "action" },
        ],
    });


})(jQuery);
