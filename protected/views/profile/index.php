<script type="text/javascript">
    $(document).ready(function() {
        
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-login").jqxInput({theme: ls.defaults.theme, width: '150px', height: 25});
        
    
        $("#ls-login").jqxInput('val', model.login);
        
        var users_data_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['users']));
        users_data_adapter.dataBind();
        
        console.log(users_data_adapter.records);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Личный кабинет';
    $this->pageName = 'Личный кабинет';
    $this->breadcrumbs=array(
            'Главная' => 'site/index',
            'Личный кабинет' => 'profile/index',
    );
?>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Users',
	'htmlOptions'=>array(
            'class'=>'form-inline'
        ),
    )); 
?>

<div class="ls-form" style="width: 500px">
    <div class="ls-form-header">Личные данные</div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Логин:</div>
            <div class="ls-form-column"><input type="text" id="ls-login" name="LoginForm[username]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'login'); ?></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div style="clear: both"></div>

<?php if(Yii::app()->user->checkAccess('manager_profile')) { ?>

<div class="ls-form-row">
    <h1><u>Пользователи</u></h1>
</div>

<?php } ?>