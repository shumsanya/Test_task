<?php


namespace app\system;


class View
{
    public function render($template, $pageData)
    {
        include VIEW_PATH.'main.php';
        include VIEW_PATH.$template;
       // include VIEW_PATH.'/save/index.php';
    }
}