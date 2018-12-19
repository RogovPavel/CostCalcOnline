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
        <style>
            @media print {
                #ls-controls {
                    display: none;
                }
            }
        </style>
        <script>
            $(document).ready(function() {
                $('#ls-print').jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
                
                
                $('#ls-print').on('click', function() {
                    window.print();
                });
            });
        </script>
    </head>
    <body style="height: inherit;">
        <div id="ls-controls" style="width: 170mm; margin: 0 auto; margin-bottom: 20px; margin-top: 10px;">
            <div class="ls-row-column-right"><input type="button" id="ls-print" value="Печать"/></div>
            <div style="clear: both;"></div>
        </div>
        <div style="width: 170mm; margin: 0 auto; background-color: white;">
            <?php echo $content; ?>
        </div>
        
    </body>
</html>
