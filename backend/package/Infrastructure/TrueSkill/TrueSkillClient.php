<?php declare(strict_types=1);

namespace Package\Infrastructure\TrueSkill;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;
use Exception;

class TrueSkillClient {
	private $client;
	private $template;

	private $response;

	public function __construct(ClientInterface $client = null, array $config = [])
	{
		$this->client = $client ?: new Client();
		$this->template = $config ?: Config::get('true_skill');

		if (!$this->template) {
			// TODO: Exceptionの型修正予定
			throw new Exception('Configパースエラー');
		}
	}

	/**
	 * TrueSkill API トークン取得する
	 *
	 * @return string|null
	 */
	public function token(): ?string
	{
		$response = $this->request('token', [
			'username' => $this->template['username'],
			'password' => $this->template['password'],
		])->get();

		if (!$response) {
			return null;
		}

		return isset($response->token) ? $response->token : null;
	}

	/**
	 * スキルのデフォルト値を取得する
	 *
	 * @param string $token
	 * @return array
	 */
	public function defaultSkill(string $token = null): array
	{
		$token = $token ?: $this->token();

		if (!$token) {
			throw new Exception("トークンエラー");
		}

		return $this->request('default_skill', [
			'auth'  => true,
			'token' => $token,
		])->toArray();
	}

	/**
	 * 試合データからスキルを計算する
	 *
	 * @param array @params
	 * @param string $token
	 * @return Object
	 */
	public function calcSkill(array $params, $token = null) {
		$token = $token ?: $this->token();

		if (!$token) {
			throw new Exception("トークンエラー");
		}

		$data = [
			'auth'  	=> true,
			'token' 	=> $token,
			'json'		=> true,
		];

		$resource = $this->request('calc_skill', array_merge($data, $params))->toArray();

		return $resource;
	}

	/**
	 * チーム分けパターンを取得を取得する
	 *
	 * @param array $params
	 * @param string $token
	 * @return Object
	 */
	public function teamDivisionPattern(array $params, $token = null)
	{
		$token = $token ?: $this->token();

		if (!$token) {
			throw new Exception("トークンエラー");
		}

		$data = [
			'auth'  	=> true,
			'token' 	=> $token,
			'json'		=> true,
		];

		$resource = $this->request('team_division_pattern', array_merge($data, $params))->toArray();

		return $resource[0];
	}

	/**
	 * 対戦履歴からプレイヤーデータをデータコンバートする
	 *
	 * @param string $token
	 */
	public function dataConversion($token = null) {}

	private function request($key, $data = []): self
	{
		$request = $this->template['requests'][$key];
		$headers = $this->addAuthHeader($data);
		$json = isset($data['json']);
		$data = $this->excludeKeyFromData($data, ['auth', 'token', 'json']);

		$paramData = $this->generateParamDara($data, $json);

		if ($request['method'] == 'POST') {
			try {
				$options = [
					'debug' 		=> false,
					'headers' 		=> $headers,
				];
				$response = $this->client->post(
					sprintf("%s/%s", $this->template['true_skill_base_url'], $request['uri']),
					array_merge(
						$options,
						$paramData,
					)
				);

				$this->response = $response->getBody()->getContents();
			} catch (ClientException $e) {
				$this->response = $e->getResponse()->getBody()->getContents();
			}

		} else if ($request['method'] == 'GET') {
			$response = $this->client->get(
				sprintf("%s/%s", $this->template['true_skill_base_url'], $request['uri']),
				[
					'headers' 		=> $headers,
				]
			);

			$this->response = $response->getBody()->getContents();

		} else {
			// TODO: Exceptionの型修正予定
			throw new Exception('method が不正です。');
		}

		return $this;
	}

	private function excludeKeyFromData(array $data, array $excludeData): array
	{
		foreach ($excludeData as $key) {
			if (isset($data[$key])) unset($data[$key]);
		}

		return $data;
	}

	private function jsonDecode()
	{
		$data = json_decode($this->response);

		if (json_last_error() !== JSON_ERROR_NONE) {
			// TODO: Exceptionの型修正予定
			throw new Exception("json parse error.");
		}

		return $data;
	}

	private function get()
	{
		return (object) $this->jsonDecode();
	}

	private function toArray(): array
	{
		if (!$this->response) {
			return [];
		}

		return (array) $this->jsonDecode();
	}

	/**
	 * ヘッダーを追加する
	 *
	 * @param array $data
	 * @return array
	 */
	private function addAuthHeader(array $data)
	{
		$headers = [];
		if (isset($data['auth'])) {
			$headers['Authorization'] = sprintf("jwt %s", $data['token']);
		}

		if (isset($data['json'])) {
			$headers['Content-Type'] = 'application/json';
		}

		return $headers;
	}

	/**
	 * content-typeにあわせてデータ生成
	 *
	 * @param array $data
	 * @param bool $json
	 * @return array
	 */
	private function generateParamDara(array $data, bool $json = false): array
	{
		$params = [];
		if ($json) {
			$params[RequestOptions::JSON] = $data;
		} else {
			$params['form_params'] = $data;
		}

		return $params;
	}

}