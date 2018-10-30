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
        
        $("#ls-client-name").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-inn").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-kpp").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-account").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-ogrn").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-okpo").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-bank").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {selectedIndex: 0, source: banks_adapter, displayMember: "bankname", valueMember: "bank_id", width: 'calc(100% - 8px)'}));
        $("#ls-client-juraddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-client-factaddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        
        
        $("#ls-client-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-client-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        $("#ls-client-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#clients').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-client-save").click();
                return false;
            }
        });
        
        $("#ls-client-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('clients/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('clients/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#clients').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.clients.id = parseInt(Res.id);
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
        
        $("#ls-client-name").jqxInput('val', model.clientname);
        $("#ls-client-inn").jqxInput('val', model.inn);
        $("#ls-client-kpp").jqxInput('val', model.kpp);
        $("#ls-client-account").jqxInput('val', model.account);
        $("#ls-client-ogrn").jqxInput('val', model.ogrn);
        $("#ls-client-okpo").jqxInput('val', model.okpo);
        $("#ls-client-bank").jqxComboBox('val', model.bank_id);
        $("#ls-client-juraddress").jqxInput('val', model.jur_address);
        $("#ls-client-factaddress").jqxInput('val', model.fact_address);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clients',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="clients[client_id]" value="<?php echo $model->client_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-name" name="clients[clientname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'clientname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">ИНН:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-inn" name="clients[inn]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'inn'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">КПП:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-kpp" name="clients[kpp]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'kpp'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Р/Счет:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-account" name="clients[account]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'account'); ?></div>
        </div>
        <div class="ls-form-row">
                <div class="ls-form-label">ОГРН:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-ogrn" name="clients[ogrn]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'ogrn'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">ОКПО:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-okpo" name="clients[okpo]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'okpo'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Банк:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-client-bank" name="clients[bank_id]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'bank_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Юр. адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-juraddress" name="clients[jur_address]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'jur_address'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Факт. адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-client-factaddress" name="clients[fact_address]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'fact_address'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-client-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-client-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
