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
//    $sender = new LSPHPMailer();
//    
//    $sender->host = 'it-pc-02';
//    $sender->port = 2155;
//    $sender->username = 'reglament';
//    $sender->password = 'resetboard';
//    $sender->fromaddress = 'reglament@aliton.ru';
    
//    $sender->Send(array('pasha-rogov@yandex.ru'), array(), 'test22', 'test', '', true);
?>