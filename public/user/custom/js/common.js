(function( $ ){
    ("use strict");

    // Show/Hide Add plan inner field
    $(document).on('click','.bilingCycle-checkbox-item', function () {
        if ($('.sf-select-without-search')) {
            $('.sf-select-without-search').niceSelect('update');
        }

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

    // Maximum Redemption
    $(document).on('click', '.redemption-type', function(){
        var type = $(this).val();
        if(type == 1){
            $(".maximum-redemption").addClass('d-none');
        }else if(type == 2){
            $(".maximum-redemption").addClass('d-none');
        }else if(type == 3){
            $(".maximum-redemption").removeClass('d-none');
        }
    });

    // get-plan-list

    $(document).on('click', '.get-plan-list', function(){
        $("#productId2").val($(this).data('id'));
        $("#productId3").val($(this).data('id'));
        commonAjax('GET', $('#plan-list-route').val(), planListResponse, planListResponse, { 'product_id': $(this).data('id') });
    });

    function planListResponse(response){
        $(".product-plan").html(response.responseText);
    }

    $(document).on('click', '.copy-subscription-link', function (e) {
        var copyText = $(this).data('link');
        copyToClipboard(copyText);
    });

    window.copyToClipboard = copyToClipboard;
    function copyToClipboard(txt) {
        navigator.clipboard.writeText(txt)
            .then(() => {
                toastr.success('Copy to clipboard');
            })
            .catch((err) => {
                toastr.error('Error copying text');
            });

    }


    $(document).on('click', '.bilingCycle-checkbox-item', function (e) {
        if($(this).find('input').val() == 2){
            $(".billing-cycle-item").removeClass('d-none');
            $(".billing-cycle-item-recurring-number").addClass('d-none');
        }else if($(this).find('input').val() == 3){
            $(".billing-cycle-item").removeClass('d-none');
            $(".billing-cycle-item-recurring-number").removeClass('d-none');
        }else{
            $(".billing-cycle-item").addClass('d-none');
            $(".billing-cycle-item-recurring-number").addClass('d-none');
        }
    });

})(jQuery);
