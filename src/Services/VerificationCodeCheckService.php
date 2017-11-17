<?php 

namespace Tjwenke\Alidayu\Services;

use Illuminate\Support\Facades\Cache;

class VerificationCodeCheckService {

	public $domain = 'domain';

	public function domain($domain = 'domain')
	{
		$this->domain = $domain;
		return $this;
	}

	public function check($phone, $code)
	{
		$key = $this->domain . ':' . $phone;
		$data = Cache::get($key);
		if (!$data) {
			return [
				'code' => 2,
				'message' => 'code expire',
			];
		}
		if ($data['code'] != $code) {
			$data['fail'] = $data['fail'] - 1;
			$this->updateData($key, $data);
			return [
				'code' => 3,
				'message' => 'code wrong',
			];
		}
		$data['success'] = $data['success'] - 1;
		$this->updateData($key, $data);
		return [
			'code' => 0,
			'message' => 'success',
		];
	}

	private function updateData($key, $data)
	{
		if ($data['fail'] < 1 || $data['success'] < 1) {
			Cache::forget($key);
		} else {
			Cache::put($key, $data, $data['expire_at']);
		}
	}
}