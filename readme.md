# Install
````
composer require tjwenke/laravel-alidayu

php artisan vendor:publish --provider="Tjwenke\Alidayu\ServiceProvider"
````
Then you should change the config file in ``config/alidayu.php``
````
app_key: alidayu app key 
app_secret: alidayu app secret
log_path: error log path, just when app.debug=true will write log
code_length: verification code length
expire_after: verification code expire time, minutes
resend_delay: verification code resend delay time, minutes
success_times: verfication code check success times
fail_times: verfication code check fail times
````
when verfication code check success times or fail times less than 0, verfication code will be expired.

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

## Return
````
[
	'code' => code
	'message' => message
]
````
* 0 - handle success  
* 1 - verification code sending  
* 2 - verification code expire  
* 3 - verification code wrong  
* 4 - message send fail  