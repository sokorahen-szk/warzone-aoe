<?php declare(strict_types=1);

namespace Package\Application\Admin\Player\ListData;

use Package\Domain\System\Entity\ApiPaginator;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\System\ValueObject\Limit;
use Package\Domain\System\ValueObject\Offset;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Usecase\Admin\Player\ListData\AdminPlayerListCommand;
use Package\Usecase\Admin\Player\ListData\AdminPlayerListData;
use Package\Usecase\Admin\Player\ListData\AdminPlayerListServiceInterface;

class AdminPlayerListService implements AdminPlayerListServiceInterface {

    private $playerRepository;

    public function __construct(
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->playerRepository = $playerRepository;
    }

    public function handle(AdminPlayerListCommand $command): AdminPlayerListData
    {
		$paginator = new Paginator([
			'offset' 	=> 	new Offset($command->page),
			'limit' 	=>	new Limit($command->limit),
		]);

        $players = $this->playerRepository->list($paginator);
        $playerTotalCount = $this->playerRepository->listCount();

		$apiPaginator = new ApiPaginator([
			'currentPage' 	=> $command->page,
			'totalCount' 	=> $playerTotalCount,
			'limit' 		=> $command->limit,
		]);

        return new AdminPlayerListData($players, $apiPaginator);
    }
}