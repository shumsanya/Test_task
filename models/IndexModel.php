<?php
namespace app\models;


use PDO;
use PDOException;

class IndexModel extends Model
{

    public static function existenceTable(){
        return $results = self::$db->query("SHOW TABLES LIKE 'test'");
    }

    public static function getData($beginning_of_choice = 0, $number_of_lines = 10){
        $sql = "SELECT * FROM `test` WHERE `id` LIMIT :beginning_of_choice, :number_of_lines";
        $stm =  self::$db->prepare($sql);
        $stm->bindParam(':beginning_of_choice', $beginning_of_choice, PDO::PARAM_INT);
        $stm->bindParam(':number_of_lines', $number_of_lines, PDO::PARAM_INT);
        $stm->execute();
        return $data = $stm->fetchAll();
    }


    public static function get_unique_names($column){

        $sql = "SELECT DISTINCT ".$column." FROM test ORDER BY ".$column;
        $stm =  self::$db->prepare($sql);
        $stm->execute();
        return $data = $stm->fetchAll();
    }


    public static function get_sort_category($column_name, $field_name, $beginning_of_choice, $number_of_lines){

        $sql = "SELECT * FROM test WHERE ".$column_name." = :field_name LIMIT :beginning_of_choice, :number_of_lines";
        $stm =  self::$db->prepare($sql);

// ???       $stm->bindParam(':name_column', $column_name);
        $stm->bindParam(':field_name', $field_name);
        $stm->bindParam(':beginning_of_choice', $beginning_of_choice, PDO::PARAM_INT);
        $stm->bindParam(':number_of_lines', $number_of_lines, PDO::PARAM_INT);

        $stm->execute();
        return $data = $stm->fetchAll();
    }


    public static function get_sort_ege($ege, $min_ege, $max_ege, $beginning_of_choice, $number_of_lines){

        if ($ege == 'max_min'){
            $sql = "SELECT *
                    FROM test 
                    WHERE birthDate >= :min_ege and birthDate <= :max_ege
                    ORDER BY birthDate DESC 
                    LIMIT :beginning_of_choice, :number_of_lines";
        }else{
            $sql = "SELECT *
                    FROM test 
                    WHERE birthDate >= :min_ege and birthDate <= :max_ege
                    ORDER BY birthDate  
                    LIMIT :beginning_of_choice, :number_of_lines";
        }

        $stm = self::$db->prepare($sql);
        $stm->bindParam(':min_ege', $min_ege);
        $stm->bindParam(':max_ege', $max_ege);
        $stm->bindParam(':beginning_of_choice', $beginning_of_choice, PDO::PARAM_INT);
        $stm->bindParam(':number_of_lines', $number_of_lines, PDO::PARAM_INT);
        $stm->execute();

        return $data = $stm->fetchAll();
    }


    public static function get_full_years($number_years, $number_of_lines, $last_number_id){

      $end_of_period = date('Y-m-d', strtotime('-'.$number_years.' year'));
      $beginning_of_period = date('Y-m-d', strtotime($end_of_period.' -1 year'));

        $beginning_of_period = strval($beginning_of_period);
        $end_of_period = strval($end_of_period);

      $sql = "SELECT * FROM test WHERE birthDate > :beginning_of_period AND birthDate <= :and_of_period LIMIT :last_number_id, :number_of_lines";
     // $sql = "SELECT * FROM test WHERE birthDate > '2000-01-10' AND birthDate <= '2001-01-10' ORDER BY birthDate LIMIT 10";
      $stm = self::$db->prepare($sql);
      $stm->bindParam(':beginning_of_period', $beginning_of_period);
      $stm->bindParam(':and_of_period', $end_of_period);
      $stm->bindParam(':last_number_id', $last_number_id, PDO::PARAM_INT);
      $stm->bindParam(':number_of_lines', $number_of_lines, PDO::PARAM_INT);
      $stm->execute();

        return $data = $stm->fetchAll();
    }


    public static function createTable($my_file){

        try {
            $sql = "CREATE Table test(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    category VARCHAR(30) NOT NULL,
                    firstname VARCHAR(30) NOT NULL,
                    lastname VARCHAR(30) NOT NULL,
                    email VARCHAR(50),
                    gender VARCHAR(20) NOT NULL,
                    birthDate DATE NOT NULL
                 )";
            self::$db->exec($sql);
        }catch (PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }

        $counter = 0; set_time_limit (600);
        while (($data = fgetcsv($my_file, 1000, ",")) !==false){

            if ($counter == 0){ $counter++; continue; }

            $sql = "INSERT INTO Test (category, firstname, lastname, email, gender, birthDate) VALUE (?,?,?,?,?,?)";
            $stmt= self::$db->prepare($sql);
            $stmt->execute([$data[0],$data[1],$data[2],$data[3],$data[4],$data[5]]);
        }
        fclose($my_file);
    }
}