<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during email for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'greeting' => 'Hello!',
    'greeting_user' => 'Hello, :user!',
    'do_not_reply' => 'This is an automatic email sent by system, please do not reply to this email address.',
    'copy_link_help' => 'If you\'re having trouble clicking the ":action" button, copy and paste the URL below into web browser:',
    'regards' => 'Regards,',
    'regards_sender' => 'OMG Team',
    'any_questions' => 'Any question or help?',
    'visit_link' => 'Visit this link',
    
    // Welcome Email Template
    'welcome' => [
        'title'=> 'Welcome to :app_name',
        'paragraph_1' => 'Welcome to :app_name. Your email has been successfully verified. This is the first step, the next step is to complete your page with a photo, description, and a little bit about you.',
        'paragraph_2' => ':app_name wants to provide the best for you both as Content Creator and Your Fans. Show your work and get supporters!',
        'button_1' => 'Open Dashboard',
    ],

    // Verify Email Template
    'verify' => [
        'title'=> 'Verify Email Address',
        'paragraph_1' => 'Please click on the button below to validate your email address and confirm that you are the owner of this account. If not, please ignore this email.',
        'button_1' => 'Verify',
    ],

    // Reset Password Template
    'reset_pw' => [
        'title' => 'Reset Password',
        'paragraph_1' => 'Someone has sent request to reset your password, If you didn\'t request this, please ignore this email.',
        'button_1' => 'Reset Password',
    ],

];
