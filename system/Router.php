<?php

namespace app\system;


class Router
{
     public static function buildRout()
    {

        //* контроллер и action по умолчанию
        $controllerName = 'IndexController';
        $action = 'Index';

        //* создаем масив, с помощью разделителя, из урла
        $route = explode("/", $_SERVER['REQUEST_URI']);

        //* задаем название Контроллеру
        if (!empty($route[2]) && strpos($route[2], '?') === false){
            $controllerName = ucfirst($route[2]);
            $controllerName = $controllerName.'Controller';
        }

        //* задаем название Методу (action)
        if (!empty($route[3]) && $route != "" && strpos($route[3], '?') === false) {
            $action = ucfirst($route[3]);
        }

        $controllerName = '\app\controllers\\' . $controllerName;

        
        //* создаем обект класса Контроллера и вызываем метод (action) этого класса
        $controller = new $controllerName();

        //* проверяем существование метода класса
        if (!method_exists($controller, $action)){
            self::errorPage('метод  - '. $action .' -  класса '.$controllerName.'  не найден');
        }

        $controller->$action();
    }

    public static function errorPage($e)
    {
        echo('<h1>страница не найдена 404</h1><br> <h3 style="color: blue"> * '.$e.' * </h3>') ;
        echo('<h3> <a href="http://localhost/test_task_MVC" style="color: red"> перейти на главную </a> </h3><br>') ;
        exit();
    }
}
