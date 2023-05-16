 <?php
            // Get the phone number from the registration form
            if(!empty($_POST['phoneNumber']))
            {
                  $phone = $_POST['phoneNumber'];
                // Generate a verification code
                $code = rand(100000, 999999);
                
                // Use the REST API Client to make requests to the Twilio REST API
                require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php';
                // Your Account SID and Auth Token from twilio.com/console
                $twilio_number = '+13393453177'; // Replace with your Twilio phone number       +447743846257
                $account_sid = 'AC4c844210e7ff2f4b0c30c9ce5fc6612e';
                $auth_token = '8f0a6a9fc29f954cda5c033b1b5a1eb9';
            
                // Send the verification code to the user's phone number using Twilio's API
                $twilio = new Twilio\Rest\Client($account_sid, $auth_token);
                $message = $twilio->messages->create(
                    $phone,
                    array(
                        'from' => $twilio_number,
                        'body' => 'Your verification code to register at Jeeto Dhan: ' . $code
                    )
                );

            
                // Save the verification code to the user's session for later validation
               // WC()->session->set('verification_code', $code);
                echo json_encode(['status'=>'success','verification_code'=>$code]);
            }
  
