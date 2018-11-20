<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-streettype-name").jqxInput({theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25});
        $("#ls-streettype-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-streettype-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-streettype-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#streettypes').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-streettype-save").click();
                return false;
            }
        });
        
        $("#ls-streettype-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('streettypes/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('streettypes/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#streettypes').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.streettypes.id = parseInt(Res.id);
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
        
        $("#ls-streettype-name").jqxInput('val', model.streettype_name);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'streettypes',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="streettypes[streettype_id]" value="<?php echo $model->streettype_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-streettype-name" name="streettypes[streettype_name]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'streettype_name'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-streettype-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-streettype-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
