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

	public function __constructor($config)
	{
		$this->client = new Client([
			'app_key' => $config['app_key'],
			'app_secret' => $config['app_secret'];
		]);
		$this->request = new AlibabaAliqinFcSmsNumSend;
		if (config('app.debug')) {
			$this->log_path = $config['log_path'];
		}
	}

	public function template($code)
	{
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
		if ($res->result->err_code !== 0 && $this->log_path) {
			Log::useFiles($this->log_path);
			Log::info('message send fail', [
				'request_id' => $res->request_id,
				'params' => $this->request->params,
				'result' => [
					'err_code' => $res->result->err_code,
					'model' => $res->result->model,
					'msg' => $res->result->msg,
					'success' => $res->result->success,
				],
			]);
		}
		return $res->result;
	}
}
