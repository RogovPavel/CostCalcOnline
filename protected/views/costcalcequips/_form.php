<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var dataequips;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['Equips']
            },
            success: function(Res) {
                Res = JSON.parse(Res);

                dataequips = Res[0];
                
                $("#ls-costcalcequips-equip").jqxComboBox({source: dataequips});
                $("#ls-costcalcequips-equip").val(model.equip_id);
            }
        });
        
        $('#ls-costcalcequips-equip').on('select', function (event) {
            var args = event.args;
            if (args) {
                var item = args.item;
                var data = item.originalItem;
                $("#ls-costcalcequips-unit").val(data.unit_name);
            }
        }); 
        
        $("#ls-costcalcequips-equip").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "equipname", valueMember: "equip_id", width: '380px'}));
        $("#ls-costcalcequips-unit").jqxInput($.extend(true, {}, ls.settings['input'], {width: '70px'}));
        $("#ls-costcalcequips-quant").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcequips-pricelow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcequips-pricehigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcequips-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-costcalcequips-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-costcalcequips-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        
        
        $("#ls-costcalcequips-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#costcalcequipsequips').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-costcalcequips-save").click();
                return false;
            }
        });
        
        $("#ls-costcalcequips-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('costcalcequips', action, $('#costcalcequips').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.costcalcequips.rowid = parseInt(Res.id);
                    ls.costcalculations.refresh(true);
                    ls.costcalcequips.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else 
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-costcalcequips-equip").jqxComboBox('val', model.equip_id);
        $("#ls-costcalcequips-quant").jqxNumberInput('val', parseFloat(model.quant));
        $("#ls-costcalcequips-pricelow").jqxNumberInput('val', parseFloat(model.price_low));
        $("#ls-costcalcequips-pricehigh").jqxNumberInput('val', parseFloat(model.price_high));
        $("#ls-costcalcequips-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcalcequips',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="costcalcequips[cceq_id]" value="<?php echo $model->cceq_id; ?>" />
<input type="hidden" name="costcalcequips[calc_id]" value="<?php echo $model->calc_id; ?>" />


<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Оборудование:</div>
                <div>
                    <div id="ls-costcalcequips-equip" name="costcalcequips[equip_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'equip_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Ед. изм.:</div>
                <div>
                    <input id="ls-costcalcequips-unit" style="text-align: center;" autocomplete="off" />
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Кол-во:</div>
                <div>
                    <div id="ls-costcalcequips-quant" name="costcalcequips[quant]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'quant'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Себестоимость:</div>
                <div>
                    <div id="ls-costcalcequips-pricelow" name="costcalcequips[price_low]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'price_low'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Стоимость:</div>
                <div>
                    <div id="ls-costcalcequips-pricehigh" name="costcalcequips[price_high]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'price_high'); ?></div>
                </div>
            </div>
            
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-costcalcequips-note" name="costcalcequips[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-costcalcequips-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-costcalcequips-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
