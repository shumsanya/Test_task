<?php
use app\models\IndexModel;


?>
<div class="container" style="margin-top: 30px">
    <?php if (!isset($pageData['data_without_sorting'])){?>
        <a href="http://localhost/test_task_MVC/">
            <button class="btn btn-info">Показать без сортировки</button>
        </a>
<!--    СОХРАНИТЬ ДАННЫЕ В ФАЙЛ  -->
        <a href="<?php $str = "http://localhost/test_task_MVC/save/? filter=". $pageData['filter']."& save=true &". http_build_query($pageData['data_get_params']); echo $str?>">
            <button class="btn btn-info" style="color: #a71d2a; font-weight: bold">Сохранить данные таблици в файл</button>
        </a>
    <?php }else { ?>
        <a href="<?php $str = "http://localhost/test_task_MVC/save/? filter=". $pageData['filter']."& save=true &". http_build_query($pageData['data_get_params']); echo $str?>">
            <button class="btn btn-info" style="color: #a71d2a; font-weight: bold">Сохранить данные таблици в файл</button>
        </a>

    <?php } ?>
</div>

<div class="container" style="margin-top: 30px">
    <table class="table table-bordered table-dark">
        <thead >
        <tr class="table-info">
            <th scope="col" style="color: #005cbf">category
                <div class="btn-group dropright">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" color: #db4e4e ; padding: 0 6px;  "></button>
                    <div class="dropdown-menu" >
                        <h6 class="dropdown-header">Выберите категорию для сортировки</h6>
                        <?php
                        $heading_name = IndexModel::get_unique_names('category');
                        foreach($heading_name as $value){  ?>
                            <a class="dropdown-item" href="?filter=2& field=<?php echo ($value['category']); ?>& column_name=category"><?php echo ($value['category']); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </th>
            <th scope="col" style="color: #005cbf">firstname
                <div class="btn-group dropright">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" color: #db4e4e ; padding: 0 6px;  "></button>
                    <div class="dropdown-menu" >
                        <h6 class="dropdown-header">Выберите имя для сортировки</h6>
                        <?php
                        $heading_name = IndexModel::get_unique_names('firstname');
                        foreach($heading_name as $value){  ?>
                            <a class="dropdown-item" href="?filter=2& field=<?php echo ($value['firstname']); ?>& column_name=firstname""><?php echo ($value['firstname']); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </th>
            <th scope="col" style="color: #005cbf">lastname
                <div class="btn-group dropright">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" color: #db4e4e ; padding: 0 6px;  "></button>
                    <div class="dropdown-menu" >
                        <h6 class="dropdown-header">Выберите фамилию для сортировки</h6>
                        <?php
                        $heading_name = IndexModel::get_unique_names('lastname');
                        foreach($heading_name as $value){  ?>
                            <a class="dropdown-item" href="?filter=2& field=<?php echo ($value['lastname']); ?>& column_name=lastname""><?php echo ($value['lastname']); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </th>
            <th scope="col" style="color: #005cbf">email</th>
            <th scope="col" style="color: #005cbf">gender
                <div class="btn-group dropright">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" color: #db4e4e ; padding: 0 6px;  "></button>
                    <div class="dropdown-menu" >
                        <h6 class="dropdown-header">Выберите пол для сортировки</h6>
                        <?php
                        $heading_name = IndexModel::get_unique_names('gender');
                        foreach($heading_name as $value){  ?>
                            <a class="dropdown-item" href="?filter=2& field=<?php echo ($value['gender']); ?>& column_name=gender""><?php echo ($value['gender']); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </th>
            <th scope="col" style="color: #005cbf">birthDate
                <div class="btn-group dropleft">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"
                        style=" color: #db4e4e ; padding: 0 6px;  "></button>
                    <div class="dropdown-menu" >
                        <h6 class="dropdown-header">Сортируйте по дате, или по возрасту</h6>
                        <?php echo get_form();?>
                    </div>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($pageData['data_without_sorting'] ? $pageData['data_without_sorting'] : $pageData['data_with_sorting'] as $item){ ?>
            <tr>
                <?php
                echo ("<td>". $item['category']  ."</td>");
                echo ("<td>". $item['firstname']  ."</td>");
                echo ("<td>". $item['lastname']  ."</td>");
                echo ("<td>". $item['email']  ."</td>");
                echo ("<td>". $item['gender']  ."</td>");
                echo ("<td>". $item['birthDate']  ."</td>");
                $i++;
                ?>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>


<!--  ПАГИНАЦИЯ  -->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <!-- Кнопка Назад -->
        <li class="page-item ">
            <a class="page-link" href="<?php if($pageData['page_number'] <= 1){ echo '#'; } else {$str = "?page_number=".($pageData['page_number'] - 1)."& filter=". $pageData['filter']."&". http_build_query($pageData['data_get_params']); echo $str;} ?>" >Назад</a>
        </li>

        <!-- Кнопка 1 -->
        <li class="page-item <?php if ($pageData['page_number'] == 1){ echo 'active';} ?>">
            <a class="page-link" href="<?php $str = "?page_number=1& filter=". $pageData['filter'] ."& field=". $_GET['field']. "& column_name=". $_GET['column_name']."&". http_build_query($pageData['data_get_params']); echo $str;?>">1</a></li>

        <!-- Кнопка 2 -->
        <?php if($pageData['page_number'] == 1 || $pageData['page_number'] == 2 || $pageData['page_number'] == 3){
            $button_2 = 2;
        }else{
            $button_2 = $pageData['page_number'];
        }?>
        <li class="page-item <?php if ($pageData['page_number'] == $button_2){ echo 'active';} ?>">
            <a class="page-link" href="<?php $str = "?page_number=".$button_2."& filter=". $pageData['filter']."&". http_build_query($pageData['data_get_params']); echo $str;?>">
                <?php echo $button_2; ?>
            </a>
        </li>

        <!-- Кнопка 3 -->
        <?php if($pageData['page_number'] == 1 || $pageData['page_number'] == 2 || $pageData['page_number'] == 3){
            $button_3 = 3;
        }else{
            $button_3 = $pageData['page_number']+1;
        } ?>
        <li class="page-item <?php if ($pageData['page_number'] == $button_3){ echo 'active';} ?>">
            <a class="page-link" href="<?php $str = "?page_number=".$button_3."& filter=". $pageData['filter']."&". http_build_query($pageData['data_get_params']); echo $str;?>">
                <?php echo $button_3; ?>
            </a>
        </li>

        <!-- Кнопка Следующяя -->
        <li class="page-item">
            <a class="page-link" href="<?php $str = "?page_number=".($pageData['page_number'] + 1)."& filter=". $pageData['filter']."&". http_build_query($pageData['data_get_params']); echo $str;?>">Следующяя</a>
        </li>

    </ul>
</nav>
    <!--  Конец ПАГИНАЦИИ  -->

<!-- скрипти нужны для работы выпадающих элементов, «построены» на сторонней библиотеке Popper.js-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<?php
function get_form(){
    return '
<!--<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#">X</a>-->
   <form class="px-6 py-4" method="get" style="width: 250px; margin: 15px">
   
        <div class="form-group">
            <label for="min_ege">укажите минимальный возраст</label>
            <input type="date" class="form-control" name="min_ege" id="min_ege" placeholder="1" required>
        </div>
    
        <div class="form-group">
            <label for="max_ege">укажите максимальный возраст</label>
            <input type="date" class="form-control" name="max_ege" id="max_ege" placeholder="100 +" required >
        </div>
   
     <div class="form-group">
            <div class="form-check">
                <input type="radio" id="max_min" name="ege" value="max_min">
                <label class="form-check-label" for="max_min">
                    от большего к меньшему
                </label> 
            </div>
        </div>
    
        <div class="form-group">
            <div class="form-check">
                <input type="radio" id="min_max" name="ege" value="min_max" required>
                <label class="form-check-label" for="min_max">
                    от меньшего к большему
                </label>
            </div>
        </div>
    
        <input type="hidden" name="filter" value="3">
    
        <button type="submit" class="btn btn-primary">Сортировать</button>
    </form>
    
    <div class="dropdown-divider"></div>
    
    <form class="px-4 py-3" method="get" >
         <div class="form-group">
            <label for="number_years">Введите число и узнаете кому исполнилось такое количество лет</label>
            <input type="text" class="form-control" name="number_years" id="number_years" placeholder="35"  >
        </div>
        
        <input type="hidden" name="filter" value="4">
        
        <button type="submit" class="btn btn-primary">Сортировать</button>
    </form>
    ';
}