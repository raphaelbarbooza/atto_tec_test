<?php

return [

    'general' => [
        'loading' => 'loading',
        'home' => 'Home',
        'logout' => 'Logout',
        'actions' => [
            'details' => 'Details',
            'edit' => 'Edit',
            'delete' => 'Remove',
            'save' => 'Save',
            'cancel' => 'Cancel',
            'close' => 'Close',
            'confirm' => 'Confirm'
        ],
        'validation' => [
            'type_something' => 'You need to inform some data.'
        ]
    ],
    'auth' => [
        'email' => "E-mail",
        'password' => "Password",
        'confirm_password' => "Confirm Password",
        'reset_password_action' => "Reset Password",
        'login' => "Login",
        'forgot_password' => "Forgot Your Password?",
        'messages' => [
            'required_mail' => "The email field is required.",
            'required_password' => "You must input some password.",
            'invalid_mail' => "Invalid mail.",
            'min_password' => "Usually passwords has 8 or more chars."
        ],
        'invalid_credentials' => "Invalid e-mail or password",
        'reset_password' => [
            'title' => 'Reset password',
            'instructions' => "Inform your e-mail address, and we will send you a mail with the link for password reset.",
            'reset_instructions' => "Confirm your e-mail address and inform your new password.",
            'default_email_error' => "Please, verify if the e-mail address belongs to a active user.",
            'default_password_error' => "Passwords must have atleast 8 characters, and be confirmed.",
            'send_password_link' => "Send Password Reset Link",
        ]
    ],
    'localization' => [
        'switcher_error' => "Error on changing app language, try again later."
    ],
    'producers' => [
        'title' => 'Manage Producers',
        'detail_title' => 'Producer Detail',
        'filters' => [
            'search' => 'Search',
            'producer_type'=> 'Producer Type',
            'any' => 'Any',
            'individual' => 'Individual',
            'collective' => 'Collective'
        ],
        'actions' => [
            'new_producer' => 'New Producer',
            'edit_producer' => 'Edit Producer'
        ],
        'table' => [
            'company_name' => 'Company Name',
            'trade_name' => 'Trade Name',
            'social_number' => 'Social Number',
            'phone' => 'Phone',
            'localization' => 'Localization',
            'state' => 'State',
            'city' => 'City',
            'state_registration' => 'State Registration'
        ],
        'created' => 'Producer created successfully',
        'updated' => 'Producer updated successfully',
        'to_remove' => 'Are you sure you want to remove :producer ?',
        'removed' => 'Producer removed successfully'
    ],
    'farms' => [
        'title' => 'Registered Farms',
        'creating_alert' => 'You can add shapes and plots in this farm after creation.',
        'select_alert' => 'Select a farm on the left menu',
        'filters' => [
            'search' => 'Filter'
        ],
        'actions' => [
            'new_farm' => 'Create new farm',
            'edit_farm' => 'Edit farm',
            'remove_farm' => 'Remove farm'
        ],
        'table' => [
            'name' => 'Farm Name',
        ],
        'created' => 'Farm created successfully',
        'updated' => 'Farm updated successfully',
        'to_remove' => 'Are you sure you want to remove :farm ?',
        'removed' => 'Farm removed successfully'
    ],
    'plot' => [
        'actions' => [
            'new_plot' => 'Add Plot',
            'remove_plot' => 'Remove Plot',
            'select_plot' => 'Select a Plot'
        ],
        'form' => [
            'identification' => 'Name or Reference',
            'file' => 'Load a .geo.json or the .shp with it .shx .prj and .dbf dependencies',
            'file_field' => 'Ref File',
            'invalid_file' => 'Invalid plot file, check if is a valid .geo.json or or the .shp with it .shx .prj and .dbf dependencies.'
        ],
        'created' => 'Plot added successfully',
        'to_remove' => 'Are you sure you want to remove :plot ?',
        'removed' => 'Plot removed successfully',
        'no_loaded' => 'Select a plot to view on map',
        'invalid_map_load' => "Looks like we can't render this geojson file, try to remove this plot and upload another one"
    ],

];
