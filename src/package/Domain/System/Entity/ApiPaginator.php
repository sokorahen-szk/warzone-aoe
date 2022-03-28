<?php

namespace Package\Domain\System\Entity;

use Package\Domain\Resource;

class ApiPaginator extends Resource {
	protected $currentPage;
	protected $totalCount;
	protected $limit;

	public function __construct($data)
	{
		parent::__construct($data);
	}

	public function getPrefPage(): int
	{
		return $this->getCurrentPage() > 1 ? $this->getCurrentPage() - 1 : 1;
	}

	public function getCurrentPage(): int
	{
		return $this->currentPage >= 1 ? $this->currentPage : 1;
	}

	public function getNextPage(): int
	{
		return $this->getCurrentPage() < $this->getTotalPage() ? $this->getCurrentPage() + 1 : $this->getTotalPage();
	}

	public function getTotalCount(): int
	{
		return $this->totalCount;
	}

	public function getTotalPage(): int
	{
		return ceil($this->totalCount/$this->limit);
	}

	public function getLimit(): int
	{
		return $this->limit;
	}

	public function getPaginator()
	{
		return (object) [
			'pref' 			=> $this->getPrefPage(),
			'current' 		=> $this->getCurrentPage(),
			'next' 			=> $this->getNextPage(),
			'totalCount' 	=> $this->getTotalCount(),
			'totalPage' 	=> $this->getTotalPage(),
			'limit' 		=> $this->getLimit(),
		];
	}
}