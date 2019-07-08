jQuery(document).ready(function ($) {

    setTimeout(function(){
        $('#cc_phone_number').val($('#billing_phone').val());
    }, 2000)

    $(".woocommerce-checkout.wizard .step-panes .step-content").removeClass('active');
    $(".woocommerce-checkout.wizard .steps-wrap .step").removeClass('current');
    $(".woocommerce-checkout.wizard .steps-wrap .step").removeClass('passed');

    var stepContents = $(".woocommerce-checkout.wizard .step-panes").find(".step-content");
    var steps = $(".woocommerce-checkout.wizard .steps-wrap").find(".step");

    currentStep = 0;

    function setStep(cs){
        $(".woocommerce-checkout.wizard .step-panes .step-content").removeClass('active');
        $(stepContents[cs]).addClass('active');

        $(steps[cs-1]).removeClass('current');
        $(steps[cs-1]).addClass('passed');
        $(steps[cs]).addClass('current');
        $(steps[cs+1]).removeClass('current');
        $(steps[cs+1]).removeClass('passed');
    }

    setStep(currentStep);

    $('.woocommerce-checkout.wizard .next-step').click(function(){
        $('#billing_state').val('*')
        if(currentStep < stepContents.length){
            var flag = 0;
            $('.woocommerce-checkout.wizard input').each(function(){
                if ( $(this).val() == '' && $(this).is(':visible') &&$(this).parent().parent().hasClass('validate-required')) {
                    $(this).css('border', '2px solid #a00');
                    flag = 1;
                }
            })
            if (flag == 0) {
                currentStep++;
                setStep(currentStep);
            }
        }
        console.log(currentStep);
    })

    $('.woocommerce-checkout.wizard .prev-step').click(function(){
        if(0 < currentStep){
            currentStep--;
            setStep(currentStep);
        }
        console.log(currentStep);
    })

    $('#billing_phone').on('input', function() {
        $('#cc_phone_number').val($(this).val());
    });

    $('#billing_company').val('Tomoori');
    $('#billing_company_field').hide();
    
});