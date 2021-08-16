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
                    $data_to_write = $model::getData();
                    break;
                case 2:
                    $data_to_write = $model->get_sort_category($_GET['column_name'], $_GET['field']);
                    $this->pageData['data_get_params'] = array('column_name' => $_GET['column_name'], 'field' => $_GET['field']);
                    break;
                case 3:
                    $data_to_write = $model->get_sort_ege($_GET['ege'], $_GET['min_ege'], $_GET['max_ege']);
                    $this->pageData['data_get_params'] = array('ege' => $_GET['ege'], 'min_ege' => $_GET['min_ege'], 'max_ege' => $_GET['max_ege']);
                    break;
                case 4:
                    $data_to_write = $model->get_full_years($_GET['number_years']);
                    $this->pageData['data_get_params'] = array('number_years' => $_GET['number_years']);
                    break;
            }
        } else {
           // нет данных для записи
            echo 'нет данных для записи';
        }

        $filename = "new_file.csv";
        $fp = fopen(ROOT.'/downloads/'.$filename, 'w');


        $headers = [
            'id' => 'id', 'category' => 'category', 'firstname' => 'firstname', 'lastname' => 'lastname', 'email' => 'email', 'gender' => 'gender', 'birthDate' => 'birthDate'
        ];

        fputcsv($fp, $headers);

        foreach($data_to_write as $row) {
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