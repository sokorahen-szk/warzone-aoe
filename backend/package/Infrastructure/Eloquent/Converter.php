<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent;

use App\Models\RoleModel;
use App\Models\PlayerModel;
use App\Models\UserModel;
use App\Models\RegisterRequestModel;
use App\Models\GameRecordModel;
use App\Models\PlayerMemoryModel;
use App\Models\GamePackageModel;
use App\Models\MapModel;
use App\Models\RuleModel;

use Package\Domain\User\Entity\Role;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\RegisterRequest;
use Package\Domain\Game\Entity\GamePlayerRecord;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\Entity\GameMap;
use Package\Domain\Game\Entity\GameRule;

use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Role\RoleName;
use Package\Domain\User\ValueObject\Role\RoleLevel;

use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\MinRate;
use Package\Domain\User\ValueObject\Player\MaxRate;
use Package\Domain\User\ValueObject\Player\Win;
use Package\Domain\User\ValueObject\Player\Defeat;
use Package\Domain\User\ValueObject\Player\Games;
use Package\Domain\User\ValueObject\Player\Streak;
use Package\Domain\User\ValueObject\Player\Enabled;
use Package\Domain\User\ValueObject\Player\GamePackages;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name as UserName;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Status;

use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;

use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;

use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameMap\Image;

use Package\Domain\Game\ValueObject\GameRule\GameRuleId;

use Package\Domain\User\ValueObject\PlayerMemory\PlayerMemoryId;

use Package\Domain\System\ValueObject\Description;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Name;

class Converter {
    public static function role(RoleModel $role): Role
    {
        return new Role([
            'roleId'        => new RoleId($role->id),
            'roleName'      => new RoleName($role->name),
            'roleLevel'     => new RoleLevel($role->level),
        ]);
    }
    public static function player(PlayerModel $player): Player
    {
        $user = null;
        if ($player->user) {
            $user = self::user($player->user);
        }

        return new Player([
            'playerId'      => new PlayerId($player->id),
            'playerName'    => new PlayerName($player->name),
            'mu'            => new Mu($player->mu),
            'sigma'         => new Sigma($player->sigma),
            'rate'          => new Rate($player->rate),
            'minRate'       => new MinRate($player->min_rate),
            'maxRate'       => new MaxRate($player->max_rate),
            'win'           => new Win($player->win),
            'defeat'        => new Defeat($player->defeat),
            'games'         => new Games($player->games),
            'streak'        => new Streak($player->streak),
            'gamePackages'  => new GamePackages($player->game_packages),
            'joinedAt'      => new Datetime($player->joined_at),
            'lastGameAt'    => new Datetime($player->last_game_at),
            'enabled'       => new Enabled($player->enabled),
            'user'          => $user,
        ]);
    }

    /**
     * @param Collection $players
     * @return Player[]
     */
    public static function players($players): array
    {
        $resources = [];

        $players->each(function($item) use (&$resources) {
            $resources[] = self::player($item);
        });

        return $resources;
    }

    public static function registerRequest(RegisterRequestModel $registerRequest): RegisterRequest
    {
        $userId = null;
        if ($registerRequest->user_id) {
            $userId = new UserId($registerRequest->user_id);
        }
        return new RegisterRequest([
            'registerId' => new RegisterId($registerRequest->id),
            'playerId' => new PlayerId($registerRequest->player_id),
            'player' => self::player($registerRequest->player),
            'userId' => $userId,
            'registerStatus' => new RegisterStatus($registerRequest->status),
            'remarks' => new Remarks($registerRequest->remarks),
        ]);
    }

    /**
     * @param Collection $registerRequests
     * @return RegisterRequest[]
     */
    public static function registerRequests($registerRequests): array
    {
        $resources = [];

        $registerRequests->each(function($item) use (&$resources) {
            $resources[] = self::registerRequest($item);
        });

        return $resources;
    }

    /**
     * @param UserModel $user
     * @return User
     */
    public static function user(UserModel $user): User
    {
        $player = null;
        if ($user->player) {
            $player = self::player($user->player);
        }
        $role = null;
        if ($user->role) {
            $role = self::role($user->role);
        }
        return new User([
            'id'            => new UserId($user->id),
            'player'        => $player,
            'playerId'      => new PlayerId($user->player_id),
            'role'          => $role,
            'roleId'        => new RoleId($user->role_id),
            'name'          => new UserName($user->name),
            'steamId'       => new SteamId($user->steam_id),
            'twitterId'     => new TwitterId($user->twitter_id),
            'webSiteUrl'    => new WebSiteUrl($user->website_url),
            'avatorImage'   => new AvatorImage($user->avator_image),
            'email'         => new Email($user->email),
            'status'        => new Status($user->status),
            'createdAt'     => new Datetime($user->created_at),
          ]);
    }

    public static function gamePlayerRecord(GameRecordModel $gameRecord): GamePlayerRecord
    {
        return new GamePlayerRecord([
            'gameRecordId'      => new GameRecordId($gameRecord->id),
            'playerMemory'      => self::playerMemory($gameRecord->player_memories[0]),
            'gamePackageId'     => new GamePackageId($gameRecord->game_package_id),
            'winningTeam'       => new GameTeam($gameRecord->winning_team),
            'victoryPrediction' => new VictoryPrediction($gameRecord->victory_prediction),
            'status'            => new GameStatus($gameRecord->status),
            'startedAt'         => new Datetime($gameRecord->started_at),
            'finishedAt'        => new Datetime($gameRecord->finished_at),
        ]);
    }

    /**
     * @param Collection $gameRecords
     * @return GamePlayerRecord[]
     */
    public static function gamePlayerRecords($gameRecords): array
    {
        $resources = [];

        $gameRecords->each(function($item) use (&$resources) {
            $resources[] = self::gamePlayerRecord($item);
        });

        return $resources;
    }

    public static function gameRecord(GameRecordModel $gameRecord): GameRecord
    {
        return new GameRecord([
            'gameRecordId'      => new GameRecordId($gameRecord->id),
            'gamePackage'       => self::gamePackage($gameRecord->game_package),
            'playerMemories'    => self::playerMemories($gameRecord->player_memories),
            'winningTeam'       => new GameTeam($gameRecord->winning_team),
            'victoryPrediction' => new VictoryPrediction($gameRecord->victory_prediction),
            'status'            => new GameStatus($gameRecord->status),
            'startedAt'         => new Datetime($gameRecord->started_at),
            'finishedAt'        => new Datetime($gameRecord->finished_at),
        ]);
    }

    /**
     * @param Collection $gameRecords
     * @return GameRecord[]
     */
    public static function gameRecords($gameRecords): array
    {
        $resources = [];

        $gameRecords->each(function($item) use (&$resources) {
            $resources[] = self::gameRecord($item);
        });

        return $resources;
    }

    public static function playerMemory(PlayerMemoryModel $playerMemory): PlayerMemory
    {
        return new PlayerMemory([
            'playerMemoryId'    => new PlayerMemoryId($playerMemory->id),
            'playerId'          => new PlayerId($playerMemory->player_id),
            'player'            => self::player($playerMemory->player),
            'team'              => new GameTeam($playerMemory->team),
            'mu'                => new Mu($playerMemory->mu),
            'afterMu'           => new Mu($playerMemory->afterMu),
            'sigma'             => new Sigma($playerMemory->sigma),
            'afterSigma'        => new Sigma($playerMemory->afterSigma),
            'rate'              => new Rate($playerMemory->rate),
            'afterRate'         => new Rate($playerMemory->afterRate),
        ]);
    }

    /**
     * @param Collection $playerMemories
     * @return PlayerMemory[]
     */
    public static function playerMemories($playerMemories): array
    {
        $resources = [];

        $playerMemories->each(function($item) use (&$resources) {
            $resources[] = self::playerMemory($item);
        });

        return $resources;
    }

    public static function gamePackage(GamePackageModel $gamePackage): GamePackage
    {
        return new GamePackage([
            'gamePackageId' => new GamePackageId($gamePackage->id),
            'name'          => new Name($gamePackage->name),
            'description'   => new Description($gamePackage->description),
        ]);
    }

    /**
     * @param Collection $gamePackages
     * @return GamePackage[]
     */
    public static function gamePackages($gamePackages): array
    {
        $resources = [];

        $gamePackages->each(function($item) use (&$resources) {
            $resources[] = self::gamePackage($item);
        });

        return $resources;
    }

    public static function gameMap(MapModel $gameMap): GameMap
    {
      return new GameMap([
        'gameMapId'        => new GameMapId($gameMap->id),
        'gamePackageId'    => new GamePackageId($gameMap->game_package_id),
        'name'             => new Name($gameMap->name),
        'image'            => new Image($gameMap->image),
        'description'      => new Description($gameMap->description),
      ]);
    }

    public static function gameRule(RuleModel $gameRule): GameRule
    {
      return new GameRule([
        'gameRuleId'       => new GameRuleId($gameRule->id),
        'gamePackageId'    => new GamePackageId($gameRule->game_package_id),
        'name'             => new Name($gameRule->name),
        'description'      => new Description($gameRule->description),
      ]);
    }
}