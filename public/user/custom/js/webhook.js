(function ($) {
    "use strict";
    $("#webhookTable").DataTable({
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
        ajax: $("#webhookTableRoute").val(),
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
            { data: "webhook_name", name: "webhook_name" },
            { data: "webhook_url", name: "webhook_url" },
            { data: "product_name", name: "product_name" },
            { data: "plan_name", name: "plan_name" },
            { data: "status", name: "status", responsivePriority: 1 },
            { data: "action", searchable: false, responsivePriority: 2 },
        ],
    });

    $(document).on("change", ".product-change-action", function () {
        commonAjax(
            "GET",
            $("#plan-route").val(),
            planResForWebhookByProId,
            planResForWebhookByProId,
            { id: $(this).val() }
        );
    });

    function planResForWebhookByProId(response) {
        if (response.status) {
            $(".plan-filter-data-for-webhook").html(response.data);
            if ($(".sf-select-without-search")) {
                $(".sf-select-without-search").niceSelect("update");
            }
        } else {
            $(".plan-filter-data-for-webhook").html();
        }
    }
})(jQuery);
