<?php
namespace app\controllers;

use app\models\SaveModels;


class SaveController extends Controller
{
    public function Index()
    {
        $model = new SaveModels();

        $this->pageData['title'] = "Запись данных";

        //* Проверка GET параметров для определения нужной сортировки
        if ($_GET['filter']) {

            switch ($_GET['filter']) {
                case 1:
                    $this->pageData['data_with_sorting'] = $model::getData();

                    //* передача параметров для правильной работы пагинации
                    $this->pageData['data_get_params'] = array('' => $_GET[' ']);
                    break;
                case 2:

                    $this->pageData['data_with_sorting'] = $model->get_sort_category($_GET['column_name'], $_GET['field']);
                    $this->pageData['data_get_params'] = array('column_name' => $_GET['column_name'], 'field' => $_GET['field']);
                    
                    break;
                case 3:
                    $this->pageData['data_with_sorting'] = $model->get_sort_ege($_GET['ege'], $_GET['min_ege'], $_GET['max_ege']);
                    $this->pageData['data_get_params'] = array('ege' => $_GET['ege'], 'min_ege' => $_GET['min_ege'], 'max_ege' => $_GET['max_ege']);
                    break;
                case 4:
                    $last_number_id = is_null($_GET['last_number_id']) ? 0 : $_GET['last_number_id'];
                    $this->pageData['data_with_sorting'] = $model->get_full_years($_GET['number_years']);
                    $last_number_id = $this->pageData['data_with_sorting'][9]['id'];
                    $this->pageData['data_get_params'] = array('number_years' => $_GET['number_years'], 'last_number_id' => $last_number_id);
                    break;
            }
        } else {
           // нет данных для записи
        }


        $array = array (0 => Array ('id' => id, 'category' => category, 'firstname' => firstname, 'lastname' => lastname, 'email' => email, 'gender' => gender, 'birthDate' => birthDate ));

        // добавляем в начало масива название колонок
        array_unshift($mass_data, $array); //

        $mass_data = $array + $mass_data;

       /* $filename = "new_file.csv";
        $fp = fopen('d:\OpenServer\domains\localhost\test_task\\'.$filename, 'w');*/

        foreach($mass_data as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);



        return $this->view->render($this->nameTemplate('index'), $this->pageData);
    }


    function nameClass()
    {
        return get_class($this) ;
    }

}