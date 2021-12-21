<?php

return [
    [
        'label' => '新規登録リクエスト一覧取得',
        'path' => 'admin/request',
        'level' => 50,
    ],
    [
        'label' => '新規登録リクエスト更新',
        'path' => 'admin/request/[0-9]*',
        'level' => 50,
    ],
    [
        'label' => 'ユーザ管理一覧取得',
        'path' => 'admin/user',
        'level' => 100,
    ],
    [
        'label' => 'ユーザ管理更新',
        'path' => 'admin/user/[0-9]*',
        'level' => 100,
    ],
    [
        'label' => 'ユーザ管理作成',
        'path' => 'admin/user/create',
        'level' => 100,
    ],
];