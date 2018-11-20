<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var equips_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['equips']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        $('#ls-objectequip-equip').on('select', function (event) {
            var args = event.args;
            if (args) {
                var item = args.item;
                var data = item.originalItem;
                $("#ls-objectequip-unit").val(data.unit_name);
            }
        }); 
        
        $("#ls-objectequip-equip").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: equips_adapter, displayMember: "equipname", valueMember: "equip_id", width: '380px'}));
        $("#ls-objectequip-unit").jqxInput($.extend(true, {}, ls.settings['input'], {width: '70px'}));
        $("#ls-objectequip-quant").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-objectequip-install").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy'}));
        $("#ls-objectequip-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-objectequip-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-objectequip-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        
        
        $("#ls-objectequip-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#objectequipequips').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-objectequip-save").click();
                return false;
            }
        });
        
        $("#ls-objectequip-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('objectequips/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('objectequips/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#objectequips').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.state == 0) {
                        ls.objectequip.id = parseInt(Res.id);
                        $('#ls-btn-refresh-objectequip').click();
                        
                        if ($('#ls-dialog').length>0)
                        $('#ls-dialog').jqxWindow('close');
                    }
                    else if (Res.state == 1) {
                        $("#ls-dialog-content").html(Res.content);
                    }
                    else
                        ls.showerrormassage('Ошибка', Res.error);
                    
                    
                    
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', Res.responseText);
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-objectequip-equip").jqxComboBox('val', model.equip_id);
        $("#ls-objectequip-quant").jqxNumberInput('val', model.quant);
        $("#ls-objectequip-install").jqxDateTimeInput('val', ls.dateconverttosjs(model.install));
        $("#ls-objectequip-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'objectequips',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="objectequips[objeq_id]" value="<?php echo $model->objeq_id; ?>" />
<input type="hidden" name="objectequips[object_id]" value="<?php echo $model->object_id; ?>" />
<input type="hidden" name="objectequips[objectgr_id]" value="<?php echo $model->objectgr_id; ?>" />


<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Оборудование:</div>
                <div>
                    <div id="ls-objectequip-equip" name="objectequips[equip_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'equip_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Ед. изм.:</div>
                <div>
                    <input id="ls-objectequip-unit" style="text-align: center;" autocomplete="off" />
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Кол-во:</div>
            <div class="ls-form-column" style=""><div type="text" id="ls-objectequip-quant" name="objectequips[quant]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'quant'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Дата установки:</div>
            <div class="ls-form-column" style=""><div type="text" id="ls-objectequip-install" name="objectequips[install]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'install'); ?></div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-objectequip-note" name="objectequips[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-objectequip-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-objectequip-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
