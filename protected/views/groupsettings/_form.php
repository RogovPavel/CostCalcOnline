<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var dataimages;
        var datatemplates;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['ImagesList', 'Templates']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                
                var tmpdata = Res[0];
                datatemplates = Res[1];
                dataimages = [];
                
                for (var i = 0; i < tmpdata.length; i++) {
                    dataimages[i] = {html: "<div style='padding: 0px; margin: 0px; height: 95px; float: left;'><img width='100%' height='100%' style='float: left; margin-top: 4px; margin-right: 15px;' src='images/index/" + tmpdata[i]['image_id'] + "'/><div style='margin-top: 10px; font-size: 13px;'>", value: tmpdata[i]['image_id']};
                }
                
                $("#ls-setting-edit-logo").jqxComboBox({source: dataimages});
                $("#ls-setting-edit-logo").val(model.logo);
                $("#ls-setting-edit-template").jqxComboBox({source: datatemplates});
                $("#ls-setting-edit-template").val(model.templatefordemands);
            }
        });
        
        $("#ls-setting-edit-theme").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: ls.themes, displayMember: "name", valueMember: "name", width: '200px'}));
        $("#ls-setting-edit-logo").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: ls.themes, valueMember: "value", width: '200px'}));
        $("#ls-setting-edit-host").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25}));
        $("#ls-setting-edit-port").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25}));
        $("#ls-setting-edit-username").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25}));
        $("#ls-setting-edit-password").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25}));
        $("#ls-setting-edit-fromaddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25}));
        $("#ls-setting-edit-template").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: datatemplates, displayMember: "templatename", valueMember: "template_id", width: '300px'}));
        
        $("#ls-setting-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-setting-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-setting-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#groupsettings').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-setting-save").click();
                return false;
            }
        });
        
        $("#ls-setting-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('groupsettings', action, $('#groupsettings').serialize(), function(Res) {
                Res = JSON.parse(Res);
                ls.lock_operation = false;
                if (Res.state == 0) {
                    
                    localStorage.setItem('theme', $("#ls-setting-edit-theme").val());
                    ls.options.refresh(true);
                    
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-setting-edit-theme").jqxComboBox('val', model.theme);
        $("#ls-setting-edit-host").jqxInput('val', model.host);
        $("#ls-setting-edit-port").jqxInput('val', model.port);
        $("#ls-setting-edit-username").jqxInput('val', model.username);
        $("#ls-setting-edit-password").jqxInput('val', model.password);
        $("#ls-setting-edit-fromaddress").jqxInput('val', model.fromaddress);
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groupsettings',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="groupsettings[setting_id]" value="<?php echo $model->setting_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Тема:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-setting-edit-theme" name="groupsettings[theme]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'theme'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Логотип:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-setting-edit-logo" name="groupsettings[logo]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'logo'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column" style="font-weight: bold"><u>Почтовые настройки</u></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Адрес сервера:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><input type="text" id="ls-setting-edit-host" name="groupsettings[host]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'host'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Порт:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><input type="text" id="ls-setting-edit-port" name="groupsettings[port]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'port'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Логин:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><input type="text" id="ls-setting-edit-username" name="groupsettings[username]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'username'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Пароль:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><input type="text" id="ls-setting-edit-password" name="groupsettings[password]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'password'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Адрес отправителя:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><input type="text" id="ls-setting-edit-fromaddress" name="groupsettings[fromaddress]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'fromaddress'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label" style="width: 150px;">Шаблон для заявок:</div>
            <div class="ls-form-column" style="width: calc(100% - 156px);"><div id="ls-setting-edit-template" name="groupsettings[templatefordemands]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'templatefordemands'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-setting-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-setting-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
