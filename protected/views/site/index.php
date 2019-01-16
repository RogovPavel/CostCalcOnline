<?php
    $this->pageTitle=Yii::app()->name;
    $this->pageName = 'Добро пожаловать!';
    $this->breadcrumbs=array(
            'Главная' => 'site/index',
    );
?>
<div style="">
    
    <div style="font-weight: bold;">
        Новости\Последние изменения от 01.12.2018
    </div>
    
    <ul>
        <li>Исправлены ошибки в работе сметы</li>
        <li>Добавлена печатная форма КП\сметы</li>
        
    </ul>
</div>


<?php 
    $arr = array();
    $text = 'Здесь будет какойто хаотичный кот123 текст. например слова кот123 и т.д.';
    
    $regexp = '/кот[1-3]{3}/';
    
    preg_match_all($regexp, $text, $arr);
    
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    
       
?>