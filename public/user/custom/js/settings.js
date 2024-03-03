(function ($) {
    ("use strict");
    $(document).on('change', '.templateStatus', function () {
        var category = $(this).closest('li').find('input[name=category]').val()
        commonAjax('GET', $('#emailTemplateStatus').val(), commonResponse, commonResponse, { 'category': category })
    });

    $(document).on('click', '.templateConfigure', function () {
        var category = $(this).closest('li').find('input[name=category]').val()
        commonAjax('GET', $('#emailTemplateConfigRoute').val(), emailTemplateConfigRes, emailTemplateConfigRes, { 'category': category })
    });

    function emailTemplateConfigRes(response) {
        if (response['status'] == true) {
            var selector = $('#emailConfigureModal');
            var fields = '';
            Object.entries(response.data.fields).forEach((field) => {
                fields += '<span class="px-9 bg-white rounded-pill fs-12 fw-400 lh-24 text-textBlack singleField" data-field="' + field[0] + '">' + field[0] + '</span>';
            });
            selector.find('.templateFields').html(fields);
            selector.find('input[name=category]').val(response.data.template.category);
            selector.find('input[name=subject]').val(response.data.template.subject);
            selector.find('textarea[name=body]').summernote('code', response.data.template.body);
            selector.modal('show');
        } else {
            commonHandler(response)
        }
    }

    $(document).on('click', '.singleField', function () {
        var field = $(this).data('field');
        $('.summernoteOne').summernote('editor.saveRange');
        $('.summernoteOne').summernote('editor.restoreRange');
        $('.summernoteOne').summernote('editor.focus');
        $('.summernoteOne').summernote('editor.insertText', field);
    });

    function getCheckoutPageUpdateRes(data) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (data['status'] == true) {
            output = output + data['message'];
            type = 'success';
            alertAjaxMessage(type, output);
            nextStep(data.data.step)
            if (data.data.step === 'nextStep5') {
                var gateways = JSON.parse($('#gateways').val());
                var gatewayIds = JSON.parse(data.data.gateways);
                var gatewayListHtml = '';
                gatewayIds.forEach((id) => {
                    let gateway = gateways.find(x => x.id == id);
                    if (typeof gateway != 'undefined') {
                        gatewayListHtml += `<div
                            class="flex-grow-1 max-w-419 mb-3 position-relative w-100">
                            <div
                                class="zForm-wrap-radio py-13 px-15 bd-one bd-c-stroke-2-color bd-ra-8 bg-input-color">
                                <label
                                    class="form-check-label">${gateway.title}</label>
                            </div>
                            <div
                                class="position-absolute top-50 end-0 translate-middle-y pr-15">
                                <img src="${window.location.origin}/${gateway.image}" />
                            </div>
                        </div>`;
                    }
                });
                $('#gatewaysShow').html(gatewayListHtml);
            }
        } else {
            commonHandler(data)
        }
    }
    window.getCheckoutPageUpdateRes = getCheckoutPageUpdateRes;

    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);
    function nextStep(stepClassName) {
        current_fs = $('.' + stepClassName).parent().parent();
        next_fs = $('.' + stepClassName).parent().parent().next();
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative"
                    });
                    next_fs.css({ opacity: opacity });
                },
                duration: 500
            }
        );
        setProgressBar(++current);
        goToList(stepClassName)
    }

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%");
    }

    function goToList(stepClassName) {
        if (stepClassName === 'lastStep') {
        }
    }

    $(".previousBtn").click(function () {
        current_fs = $(this).parent().parent();
        previous_fs = $(this).parent().parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });
                    previous_fs.css({ opacity: opacity });
                },
                duration: 500,
            }
        );
        // setProgressBar(--current);
    });

    $(document).on('click', '.addBasicInfoFieldBtn', function () {
        var basicInfoHtml = basicInfoTemplate();
        $('.basicInfoAppend').append(basicInfoHtml)
    });

    $(document).on('click', '.addBillingInfoFieldBtn', function () {
        var billingInfoHtml = billingInfoTemplate();
        $('.billingInfoAppend').append(billingInfoHtml)
    });

    $(document).on('click', '.addShippingInfoFieldBtn', function () {
        var shippingInfoHtml = shippingInfoTemplate();
        $('.shippingInfoAppend').append(shippingInfoHtml)
    });

    function basicInfoTemplate() {
        return `<div class="row mb-2">
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Type</label>
                            <select class="form-control zForm-control basic-type"
                                name="basic[type][]">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Label</label>
                            <input type="text"
                                class="form-control zForm-control basic-label"
                                name="basic[label][]"
                                placeholder="Label" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Placeholder</label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control zForm-control rounded basic-placeholder"
                                    name="basic[placeholder][]"
                                    placeholder="Placeholder" />
                                <button type="button"
                                    class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
    }

    function billingInfoTemplate() {
        return `<div class="row mb-2">
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Type</label>
                            <select class="form-control zForm-control billing-type"
                                name="billing[type][]">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Label</label>
                            <input type="text"
                                class="form-control zForm-control billing-label"
                                name="billing[label][]"
                                placeholder="Label" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Placeholder</label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control zForm-control rounded billing-placeholder"
                                    name="billing[placeholder][]"
                                    placeholder="Placeholder" />
                                <button type="button"
                                    class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
    }

    function shippingInfoTemplate() {
        return `<div class="row mb-2">
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Type</label>
                            <select class="form-control zForm-control shipping-type"
                                name="shipping[type][]">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Label</label>
                            <input type="text"
                                class="form-control zForm-control shipping-label"
                                name="shipping[label][]"
                                placeholder="Label" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="zForm-wrap">
                            <label class="zForm-label">Placeholder</label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control zForm-control rounded shipping-placeholder"
                                    name="shipping[placeholder][]"
                                    placeholder="Placeholder" />
                                <button type="button"
                                    class="bg-white border-0 input-group-text removeInfoBtn text-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
    }

    $(document).on('click', '.removeInfoBtn', function () {
        $(this).closest('.row').remove();
    })

    $(document).on('click', '.webhookModalBtn', function () {
        $('#webhookModal form')[0].reset();
    })
    $(document).on('click', '.taxModalBtn', function () {
        $('#taxModal form')[0].reset();
    })


})(jQuery);
