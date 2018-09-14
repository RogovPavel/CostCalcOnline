<!--<!DOCTYPE html>-->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_two_column.css">
	
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-3.3.1.min.js"></script>
        <link>
        <?php Yii::app()->clientScript->registerPackage('ls_libs'); ?>
        <link>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#ls-top-menu").jqxMenu({theme: ls.defaults.theme, width: 'calc(100% - 2px)', height: '28px'});
                $("#ls-top-menu").css('visibility', 'visible');
                $("#ls-left-menu").jqxNavigationBar({theme: ls.defaults.theme, width: 200, expandMode: 'multiple', expandedIndexes: [0, 1]});
            });
        </script>
        
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="ls-main-container">
            <div class="ls-column-left">
                <div class="ls-left-menu-container">
                    <div id="ls-left-menu">
                        <div>
                            <div style='margin-top: 2px;'>
                                <div style='float: left;'>
                                    <img alt='Genegals' src='/images/notesIcon.png' />
                                </div>
                                <div style='margin-left: 4px; float: left;'>Общие</div>
                            </div>
                        </div>
                        <div>
                            <ul>
                                <li><a href='<?php echo Yii::app()->createUrl('profile'); ?>'>Личный кабинет</a></li>
                                <li><a href='#'>Обратная связь</a></li>
                            </ul>
                        </div>
                        <div>
                            <div style='margin-top: 2px;'>
                                <div style='float: left;'>
                                    <img alt='Genegals' src='/images/contactsIcon.png' />
                                </div>
                                <div style='margin-left: 4px; float: left;'>Справочники</div>
                            </div>
                        </div>
                        <div>
                            <ul>
                                <li><a href='<?php echo Yii::app()->createUrl('regions'); ?>'>Регионы</a></li>
                                <li><a href='#'>Адреса</a></li>
                                <li><a href='#'>Клиенты</a></li>
                                <li><a href='#'>Банки</a></li>
                                <li><a href='#'>Типы заявок</a></li>
                                <li><a href='#'>Приоритеты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ls-column-right">
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
        </div>
        <div id="ls-dialog" style="display: none;">
            <div id="ls-dialog-header">
                <span id="ls-dialog-header-text"></span>
            </div>
            <div style="padding: 10px;" id="ls-dialog-content">
                
            </div>
        </div>
    </body>
</html>

