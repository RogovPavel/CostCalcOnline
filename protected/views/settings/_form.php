<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-setting-edit-theme").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: ls.themes, displayMember: "name", valueMember: "name", width: '200px'}));
        
        $("#ls-setting-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-setting-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-setting-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#settings').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-setting-save").click();
                return false;
            }
        });
        
        $("#ls-setting-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('settings', action, $('#settings').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    
                    localStorage.setItem('theme', $("#ls-setting-edit-theme").val());
                    location.reload();
                    
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-setting-edit-theme").jqxComboBox('val', model.theme);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="settings[setting_id]" value="<?php echo $model->setting_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Тема:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-setting-edit-theme" name="settings[theme]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'theme'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-setting-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-setting-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
