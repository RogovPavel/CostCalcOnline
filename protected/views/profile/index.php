<script type="text/javascript">
    ls.users = {
        id: 0
    };
    
    $(document).ready(function() {
        
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-login").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25, disabled: true}));
        $("#ls-password").jqxPasswordInput($.extend(true, {}, ls.settings['passwordinput'], {width: '150px', height: 25, disabled: true}));
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0:
                    var users_data_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['users']));
                    var currentrow_users;
                    
                    var checkbutton = function() {
                        $('#ls-btn-update').jqxButton({disabled: !(currentrow_users != undefined)})
                        $('#ls-btn-delete').jqxButton({disabled: !(currentrow_users != undefined)})
                    };
                    
                    $("#ls-users-grid").on('rowselect', function (event) {
                        currentrow_users = $('#ls-users-grid').jqxGrid('getrowdata', event.args.rowindex);
                        checkbutton();
                    });
                    
                    $("#ls-users-grid").on('rowdoubleclick', function(){
                        $('#ls-btn-update').click();
                    });
                    
                    $("#ls-users-grid").on('bindingcomplete', function() {
                        var idx = $('#ls-users-grid').jqxGrid('selectedrowindex'); 

                        if (ls.users.id != 0) {
                            idx = $("#ls-users-grid").jqxGrid('getrowboundindexbyid', ls.users.id);
                            ls.users.id = 0;
                        }


                        if (idx == -1)
                            idx = 0;

                        $("#ls-users-grid").jqxGrid('selectrow', idx);
                        $("#ls-users-grid").jqxGrid('ensurerowvisible', idx);

                        checkbutton();
                        ls.lock_operation = false;
                    });
                    
                    $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    $("#ls-users-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            source: users_data_adapter,
                            columns: [
                                { text: 'ИД', datafield: 'user_id', width: 150},
                                { text: 'Логин', datafield: 'login', width: 150},    
                                { text: 'ФИО', datafield: 'fullname', width: 200},    
                                { text: 'День рождения', datafield: 'birthday', width: 100, cellsformat: 'dd.MM.yyyy'},    
                                { text: 'Роль', datafield: 'rolename', width: 150},    

                            ]

                    }));
                    
                    
                    
                    $('#ls-btn-create').on('click', function() {
                        if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('users/create')) ?>,
                            type: 'POST',
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.error == 0) {
                                    $("#ls-dialog-content").html(Res.content);
                                    $("#ls-dialog-header-text").html(Res.dialog_header);
                                    $('#ls-dialog').jqxWindow('open');
                                } else
                                    ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                            },
                            error: function(Res) {
                                ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                            }
                        });
                    });
                    
                    $('#ls-btn-update').on('click', function() {
                        if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
                        if (currentrow_users == undefined) return;            
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('users/update')) ?>,
                            type: 'POST',
                            data: {
                                user_id: currentrow_users.user_id
                            },
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.error == 0) {
                                    $("#ls-dialog-content").html(Res.content);
                                    $("#ls-dialog-header-text").html(Res.dialog_header);
                                    $('#ls-dialog').jqxWindow('open');
                                } else
                                    ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                            },
                            error: function(Res) {
                                ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                            }
                        });
                    });
                    
                    $('#ls-btn-refresh').on('click', function() {
                        if (ls.lock_operation) return;

                        ls.lock_operation = true;
                        $("#ls-users-grid").jqxGrid('updatebounddata');
                    });
                    
                    $('#ls-btn-delete').on('click', function() {
                        if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
                        if (currentrow_users == undefined) return;            
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('users/delete')) ?>,
                            type: 'POST',
                            data: {
                                user_id: currentrow_users.user_id
                            },
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.error == 0) {
                                    $('#ls-btn-refresh').click();
                                } else
                                    ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                            },
                            error: function(Res) {
                                ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                            }
                        });
                    });
                break;
            }
        };
        
        $('#ls-profile-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], { width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets}));
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 348}));
        
        $("#ls-login").jqxInput('val', model.login);
        $("#ls-password").jqxPasswordInput('val', model.password);
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Админка';
    $this->pageName = 'Админка';
    $this->breadcrumbs=array(
            'Главная' => 'site/index',
            'Личный кабинет' => 'profile/index',
    );
?>

<div class="ls-form" style="width: 500px">
    <div class="ls-form-header">Личные данные</div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-label">Логин:</div>
            <div class="ls-form-column"><input type="text" id="ls-login" name="LoginForm[username]" autocomplete="off"/></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Пароль:</div>
            <div class="ls-form-column"><input type="password" id="ls-password" name="LoginForm[passowrd]" autocomplete="off"/></div>
        </div>
    </div>
</div>

<div style="clear: both"></div>

<?php if(Yii::app()->user->checkAccess('manager_profile')) { ?>

<div class="ls-form-row" style="margin-top: 6px; height: calc(100% - 308px);">
    <div id='ls-profile-tab'>
        <ul>
            <li style="margin-left: 30px;">Мои сотрудники</li>
        </ul>
        <div style="padding: 10px;">
            <div class="ls-row" style="height: calc(100% - 62px);">
                <div id="ls-users-grid"></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
                <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
                <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
                <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
            </div>
        </div>
    </div>
</div>

<?php } ?>