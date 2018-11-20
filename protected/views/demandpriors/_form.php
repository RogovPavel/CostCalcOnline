<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-demandprior-name").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25}));
        $("#ls-demandprior-timeexec").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {theme: ls.defaults.theme, width: '100px', height: 25, decimalDigits: 0}));
        $("#ls-demandprior-worktime").jqxCheckBox($.extend(true, {}, ls.settings['checkbox'], {theme: ls.defaults.theme, width: '300px', height: 25}));
        $("#ls-demandprior-weekend").jqxCheckBox($.extend(true, {}, ls.settings['checkbox'], {theme: ls.defaults.theme, width: '300px', height: 25}));
        
        
        $("#ls-demandprior-save").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
        $("#ls-demandprior-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
        
        $("#ls-demandprior-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#demandpriors').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-demandprior-save").click();
                return false;
            }
        });
        
        $("#ls-demandprior-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('demandpriors/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('demandpriors/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#demandpriors').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.demandpriors.id = parseInt(Res.id);
                        $('#ls-btn-refresh').click();
                        
                        if ($('#ls-dialog').length>0)
                            $('#ls-dialog').jqxWindow('close');
                    }
                    else {
                        $("#ls-dialog-content").html(Res.content);
                    }
                    
                    
                    
                    
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-demandprior-name").jqxInput('val', model.demandprior_name);
        $("#ls-demandprior-timeexec").jqxNumberInput('val', model.time_exec);
        $("#ls-demandprior-worktime").jqxCheckBox('val', ls.stringtobool(model.worktime));
        $("#ls-demandprior-weekend").jqxCheckBox('val', ls.stringtobool(model.weekend));
        
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'demandpriors',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="demandpriors[demandprior_id]" value="<?php echo $model->demandprior_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-demandprior-name" name="demandpriors[demandprior_name]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'demandprior_name'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Время на выполнение (ч):</div>
            <div class="ls-form-column" style=""><div id="ls-demandprior-timeexec" name="demandpriors[time_exec]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'time_exec'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label"><div id="ls-demandprior-worktime" name="demandpriors[worktime]">Учитывать рабочее время</div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'worktime'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label"><div id="ls-demandprior-weekend" name="demandpriors[weekend]">Учитывать выходные</div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'weekend'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-demandprior-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-demandprior-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
