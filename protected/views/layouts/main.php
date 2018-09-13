<!--<!DOCTYPE html>-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        
        <?php Yii::app()->clientScript->registerPackage('ls_libs'); ?>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $("#ls-top-menu").jqxMenu({theme: ls.defaults.theme, width: 'calc(100% - 2px)', height: '28px'});
                $("#ls-top-menu").css('visibility', 'visible');
                
                
            });
        </script>
        
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="ls-main-container">
            <div class="ls-top-menu_container">
                <div id="ls-top-menu" style="visibility: hidden;">
                    <ul>
                        <li><a href="#">Главная</a></li>
                        <li><a href="#">Поддержка</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('site/login'); ?>">Вход</a></li>
                    </ul>
                </div>
            </div>
            <div class="ls-breadcrumbs-container">
                <div class="ls-breadcrumbs">
                    <?php
                        if(isset($this->breadcrumbs)) {
                            foreach ($this->breadcrumbs as $key => $value) {
                                $url = (isset($value[1])) ? Yii::app()->createUrl($value[0], $value[1]) : Yii::app()->createUrl($value[0]);
                                echo    '<div class="ls-breadcrumbs-item">
                                            <div class="ls-arrow-right-breadcrumbs"></div>
                                            <span><a href="' . $url . '">' . $key . '</a></span>
                                        </div>';
                            }
                        }
                        
                    ?>
                </div>
            </div>
            <div class="ls-body-container">
                <div class="ls-body-header"><span>Авторизация</span></div>
                <div class="ls-body-content">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>    