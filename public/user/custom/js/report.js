(function ($) {
    "use strict";
    $("#productListDataTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: false,
        ajax: $('#report-products-list-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },

        dom: '<"tableTop"<"d-flex justify-content-center align-items-center"\Bfrt\>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',

        buttons: [{
            extend: 'excel',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'pdf',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'copy',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        }
        ],

        columns: [
            { "data": "name", "name": "name", responsivePriority: 1 },
            { "data": "total_plans", "name": "total_plans" },
            { "data": "total_coupons", "name": "total_coupons" },
            { "data": "total_license", "name": "total_license" },
            { "data": "created_at", "name": "created_at", responsivePriority: 2 },
        ],
    });
    $('#exportButton').on('click', function () {
        table.button('.buttons-excel').trigger();
    });

    $("#salesListDataTable").DataTable({
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
        ajax: $('#report-sales-list-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search pending event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },

        dom: '<"tableTop"<"d-flex justify-content-center align-items-center"\Bfrt\>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',

        // buttons: [
        //     'excel', 'pdf', 'print'
        // ],

        buttons: [{
            extend: 'excel',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'pdf',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'copy',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        }
        ],

        columns: [
            { "data": "created_at", "name": "created_at" },
            { "data": "invoice", "name": "invoice" },
            { "data": "customer", "name": "customer" },
            { "data": "product_name", "name": "productName" },
            { "data": "plan_name", "name": "planName" },
            { "data": "subscription", "name": "subscription" },
            { "data": "gateway", "name": "gateway" },
            { "data": "tax", "name": "tax" },
            { "data": "total", "name": "total" },
        ],
    });

    $("#customersListDatatable").DataTable({
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
        ajax: $('#report-customer-list-route').val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search pending event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },

        dom: '<"tableTop"<"d-flex justify-content-center align-items-center"\Bfrt\>>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',

        buttons: [{
            extend: 'excel',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'pdf',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        },
        {
            extend: 'copy',
            className: 'default-hover-btn border-0 p-0 py-8 px-15 bg-main-color text-white bd-ra-8 fs-18 fw-500 lh-17'
        }
        ],

        columns: [
            { "data": "name", "name": "name" },
            { "data": "email", "name": "email" },
            { "data": "created_at", "name": "userDetail.created_at" },
            { "data": "country", "name": "userDetail.country" },
            { "data": "payment", "name": "userDetail.payment" },
            { "data": "tax", "name": "orders.total_tax" },
            { "data": "revenue", "name": "orders.total_revenue" },
        ],
    })
})(jQuery)
