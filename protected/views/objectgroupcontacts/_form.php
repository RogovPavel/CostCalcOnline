<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var data_positions;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: false,
            data: {
                Models: ['ClientPositions']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                
                data_positions = Res[0];
            }
        });
        
        $("#ls-objectgroupcontact-surname").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '180px', height: 25}));
        $("#ls-objectgroupcontact-firstname").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '150px', height: 25}));
        $("#ls-objectgroupcontact-lastname").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '180px', height: 25}));
        $("#ls-objectgroupcontact-position").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: data_positions, displayMember: "positionname", valueMember: "position_id", width: '200px'}));
        $("#ls-objectgroupcontact-phonenumber").jqxMaskedInput($.extend(true, {}, ls.settings['maskedinput'], { width: 200, mask: '(###) ###-##-##'}));
        $("#ls-objectgroupcontact-email").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '200px', height: 25}));
        
        $("#ls-objectgroupcontact-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-objectgroupcontact-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-objectgroupcontact-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#objectgroupcoantacts').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-objectgroupcontact-save").click();
                return false;
            }
        });
        
        $("#ls-objectgroupcontact-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('objectgroupcontacts', action, $('#objectgroupcontacts').serialize(), function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.lock_operation = false;
                    ls.objectgroupcontacts.rowid = parseInt(Res.id);
                    ls.objectgroupcontacts.refresh(false);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                
            });
        });
        
        $("#ls-objectgroupcontact-surname").jqxInput('val', model.surname);
        $("#ls-objectgroupcontact-firstname").jqxInput('val', model.firstname);
        $("#ls-objectgroupcontact-lastname").jqxInput('val', model.lastname);
        $("#ls-objectgroupcontact-position").jqxComboBox('val', model.position_id);
        $("#ls-objectgroupcontact-phonenumber").jqxMaskedInput('val', model.phonenumber);
        $("#ls-objectgroupcontact-email").jqxInput('val', model.email);
        
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'objectgroupcontacts',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="objectgroupcontacts[contact_id]" value="<?php echo $model->contact_id; ?>" />
<input type="hidden" name="objectgroupcontacts[objectgr_id]" value="<?php echo $model->objectgr_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div>Фамилия:</div>
                <div>
                    <input type="text" id="ls-objectgroupcontact-surname" name="objectgroupcontacts[surname]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'surname'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Имя:</div>
                <div>
                    <input type="text" id="ls-objectgroupcontact-firstname" name="objectgroupcontacts[firstname]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'firstname'); ?></div>
                </div>
            </div>
            <div class="ls-form-column">
                <div>Отчество:</div>
                <div>
                    <input type="text" id="ls-objectgroupcontact-lastname" name="objectgroupcontacts[lastname]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'lastname'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 120px;">Должность:</div>
            <div class="ls-form-column">
                <div id="ls-objectgroupcontact-position" name="objectgroupcontacts[position_id]" autocomplete="off"></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'position_id'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 120px;">Телефон:</div>
            <div class="ls-form-column">
                <input type="text" id="ls-objectgroupcontact-phonenumber" name="objectgroupcontacts[phonenumber]" autocomplete="off" />
                <div class="ls-form-error"><?php echo $form->error($model, 'phonenumber'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="width: 120px;">Email:</div>
            <div class="ls-form-column">
                <input type="text" id="ls-objectgroupcontact-email" name="objectgroupcontacts[email]" autocomplete="off" />
                <div class="ls-form-error"><?php echo $form->error($model, 'email'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-objectgroupcontact-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-objectgroupcontact-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
