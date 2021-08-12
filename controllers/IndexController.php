<?php
namespace app\controllers;

use app\models\IndexModel;
//use app\system\View;


class IndexController extends Controller
{

    public function Index()
    {
        $this->pageData['title'] = "Главная";
        $model = new IndexModel();

//* Проверка на существование таблицы в базе данных
        $result = $model::existenceTable();

//* Если таблица в базе данных существует, выводим данные таблицы
        if($result->rowCount()>0) {

            $this->pageData['title'] = "Таблица с данными";


            //* Пагинация *//
//* Задаем количество строк отображаемых на одной странице (для пагенации)
            $number_of_lines = 10;

//* начальное значение для отбора данных
            $beginning_of_choice = 0;

//* Переменная  $filter  указываящяя на исполняемый метод

//* Поверка GET параметров
            if ($_GET['page_number']) {
//* Если да то переменной $page_number присваиваем его же значение
                $page_number = $_GET['page_number'];
            } else {
//* Присваиваем $page_number один
                $page_number = 1;
            }

//* Вычисляем с какой строки выводить данные
            $beginning_of_choice = (intval($page_number) - 1) * $number_of_lines;

//* Проверка GET параметров для определения нужной сортировки
            if ($_GET['filter']) {

                if (!$_GET['field'] == '' ){
                    $filter = 2;
                }else{
                    $filter = $_GET['filter'];
                }

                switch ($filter) {
                    case 1:
                        $this->pageData['data_with_sorting'] = $model::getData($beginning_of_choice, $number_of_lines);

                        //* передача параметров для правильной работы пагинации
                        $this->pageData['data_get_params'] = array('' => $_GET[' ']);
                        break;
                    case 2:
                        $this->pageData['data_with_sorting'] = $model->get_sort_category($_GET['column_name'], $_GET['field'], $beginning_of_choice, $number_of_lines);
                        $this->pageData['data_get_params'] = array('column_name' => $_GET['column_name'], 'field' => $_GET['field']);
                        break;
                    case 3:
                        $this->pageData['data_with_sorting'] = $model->get_sort_ege($_GET['ege'], $_GET['min_ege'], $_GET['max_ege'], $beginning_of_choice, $number_of_lines);
                        $this->pageData['data_get_params'] = array('ege' => $_GET['ege'], 'min_ege' => $_GET['min_ege'], 'max_ege' => $_GET['max_ege']);
                        break;
                    case 4:
                        $last_number_id = is_null($_GET['last_number_id']) ? 0 : $_GET['last_number_id'];
                        $this->pageData['data_with_sorting'] = $model->get_full_years($_GET['number_years'], $number_of_lines, $last_number_id);
                        $last_number_id = $this->pageData['data_with_sorting'][9]['id'];
                        $this->pageData['data_get_params'] = array('number_years' => $_GET['number_years'], 'last_number_id' => $last_number_id);
                        break;
                }
            } else {
                $filter = 1;
                //* получаем данные без сортировки
                $this->pageData['data_without_sorting'] = $model::getData($beginning_of_choice, $number_of_lines);

                //* передача параметров для правильной работы пагинации
                $this->pageData['data_get_params'] = array('' => $_GET[' ']);
            }

            $this->pageData['page_number'] = $page_number;
            $this->pageData['filter'] = $filter;

           return $this->view->render($this->nameTemplate('table'), $this->pageData);
        }else{

           $this->pageData['title'] = "загрузить файл";

            //* если файл передали, загружаем файл
            if($_FILES["file"]){
                $my_file = fopen($_FILES['file']['tmp_name'], "r");

                echo '<div class="spinner-border text-info" role = "status" >
                          <span class="sr-only" > Loading...</span >
                      </div >';

                $model::createTable($my_file);
                return $this->Index();
            }
        }

        return $this->view->render($this->nameTemplate('index'), $this->pageData);
    }


    function nameClass()
    {
        return get_class($this) ;
    }

}