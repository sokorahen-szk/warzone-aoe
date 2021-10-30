<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Exception;

class DiscordClient {

	private $client;
	private $method;
	private $template;

	// テンプレート内で置換するワードの区切り
	// 例: ##userName## -> ユーザ名　に置換する区切り
	const REPLACE_DELIMIT = '##';

	const DEFAULT_METHOD = 'POST';

	public function __construct()
	{
		$this->client = new Client();
        $this->options = [
            'http_errors' => true,
        ];
		$this->method = self::DEFAULT_METHOD;

		$this->template = Config::get('notification');
	}

	/**
	 *
	 * @param string $webHook <チャンネルID>/<ランダム数字>
	 * @param string $templateName
	 * @param array $data
	 * @return void
	 */
	public function sendMessageOnTemplate(string $webHook, string $templateName, array $data = []): bool
	{
		$json = $this->parseTemplateJson($templateName, $data);
		switch($this->method) {
			case 'POST':
				return $this->postEventRequest($webHook, $json);
		}

		return false;
	}

	private function postEventRequest(string $webHook, string $json): bool
	{
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception("json parse error.");
		}

		$response = $this->client->post(
			sprintf("%s/%s", $this->template['discord_base_url'], $webHook), [
			'future' 		=> true,
			'headers' 		=> ['Content-Type' => 'application/json'],
			'body' 			=> $json,
		]);

		if (!preg_match("/^2[0-9]{2}$/", (string) $response->getStatusCode())) {
			throw new Exception("bad http request code %d", $response->getStatusCode());
		}

		return true;
	}

	private function parseTemplateJson(string $templateName, array $data): string
	{
		$templateBody = $this->template[$templateName] ?? null;

		if (!$templateBody) {
			throw new Exception('正しいテンプレート名ではありません。');
		}

		foreach ($data as $key => $value) {
			$v = sprintf("%s%s%s",
				self::REPLACE_DELIMIT,
				$key,
				self::REPLACE_DELIMIT
			);
			$templateBody = str_replace($v, $value, $templateBody);
		}

		$content = ['content' => $templateBody];

		return json_encode($content);
	}
}