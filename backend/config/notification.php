<?php

return (object) [
	// Webhook ベースURL
	'discord_base_url' => 'https://discord.com/api/webhooks',

	// BOT
	'bot_name' => 'WARZONE通知',

	'embed_color' => (object)[
		'info' => 0x94c5ca,
		'success' => 0x94c529,
	],

	// 新規登録　通知するテンプレート
	'register_notification_template'  => "```
新規登録リクエストがありました。

【参加時間】
##datetime##

【ユーザ名】
##userName##

【プレイヤー名】
##playerName##

【プレイ経験】
##packages##

【Age of Empires II DE (steam版)のアラビアマップ 8人戦 4 vs 4の経験がありますか？】
##arabiaGameExperienceCount##

【戦術で実践可能な戦術があれば選択してください。】
##tactics##

【過去に以下のコミュニティーに参加していた場合選択してください。】
##communityJoined##

```
ログイン後に「新規登録リクエスト」をご確認ください。
##appUrl##/admin/request
",

	'support_name' => 'warzone運営チーム',
	'support_mail_address' => env('MAIL_FROM_ADDRESS'),

	'password_reset_uri' => 'passowrd/reset'
];
