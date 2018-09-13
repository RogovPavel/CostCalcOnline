<script type="text/javascript">
    $(document).ready(function() {
        $("#ls-login").jqxInput({theme: ls.defaults.theme, width: '150px', height: 25});
        $("#ls-password").jqxPasswordInput({theme: ls.defaults.theme, width: '150px', height: 25});
        $("#ls-btn-login").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-btn-remember-pass").jqxButton({theme: ls.defaults.theme, width: '160px', height: 30});
    });
</script>

<?php

$this->pageTitle=Yii::app()->name . ' - Авторизация';
$this->breadcrumbs=array(
        'Главная' => array('site/index'),
	'Авторизация',
);
?>

<div class="ls-form">
    <div class="ls-form-header">Вход</div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Логин:</div>
            <div class="ls-form-column"><input type="text" id="ls-login"/></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Пароль:</div>
            <div class="ls-form-column"><input type="password" id="ls-password"/></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-btn-login" value="Войти"/></div>
            <div class="ls-form-column" style="float: right;"><input type="button" id="ls-btn-remember-pass" value="Забыли пароль?"/></div>
        </div>
    </div>
</div>


