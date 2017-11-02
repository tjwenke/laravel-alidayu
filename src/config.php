<?php

return [
	'app_key' => env('ALIDAYU_APP_KEY', 'your-app-key'),
	'app_secret' => env('ALIDAYU_APP_SECRET', 'your-app-secret'),
	'log_path' => env('ALIDAYU_LOG_PATH', storage_path('logs/alidayu.log')),
	'code_length' => 4,
	'expire_after' => 30,	// expire time, minutes
	'resend_delay' => 1,	// resend deley, minutes
	'success_times' => 1,
	'fail_times' => 6,
];