<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-firm-name").jqxInput({theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25});
        $("#ls-firm-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-firm-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
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
                var url = <?php echo json_encode(Yii::app()->createUrl('firms/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('firms/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#firms').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.firms.id = parseInt(Res.id);
                        $('#ls-btn-refresh').click();
                    }
                    
                    if ($('#ls-dialog').length>0)
                        $('#ls-dialog').jqxWindow('close');
                    
                    
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При сохранении данных произошла ошибка. Повторите попытку позже.');
                    ls.lock_operation = false;
                }
            });
        });
        
        $("#ls-firm-name").jqxInput('val', model.firmname);
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
            <div class="ls-form-column"><input type="button" id="ls-firm-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-firm-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
