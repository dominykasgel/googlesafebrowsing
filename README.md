GoogleSafeBrowsing
=====

Goole Safe Browsing v4 package for Laravel.

Installation
====

Run the following from the Terminal:

    composer require dominykasgel/google-safe-browsing

Next, add your new provider to the providers array of config/app.php:

    'providers' => [
        dominykasgel\GoogleSafeBrowsing\GoogleSafeBrowsingServiceProvider::class,
    ]

Finally, add aliases to the aliases array of config/app.php:
    'aliases' => [
        'GoogleSafeBrowsing' => dominykasgel\GoogleSafeBrowsing\Facades\GoogleSafeBrowsingFacade::class
    ]

Preparation
====

1. You need to get your API key from [Google Safe Browsing API](https://developers.google.com/safe-browsing/v4/get-started).  
2. Publish the config file.

    php artisan vendor:publish --force
    
3. Set your API key in `YOUR-APP/config/google_safe_browsing.php`

    'api_key' => '*************************************'

Usage
====
    GoogleSafeBrowsing::lookup( 'https://www.github.com' );

    if ( GoogleSafeBrowsing::isSecure() ) {
        echo 'Secure!';
    }

More examples
====
    GoogleSafeBrowsing::lookup( 'https://www.github.com' );

    if ( GoogleSafeBrowsing::isSecure() ) {
        echo 'Secure!';
    }

    if ( GoogleSafeBrowsing::isSocialEngineering() ) {
        echo 'Social Engineering!';
    }

    if ( GoogleSafeBrowsing::isMalware() ) {
        echo 'Malware!';
    }

    if ( GoogleSafeBrowsing::isUnwanted() ) {
        echo 'Unwatend software!';
    }

    if ( GoogleSafeBrowsing::isHarmfulApplication() ) {
        echo 'Harmful application!';
    }

License
====

The package is licensed under the GPL v3 License.

Copyright 2017 Dominykas Gelucevičius