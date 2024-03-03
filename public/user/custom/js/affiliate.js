(function ($) {
    ("use strict");

    $('#addAffiliateConfigBtn').on('click', function () {
        var selector = $('#addAffiliateConfigModal');
        selector.find('.is-invalid').removeClass('is-invalid');
        selector.find('.error-message').remove();
        selector.modal('show')
        selector.find('form').trigger("reset");
        selector.find(".plan-append-data").html('');
    });

    var stateSelector;
    $(document).on("change", ".product_id", function () {
        stateSelector = $(this);
        stateSelector.closest('form').find(".plan-append-data").html('');
        if (jQuery.inArray("all", $(this).val()) === -1 && jQuery.isEmptyObject($(this).val()) == false) {
            commonAjax("GET", $("#getPlanByProductRoute").val(), getPlanByProductsRes, getPlanByProductsRes, { ids: $(this).val() });
        } else {
            var html = `<option value="all" selected>All Plans</option>`;
            stateSelector.closest('form').find(".plan-append-data").html(html);
        }
    });

    function getPlanByProductsRes(response) {
        var html = `<option value="all">All Plans</option>`;
        $.each(response, function (key, value) {
            if (key == 0) {
                html += `<option value="${value.id}" selected>${value.name}</option>`;
            } else {
                html += `<option value="${value.id}">${value.name}</option>`;
            }
        })
        stateSelector.closest('form').find(".plan-append-data").html(html);
    }

    $(document).on("click", ".statusConfig", function () {
        commonAjax("GET", $("#getAffiliateInfoRoute").val(), getConfigStatusResponse, getConfigStatusResponse, { id: $(this).data('id') });
    });

    function getConfigStatusResponse(response) {
        var selector = $('#statusAffiliateConfigModal');
        selector.find('input[name=id]').val(response.id)
        selector.find('select[name=status]').val(response.status)
        selector.modal('show')
    }

    $(document).on("click", ".editConfig", function () {
        commonAjax("GET", $("#getAffiliateConfigInfoRoute").val(), getConfigEditResponse, getConfigEditResponse, { id: $(this).data('id') });
    });

    function getConfigEditResponse(response) {
        var selector = $('#editAffiliateConfigModal');
        selector.find('input[name=id]').val(response.id)
        selector.find('input[name=title]').val(response.title)
        selector.find('.product_id').select2('val', JSON.parse(response.products))

        var html = `<option value="all">All Plans</option>`;
        $.each(response.planByProducts, function (key, value) {
            html += `<option value="${value.id}">${value.name}</option>`;
        })
        selector.find('.plan-append-data').html(html)
        selector.find('.plan_id').select2('val', JSON.parse(response.plans))

        selector.find('.affiliate_id').select2('val', JSON.parse(response.affiliates))

        selector.find('select[name=commission_type]').val(response.commission_type)
        selector.find('input[name=commission_amount]').val(response.commission_amount)
        selector.find('select[name=recurring_commission_type]').val(response.recurring_commission_type)
        selector.find('input[name=recurring_commission_amount]').val(response.recurring_commission_amount)
        selector.modal('show')
    }

    $("#allAffiliateDataTable").DataTable({
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
        ajax: $('#affiliateIndexRoute').val(),
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
            { data: "name", name: "name" },
            { data: "email", name: "email" },
            { data: "status", name: "status" },
            { data: "action", name: "action" },
        ],
    });

    $("#allAffiliateConfigDataTable").DataTable({
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
        ajax: $('#affiliateConfigListRoute').val(),
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
            { data: "title", name: "title" },
            { data: "products", name: "products" },
            { data: "plans", name: "plans" },
            { data: "affiliates", name: "affiliates" },
            { data: "commission_amount", name: "commission_amount" },
            { data: "action", name: "action" },
        ],
    });

    $("#affiliateLinkDataTable").DataTable({
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
        ajax: $('#affiliateLinkRoute').val(),
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
            { data: "product", name: "product" },
            { data: "plan", name: "plan" },
            { data: "action", name: "action" },
        ],
    });

    $("#affiliateHistoryDataTable").DataTable({
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
            { data: "userName", name: "user.name" },
            { data: "product", name: "products.name" },
            { data: "plan", name: "plans.name" },
            { data: "date", name: "date" },
            { data: "plan_price", name: "plans.price" },
            { data: "amount", name: "affiliate_histories.amount" },
        ],
    });
    $(document).on('click', '.copyLink', function () {
        copyToClipboard($(this).data('link'))
    });
    function copyToClipboard(text) {
        // Create a temporary element (e.g., a textarea) to hold the text
        var tempElement = document.createElement("textarea");
        tempElement.value = text;

        // Append the element to the DOM
        document.body.appendChild(tempElement);

        // Select the text in the element
        tempElement.select();

        // Execute the copy command
        document.execCommand("copy");

        // Remove the temporary element
        document.body.removeChild(tempElement);
        toastr.success('Copy to clipboard');
    }

    $(document).on('click', '.orderPayStatus', function () {
        commonAjax('GET', $('#ordersGetInfoRoute').val(), getInfoRes, getInfoRes, { 'id': $(this).data('id') });
    });

    function getInfoRes(response) {
        const selector = $('#payStatusChangeModal');
        selector.find('input[name=id]').val(response.data.id)
        selector.find('select[name=status]').val(response.data.payment_status)
        selector.modal('show')
    }

    $(document).ready(function () {
        allOrderDataTable('All')
    });

    $(document).on('click', '.orderStatusTab', function (e) {
        var status = $(this).data('status');
        allOrderDataTable(status)
    });

    function allOrderDataTable(status) {
        var dataTableColumns = [
            { data: 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false, searchable: false },
            { data: "date", name: "date" },
            { data: "payment_details", name: "payment_details" },
            { data: "amount", name: "amount" },
            { data: "status", name: "status" },
        ];
        if (status == 'Pending') {
            dataTableColumns.push({ "data": "action", responsivePriority: 2 });
        }

        $("#" + status + "WithdrawRequestDataTable").DataTable({
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
                url: $('#ordersStatusRoute').val(),
                data: function (data) {
                    data.status = status;
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
            columns: dataTableColumns,
            stateSave: true,
            "bDestroy": true
        });
    }


})(jQuery);
