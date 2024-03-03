(function ($) {
    "use strict";

    $("#taxDataTable").DataTable({
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
        ajax: $("#settingsTaxRoute").val(),
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search news",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',

        columns: [
            {
                data: "tax_rule_name",
                name: "tax_rule_name",
                responsivePriority: 1,
            },
            { data: "product_name", name: "product_name" },
            { data: "plan_name", name: "plan_name" },
            { data: "tax_amount", name: "tax_amount" },
            { data: "status", name: "status" },
            { data: "action", responsivePriority: 2 },
        ],
    });

    $(document).on("change", "#product-id", function () {
        commonAjax(
            "GET",
            $("#plan-route").val(),
            planResByProId,
            planResByProId,
            { id: $(this).val() }
        );
    });

    function planResByProId(response) {
        if (response.status) {
            $(".plan-filter-data").html(response.data);
            if ($(".sf-select-without-search")) {
                $(".sf-select-without-search").niceSelect("update");
            }
        } else {
            $(".plan-filter").html();
        }
    }
    $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function(event) {
        $($.fn.dataTable.tables(true)).DataTable().responsive.recalc();
        $($.fn.dataTable.tables(true)).css('width', '100%');
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
    });


})(jQuery);
