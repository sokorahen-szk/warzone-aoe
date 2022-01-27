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

ログイン後に「新規登録リクエスト」をご確認ください。

##appUrl##/admin/request
```
"
];
