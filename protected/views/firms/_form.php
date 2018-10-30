<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var banks_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['banks']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        $("#ls-firm-name").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-inn").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-kpp").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-account").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-ogrn").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-okpo").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-bank").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {selectedIndex: 0, source: banks_adapter, displayMember: "bankname", valueMember: "bank_id", width: 'calc(100% - 8px)'}));
        $("#ls-firm-juraddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-factaddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        
        
        $("#ls-firm-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-firm-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        $("#ls-firm-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#firms').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-firm-save").click();
                return false;
            }
        });
        
        $("#ls-firm-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('firms/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('firms/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#firms').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.firms.id = parseInt(Res.id);
                        $('#ls-btn-refresh').click();
                        
                        if ($('#ls-dialog').length>0)
                        $('#ls-dialog').jqxWindow('close');
                    } else {
                        $("#ls-dialog-content").html(Res.content);
                    }
                    
                    
                    
                    
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-firm-name").jqxInput('val', model.firmname);
        $("#ls-firm-inn").jqxInput('val', model.inn);
        $("#ls-firm-kpp").jqxInput('val', model.kpp);
        $("#ls-firm-account").jqxInput('val', model.account);
        $("#ls-firm-ogrn").jqxInput('val', model.ogrn);
        $("#ls-firm-okpo").jqxInput('val', model.okpo);
        $("#ls-firm-bank").jqxComboBox('val', model.bank_id);
        $("#ls-firm-juraddress").jqxInput('val', model.jur_address);
        $("#ls-firm-factaddress").jqxInput('val', model.fact_address);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'firms',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="firms[firm_id]" value="<?php echo $model->firm_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-name" name="firms[firmname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'firmname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">ИНН:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-inn" name="firms[inn]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'inn'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">КПП:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-kpp" name="firms[kpp]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'kpp'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Р/Счет:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-account" name="firms[account]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'account'); ?></div>
        </div>
        <div class="ls-form-row">
                <div class="ls-form-label">ОГРН:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-ogrn" name="firms[ogrn]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'ogrn'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">ОКПО:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-okpo" name="firms[okpo]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'okpo'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Банк:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-firm-bank" name="firms[bank_id]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'bank_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Юр. адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-juraddress" name="firms[jur_address]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'jur_address'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Факт. адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-firm-factaddress" name="firms[fact_address]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'fact_address'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-firm-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-firm-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
