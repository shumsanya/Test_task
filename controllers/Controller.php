<?php
namespace app\controllers;

use app\models\Model;
use app\system\View;

abstract class Controller
{
    public $view;
    protected $template;
    protected $pageData = array();

    public function __construct()
    {
        $this->view = new View();
        $this->template = $this->nameClass();
    }


    protected function nameTemplate($file){
        $re = '~^(\P{Lu}*\p{Lu}.*?)\s*(\p{Lu}.*)$~us';
        preg_match($re, $this->nameClass(), $matches);
        $x = explode("\\", $matches[1]);
    //echo $x[2].'\\'.$file.'.php';
        return $x[2].'\\'.$file.'.php';
    }
}