<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

interface DiscordClientInterface {
	/**
	 *
	 * @param string $webHook <チャンネルID>/<ランダム数字>
	 * @param string $templateName
	 * @param array $data
	 * @return void
	 */
	public function sendMessageOnTemplate(string $webHook, string $templateName, array $data = []): bool;

	/**
	 * @param string $webHook <チャンネルID>/<ランダム数字>
	 * @param string $embeds
	 * @return boolean
	 */
	public function sendMessageEmbeds(string $webHook, array $embeds): bool;
}