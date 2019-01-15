<!--<!DOCTYPE html>-->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <meta name="meta-theme" theme="<?php echo $this->theme; ?>">
        <?php Yii::app()->clientScript->registerPackage('ls_libs'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/js/jqwidgets/styles/jqx." . $this->theme . ".css"); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/main." . $this->theme . ".css"); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        
        <div class="ls-main-container">
            <div class="ls-column-right">
                <div class="ls-top-menu_container">
                    <div id="ls-top-menu" style="visibility: hidden;">
                        <!--Подгружаем меню-->
                        <?php 
                            $menu = include(Yii::app()->basePath . '/config/menu.php');
                            echo $menu;
                        ?>
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
        </div>
        <div id="ls-dialog" style="display: none;">
            <div id="ls-dialog-header">
                <span id="ls-dialog-header-text"></span>
            </div>
            <div style="padding: 10px;" id="ls-dialog-content">
                
            </div>
        </div>
        <div id="ls-error-dialog" style="display: none;">
            <div id="ls-error-dialog-header">
                <span id="ls-error-dialog-header-text"></span>
            </div>
            <div style="padding: 10px;" id="ls-error-dialog-content">
                <div class="ls-row" style="height: calc(100% - 34px);"><textarea id="ls-error-message"></textarea></div>
                <div class="ls-row">
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-error-close" value="Закрыть" /></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        $("#ls-top-menu").jqxMenu({theme: ls.defaults.theme, width: 'calc(100% - 2px)', height: '30px'});
        $("#ls-top-menu").css('visibility', 'visible');
    });
</script>

