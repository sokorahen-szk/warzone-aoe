<?php declare(strict_types=1);

namespace Package\Infrastructure\TrueSkill;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;

class TrueSkillClient {
	private $client;
	private $template;

	private $response;

	public function __construct(Client $client = null, array $config = [])
	{
		$this->client = $client ?: new Client();
		$this->template = $config ?: Config::get('true_skill');

		if (!$this->template) {
			// TODO: Exceptionの型修正予定
			throw new \Exception('Configパースエラー');
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
		])->toArray();

		if (!$response) {
			null;
		}

		return isset($response->token) ? $response->token : null;
	}

	/**
	 * スキルのデフォルト値を取得する
	 *
	 * @param string $token
	 */
	public function defaultSkill(string $token = null) {}

	/**
	 * 試合データからスキルを計算する
	 *
	 * @param string $token
	 */
	public function calcSkill($token = null) {}

	/**
	 * チーム分けパターンを取得を取得する
	 *
	 * @param string $token
	 */
	public function teamDivisionPattern($token = null) {}

	/**
	 * 対戦履歴からプレイヤーデータをデータコンバートする
	 *
	 * @param string $token
	 */
	public function dataConversion($token = null) {}

	private function request($key, $data = []): self
	{
		$request = $this->template['requests'][$key];

		if ($request['method'] == 'POST') {
			try {
				$response = $this->client->post(
					sprintf("%s/%s", $this->template['true_skill_base_url'], $request['uri']),
					[
						'debug' 		=> false,
						'form_params'  	=> $data,
						'headers' 		=> [
							'Content-Type' => 'application/x-www-form-urlencoded',
						],
					]
				);

				$this->response = $response->getBody()->getContents();

			} catch (ClientException $e) {
				$this->response = $e->getResponse()->getBody()->getContents();
			}

		} else if ($request['method'] == 'GET') {
			$response = $this->client->get(
				sprintf("%s/%s", $this->template['true_skill_base_url'], $request['uri'])
			);

			$this->response = $response->getBody()->getContents();

		} else {
			// TODO: Exceptionの型修正予定
			throw new \Exception('method が不正です。');
		}

		return $this;
	}

	private function json(): string
	{
		if (!$this->response) {
			return '';
		}

		return $this->response;
	}

	private function toArray()
	{
		if (!$this->response) {
			return [];
		}

		$data = json_decode($this->response);

		if (json_last_error() !== JSON_ERROR_NONE) {
			// TODO: Exceptionの型修正予定
			throw new \Exception("json parse error.");
		}

		return $data;
	}

}