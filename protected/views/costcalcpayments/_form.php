<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var datausers;
        var dataclients;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['Users', 'Clients']
            },
            success: function(Res) {
                Res = JSON.parse(Res);

                datausers = Res[0];
                dataclients = Res[1];
                
                $("#ls-costcalcpayments-user").jqxComboBox({source: datausers});
                $("#ls-costcalcpayments-user").val(model.user_id);
                $("#ls-costcalcpayments-client").jqxComboBox({source: dataclients});
                $("#ls-costcalcpayments-client").val(model.client_id);
            }
        });
        
        $("#ls-costcalcpayments-date").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: new Date(), width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm'}));
        $("#ls-costcalcpayments-user").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "shortname", valueMember: "user_id", width: '380px'}));
        $("#ls-costcalcpayments-client").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "clientname", valueMember: "client_id", width: '380px'}));
        $("#ls-costcalcpayments-sumpay").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcpayments-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-costcalcpayments-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-costcalcpayments-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        
        
        $("#ls-costcalcpayments-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#costcalcpaymentsequips').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-costcalcpayments-save").click();
                return false;
            }
        });
        
        $("#ls-costcalcpayments-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('costcalcpayments', action, $('#costcalcpayments').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.costcalcpayments.rowid = parseInt(Res.id);
                    ls.costcalculations.refresh(true);
                    ls.costcalcpayments.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else 
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-costcalcpayments-date").jqxDateTimeInput('val', ls.dateconverttosjs(model.date));
        $("#ls-costcalcpayments-user").jqxComboBox('val', model.user_id);
        $("#ls-costcalcpayments-sumpay").jqxNumberInput('val', parseFloat(model.sumpay));
        $("#ls-costcalcpayments-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcalcpayments',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="costcalcpayments[payment_id]" value="<?php echo $model->payment_id; ?>" />
<input type="hidden" name="costcalcpayments[calc_id]" value="<?php echo $model->calc_id; ?>" />


<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">Дата выплаты:</div>
            <div class="ls-form-column">
                <div id="ls-costcalcpayments-date" name="costcalcpayments[date]" autocomplete="off"></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'date'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Сотрудник:</div>
                <div>
                    <div id="ls-costcalcpayments-user" name="costcalcpayments[user_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'user_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Сумма:</div>
                <div>
                    <div id="ls-costcalcpayments-sumpay" name="costcalcpayments[sumpay]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sumpay'); ?></div>
                </div>
            </div>
            
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Подрядчик:</div>
                <div>
                    <div id="ls-costcalcpayments-client" name="costcalcpayments[client_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'client_id'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-costcalcpayments-note" name="costcalcpayments[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-costcalcpayments-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-costcalcpayments-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
