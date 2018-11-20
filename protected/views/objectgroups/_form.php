<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var data_clients;
        var data_regions;
        var data_streets;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: false,
            data: {
                Models: ['Clients', 'Regions', 'Streets']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                
                data_clients = Res[0];
                data_regions = Res[1];
                data_streets = Res[2];
            }
        });
        
        $("#ls-objectgroup-client").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: data_clients, displayMember: "clientname", valueMember: "client_id", width: 'calc(100% - 8px)'}));
        $("#ls-objectgroup-region").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: data_regions, displayMember: "region_name", valueMember: "region_id", width: '140px'}));
        $("#ls-objectgroup-street").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: data_streets, displayMember: "streetname", valueMember: "street_id", width: '180px'}));
        $("#ls-objectgroup-house").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '80px', height: 25}));
        $("#ls-objectgroup-corp").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '80px', height: 25}));
        $("#ls-objectgroup-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {theme: ls.defaults.theme, width: 'calc(100% - 2px)', height: 75}));
        
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
                var url = <?php echo json_encode(Yii::app()->createUrl('objectgroups/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('objectgroups/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#objectgroups').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.state == 0) {
                        
                        ls.objectgroups.id = parseInt(Res.id);
                        $('#ls-btn-refresh').click();
                        
                        if ($('#ls-og-edit').length>0)
                            ls.objectgroups.refresh();
                        
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
                    ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-objectgroup-client").jqxComboBox('val', model.client_id);
        $("#ls-objectgroup-region").jqxComboBox('val', model.region_id);
        $("#ls-objectgroup-street").jqxComboBox('val', model.street_id);
        $("#ls-objectgroup-house").jqxInput('val', model.house);
        $("#ls-objectgroup-corp").jqxInput('val', model.corp);
        $("#ls-objectgroup-note").jqxTextArea('val', model.note);
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
            <div class="ls-form-label">Клиент:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-objectgroup-client" name="objectgroups[client_id]" autocomplete="off"/></div>
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
