<!--<!DOCTYPE html>-->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-3.3.1.min.js"></script>
        <link>
        <?php Yii::app()->clientScript->registerPackage('ls_libs'); ?>
        <link>
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
                        <?php if (Yii::app()->user->isGuest) { ?>
                            <li><a href="<?php echo Yii::app()->createUrl('site/login'); ?>">Вход</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">Выход (<?php echo Yii::app()->user->login; ?>)</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="ls-breadcrumbs-container">
                <div class="ls-breadcrumbs">
                    <?php
                        if(isset($this->breadcrumbs)) {
                            foreach ($this->breadcrumbs as $key => $value) {
                                echo    '<div class="ls-breadcrumbs-item">
                                            <div class="ls-arrow-right-breadcrumbs"></div>
                                            <span><a href="' . Yii::app()->createUrl($value) . '">' . $key . '</a></span>
                                        </div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="ls-body-container">
                <div class="ls-body-header"><span><?php echo $this->pageName; ?></span></div>
                <div class="ls-body-content">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>    