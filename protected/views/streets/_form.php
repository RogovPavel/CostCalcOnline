<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var streettypes_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['streettypes']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        var regions_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['regions']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        $("#ls-street-name").jqxInput({theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25});
        $("#ls-street-streettype").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: streettypes_adapter, displayMember: "streettype_name", valueMember: "streettype_id", width: 'calc(100% - 8px)'}));
        $("#ls-street-region").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: regions_adapter, displayMember: "region_name", valueMember: "region_id", width: 'calc(100% - 8px)'}));
        
        $("#ls-street-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-street-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-street-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#streets').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-street-save").click();
                return false;
            }
        });
        
        $("#ls-street-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('streets/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('streets/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#streets').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.streets.id = parseInt(Res.id);
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
        
        $("#ls-street-name").jqxInput('val', model.streetname);
        $("#ls-street-streettype").jqxComboBox('val', model.streettype_id);
        $("#ls-street-region").jqxComboBox('val', model.region_id);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'streets',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="streets[street_id]" value="<?php echo $model->street_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-street-name" name="streets[streetname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'streetname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Тип:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-street-streettype" name="streets[streettype_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'streettype_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Регион:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-street-region" name="streets[region_id]" autocomplete="off"/></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'region_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-street-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-street-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
