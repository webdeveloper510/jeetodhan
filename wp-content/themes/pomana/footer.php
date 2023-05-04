<?php
/**
 * The template for displaying the footer.
 *
*/

?>

    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <?php if (pomana_redux('mt_backtotop_status') == true) { ?>
            <!-- BACK TO TOP BUTTON -->
            <a class="back-to-top modeltheme-is-visible modeltheme-fade-out">
                <span></span>
            </a>
        <?php } ?>
    <?php } ?>


    <div class="clearfix"></div>
    <footer>

        <?php if ( class_exists('ReduxFrameworkPlugin')) { ?>
        <!-- FOOTER TOP -->
        <div class="row footer-top">
            <div class="container">
            <?php
                // Check if the Redux Framework is active
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    //FOOTER ROW #1
                    echo pomana_footer_row1();
                }
             ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <?php if(pomana_redux('modeltheme-enable-copyright')==true){ ?>
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p class="copyright"><?php echo wp_kses(pomana_redux('pomana_footer_text_right'), 'link'); ?></p>            
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div class="footer footer-fallback">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="copyright"><?php echo esc_html__('© pomana Theme. | All right Reserved.', 'pomana'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </footer>
</div>
<script>
const anchor = document.querySelector("a[href='#tab-lottery_history']");
anchor.textContent = "Draw History";

</script>
<script>
 jQuery(document).ready(function($) {
     $("#otpAjax").on('click',function() {
         
                var phoneNumber =  $('#billing_phone').val();
                if(phoneNumber != '')
                {
                      $.ajax({
                            url:'http://www.wellspringinfotech.com/lottery/otpAjax.php',
                            type:'post',
                            data:{
                                phoneNumber: phoneNumber,
                            },
                            success:function(data)
                            {
                               var result = JSON.parse(data);
                               if(result.status == 'success')
                               {
                                   var sOtp = result.verification_code;
                                  var input = document.createElement("input");
                                    
                                    input.setAttribute("type", "hidden");
                                    
                                    input.setAttribute("name", "sOtp");
                                    input.setAttribute("id", "sOtp");
                                    input.setAttribute("value", sOtp);
                                    
                                    //append to form element that you want .
                                      $('#sotpDiv').html(input);
                                  $('#registration-popup').fadeIn();
                               }
                            }
                    })
                }
                else
                {
                     alert('Please fill all the mandatory details first');
                }
      
        });
       
         $("#resendOtp").on('click',function() {
             var phoneNumber =  $('#billing_phone').val();
                if(phoneNumber != '')
                {
                      $.ajax({
                            url:'http://www.wellspringinfotech.com/lottery/otpAjax.php',
                            type:'post',
                            data:{
                                phoneNumber: phoneNumber,
                            },
                            success:function(data)
                            {
                               var result = JSON.parse(data);
                               if(result.status == 'success')
                               {
                                   var sOtp = result.verification_code;
                                   var el = document.getElementById('sOtp');
                                   if(el)
                                   {
                                       $("#sOtp").remove();
                                   }
                                   
                                  var input = document.createElement("input");
                                  input.setAttribute("type", "hidden");
                                    input.setAttribute("name", "sOtp");
                                    input.setAttribute("id", "sOtp");
                                    input.setAttribute("value", sOtp);
                                    
                                    //append to form element that you want .
                                    $('#sotpDiv').html(input);
                                  $('#registration-popup').fadeIn();
                               }
                            }
                    })
                }
                else
                {
                    alert('Please fill all the mandatory details first');
                }
        });
 });
</script>
<?php wp_footer(); ?>
</body>
</html>
