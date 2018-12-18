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
        <div style="width: 170mm; margin: 0 auto; background-color: white;">
            <?php echo $content; ?>
        </div>
        
    </body>
</html>
