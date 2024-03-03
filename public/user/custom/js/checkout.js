(function ($) {
    ("use strict");
    var currencyRes;
    var afterDiscountPlanPrice;
    var planPrice = parseFloat($('#planPrice').val()).toFixed(2);
    var planSetupFee = parseFloat($('#planSetupFee').val()).toFixed(2);
    var planShippingCharge = parseFloat($('#planShippingCharge').val()).toFixed(2);
    var discountAmount = parseFloat($('#discountAmount').val()).toFixed(2)

    $(document).on('click', '.paymentGateway', function (e) {
        $('#selectGateway').val('')
        $('#selectCurrency').val('');
        $('#couponCode').val('')
        discountAmount = 0.00;
        $('#discountShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(parseFloat(discountAmount)), currencySymbol));
        $('#totalShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(parseFloat(planPrice) + parseFloat(planSetupFee) + parseFloat(planShippingCharge)), currencySymbol));
        var selectGatewaySlug = $(this).data('gateway');
        var selectGatewayId = $(this).val();
        $('#selectGateway').val(selectGatewaySlug)
        commonAjax('GET', $('#getCurrencyByGatewayRoute').val(), getCurrencyRes, getCurrencyRes, { 'id': selectGatewayId });
        $('html, body').animate({
            scrollTop: $("#gatewayCurrencyAppend").offset().top
        }, 200);
        if (selectGatewaySlug == 'bank') {
            $('#bankSection').removeClass('d-none');
            $('#bank_slip').attr('required', true);
            $('#bank_id').attr('required', true);
        } else {
            $('#bank_slip').attr('required', false);
            $('#bank_id').attr('required', false);
            $('#bankSection').addClass('d-none');
        }
    });

    function getCurrencyRes(response) {
        currencyRes = response.data;
        currencyHtmlTemplate(currencyRes)
    }

    function currencyHtmlTemplate(currencyRes) {
        var html = '';
        afterDiscountPlanPrice = parseFloat(planPrice) + parseFloat(planSetupFee) + parseFloat(planShippingCharge) - parseFloat(discountAmount);
        Object.entries(currencyRes).forEach((currency) => {
            let currencyAmount = currency[1].conversion_rate * afterDiscountPlanPrice;
            html += `<li>
                        <div class="position-relative w-100 d-flex justify-content-between">
                            <div class="zForm-wrap-radio gatewayCurrencyAmount">
                                <input class="form-check-input" type="radio" name="currencyAmount" value="${gatewayCurrencyPrice(currencyAmount, currency[1].symbol)}"
                                    id="${currency[1].id}" />
                                <label class="form-check-label" for="${currency[1].id}">${currency[1].currency}</label>
                            </div>
                            <div class="position-absolute top-50 end-0 translate-middle-y">
                                <p><span>${currencyPrice(afterDiscountPlanPrice)}</span> * <span>${currency[1].conversion_rate}</span> = <span>${gatewayCurrencyPrice(currencyAmount, currency[1].symbol)}</span></p>
                            </div>
                        </div>
                    </li>`;
        });
        $('#gatewayCurrencyAppend').html(html);
    }

    $(document).on('click', '.gatewayCurrencyAmount', function () {
        var getCurrencyAmount = '(' + $(this).find('input').val() + ')';
        $('#gatewayCurrencyAmount').text(getCurrencyAmount)
        $('#selectCurrency').val($(this).text().replace(/\s+/g, ''));
    });

    $(document).on('change', '#bank_id', function () {
        $('#bankDetails').removeClass('d-none');
        $('#bankDetails').html($(this).find(':selected').data('details'));
    });

    $('#paymentNowBtn').on('click', function () {
        var gateway = $('#selectGateway').val()
        var currency = $('#selectCurrency').val();

        if (gateway == '') {
            toastr.error('Select Gateway');
            $('#paymentNowBtn').attr('type', 'button');
        } else {
            if (currency == '') {
                toastr.error('Select Currency');
                $('#paymentNowBtn').attr('type', 'button');
                $('html, body').animate({
                    scrollTop: $("#gatewayCurrencyAppend").offset().top
                }, 200);
            } else {
                $('#paymentNowBtn').attr('type', 'submit');
            }
        }
    });

    function checkoutOrderResponse(data) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (data['status'] == true) {
            if (data.data.gateway == 'bank') {
                output = output + data['message'];
                type = 'success';
                alertAjaxMessage(type, output);
                window.location.href = $('#waitingRoute').val();
            } else if (data.data.gateway == 'cash') {
                output = output + data['message'];
                type = 'success';
                alertAjaxMessage(type, output);
                window.location.href = $('#waitingRoute').val();
            } else {
                window.location.href = data.data.redirect_url;
            }
        } else {
            commonHandler(data)
        }
    }
    window.checkoutOrderResponse = checkoutOrderResponse;

    $('#couponCodeApplyBtn').on('click', function () {
        var coupon_code = $('#couponCode').val();
        commonAjax('GET', $('#getCouponInfoRoute').val(), getCouponResponse, getCouponResponse, { 'plan_id': $('#planId').val(), 'code': coupon_code, 'user_id': $('#userId').val() });
    });

    function getCouponResponse(data) {
        if (data['status'] == true) {
            $('#gatewayCurrencyAppend').html();
            $('#selectCurrency').val()
            if (data.data.coupon.discount_type == 1) {
                discountAmount = parseFloat(data.data.coupon.discount).toFixed(2);
                afterDiscountPlanPrice = parseFloat(planPrice) + parseFloat(planSetupFee) + parseFloat(planShippingCharge) - data.data.coupon.discount;
                $('#discountAmount').val(discountAmount);
                $('#discountShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(discountAmount), currencySymbol))
                $('#totalShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(afterDiscountPlanPrice), currencySymbol))
            } else {
                discountAmount = parseFloat(data.data.coupon.discount) * 0.01 * parseFloat(planPrice);
                afterDiscountPlanPrice = parseFloat(planPrice) + parseFloat(planSetupFee) + parseFloat(planShippingCharge) - discountAmount;
                $('#discountAmount').val(discountAmount);
                $('#discountShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(discountAmount), currencySymbol))
                $('#totalShowAmount').text(gatewayCurrencyPrice(visualNumberFormat(afterDiscountPlanPrice), currencySymbol))
            }
            if (currencyRes != null) {
                currencyHtmlTemplate(currencyRes)
            }
            toastr.success(data['message']);
        } else {
            commonHandler(data)
        }
    }

    $('#sameAsBillingBtn').on('change', function () {
        var isBillingSame = $("#sameAsBillingBtn").is(":checked");
        var billingInfoSelector = $('#billingInfo');
        var shippingInfoSelector = $('#shippingInfo');
        billingInfoFields = billingInfoSelector.find('input,textarea');
        shippingInfoFields = shippingInfoSelector.find('input,textarea');
        if (isBillingSame == true) {
            billingInfoFields.each(function (e) {
                var billingFieldType = $(this).attr('type');
                var billingFieldAttrName = $(this).attr('name');
                var billingFieldName = billingFieldAttrName.split('_')[1];
                var billingFieldValue = $(this).val();
                shippingInfoFields.each(function () {
                    var shippingFieldAttrName = $(this).attr('name');
                    var shippingFieldName = shippingFieldAttrName.split('_')[1];
                    if (shippingFieldName == billingFieldName) {
                        $(this).val(billingFieldValue);
                    }
                });

            });
        } else {
            shippingInfoFields.each(function () {
                $(this).val('');
            });
        }
    });
})(jQuery);

