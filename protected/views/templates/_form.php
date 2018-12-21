<script type="text/javascript">
    $(document).ready(function() {
        var state = false;
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var closewindow = <?php echo json_encode($closewindow); ?>;
        
        
        $("#ls-templates-name").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25}));
        $("#ls-templates-active").jqxCheckBox($.extend(true, {}, ls.settings['checkbox'], {theme: ls.defaults.theme, width: '300px', height: 25}));
        $('#ls-templates-editor').jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: "calc(100% - 2px)", width: 'calc(100% - 2px)'}));
        $("#ls-templates-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-templates-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-templates-show-view").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-templates-cancel").on('click', function() {
            window.close();
        });
        
        $("#ls-templates-show-view").on('click', function() {
            if (!state) {
                $('#ls-templates-code').css({'display': 'none'});
                $('#ls-templates-view').css({'display': 'block', 'height': '100%', width: '100%'});

                $('#ls-templates-view').html($('#ls-templates-editor').val());
                state = true;
            }
            else {
                $('#ls-templates-view').css({'display': 'none'});
                $('#ls-templates-code').css({'display': 'block'});
                state = false; 
            }
        });
        
        
        $("#ls-templates-save").on('click', function() {
            $('#ls-templates-template').val($('#ls-templates-editor').val());
            $('#templates').submit();
        });
        
        $("#ls-templates-name").jqxInput('val', model.templatename);
        $('#ls-templates-editor').jqxTextArea('val', model.template);
        $("#ls-templates-active").jqxCheckBox('val', ls.stringtobool(model.active));
        
        if (closewindow)
            window.close();
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'templates',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" id="ls-templates-template" name="templates[template]"/>

<div class="ls-row" style="width: 1024px; height: 100%">
    <div style="margin-bottom: 12px;">
        <div class="ls-row">
            <div class="ls-row-column">
                <div class="ls-form-label">Имя шаблона:</div>
                <div class="ls-row-column"><input type="text" id="ls-templates-name" name="templates[templatename]" autocomplete="off"/></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'templatename'); ?></div>
            </div>
        </div>
        <div class="ls-row">
            <div class="ls-row-column">
                <div class="ls-form-column"><div id="ls-templates-active" name="templates[active]">Активно</div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'active'); ?></div>
            </div>
            <div class="ls-row-column-right">
                <input type="button" id="ls-templates-show-view" value="Просмотр"/>
            </div>
        </div>
    </div>
    <div class="ls-row" style="height: calc(100% - 108px);">
        <div id="ls-templates-code">
            <textarea id="ls-templates-editor" name=""></textarea>
            <div class="ls-form-error"><?php echo $form->error($model, 'template'); ?></div>
        </div>
        <div id="ls-templates-view" style="display: none; overflow: auto;">
            
        </div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-templates-save" value="Сохранить"/></div>
        <div class="ls-row-column-right"><input type="button" id="ls-templates-cancel" value="Отмена"/></div>
    </div>
</div>
    
<?php $this->endWidget(); ?>

