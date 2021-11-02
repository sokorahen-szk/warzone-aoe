<?php

return (object) [
	// Webhook ベースURL
	'discord_base_url' => 'https://discord.com/api/webhooks',

	// BOT
	'bot_name' => 'WARZONE通知',

	// 新規登録　通知するテンプレート
	'register_notification_template'  => "```
新規登録リクエストがありました。

【申請時間】
##datetime##

【ユーザ名】
##userName##

【プレイヤー名】
##playerName##

【プレイ経験】
##packages##

ログイン後に「新規登録リクエスト」をご確認ください。

https://warzone-aoe.herokuapp.com/admin/request
```
"
];
