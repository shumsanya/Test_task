<?php
namespace app\controllers;


class UserController extends Controller
{

    //$this->model = new IndexModel();
    public function index()
    {
        $this->pageData['title'] = "About user";
        $this->view->render($this->nameTemplate('index'), $this->pageData);
    }

    function nameClass()
    {
        return get_class($this) ;
    }
}