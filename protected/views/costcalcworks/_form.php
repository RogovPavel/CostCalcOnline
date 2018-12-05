<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        var first = true;
        
        var dataequips;
        var dataworks;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['CostCalcEquips', 'Works'],
                Filters: {
                    CostCalcEquips: [{field: 'e.calc_id', operand: 1, value: model.calc_id}]
                }
            },
            success: function(Res) {
                Res = JSON.parse(Res);

                dataequips = Res[0];
                dataworks = Res[1];
                
                for (var i = 0; i < dataequips.length; i++)
                    dataequips[i].html = dataequips[i].equipname + ', Кол-во:' + parseFloat(dataequips[i].quant) + ', Цена:' + parseFloat(dataequips[i].price_high);
                
                $("#ls-costcalcworks-equip").jqxComboBox({source: dataequips});
                $("#ls-costcalcworks-equip").val(model.cceq_id);
                $("#ls-costcalcworks-work").jqxComboBox({source: dataworks});
                $("#ls-costcalcworks-work").val(model.work_id);
            }
        });
        
        $('#ls-costcalcworks-equip').on('select', function (event) {
            if (first && !state_insert) {
                first = false;
                return;
            }
            
            var args = event.args;
            if (args) {
                var item = args.item;
                var data = item.originalItem;
                $("#ls-costcalcworks-unit").val(data.unit_name);
                $("#ls-costcalcworks-quant").jqxNumberInput('val', data.quant);
            }
        }); 
        
        $("#ls-costcalcworks-quant").on('change', function(event) {
            var value = event.args.value;
            
            var item = $("#ls-costcalcworks-equip").jqxComboBox('getSelectedItem'); 
            
            if (parseFloat(value) != parseFloat(item.originalItem.quant))
                $("#ls-costcalcworks-quant > input").css({'color': 'red'});
            else
                $("#ls-costcalcworks-quant > input").css({'color': ''});
        });
        
        $("#ls-costcalcworks-workname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '380px'}));
        $("#ls-costcalcworks-work").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "workname", valueMember: "work_id", width: '380px'}));
        $("#ls-costcalcworks-equip").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "equipname", valueMember: "cceq_id", width: '380px'}));
        $("#ls-costcalcworks-unit").jqxInput($.extend(true, {}, ls.settings['input'], {width: '70px'}));
        $("#ls-costcalcworks-quant").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcworks-pricelow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcworks-pricehigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcworks-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-costcalcworks-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-costcalcworks-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        
        
        $("#ls-costcalcworks-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#costcalcworksequips').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-costcalcworks-save").click();
                return false;
            }
        });
        
        $("#ls-costcalcworks-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('costcalcworks', action, $('#costcalcworks').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.costcalcworks.rowid = parseInt(Res.id);
                    ls.costcalculations.refresh(true);
                    ls.costcalcworks.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else 
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-costcalcworks-workname").jqxInput('val', model.workname);
        $("#ls-costcalcworks-quant").jqxNumberInput('val', parseFloat(model.quant));
        $("#ls-costcalcworks-pricelow").jqxNumberInput('val', parseFloat(model.price_low));
        $("#ls-costcalcworks-pricehigh").jqxNumberInput('val', parseFloat(model.price_high));
        $("#ls-costcalcworks-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcalcworks',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="costcalcworks[ccwk_id]" value="<?php echo $model->ccwk_id; ?>" />
<input type="hidden" name="costcalcworks[calc_id]" value="<?php echo $model->calc_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-column" style="width: 120px;">Наим. работы:</div>
                <div class="ls-form-column">
                    <input id="ls-costcalcworks-workname" name="costcalcworks[workname]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'workname'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-column" style="width: 120px;">Из справочника:</div>
                <div class="ls-form-column">
                    <div id="ls-costcalcworks-work" name="costcalcworks[work_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'work_id'); ?></div>
                </div>
            </div>
        </div>
        
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 120px; height: 1px;"></div>
            <div class="ls-form-column">
                <div>Себестоимость:</div>
                <div>
                    <div id="ls-costcalcworks-pricelow" name="costcalcworks[price_low]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'price_low'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Стоимость:</div>
                <div>
                    <div id="ls-costcalcworks-pricehigh" name="costcalcworks[price_high]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'price_high'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Кол-во:</div>
                <div>
                    <div id="ls-costcalcworks-quant" name="costcalcworks[quant]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'quant'); ?></div>
                </div>
            </div>
            
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 120px; height: 1px;"></div>
            <div class="ls-form-column">
                <div>Оборудование:</div>
                <div>
                    <div id="ls-costcalcworks-equip" name="costcalcworks[cceq_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'cceq_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Ед. изм.:</div>
                <div>
                    <input id="ls-costcalcworks-unit" style="text-align: center;" autocomplete="off" />
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-costcalcworks-note" name="costcalcworks[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-costcalcworks-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-costcalcworks-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
