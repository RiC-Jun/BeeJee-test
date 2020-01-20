<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Paginator;

class Index extends ControllerViewableAbstract
{

    protected $dbConditions = [];
    protected $pagination;

    public function __construct()
    {
        parent::__construct();
        $this->pagination = new Paginator();
    }

    protected function handle()
    {
        $this->prepareDbQueryParams();

        $this->view->pagination = $this->pagination->toHtml();
        $this->view->currentPage = $this->pagination->currentPage;
        $this->view->sorting = $this->prepareSortingData();

        $this->view->message = $_SESSION['message'];
        unset($_SESSION['message']);

        $this->view->admin = User::isLoggedIn();
        $this->view->tasks = Task::getAll($this->dbConditions);
        echo $this->view->render(__DIR__ . '/../../templates/index.php');
    }

    protected function prepareDbQueryParams()
    {
        $this->dbConditions['start'] = $this->pagination->getDbLimitStart();
        $this->dbConditions['step'] = $this->pagination->itemsPerPage;
        $this->dbConditions['field'] = $_GET['field'] ?: 'id';
        $this->dbConditions['direction'] = strtoupper($_GET['direction'] ?: 'desc');
    }

    protected function prepareSortingData()
    {
        $sortingArr = [];
        $fieldsArr = (include __DIR__ . '/../config.php')['fields'];
        $directionArr = (include __DIR__ . '/../config.php')['directions'];

        $i = 0;
        foreach ($fieldsArr as $key => $item) {
            $sortingArr['fields'][$i]['name'] = $item;
            $sortingArr['fields'][$i]['value'] = $key;
            if ($key == $_GET['field']) {
                $sortingArr['fields'][$i]['active'] = 1;
            } else {
                $sortingArr['fields'][$i]['active'] = 0;
            }
            $i++;
        }

        $i = 0;
        foreach ($directionArr as $key => $item) {
            $sortingArr['direction'][$i]['name'] = $item;
            $sortingArr['direction'][$i]['value'] = $key;
            if ($key == $_GET['direction']) {
                $sortingArr['direction'][$i]['active'] = 1;
            } else {
                $sortingArr['direction'][$i]['active'] = 0;
            }
            $i++;
        }

        return $sortingArr;
    }

}