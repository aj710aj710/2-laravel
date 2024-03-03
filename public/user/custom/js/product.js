(function ($) {
    ("use strict");
    $("#productTable").DataTable({
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
        ajax: $('#product-list-route').val(),
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
            { data: "plans", name: "plans", searchable: false, orderable: false },
            { data: "coupons", name: "coupons", searchable: false, orderable: false },
            { data: "addons", name: "addons", searchable: false, orderable: false },
            { data: "action", name: "action" },
        ],
    });

    $(document).on('click', '.product-id-push-on-add-modal', function (e) {
        $('#productId').val($(this).data('id'));
    });


    // Show/Hide Add plan inner field
    $(".bilingCycle-checkbox-item").on('click', function () {
        var index = $(this).index();
        var hideItems = $(".bilingCycle-open-items .bilingCycle-open-item");

        if (hideItems.length === 2) {
            hideItems
                .eq(index - 1)
                .removeClass("d-none")
                .addClass("d-block");
        }

        hideItems.each(function (i, el) {
            if (i !== index - 1 && $(el).hasClass("d-block")) {
                $(el).removeClass("d-block").addClass("d-none");
            }
        });
    });

    $(document).on('click', '.addPlanModal', function () {
        $('#addPlanModal form')[0].reset();
    })

    $(document).on('click', '.addCouponModal', function () {
        $('#addCouponModal form')[0].reset();
    })
    $(document).on('click', '.addLicenseModal', function () {
        $('#addLicenseModal form')[0].reset();
    })



})(jQuery);
