<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-bank-name").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-bank-city").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-bank-account").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        $("#ls-bank-bik").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 8px)'}));
        
        
        $("#ls-bank-save").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        $("#ls-bank-cancel").jqxButton($.extend(true, {}, ls.settings['button'], {width: '100px', height: 30}));
        
        $("#ls-bank-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#banks').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-bank-save").click();
                return false;
            }
        });
        
        $("#ls-bank-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var url = <?php echo json_encode(Yii::app()->createUrl('banks/create')); ?>;
            else
                var url = <?php echo json_encode(Yii::app()->createUrl('banks/update')); ?>;
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#banks').serialize(),
                success: function(Res) {
                    Res = JSON.parse(Res);
                    ls.lock_operation = false;
                    
                    if (Res.error == 0) {
                        ls.banks.id = parseInt(Res.id);
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
        
        $("#ls-bank-name").jqxInput('val', model.bankname);
        $("#ls-bank-city").jqxInput('val', model.city);
        $("#ls-bank-account").jqxInput('val', model.account);
        $("#ls-bank-bik").jqxInput('val', model.bik);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'banks',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="banks[bank_id]" value="<?php echo $model->bank_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Наименование:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-bank-name" name="banks[bankname]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'bankname'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Город:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-bank-city" name="banks[city]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'city'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Р/Счет:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-bank-account" name="banks[account]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'account'); ?></div>
        </div>
        <div class="ls-form-row">
                <div class="ls-form-label">БИК:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input type="text" id="ls-bank-bik" name="banks[bik]" autocomplete="off"/></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'bik'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-bank-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-bank-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
