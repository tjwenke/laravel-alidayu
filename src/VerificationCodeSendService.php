<?php

namespace Tjwenke\Alidayu;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class VerificationCodeService extends MessageService {

	public $code_length = 4;
	public $expire_after = 30;
	public $resend_delay = 1;
	public $success_times = 1;
	public $fail_times = 6;
	public $domain = 'domain';
	public $params = [];

	public function __constructor($config)
	{
		parent::__constructor($config);
		$this->code_length = $config['code_length'];
		$this->success_times = $config['success_times'];
		$this->fail_times = $config['fail_times'];
		$this->expire_after = $config['expire_after'];
		$this->resend_delay = $config['resend_delay'];
	}

	public function domain($domain = 'domain')
	{
		$this->domain = $domain;
		return $this;
	}

	public function params($params)
	{
		$this->params = $params;
		return $this;
	}

	public function send($phone)
	{
		$key = $this->domain . ':' . $phone;
        $data = Cache::get($key);
        if ($data && $data['time'] > time() - $this->resend_delay * 60) {
            return [
            	'code' => 1,
            	'message' => 'verification code sending',
            ];
        }
		$this->params['code'] = random_int(pow(10, $this->code_length - 1), pow(10, $this->code_length) - 1);
		Cache::put($this->domain . ':' . $phone, [
			'code' => $this->params['code'],
			'success' => $this->success_times,
			'fail' => $this->fail_times,
			'time' => time(),
			'expire_at' => Carbon::now()->addMinutes($this->expire_after),
		], $this->expire_after);
		parent::params($this->params);
		return parent::send($phone);
	}
}