<?php
    $this->pageTitle=Yii::app()->name;
    $this->pageName = 'Добро пожаловать!';
    $this->breadcrumbs=array(
            'Главная' => 'site/index',
    );
?>

<h1>Приветствуем Вас <i>на страницах нашего проекта</i>!!!</h1>

<p>
    Данный проект был разработан для коммерческих организаций, индивидуальных предпринимателей, которые занимаются установками и обслуживанием систем безопасности.
    В этот проект были включены основные требования для программного обеспечения подобного рода.
</p>
<p>Основные функции которые выполняет приложение:</p>
    <ul>
        <li>Заведение новых клиентов в систему</li>
        <li>Заведение адресов клиентов</li>
        <li>Регитсрация заявок от клиентов двумя способами: внетрення форма; форма для клиентов;</li>
    </ul>

<p></p>

<?php 

//   $sql = 'SET @region_id=:p_region_id;SET @region_name=:p_region_name;SET @group_id=:p_group_id;SET @user_create=:p_user_create;CALL insert_regions(@region_id,@region_name,@group_id,@user_create);SELECT @region_id as region_id, @region_name as region_name, @group_id as group_id, @user_create as user_create';
//   $sql = 'set @p1 = :p_region_id; select @p1 as param1';
   
//   $command = Yii::app()->db->createCommand();
//   $command->text = $sql;
//   $command->bindValues(array(':p_region_id' => null, ':p_region_name' => 'ОЛОЛОЛ', ':p_group_id' => 1, ':p_user_create' => 16));
//   $command->execute();
//
//   $command->text = ('SELECT @region_id as region_id, @region_name as region_name, @group_id as group_id, @user_create as user_create;');
//   $r = $command->queryAll();
//   print_r($r);

//    $sp = new LSStoredProc();
//    
//    $sp->sp_proc_name = 'insert_regions';
//    $sp->proc_params = array('region_id', 'region_name', 'group_id', 'user_create');
//    $res = $sp->execute(array('region_id' => null, 'region_name' => '555', 'group_id' => 1, 'user_create' => 16));
//    
//    print_r($res);
    
?>

