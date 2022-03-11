<?php declare(strict_types=1);

namespace Package\Application\Admin\Player\Update;

use Exception;
use DB;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\Enabled;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateCommand;
use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateServiceInterface;

class AdminPlayerUpdateService implements AdminPlayerUpdateServiceInterface {

    private $playerRepository;

    public function __construct(
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->playerRepository = $playerRepository;
    }

    public function handle(AdminPlayerUpdateCommand $command)
    {
        $player = $this->playerRepository->getById(new PlayerId($command->playerId));
        $player->changePlayerName(new PlayerName($command->playerName));
        $player->changeMu(new Mu($command->mu));
        $player->changeSigma(new Sigma($command->sigma));
        $player->changeRate(new Rate($command->rate));
        $player->changeEnabled(new Enabled($command->enabled));

		try {
			DB::beginTransaction();

            $this->playerRepository->update($player);
            $this->playerRepository->updateEnabled($player);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}