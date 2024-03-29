<?php

namespace Makedo\Paginator\Factory;


use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Page\Builder\CountItems;
use Makedo\Paginator\Page\Builder\CountTotal;
use Makedo\Paginator\Page\Builder\HasNextByPagesCount;
use Makedo\Paginator\Page\Builder\HasPrev;
use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Paginator;
use Makedo\Paginator\Strategy\Limit\PerPage;
use Makedo\Paginator\Strategy\Skip\ById;

class SkipByIdCountableWithCurrentPage extends AbstractFactory
{
    public function createPaginator(
        Loader $loader,
        Counter $counter,
        int $id,
        int $currentPage
    ): Paginator
    {
        $limitStrategy = new PerPage($this->perPage);
        $skipStrategy  = new ById($id);
        $currentPage = $this->filterLessOrEqualZero($currentPage, 1);

        $paginator = new Paginator();
        $paginator
            ->addPipe(new Init($this->perPage, $currentPage))
            ->addPipe(new HasPrev($skipStrategy))
            ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy))
            ->addPipe(new CountItems())
            ->addPipe(new CountTotal($counter))
            ->addPipe(new HasNextByPagesCount())
        ;

        return $paginator;
    }
}
