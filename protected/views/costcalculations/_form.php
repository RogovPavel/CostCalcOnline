<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var dataobjectgroups;
        var dataclients;
        var datausers;
        var datafirms;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['ObjectGroups', 'Clients', 'Users', 'Firms']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                dataobjectgroups = Res[0];
                dataclients = Res[1];
                datausers = Res[2];
                datafirms = Res[3];
                initsource();
                setvalues();
            }
        });
        
        var initsource = function() {
            $("#ls-costcalculations-edit-objectgr").jqxComboBox({source: dataobjectgroups});
            $("#ls-costcalculations-edit-client").jqxComboBox({source: dataclients});
            $("#ls-costcalculations-edit-manager").jqxComboBox({source: datausers});
            $("#ls-costcalculations-edit-firm").jqxComboBox({source: datafirms});
        };
        
        var setvalues = function() {
            $("#ls-costcalculations-edit-objectgr").val(model.objectgr_id);
            $("#ls-costcalculations-edit-client").val(model.client_id);
            $("#ls-costcalculations-edit-manager").val(model.manager_id);
            $("#ls-costcalculations-edit-firm").val(model.firm_id);
        };
        
        $("#ls-costcalculations-edit-calc").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '100px', height: 25}));
        $("#ls-costcalculations-edit-date").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: new Date(), width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm'}));
        $("#ls-costcalculations-edit-objectgr").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "address", valueMember: "objectgr_id", width: '400px'}));
        $("#ls-costcalculations-edit-name").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '400px', height: 25}));
        $("#ls-costcalculations-edit-client").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "clientname", valueMember: "client_id", width: '400px'}));
        $("#ls-costcalculations-edit-manager").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "shortname", valueMember: "user_id", width: '200px'}));
        $("#ls-costcalculations-edit-demand").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '150px', height: 25}));
        $("#ls-costcalculations-edit-specnote").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        $("#ls-costcalculations-edit-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        $("#ls-costcalculations-edit-firm").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "firmname", valueMember: "firm_id", width: '400px'}));
        
        $("#ls-costcalculations-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-costcalculations-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-costcalculations-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#costcalculations').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-costcalculations-save").click();
                return false;
            }
        });
        
        $("#ls-costcalculations-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('costcalculations', action, $('#costcalculations').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.costcalculations.rowid = parseInt(Res.id);
                    ls.costcalculations.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-costcalculations-edit-calc").jqxInput('val', model.calc_id);
        $("#ls-costcalculations-edit-date").jqxDateTimeInput('val', ls.dateconverttosjs(model.date));
        $("#ls-costcalculations-edit-name").jqxInput('val', model.name);
        $("#ls-costcalculations-edit-demand").jqxInput('val', model.demand_id);
        $("#ls-costcalculations-edit-specnote").jqxTextArea('val', model.specnote);
        $("#ls-costcalculations-edit-note").jqxTextArea('val', model.note);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'costcalculations',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="costcalculations[calc_id]" value="<?php echo $model->calc_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-label" style="">Дата:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><div readonly="readonly" id="ls-costcalculations-edit-date" name="costcalculations[date]" autocomplete="off"></div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'date_reg'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-label">Номер:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><input readonly="readonly" id="ls-costcalculations-edit-calc" name="costcalculations[calc_id]" autocomplete="off" /></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'calc_id'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input id="ls-costcalculations-edit-name" name="costcalculations[name]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'name'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-costcalculations-edit-objectgr" name="costcalculations[objectgr_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'objectgr_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Клиент:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-costcalculations-edit-client" name="costcalculations[client_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'client_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Моя организация:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-costcalculations-edit-firm" name="costcalculations[firm_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'firm_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Менеджер:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-costcalculations-edit-manager" name="costcalculations[manager_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'manager_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Заявка №:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input id="ls-costcalculations-edit-demand" name="costcalculations[demand_id]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'demand_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div>Техническое задание:</div>
            <div>
                <textarea id="ls-costcalculations-edit-specnote" name="costcalculations[specnote]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'specnote'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-costcalculations-edit-note" name="costcalculations[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-costcalculations-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-costcalculations-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
