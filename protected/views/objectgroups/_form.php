<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var data_clients;
        var data_regions;
        var data_streets;
        var data_users;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['Clients', 'Regions', 'Streets', 'Users']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                
                data_clients = Res[0];
                data_regions = Res[1];
                data_streets = Res[2];
                data_users = Res[3];
                
                initsource();
                setvalues();
            }
        });
        
        var initsource = function() {
            $("#ls-objectgroup-client").jqxComboBox({source: data_clients});
            $("#ls-objectgroup-region").jqxComboBox({source: data_regions});
            $("#ls-objectgroup-street").jqxComboBox({source: data_streets});
            $("#ls-objectgroup-manager").jqxComboBox({source: data_users});
        };
        
        var setvalues = function() {
            $("#ls-objectgroup-client").val(model.client_id);
            $("#ls-objectgroup-region").val(model.region_id);
            $("#ls-objectgroup-street").val(model.street_id);
            $("#ls-objectgroup-manager").val(model.manager_id);
        };
        
        $("#ls-objectgroup-client").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "clientname", valueMember: "client_id", width: 'calc(100% - 8px)'}));
        $("#ls-objectgroup-region").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "region_name", valueMember: "region_id", width: '140px'}));
        $("#ls-objectgroup-street").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "streetname", valueMember: "street_id", width: '180px'}));
        $("#ls-objectgroup-house").jqxInput($.extend(true, {}, ls.settings['input'], {width: '80px', height: 25}));
        $("#ls-objectgroup-corp").jqxInput($.extend(true, {}, ls.settings['input'], {width: '80px', height: 25}));
        $("#ls-objectgroup-quantdoorway").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '140px', height: 25}));
        $("#ls-objectgroup-datebuild").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy'}));
        $("#ls-objectgroup-manager").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "shortname", valueMember: "user_id", width: '180px'}));
        $("#ls-objectgroup-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {width: 'calc(100% - 2px)', height: 75}));
        
        $("#ls-objectgroup-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-objectgroup-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-objectgroup-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#objectgroups').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-objectgroup-save").click();
                return false;
            }
        });
        
        $("#ls-objectgroup-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('objectgroups', action, $('#objectgroups').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    
                    ls.objectgroups.rowid = parseInt(Res.id);
                    ls.objectgroups.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-objectgroup-house").jqxInput('val', model.house);
        $("#ls-objectgroup-corp").jqxInput('val', model.corp);
        $("#ls-objectgroup-note").jqxTextArea('val', model.note);
        $("#ls-objectgroup-quantdoorway").jqxNumberInput('val', model.quantdoorway);
        $("#ls-objectgroup-datebuild").jqxDateTimeInput('val', ls.dateconverttosjs(model.datebuild));
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'objectgroups',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="objectgroups[objectgr_id]" value="<?php echo $model->objectgr_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 142px">Клиент:</div>
            <div class="ls-form-column" style="width: calc(100% - 148px);"><div id="ls-objectgroup-client" name="objectgroups[client_id]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'client_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Регион:</div>
                <div>
                    <div id="ls-objectgroup-region" name="objectgroups[region_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'region_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Улица:</div>
                <div>
                    <div id="ls-objectgroup-street" name="objectgroups[street_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'street_id'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Дом:</div>
                <div>
                    <input type="text" id="ls-objectgroup-house" name="objectgroups[house]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'house'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Корпус:</div>
                <div>
                    <input type="text" id="ls-objectgroup-corp" name="objectgroups[corp]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'corp'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Кол-во подъездов:</div>
                <div>
                    <div id="ls-objectgroup-quantdoorway" name="objectgroups[quantdoorway]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'quantdoorway'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Дата постройки:</div>
                <div>
                    <div id="ls-objectgroup-datebuild" name="objectgroups[datebuild]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'datebuild'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 142px">Менеджер:</div>
            <div class="ls-form-column"><div id="ls-objectgroup-manager" name="objectgroups[manager_id]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'manager_id'); ?></div>
        </div>    
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 100%">
                <div>Примечание:</div>
                <div>
                    <textarea type="text" id="ls-objectgroup-note" name="objectgroups[note]" autocomplete="off"></textarea>
                    <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-objectgroup-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-objectgroup-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
