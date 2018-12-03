<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-clientposition-name").jqxInput({theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25});
        $("#ls-clientposition-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-clientposition-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-clientposition-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#clientpositions').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-clientposition-save").click();
                return false;
            }
        });
        
        $("#ls-clientposition-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('clientpositions', action, $('#clientpositions').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.clientpositions.rowid = parseInt(Res.id);
                    ls.clientpositions.refresh(false);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-clientposition-name").jqxInput('val', model.positionname);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientpositions',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="clientpositions[position_id]" value="<?php echo $model->position_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-clientposition-name" name="clientpositions[positionname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'positionname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-clientposition-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-clientposition-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
