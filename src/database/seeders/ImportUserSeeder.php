<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use App\Models\UserModel;
use App\Models\PlayerModel;

class ImportUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dumpHelper = new DumpHelper();

        $userLines = $dumpHelper->loadDumpFile(dirname(__FILE__) . "/dumps/dump_users");
        $importUsers = [];

        foreach ($userLines as $ul) {
            $userId = (int) $ul[0];
            $t = explode("=", $ul[1]);
            if (count($t) == 2) {
                $userName = $t[1];
                $playerName = $t[0];
            }
            if (count($t) != 2) {
                $userName = strtolower($ul[1]);
                $playerName = $ul[1];
            }

            $createdDatetime = $ul[17];

            $importUsers[] = new ImportUser(
                $userId,
                $userName,
                $playerName,
                $createdDatetime
            );
        }

        $this->createUser($importUsers);
    }

    private function createUser(array $importUsers)
    {
        DB::transaction(function () use ($importUsers) {
            SeederHelper::truncate(['users', 'players']);
            foreach ($importUsers as $importUser) {
                // ownerだけデフォルトパスワードを付与しておく
                if ($importUser->userName !== "titan") {
                    $cryptedPassword = bcrypt('gfeExsAeg092@123'); // default password
                } else {
                    $cryptedPassword = Str::random(20);
                }
                PlayerModel::create([
                    'id'                => $importUser->userId,
                    'name'              => $importUser->playerName,
                    'mu'                => 2500,              // trueSkilldefault値
                    'sigma'             => 833.3333333333333, // trueSkilldefault値
                    'rate'              => 0,
                    'min_rate'          => 0,
                    'max_rate'          => 0,
                    'win'               => 0,
                    'defeat'            => 0,
                    'games'             => 0,
                    'streak'            => 0,
                    'game_packages'     => 1, // 1 = DE
                    'joined_at'         => $importUser->createdDatetime,
                    'last_game_at'      => null,
                    'enabled'           => 1, // enabled
                ]);
                UserModel::create([
                    'id'                => $importUser->userId,
                    'player_id'         => $importUser->userId,
                    'role_id'           => $importUser->roleId,
                    'name'              => $importUser->userName,
                    'status'            => 2, // active = 2
                    'password'          => $cryptedPassword,
                ]);
            }
        });
    }
}

class ImportUser {
    public $userId;
    public $userName;
    public $playerId;
    public $createdDatetime;
    public $roleId;

    private $roleIdToUserMappingList = [
        "titan" => 1,
        "kitamikami" => 2,
        "trash" => 2,
        "cannondo" => 2,
        "shishimaru" => 2,
        "esuda" => 2,
        "imasime" => 2,
        "tomo" => 2,
        "rdlynette" => 2,
        "hirahirahiraco" => 3,
        "bm" => 3,
    ];

    public function __construct(string $userId, string $userName, string $playerName, string $createdDatetime)
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->playerName = $playerName;
        $this->createdDatetime = $createdDatetime;

        $this->setRoleId($userName);
    }

    public function setRoleId(string $userName): void
    {
        foreach($this->roleIdToUserMappingList as $k => $v) {
            if ($userName === $k) {
                $this->roleId = $v;
                return;
            }
        }
        $this->roleId = 4;
    }
}