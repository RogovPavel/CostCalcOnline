<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-costcalcdetails-summaterialslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-summaterialshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-sumexpenceslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-sumexpenceshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-sumstartworkslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-sumstartworkshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-koef").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px'}));
        $("#ls-costcalcdetails-discount").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', min: 0, max: 100}));
        $("#ls-costcalcdetails-sumlowfull").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', readOnly: true}));
        $("#ls-costcalcdetails-sumhighfull").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', readOnly: true}));
        $("#ls-costcalcdetails-summarj").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', readOnly: true}));
        $("#ls-costcalcdetails-percentmarj").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', readOnly: true}));
        
        $("#ls-costcalcdetails-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-costcalcdetails-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-costcalcdetails-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#costcalcdetails').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-costcalcdetails-save").click();
                return false;
            }
        });
        
        $("#ls-costcalcdetails-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('costcalcdetails', action, $('#costcalcdetails').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.costcalcdetails.rowid = parseInt(Res.id);
                    ls.costcalcdetails.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-costcalcdetails-summaterialslow").jqxNumberInput('val', parseFloat(model.sum_materials_low));
        $("#ls-costcalcdetails-summaterialshigh").jqxNumberInput('val', parseFloat(model.sum_materials_high));
        $("#ls-costcalcdetails-sumexpenceslow").jqxNumberInput('val', parseFloat(model.sum_expences_low));
        $("#ls-costcalcdetails-sumexpenceshigh").jqxNumberInput('val', parseFloat(model.sum_expences_high));
        $("#ls-costcalcdetails-sumstartworkslow").jqxNumberInput('val', parseFloat(model.sum_startworks_low));
        $("#ls-costcalcdetails-sumstartworkshigh").jqxNumberInput('val', parseFloat(model.sum_startworks_high));
        $("#ls-costcalcdetails-discount").jqxNumberInput('val', parseFloat(model.discount));
        $("#ls-costcalcdetails-koef").jqxNumberInput('val', parseFloat(model.koef));
        $("#ls-costcalcdetails-sumlowfull").jqxNumberInput('val', parseFloat(model.sum_low_full));
        $("#ls-costcalcdetails-sumhighfull").jqxNumberInput('val', parseFloat(model.sum_high_full));
        $("#ls-costcalcdetails-summarj").jqxNumberInput('val', parseFloat(model.sum_marj));
        $("#ls-costcalcdetails-percentmarj").jqxNumberInput('val', parseFloat(model.percent_marj));
        
        var recalc = function() {
            var summaterialslow = parseFloat($("#ls-costcalcdetails-summaterialslow").jqxNumberInput('val'));
            var sumexpenceslow = parseFloat($("#ls-costcalcdetails-sumexpenceslow").jqxNumberInput('val'));
            var sumstartworkslow = parseFloat($("#ls-costcalcdetails-sumstartworkslow").jqxNumberInput('val'));
            var sumequipslow = parseFloat(model.sum_equips_low);
            var sumworkslow = parseFloat(model.sum_works_low);
            var summaterialshigh = parseFloat($("#ls-costcalcdetails-summaterialshigh").jqxNumberInput('val'));
            var sumexpenceshigh = parseFloat($("#ls-costcalcdetails-sumexpenceshigh").jqxNumberInput('val'));
            var sumstartworkshigh = parseFloat($("#ls-costcalcdetails-sumstartworkshigh").jqxNumberInput('val'));
            var sumequipshigh = parseFloat(model.sum_equips_high);
            var sumworkshigh = parseFloat(model.sum_works_high);
            
            var discount = parseFloat($("#ls-costcalcdetails-discount").jqxNumberInput('val'));
            
            var percent_marj = 0;
            var sum_marj = 0;
            
            var sumlowfull = summaterialslow + sumexpenceslow + sumstartworkslow + sumequipslow + sumworkslow;
            var sumhighfull = summaterialshigh + sumexpenceshigh + sumstartworkshigh + sumequipshigh + sumworkshigh;
            sumhighfull = (1 - discount/100.00)*sumhighfull;
            
            sum_marj = sumhighfull - sumlowfull;
            
            if (sumhighfull > 0)
                percent_marj = sum_marj/sumhighfull*100;
            
            $("#ls-costcalcdetails-sumlowfull").jqxNumberInput('val', sumlowfull);
            $("#ls-costcalcdetails-sumhighfull").jqxNumberInput('val', sumhighfull);
            $("#ls-costcalcdetails-summarj").jqxNumberInput('val', sum_marj);
            $("#ls-costcalcdetails-percentmarj").jqxNumberInput('val', percent_marj);
        };
        
        $("#ls-costcalcdetails-summaterialslow, #ls-costcalcdetails-summaterialshigh, #ls-costcalcdetails-sumexpenceslow, #ls-costcalcdetails-sumexpenceshigh, #ls-costcalcdetails-sumstartworkslow, #ls-costcalcdetails-sumstartworkshigh, #ls-costcalcdetails-discount, #ls-costcalcdetails-koef").on('valueChanged', function(){
            recalc();
        });
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcalcdetails',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="costcalcdetails[calc_id]" value="<?php echo $model->calc_id; ?>" />
<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column" style="font-weight: bold; padding-top: 26px; width: 220px;">Расходные материалы:</div>
            <div class="ls-form-column" style="margin-left: 20px;">
                <div>Себестоимость</div>
                <div>
                    <div id="ls-costcalcdetails-summaterialslow" name="costcalcdetails[sum_materials_low]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_materials_low'); ?></div>
                </div>
            </div>
            <div class="ls-form-column-right">
                <div>Стоимость</div>
                <div>
                    <div id="ls-costcalcdetails-summaterialshigh" name="costcalcdetails[sum_materials_high]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_materials_high'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="font-weight: bold; padding-top: 26px; width: 220px;">Транспортные расходы:</div>
            <div class="ls-form-column" style="margin-left: 20px;">
                <div>Себестоимость</div>
                <div>
                    <div id="ls-costcalcdetails-sumexpenceslow" name="costcalcdetails[sum_expences_low]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_expences_low'); ?></div>
                </div>
            </div>
            <div class="ls-form-column-right">
                <div>Стоимость</div>
                <div>
                    <div id="ls-costcalcdetails-sumexpenceshigh" name="costcalcdetails[sum_expences_high]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_expences_high'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="font-weight: bold; padding-top: 26px; width: 220px;">Пусконаладочные работы:</div>
            <div class="ls-form-column" style="margin-left: 20px;">
                <div>Себестоимость</div>
                <div>
                    <div id="ls-costcalcdetails-sumstartworkslow" name="costcalcdetails[sum_startworks_low]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_startworks_low'); ?></div>
                </div>
            </div>
            <div class="ls-form-column-right">
                <div>Стоимость</div>
                <div>
                    <div id="ls-costcalcdetails-sumstartworkshigh" name="costcalcdetails[sum_startworks_high]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sum_startworks_high'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="font-weight: bold; padding-top: 0px; width: 220px;">Скидка:</div>
            <div class="ls-form-column-right" style="margin-left: 20px;">
                <div style="height: 0px; width: 1px;"></div>
                <div>
                    <div id="ls-costcalcdetails-discount" name="costcalcdetails[discount]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'discount'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row" style="border-bottom: 1px solid black;padding-bottom: 12px;">
            <div class="ls-form-column" style="font-weight: bold; padding-top: 0px; width: 220px;">Коэф. накрутки на ФОТ:</div>
            <div class="ls-form-column-right" style="margin-left: 20px;">
                <div style="height: 0px; width: 1px;"></div>
                <div>
                    <div id="ls-costcalcdetails-koef" name="costcalcdetails[koef]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'koef'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row" style="text-align: center; font-weight: bold; border-bottom: 1px solid black;">
            ИТОГО:
        </div>
        <div class="ls-form-row" style="margin-top: 12px;">
            <div class="ls-form-column-right">
                <div class="ls-form-column" style="font-weight: bold;">Себестоимость:</div>
                <div class="ls-form-column"><div id="ls-costcalcdetails-sumlowfull" autocomplete="off"></div></div>
            </div>
        </div>
        <div class="ls-form-row" style="">
            <div class="ls-form-column-right">
                <div class="ls-form-column" style="font-weight: bold;">Стоимость:</div>
                <div class="ls-form-column"><div id="ls-costcalcdetails-sumhighfull" autocomplete="off"></div></div>
            </div>
        </div>
        <div class="ls-form-row" style="">
            <div class="ls-form-column-right">
                <div class="ls-form-column" style="font-weight: bold;">Маржа:</div>
                <div class="ls-form-column"><div id="ls-costcalcdetails-summarj" autocomplete="off"></div></div>
            </div>
        </div>
        <div class="ls-form-row" style="">
            <div class="ls-form-column-right">
                <div class="ls-form-column" style="font-weight: bold;">Маржа %:</div>
                <div class="ls-form-column"><div id="ls-costcalcdetails-percentmarj" autocomplete="off"></div></div>
            </div>
        </div>
        <div class="ls-form-row" style="margin-top: 30px;">
            <div class="ls-form-column"><input type="button" id="ls-costcalcdetails-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-costcalcdetails-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
