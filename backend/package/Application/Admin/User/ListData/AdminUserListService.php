<?php declare(strict_types=1);

namespace Package\Application\Admin\User\ListData;

use Package\Domain\System\Entity\ApiPaginator;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Usecase\Admin\User\ListData\AdminUserListServiceInterface;
use Package\Usecase\Admin\User\ListData\AdminUserListData;

use Package\Domain\System\ValueObject\Offset;
use Package\Domain\System\ValueObject\Limit;
use Package\Domain\System\Entity\Paginator;
use Package\Usecase\Admin\User\ListData\AdminUserListCommand;

class AdminUserListService implements AdminUserListServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(AdminUserListCommand $command): AdminUserListData
    {
		$paginator = new Paginator([
			'offset' 	=> 	new Offset($command->page),
			'limit' 	=>	new Limit($command->limit),
		]);

        $users = $this->userRepository->list($paginator);
		$userTotalCount = $this->userRepository->listCount($paginator);

		$apiPaginator = new ApiPaginator([
			'currentPage' 	=> $command->page,
			'totalCount' 	=> $userTotalCount,
			'limit' 		=> $command->limit,
		]);

        return new AdminUserListData($users, $apiPaginator);
    }
}