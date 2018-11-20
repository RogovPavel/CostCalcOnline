<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var units_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['units']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        $("#ls-equip-name").jqxInput({theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25});
        $("#ls-equip-unit").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: units_adapter, displayMember: "unit_name", valueMember: "unit_id", width: '80px'}));
        $("#ls-equip-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        $("#ls-equip-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-equip-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-equip-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#equips').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-equip-save").click();
                return false;
            }
        });
        
        $("#ls-equip-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('equips/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('equips/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#equips').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.state == 0) {
                        ls.equips.id = parseInt(Res.id);
                        $('#ls-btn-refresh').click();
                        
                        if ($('#ls-dialog').length>0)
                            $('#ls-dialog').jqxWindow('close');
                    }
                    else if (Res.state == 1) {
                        $("#ls-dialog-content").html(Res.content);
                    }
                    else
                        ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    
                    
                    
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-equip-name").jqxInput('val', model.equipname);
        $("#ls-equip-unit").jqxComboBox('val', model.unit_id);
        $("#ls-equip-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equips',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="equips[equip_id]" value="<?php echo $model->equip_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-equip-name" name="equips[equipname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'equipname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Ед. изм.:</div>
            <div class="ls-form-column" style="">
                <div id="ls-equip-unit" name="equips[unit_id]" autocomplete="off"/></div>
            </div>
            <div class="ls-form-error"><?php echo $form->error($model, 'unit_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-equip-note" name="equips[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-equip-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-equip-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
