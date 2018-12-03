<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-object-doorway").jqxInput($.extend(true, {}, ls.settings['input'], {width: '100px'}));
        $("#ls-object-quantflats").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '100px'}));
        $("#ls-object-numberflats").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px'}));
        $("#ls-object-code").jqxInput($.extend(true, {}, ls.settings['input'], {width: '100px'}));
        $("#ls-object-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        
        $("#ls-object-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-object-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        $("#ls-object-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#objects').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-object-save").click();
                return false;
            }
        });
        
        $("#ls-object-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('objects', action, $('#objects').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    
                    ls.objects.rowid = parseInt(Res.id);
                    ls.objects.refresh(false);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-object-doorway").jqxInput('val', model.doorway);
        $("#ls-object-quantflats").jqxNumberInput('val', model.quant_flats);
        $("#ls-object-code").jqxInput('val', model.code);
        $("#ls-object-note").jqxTextArea('val', model.note);
        
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'objects',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="objects[object_id]" value="<?php echo $model->object_id; ?>" />
<input type="hidden" name="objects[objectgr_id]" value="<?php echo $model->objectgr_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Подъезд:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);">
                <input type="text" id="ls-object-doorway" name="objects[doorway]" autocomplete="off"/>
                <div class="ls-form-error"><?php echo $form->error($model, 'doorway'); ?></div>
            </div>
            
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Кол-во кв-р:</div>
            <div class="ls-form-column" style="">
                <div id="ls-object-quantflats" name="objects[quant_flats]" autocomplete="off"></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'quant_flats'); ?></div>    
            </div>
            <div class="ls-form-label" style="min-width: 0px;">Номера кв-р:</div>
            <div class="ls-form-column" style="">
                <input type="text" id="ls-object-numberflats" name="objects[numberflats]" autocomplete="off" />
                <div class="ls-form-error"><?php echo $form->error($model, 'numberflats'); ?></div>    
            </div>
            
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Код домофона:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-object-code" name="objects[code]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'code'); ?></div>
        </div>
        <div class="ls-form-row">
            <div>Примечание:</div>
            <div>
                <textarea id="ls-object-note" name="objects[note]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'note'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-object-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-object-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
