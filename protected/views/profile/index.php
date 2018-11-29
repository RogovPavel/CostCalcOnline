<script type="text/javascript">
    ls.users = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-users-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['users']), {loadError: ls.loaderror});
                $("#ls-users-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-users-grid").jqxGrid('updatebounddata');
        }
    };
    
    ls.options = {
        rowid: undefined,
        row: <?php echo json_encode($settings); ?>,
        refresh: function(reset) {
            if (reset == undefined)
                reset = true;
            
            if (reset) {
                $.ajax({
                    url: '/settings/getdata/' + <?php echo json_encode(Yii::app()->user->user_id); ?>,
                    success: function(Res) {
                        ls.options.row = JSON.parse(Res);
                        ls.options.setvalues();
                    },
                    error: function(Res) {
                        ls.showerrormassage('Ошибка', Res.responseText);
                    }
                });
            }
            else {
                this.setvalues();
            }
        },
        setvalues: function() {
            $("#ls-settings-theme").jqxInput('val', ls.options.row.theme);
        }
    };
    
    $(document).ready(function() {
        
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-login").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25, disabled: true}));
        $("#ls-password").jqxPasswordInput($.extend(true, {}, ls.settings['passwordinput'], {width: '150px', height: 25, disabled: true}));
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0:
                    $("#ls-settings-theme").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $('#ls-btn-edit-settings').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    $('#ls-btn-edit-settings').on('click', function() {
                        if ($('#ls-btn-edit-settings').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('settings', 'update', {setting_id: ls.options.row.setting_id}, 'POST', false, {width: '620px', height: '124px'});
                    });
                    
                    ls.options.setvalues();
                    
                    break;
                case 1:
                    var checkbutton = function() {
                        $('#ls-btn-update').jqxButton({disabled: !(ls.users.row != undefined)})
                        $('#ls-btn-delete').jqxButton({disabled: !(ls.users.row != undefined)})
                    };
                    
                    $("#ls-users-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.users.rowindex = args.rowindex;
                        ls.users.row = args.row;
                        checkbutton();
                    });
                    
                    $("#ls-users-grid").on('rowdoubleclick', function(){
                        $('#ls-btn-update').click();
                    });
                    
                    $("#ls-users-grid").on('bindingcomplete', function() {
                        var idx  = ls.users.rowindex;
                        
                        if (ls.users.rowid != undefined) {
                            idx = $("#ls-users-grid").jqxGrid('getrowboundindexbyid', ls.users.rowid);
                            ls.users.rowid = undefined;
                        }

                        var rows = $("#ls-users-grid").jqxGrid('getrows');

                        if (idx == undefined || idx >= rows.length) 
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
                            columns: [
                                { text: 'ИД', datafield: 'user_id', width: 150},
                                { text: 'Логин', datafield: 'login', width: 150},    
                                { text: 'ФИО', datafield: 'fullname', width: 200},    
                                { text: 'День рождения', datafield: 'birthday', width: 100, cellsformat: 'dd.MM.yyyy'},    
                                { text: 'Роль', datafield: 'rolename', width: 150},    

                            ]

                    }));
                    
                    ls.users.refresh(true);
                    
                    $('#ls-btn-create').on('click', function() {
                        if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('users', 'create', {}, 'POST', false, {width: '620px', height: '310px'});
                    });
                    
                    $('#ls-btn-update').on('click', function() {
                        if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.users.row == undefined) return;
                        ls.opendialogforedit('users', 'update', {user_id: ls.users.row.user_id}, 'POST', false, {width: '620px', height: '310px'});
                    });
                    
                    $('#ls-btn-refresh').on('click', function() {
                        if (ls.lock_operation) return;
                        ls.lock_operation = true;
                        ls.users.refresh(false);
                    });
                    
                    $('#ls-btn-delete').on('click', function() {
                        if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.users.row == undefined) return;            
                        ls.delete('users', 'delete', {user_id: ls.users.row.user_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.users.rowindex--;
                                ls.users.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
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
    $this->pageTitle = 'Админка';
    $this->pageName = 'Админка';
    $this->breadcrumbs=array(
            'Главная' => 'site/index',
            'Личный кабинет' => 'profile/index',
    );
?>

<div class="ls-row" style="height: 100%;">
    <div class="ls-row">
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
    </div>
    



<?php if(Yii::app()->user->checkAccess('manager_profile')) { ?>
    <div class="ls-row" style="height: calc(100% - 118px)">
    <div class="ls-form-row" style="height: calc(100% - 2px);">
        <div id='ls-profile-tab'>
            <ul>
                <li style="margin-left: 30px;">Настройки приложения</li>
                <li style="margin-left: 0px;">Мои сотрудники</li>
            </ul>
            <div style="padding: 10px;">
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 100px">Тема:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-settings-theme" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-edit-settings" value="Изменить" /></div>
                </div>
            </div>
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
</div>
<?php } ?>
</div>