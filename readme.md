# Install
````
composer require tjwenke/laravel-alidayu

php artisan vendor:publish --provider="Tjwenke\Alidayu\ServiceProvider"
````
Then you should change the config file in ``config/alidayu.php``

# Usage
## Send Message
````
use Tjwenke\Alidayu\Facades\Message;

$result = Code::template('message template')
->params('message paramaters')
->signname('message signname')
->send('phone number');
````

## Send Verification Code
````
use Tjwenke\Alidayu\Facades\Code;

$result = Code::domain('verification code domain')
->template('message template')
->params('message paramaters')
->signname('message signname')
->send('phone number');
````
## Check Verification Code
````
use Tjwenke\Alidayu\Facades\Checker;

$result = Checker::domain('verification code domain')
->check('phone number', 'verfication code');
````

# Error Code
0 - handle success  
1 - verification code sending  
2 - verification code expire  
3 - verification code wrong  