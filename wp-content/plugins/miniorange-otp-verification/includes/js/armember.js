jQuery(document).ready(function () {
    $mo = jQuery;
    let formDetails = moarmember.forms;
    let otpType = moarmember.otpType;
    $mo(".arm_form").each(function () {
        let form = $mo(this);
        let formID = $mo('input[name="arm_form_id"]').val();
        if (formID in formDetails) {
            let fieldID = formDetails[formID][moarmember.formkey];
            setTimeout(function () {
                if ($mo("form[id*="+formID+"] .flag-container").length > 0) {
                    inputFieldId = $mo("form[id*="+formID+"] input[name=" + fieldID + "]").attr('id');
                    labelText = $mo("label[for=" + inputFieldId + "]").text();
                    $mo("label[for=" + inputFieldId + "]").remove();
                    $mo("form[id*="+formID+"] input[name=" + fieldID + "]").attr('placeholder', labelText);
                }
            }, 1000);
            let verifyID = formDetails[formID].verifyKey;
			let img   = "<div class='moloader'></div>";
            let messagebox = '<div style="margin-top:2%"><div   id="mo_message' + fieldID + '" hidden="" style="display: none; font-size: 16px; padding: 10px 20px; border-radius: 10px"></div></div>';
            let button =
                '<div style="margin-top: 2%;"><div class=""><button type="button" style="width:100%;" class="btn btn-default" id="miniorange_otp_token_submit' +
                fieldID +
                '" title="Please Enter your phone details to enable this.">' +
                moarmember.buttontext +
                "</button></div></div>";
            $mo(button + messagebox).insertAfter($mo("input[name=" + fieldID + "]").parent().next());


            $mo("#miniorange_otp_token_submit" + fieldID).click(function () { // when we click on send otp
                var a = $mo('input[name="' + fieldID + '"]').val();
                $mo("#mo_message" + fieldID).empty(),
                    $mo("#mo_message" + fieldID).append(img),
                    $mo("#mo_message" + fieldID).show(),
                    $mo.ajax({
                        url: moarmember.siteURL,
                        type: "POST",
                        data: { action: moarmember.generateURL, security: moarmember.nonce, user_phone: a, user_email: a },
                        crossDomain: !0,
                        dataType: "json",
                        success: function (b) {
                            if (b.result === "success") {
                                $mo("#mo_message" + fieldID).empty();
                                $mo("#mo_message" + fieldID).append(b.message);
                                $mo("#mo_message" + fieldID).css({"background-color":"#dbfff7","color":"#008f6e"});
                                $mo('input[name="' + fieldID + '"]').focus();
                            } else {
                                $mo("#mo_message" + fieldID).empty();
                                $mo("#mo_message" + fieldID).append(b.message);
                                $mo("#mo_message" + fieldID).css({"background-color":"#ffefef","color":"#ff5b5b"});
                                $mo('input[name="' + fieldID + '"]').focus();
                            }
                        },
                        error: function (c, b, d) {},
                    });
            });
        }
    });
});
