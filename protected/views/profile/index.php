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
    
    ls.templates = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-templates-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['templates']), {loadError: ls.loaderror});
                $("#ls-templates-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-templates-grid").jqxGrid('updatebounddata');
        }
    };
    
    ls.images = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-images-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['images']), {loadError: ls.loaderror});
                $("#ls-images-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-images-grid").jqxGrid('updatebounddata');
        }
    };
    
    ls.options = {
        rowid: undefined,
        row: <?php echo json_encode($groupsettings); ?>,
        refresh: function(reset) {
            if (reset == undefined)
                reset = true;
            
            if (reset) {
                $.ajax({
                    url: '/groupsettings/getdata/' + <?php echo json_encode(Yii::app()->user->user_id); ?>,
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
            $("#ls-groupsettings-theme").jqxInput('val', ls.options.row.theme);
            $("#ls-groupsettings-host").jqxInput('val', ls.options.row.host);
            $("#ls-groupsettings-port").jqxInput('val', ls.options.row.port);
            $("#ls-groupsettings-username").jqxInput('val', ls.options.row.username);
            $("#ls-groupsettings-password").jqxInput('val', ls.options.row.password);
            $("#ls-groupsettings-fromaddress").jqxInput('val', ls.options.row.fromaddress);
            if (ls.options.row.logo != null)
                $("#ls-groupsettings-logo").attr("src", 'images/index/' + ls.options.row.logo);
            else
                $("#ls-groupsettings-logo").attr("src", '');
        }
    };
    
    $(document).ready(function() {
    
        window.onfocus = function () {
            var Idx = $('#ls-profile-tab').jqxTabs('selectedItem');
            
            if (Idx == 2)
                ls.templates.refresh(true);
        };
        
        var model = <?php echo json_encode($model); ?>;
        
        $("#ls-login").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25, disabled: true}));
        $("#ls-password").jqxPasswordInput($.extend(true, {}, ls.settings['passwordinput'], {width: '150px', height: 25, disabled: true}));
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0:
                    $("#ls-groupsettings-theme").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $("#ls-groupsettings-host").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $("#ls-groupsettings-port").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $("#ls-groupsettings-username").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $("#ls-groupsettings-password").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25}));
                    $("#ls-groupsettings-fromaddress").jqxInput($.extend(true, {}, ls.settings['input'], {width: '250px', height: 25}));
                    $('#ls-btn-edit-groupsettings').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    
                    $('#ls-btn-edit-groupsettings').on('click', function() {
                        if ($('#ls-btn-edit-groupsettings').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('groupsettings', 'update', {setting_id: ls.options.row.setting_id}, 'POST', false, {width: '620px', height: '374px'});
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
                case 2:
                    var checkbutton = function() {
                        $('#ls-btn-templates-update').jqxButton({disabled: !(ls.templates.row != undefined)})
                        $('#ls-btn-templates-delete').jqxButton({disabled: !(ls.templates.row != undefined)})
                    };
                    
                    $("#ls-templates-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.templates.rowindex = args.rowindex;
                        ls.templates.row = args.row;
                        checkbutton();
                    });
                    
                    $("#ls-templates-grid").on('rowdoubleclick', function(){
                        $('#ls-btn-update').click();
                    });
                    
                    $("#ls-templates-grid").on('bindingcomplete', function() {
                        var idx  = ls.templates.rowindex;
                        
                        if (ls.templates.rowid != undefined) {
                            idx = $("#ls-templates-grid").jqxGrid('getrowboundindexbyid', ls.templates.rowid);
                            ls.templates.rowid = undefined;
                        }

                        var rows = $("#ls-templates-grid").jqxGrid('getrows');

                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;

                        $("#ls-templates-grid").jqxGrid('selectrow', idx);
                        $("#ls-templates-grid").jqxGrid('ensurerowvisible', idx);

                        checkbutton();
                        ls.lock_operation = false;
                    });
                    
                    $('#ls-btn-templates-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-templates-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-templates-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-templates-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    
                    $("#ls-templates-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'Наименование', datafield: 'templatename', width: 150},
                                { text: 'Активно', datafield: 'active', columntype: 'checkbox', width: 200},    
                            ]
                    }));
                    
                    ls.templates.refresh(true);
                    
                    $('#ls-btn-templates-create').on('click', function() {
                        ls.wopen('templates/create', [], 'createtemplate');
                    });
                    
                    $('#ls-btn-templates-update').on('click', function() {
                        if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
                        var params = [];
                        params['template_id'] = ls.templates.row.template_id;
                        ls.wopen('templates/update', params, 'updatetemplate');
                    });
                    
                    $('#ls-btn-templates-refresh').on('click', function() {
                        if (ls.lock_operation) return;
                        ls.lock_operation = true;
                        ls.templates.refresh(false);
                    });
                    
                    $('#ls-btn-templates-delete').on('click', function() {
                        if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.templates.row == undefined) return;            
                        ls.delete('templates', 'delete', {template_id: ls.templates.row.template_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.templates.rowindex--;
                                ls.templates.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
                            }
                        });
                    });
                break;
                case 3:
                    var checkbutton = function() {
                        $('#ls-btn-images-delete').jqxButton({disabled: !(ls.images.row != undefined)})
                    };
                    
                    $("#ls-images-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.images.rowindex = args.rowindex;
                        ls.images.row = args.row;
                        checkbutton();
                    });
                    
                    $("#ls-images-grid").on('rowdoubleclick', function(){
                        $('#ls-btn-update').click();
                    });
                    
                    $("#ls-images-grid").on('bindingcomplete', function() {
                        var idx  = ls.images.rowindex;
                        
                        if (ls.images.rowid != undefined) {
                            idx = $("#ls-images-grid").jqxGrid('getrowboundindexbyid', ls.images.rowid);
                            ls.images.rowid = undefined;
                        }

                        var rows = $("#ls-images-grid").jqxGrid('getrows');

                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;

                        $("#ls-images-grid").jqxGrid('selectrow', idx);
                        $("#ls-images-grid").jqxGrid('ensurerowvisible', idx);

                        checkbutton();
                        ls.lock_operation = false;
                    });
                    
                    $('#ls-btn-images-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-images-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-file-load').jqxFileUpload({ width: 10, fileInputName: 'logo'});
                    $('#ls-load-logo').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    $('#ls-load-logo').on('click', function() {
                        $('#ls-file-load').jqxFileUpload({uploadUrl: <?php echo json_encode(Yii::app()->createUrl('groupsettings/loadimg')); ?>});
                        $('#ls-file-load').jqxFileUpload('browse');
                    });
                    
                    $('#ls-file-load').on('select', function (event) {
                        $('#ls-file-load').jqxFileUpload('uploadAll');
                    });

                    $('#ls-file-load').on('uploadEnd', function (event) {
                        ls.images.refresh();
                    });
                    
                    var imagerenderer = function(row, datafield, value) {
                        var data = $('#ls-images-grid').jqxGrid('getrowdata', row);
                        return '<img style="margin-left: 5px;" height="60" width="120" src="/images/index/' + data['image_id'] + '"/>';
                    };
                    
                    $("#ls-images-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            rowsheight: 60,
                            columns: [
                                { text: 'ИД', datafield: 'image_id', width: 100},
                                { text: 'Изображение', datafield: 'image', width: 120, cellsrenderer: imagerenderer},
                            ]
                    }));
                    
                    ls.images.refresh(true);
                    
                    $('#ls-btn-images-create').on('click', function() {
                        
                    });
                    
                    
                    $('#ls-btn-images-refresh').on('click', function() {
                        if (ls.lock_operation) return;
                        ls.lock_operation = true;
                        ls.images.refresh(false);
                    });
                    
                    $('#ls-btn-images-delete').on('click', function() {
                        if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.images.row == undefined) return;            
                        ls.delete('images', 'delete', {image_id: ls.images.row.image_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.images.rowindex--;
                                ls.images.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
                            }
                        });
                    });
                break;
            }
        };
        
        $('#ls-profile-tab').on('selected', function(event) {
            var idx = event.args.item;
            ls.settabindex(idx);
        });
        
        var idx = ls.gettabindex();
        if (isNaN(idx))
            idx = 0;
        
        $('#ls-profile-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], {selectedItem: idx, width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets}));
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
                <li style="margin-left: 0px;">Мои шаблоны документов</li>
                <li style="margin-left: 0px;">Мои изображения</li>
            </ul>
            <div style="padding: 10px;">
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 100px">Тема:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-theme" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 100px">Логотип:</div>
                    <div class="ls-row-column" style="border: 1px solid black; width: 500px; height: 70px;"><img id="ls-groupsettings-logo" width="100%" height="100%" src=""/></div>
                    
                </div>
                <div class="ls-row" style="margin-top: 10px;">
                    <div class="ls-row-column" style="width: 200px; font-weight: bold;"><u>Почтовые настройки:</u></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 200px">Адрес:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-host" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 200px">Порт:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-port" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 200px">Логин:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-username" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 200px">Пароль:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-password" autocomplete="off"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 200px">Адрес отправителя:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" id="ls-groupsettings-fromaddress" autocomplete="off"/></div>
                </div>
                <div class="ls-row" style="margin-top: 30px;">
                    <div class="ls-row-column"><input type="button" id="ls-btn-edit-groupsettings" value="Изменить" /></div>
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
            <div style="padding: 10px;">
                <div class="ls-row" style="height: calc(100% - 62px);">
                    <div id="ls-templates-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-templates-create" value="Создать" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-templates-update" value="Изменить" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-templates-refresh" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-templates-delete" value="Удалить" /></div>
                </div>
            </div>
            <div style="padding: 10px;">
                <div class="ls-row" style="height: calc(100% - 62px);">
                    <div id="ls-images-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-load-logo" value="Загрузить"/></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-images-refresh" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-images-delete" value="Удалить" /></div>
                </div>
                <div style="display: none;">
                    <div id="ls-file-load"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</div>