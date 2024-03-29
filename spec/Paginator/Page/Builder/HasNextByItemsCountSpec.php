<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Page\Builder\HasNextByItemsCount;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;

class HasNextByItemsCountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HasNextByItemsCount::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_fills_page_with_has_next_value_true(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->items = Result::fromArray([1,2,3]);
        $page->perPage = 2;

        $page = $this->build($page);

        $page->hasNext->shouldBe(true);
    }

    function it_fills_page_with_has_next_value_false(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->items = Result::fromArray([1,2,3]);
        $page->perPage = 4;

        $page = $this->build($page);

        $page->hasNext->shouldBe(false);
    }
}
