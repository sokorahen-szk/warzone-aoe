<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use GuzzleHttp\Client;
use Config;
use Exception;

class DiscordClient implements DiscordClientInterface {
	private $client;
	private $template;

	// テンプレート内で置換するワードの区切り
	// 例: ##userName## -> ユーザ名　に置換する区切り
	const REPLACE_DELIMIT = '##';

	public function __construct()
	{
		$this->client = new Client();

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
		return $this->eventRequest($webHook, $json);
	}

	/**
	 * @param string $webHook <チャンネルID>/<ランダム数字>
	 * @param string $embeds
	 * @return boolean
	 */
	public function sendMessageEmbeds(string $webHook, array $embeds): bool
	{
		$json = json_encode($embeds);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception("json parse error.");
		}

		return $this->eventRequest($webHook, $json);
	}

	private function eventRequest(string $webHook, string $json): bool
	{
		$response = $this->client->post(
			sprintf("%s/%s", $this->template->discord_base_url, $webHook), [
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
		$templateBody = $this->template->{$templateName} ?? null;

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

		$content = [
			'content' => $templateBody,
			'username' => $this->template->bot_name,
		];
		$json  = json_encode($content);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception("json parse error.");
		}

		return $json;
	}
}