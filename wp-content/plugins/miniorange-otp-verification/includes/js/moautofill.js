if ('OTPCredential' in window) {
    window.addEventListener('DOMContentLoaded', e => {
        setTimeout(function() {
            const inputSelector = document.querySelector('input[autocomplete="one-time-code"]');
            if (!inputSelector) return;
            const abortController = new AbortController();
            const formContainingInputField = inputSelector.closest('form');
            if (formContainingInputField) {
                formContainingInputField.addEventListener('submit', e => {
                    abortController.abort();
                });
            }
            navigator.credentials.get({
                otp: {
                    transport: ['sms']
                },
                signal: abortController.signal
            }).then(otp => {
                input.value = otp.code;
                if (jQuery('input[name="miniorange_otp_token_submit"]').length) {
                    jQuery('input[name="miniorange_otp_token_submit"]').click();
                }
            }).catch(err => {
            });
        }, 3000);

    });
}