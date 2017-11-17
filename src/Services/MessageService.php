<?php

namespace Tjwenke\Alidayu;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use Illuminate\Support\Facades\Log;

class MessageService {
	protected $client;
	protected $request;
	protected $log_path;

	public function __construct($config)
	{
		$this->client = new Client(new App([
			'app_key' => $config['app_key'],
			'app_secret' => $config['app_secret']
		]));
		$this->request = new AlibabaAliqinFcSmsNumSend;
		// dd($this->request);
		if (config('app.debug')) {
			$this->log_path = $config['log_path'];
		}
	}

	public function template($code)
	{
		// dd($this->request);
		$this->request->setSmsTemplateCode($code);
		return $this;
	}

	public function params($params)
	{
		$this->request->setSmsParam($params);
		return $this;
	}

	public function signname($name)
	{
		$this->request->setSmsFreeSignName($name);
		return $this;
	}

	public function send($phone)
	{
		$this->request->setRecNum($phone);
		$res = $this->client->execute($this->request);
		if (!$res->result->success && $this->log_path) {
			Log::useFiles($this->log_path);
			Log::info('message send fail', [
				'request_id' => $res->request_id,
				'params' => $this->request->getParams(),
				'result' => [
					'err_code' => $res->result->err_code,
					'model' => $res->result->model,
					'msg' => $res->result->msg,
					'success' => $res->result->success,
				],
			]);
		}
		return $res->result->success;
	}
}
