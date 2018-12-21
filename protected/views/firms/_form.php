<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var databanks;
        var datatemplates;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['Banks', 'Templates']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                databanks = Res[0];
                datatemplates = Res[1];
                
                $("#ls-firm-bank").jqxComboBox({source: databanks});
                $("#ls-firm-bank").jqxComboBox('val', model.bank_id);
                $("#ls-firm-calctemplate").jqxComboBox({source: datatemplates});
                $("#ls-firm-calctemplate").jqxComboBox('val', model.calctemplate_id);
            },
            error: function(Res) {
                ls.showerrormassage('Ошибка!', Res.responseText);
            }
        });
        
        $("#ls-firm-name").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-firm-inn").jqxInput($.extend(true, {}, ls.settings['input'], {width: '140px'}));
        $("#ls-firm-kpp").jqxInput($.extend(true, {}, ls.settings['input'], {width: '140px'}));
        $("#ls-firm-account").jqxInput($.extend(true, {}, ls.settings['input'], {width: '230px'}));
        $("#ls-firm-ogrn").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px;'}));
        $("#ls-firm-okpo").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px'}));
        $("#ls-firm-bank").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {selectedIndex: 0, displayMember: "bankname", valueMember: "bank_id", width: 'calc(100% - 8px)'}));
        $("#ls-firm-calctemplate").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {selectedIndex: 0, displayMember: "templatename", valueMember: "template_id", width: 'calc(100% - 8px)'}));
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
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('firms', action, $('#firms').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.firms.rowid = parseInt(Res.id);
                    ls.firms.refresh(false);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1) 
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
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
            <div class="ls-form-column">
                <div>ИНН:</div>
                <div>
                    <input type="text" id="ls-firm-inn" name="firms[inn]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'inn'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>КПП:</div>
                <div>
                    <input type="text" id="ls-firm-kpp" name="firms[kpp]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'kpp'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Р/Счет:</div>
                <div>
                    <input type="text" id="ls-firm-account" name="firms[account]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'account'); ?></div>
                </div>
            </div>
        </div>
        
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>ОГРН:</div>
                <div>
                    <input type="text" id="ls-firm-ogrn" name="firms[ogrn]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'ogrn'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>ОКПО:</div>
                <div>
                    <input type="text" id="ls-firm-okpo" name="firms[okpo]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'okpo'); ?></div>
                </div>
            </div>
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
            <div class="ls-form-label">Шаблон смет:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-firm-calctemplate" name="firms[calctemplate_id]" autocomplete="off"/></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'calctemplate_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-firm-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-firm-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
