<?php

namespace App;

use App\Models\Task;

class Paginator
{
    const NUM_PLACEHOLDER = '(@num)';

    public $allItemsQty;
    public $totalPagesQty;
    public $currentPage;
    public $itemsPerPage = 3;
    public $maxPagesToShow = 5;
    public $urlPattern;
    public $sortField;
    public $sortDirection;
    protected $previousText = 'Назад';
    protected $nextText = 'Вперед';
    protected $siteAddress;

    public function __construct()
    {
        $this->allItemsQty = Task::getTotalQty();
        $this->currentPage = $_GET['page'] ?: 1;
        $this->sortField = $_GET['field'] ?: '';
        $this->sortDirection = $_GET['direction'] ?: '';
        $this->totalPagesQty = ceil($this->allItemsQty / $this->itemsPerPage);
        $this->siteAddress= $_SERVER['SERVER_NAME'];
        $this->buildUrlPattern();
    }

    public function getDbLimitStart() {
        return $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;
    }

    public function buildUrlPattern()
    {
        if ($this->sortField) {
            $this->urlPattern = '/?field=' . $this->sortField . '&direction=' . $this->sortDirection . '&page=(@num)';
        } else {
            $this->urlPattern = '/?page=(@num)';
        }
    }

    public function getNextPage()
    {
        if ($this->currentPage < $this->totalPagesQty) {
            return $this->currentPage + 1;
        }
        return null;
    }

    public function getPrevPage()
    {
        if ($this->currentPage > 1) {
            return $this->currentPage - 1;
        }
        return null;
    }


    public function getPageUrl($pageNum)
    {
        if ($pageNum == 1) {
            if ($this->sortField) {
                return '/?field=' . $this->sortField . '&direction=' . $this->sortDirection;
            } else {
                return '/';
            }
        }
        return str_replace(self::NUM_PLACEHOLDER, $pageNum, $this->urlPattern);
    }

    public function getNextUrl()
    {
        if (!$this->getNextPage()) {
            return null;
        }
        return $this->getPageUrl($this->getNextPage());
    }

    public function getPrevUrl()
    {
        if (!$this->getPrevPage()) {
            return null;
        }
        return $this->getPageUrl($this->getPrevPage());
    }

    public function getPages()
    {
        $pages = [];

        if ($this->totalPagesQty <= 1) {
            return [];
        }

        if ($this->totalPagesQty <= $this->maxPagesToShow) {
            for ($i = 1; $i <= $this->totalPagesQty; $i++) {
                $pages[] = $this->createPage($i, $i == $this->currentPage);
            }
        } else {
            $numAdjacents = (int)floor(($this->maxPagesToShow - 3) / 2);

            if ($this->currentPage + $numAdjacents > $this->totalPagesQty) {
                $slidingStart = $this->totalPagesQty - $this->maxPagesToShow + 2;
            } else {
                $slidingStart = $this->currentPage - $numAdjacents;
            }
            if ($slidingStart < 2) $slidingStart = 2;

            $slidingEnd = $slidingStart + $this->maxPagesToShow - 3;
            if ($slidingEnd >= $this->totalPagesQty) $slidingEnd = $this->totalPagesQty - 1;

            $pages[] = $this->createPage(1, $this->currentPage == 1);
            if ($slidingStart > 2) {
                $pages[] = $this->createPageEllipsis();
            }
            for ($i = $slidingStart; $i <= $slidingEnd; $i++) {
                $pages[] = $this->createPage($i, $i == $this->currentPage);
            }
            if ($slidingEnd < $this->totalPagesQty - 1) {
                $pages[] = $this->createPageEllipsis();
            }
            $pages[] = $this->createPage($this->totalPagesQty, $this->currentPage == $this->totalPagesQty);
        }

        return $pages;
    }

    protected function createPage($pageNum, $isCurrent = false)
    {
        return array(
            'num' => $pageNum,
            'url' => $this->getPageUrl($pageNum),
            'isCurrent' => $isCurrent,
        );
    }

    protected function createPageEllipsis()
    {
        return array(
            'num' => '...',
            'url' => null,
            'isCurrent' => false,
        );
    }

    public function toHtml()
    {
        if ($this->totalPagesQty <= 1) {
            return '';
        }

        $html = '<ul class="pagination">';
        if ($this->getPrevUrl()) {
            $html .= '<li class="page-item"><a href="' . htmlspecialchars($this->getPrevUrl()) . '" class="page-link" >&laquo; ' . $this->previousText . '</a></li>';
        }

        foreach ($this->getPages() as $page) {
            if ($page['url']) {
                $html .= '<li' . ' class="page-item' . ($page['isCurrent'] ? ' active' : '') . '"><a href="' . htmlspecialchars($page['url']) . '" class="page-link">' . htmlspecialchars($page['num']) . '</a></li>';
            } else {
                $html .= '<li class="page-item disabled"><span class="page-link">' . htmlspecialchars($page['num']) . '</span></li>';
            }
        }

        if ($this->getNextUrl()) {
            $html .= '<li class="page-item"><a href="' . htmlspecialchars($this->getNextUrl()) . '" class="page-link">' . $this->nextText . ' &raquo;</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }

}