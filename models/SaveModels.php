<?php
namespace app\models;

use PDO;
use PDOException;

class SaveModels extends Model
{

    public static function getData(){
        $sql = "SELECT * FROM `test` ";
        $stm =  self::$db->prepare($sql);
        $stm->execute();
        return $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_sort_category($column_name, $field_name){

        $sql = "SELECT * FROM test WHERE ".$column_name." = :field_name ";
        $stm =  self::$db->prepare($sql);

        $stm->bindParam(':field_name', $field_name);

        $stm->execute();
        return $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function get_sort_ege($ege, $min_ege, $max_ege){

        if ($ege == 'max_min'){
            $sql = "SELECT *
                    FROM test 
                    WHERE birthDate >= :min_ege and birthDate <= :max_ege
                    ORDER BY birthDate DESC 
                   ";
        }else{
            $sql = "SELECT *
                    FROM test 
                    WHERE birthDate >= :min_ege and birthDate <= :max_ege
                    ORDER BY birthDate  
                   ";
        }

        $stm = self::$db->prepare($sql);
        $stm->bindParam(':min_ege', $min_ege);
        $stm->bindParam(':max_ege', $max_ege);
        $stm->execute();

        return $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function get_full_years($number_years){

        $end_of_period = date('Y-m-d', strtotime('-'.$number_years.' year'));
        $beginning_of_period = date('Y-m-d', strtotime($end_of_period.' -1 year'));

        $beginning_of_period = strval($beginning_of_period);
        $end_of_period = strval($end_of_period);

        $sql = "SELECT * FROM test WHERE birthDate > :beginning_of_period AND birthDate <= :and_of_period ";
        // $sql = "SELECT * FROM test WHERE birthDate > '2000-01-10' AND birthDate <= '2001-01-10' ORDER BY birthDate LIMIT 10";
        $stm = self::$db->prepare($sql);
        $stm->bindParam(':beginning_of_period', $beginning_of_period);
        $stm->bindParam(':and_of_period', $end_of_period);
        $stm->execute();

        return $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    }


}