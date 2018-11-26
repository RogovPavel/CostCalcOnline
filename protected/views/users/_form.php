<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var dataroles;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['Roles']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                dataroles = Res[0];
                
                $("#ls-user-roleid").jqxComboBox({source: dataroles});
                $("#ls-user-roleid").jqxComboBox('val', model.role_id);
            }
        });
        
        $("#ls-user-userid").jqxInput($.extend(true, {}, ls.settings['input'], {width: '80px', height: 25, disabled: true}));
        $("#ls-user-login").jqxInput($.extend(true, {}, ls.settings['input'], {width: '120px', height: 25, disabled: false}));
        $("#ls-user-password").jqxPasswordInput($.extend(true, {}, ls.settings['passwordinput'], {width: '120px', height: 25, disabled: false}));
        $("#ls-user-surname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '160px', height: 25, disabled: false}));
        $("#ls-user-firstname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '160px', height: 25, disabled: false}));
        $("#ls-user-lastname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25, disabled: false}));
        $("#ls-user-sex").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: [{id: 1, name: 'М'}, {id: 2, name: 'Ж'}], displayMember: "name", valueMember: "id", width: '80px'}));
        $("#ls-user-bithday").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy'}));
        $("#ls-user-homephonenumber").jqxInput($.extend(true, {}, ls.settings['input'], {width: '180px', height: 25, disabled: false}));
        $("#ls-user-workphonenumber").jqxInput($.extend(true, {}, ls.settings['input'], {width: '180px', height: 25, disabled: false}));
        $("#ls-user-workemail").jqxInput($.extend(true, {}, ls.settings['input'], {width: '180px', height: 25, disabled: false}));
        $("#ls-user-roleid").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "rolename", valueMember: "role_id", width: '200px'}));
        
        
        $("#ls-user-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-user-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-user-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#users').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-user-save").click();
                return false;
            }
        });
        
        $("#ls-user-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('users', action, $('#users').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    ls.users.rowid = parseInt(Res.id);
                    ls.users.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-user-userid").jqxInput('val', model.user_id);
        $("#ls-user-login").jqxInput('val', model.login);
        $("#ls-user-password").jqxPasswordInput('val', model.password);
        $("#ls-user-surname").jqxInput('val', model.surname);
        $("#ls-user-firstname").jqxInput('val', model.firstname);
        $("#ls-user-lastname").jqxInput('val', model.lastname);
        $("#ls-user-sex").jqxComboBox('val', model.sex);
        $("#ls-user-bithday").jqxDateTimeInput('val', ls.dateconverttosjs(model.birthday));
        $("#ls-user-homephonenumber").jqxInput('val', model.home_phonenumber);
        $("#ls-user-workphonenumber").jqxInput('val', model.work_phonenumber);
        $("#ls-user-workemail").jqxInput('val', model.work_email);
        $("#ls-user-roleid").jqxComboBox('val', model.role_id);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="users[user_id]" value="<?php echo $model->user_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column" style="line-height: 20px;">
                <div>ИД:</div>
                <div>
                    <input type="text" id="ls-user-userid" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'user_name'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Логин:</div>
                <div>
                    <input type="text" id="ls-user-login" name="users[login]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'user_login'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Пароль:</div>
                <div>
                    <input type="password" id="ls-user-password" name="users[password]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'user_password'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Пол:</div>
                <div>
                    <div id="ls-user-sex" name="users[sex]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'sex'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Фамилия:</div>
                <div>
                    <input type="text" id="ls-user-surname" name="users[surname]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'surname'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Имя:</div>
                <div>
                    <input type="text" id="ls-user-firstname" name="users[firstname]" autocomplete="off"/>
                    <div class="ls-form-error"><?php echo $form->error($model, 'firstname'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Отчество:</div>
                <div>
                    <input type="text" id="ls-user-lastname" name="users[lastname]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'user_lastname'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="line-height: 20px;">
                <div>День рождения:</div>
                <div>
                    <div id="ls-user-bithday" name="users[birthday]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'bithday'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Дом. номер:</div>
                <div>
                    <input type="text" id="ls-user-homephonenumber" name="users[home_phonenumber]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'home_phonenumber'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Раб. номер:</div>
                <div>
                    <input type="text" id="ls-user-workphonenumber" name="users[work_phonenumber]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'work_phonenumber'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Раб. Email:</div>
                <div>
                    <input type="text" id="ls-user-workemail" name="users[work_email]" autocomplete="off" />
                    <div class="ls-form-error"><?php echo $form->error($model, 'work_email'); ?></div>
                </div>
            </div>
            <div class="ls-form-column" style="line-height: 20px;">
                <div>Роль:</div>
                <div>
                    <div id="ls-user-roleid" name="users[role_id]" autocomplete="off"></div>
                    <div class="ls-form-error"><?php echo $form->error($model, 'role_id'); ?></div>
                </div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-user-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-user-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
