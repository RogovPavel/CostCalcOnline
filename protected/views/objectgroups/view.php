<script type="text/javascript">
    ls.objectgroups = {
        id: undefined,
        row: <?php echo json_encode($model); ?>,
        refresh: function(reset) {
            if (reset == undefined)
                reset = true;
            
            if (reset) {
                $.ajax({
                    url: '/objectgroups/getdata/' + ls.objectgroups.row.objectgr_id,
                    success: function(Res) {
                        ls.objectgroups.row = JSON.parse(Res);
                        ls.objectgroups.setvalues();
                    },
                    error: function(Res) {
                        ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                    }
                });
            }
            else {
                this.setvalues();
            }
        },
        setvalues: function() {
            $("#ls-og-clientname").jqxInput('val', ls.objectgroups.row.clientname);
            $("#ls-og-address").jqxInput('val', ls.objectgroups.row.address);
            $("#ls-og-note").jqxTextArea('val', ls.objectgroups.row.note);
        }
    };
    
    ls.objectgroupcontacts = {
        id: undefined,
        row: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-objectgroupcontacts-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objectgroupcontacts']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.objectgroups.row.objectgr_id != null && ls.objectgroups.row.objectgr_id != undefined)
                            fltrs.push({field: 'ogc.objectgr_id', operand: 1, value: ls.objectgroups.row.objectgr_id});
                        else
                            fltrs.push({field: 'ogc.objectgr_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-objectgroupcontacts-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-objectgroupcontacts-grid").jqxGrid('updatebounddata');
        }
    };
    ls.objects = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-objects-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objects']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.objectgroups.row.objectgr_id != null && ls.objectgroups.row.objectgr_id != undefined)
                            fltrs.push({field: 'o.objectgr_id', operand: 1, value: ls.objectgroups.row.objectgr_id});
                        else
                            fltrs.push({field: 'o.objectgr_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-objects-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-objects-grid").jqxGrid('updatebounddata');
        }
    };
    ls.objectequips = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-objectequips-grid").jqxGrid('isBindingCompleted'))
                return;
            
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objectequips']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.objects.row != undefined && ls.objects.row != null)
                            fltrs.push({field: 'oe.object_id', operand: 1, value: ls.objects.row.object_id});
                        else
                            fltrs.push({field: 'oe.object_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-objectequips-grid").jqxGrid({source: adapter});
            }
            else 
                $("#ls-objectequips-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var settabindex = function(idx) {
            try {
                history.pushState(null, null, '#' + idx);
            } catch(e) {};
        };
        
        var gettabindex = function() {
            idx = location.hash;
            idx = idx.substr(1);
            return parseInt(idx);
        };
        
        
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0:
                    $("#ls-og-clientname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '250px', height: 25, disabled: false}));
                    $("#ls-og-address").jqxInput($.extend(true, {}, ls.settings['input'], {width: '250px', height: 25, disabled: false}));
                    $("#ls-og-note").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {theme: ls.defaults.theme, width: 'calc(100% - 2px)', height: 'calc(100% - 2px)'}));
                    $("#ls-og-edit").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
                    ls.objectgroups.refresh(false);
                    
                    
                    $('#ls-og-edit').on('click', function() {
                        if ($('#ls-og-edit').jqxButton('disabled') || ls.lock_operation) return;
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objectgroups/update')) ?>,
                            type: 'POST',
                            data: {
                                objectgr_id: ls.objectgroups.row.objectgr_id
                            },
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
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
                    
                    
                    
                    var checkbuttoncontacts = function() {
                        $('#ls-btn-update-contact').jqxButton({disabled: !(ls.objectgroupcontacts.row != undefined)})
                        $('#ls-btn-delete-contact').jqxButton({disabled: !(ls.objectgroupcontacts.row != undefined)})
                    };
                    
                    $("#ls-objectgroupcontacts-grid").on('bindingcomplete', function() {
                        var idx = $('#ls-objectgroupcontacts-grid').jqxGrid('selectedrowindex'); 
                        
                        
                        if (ls.objectgroupcontacts.id != 0) {
                            
                            
                            idx = $("#ls-objectgroupcontacts-grid").jqxGrid('getrowboundindexbyid', ls.objectgroupcontacts.id);
                            ls.objectgroupcontacts.id = 0;
                        }


                        if (idx == -1)
                            idx = 0;
                        
                        

                        $("#ls-objectgroupcontacts-grid").jqxGrid('selectrow', idx);
                        $("#ls-objectgroupcontacts-grid").jqxGrid('ensurerowvisible', idx);

                        checkbuttoncontacts();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-objectgroupcontacts-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.objectgroupcontacts.index = args.rowindex;
                        ls.objectgroupcontacts.row = args.row;
                        checkbuttoncontacts();
                    });
                    
                    $("#ls-objectgroupcontacts-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'ФИО', columngroup: 'group1', datafield: 'fullname', width: 180},    
                                { text: 'Должность', columngroup: 'group1', datafield: 'position_name', width: 120},
                                { text: 'Телефон', columngroup: 'group1', datafield: 'phonenumber', width: 120},
                                { text: 'Почта', columngroup: 'group1', datafield: 'email', width: 120},
                            ],
                            columngroups: [
                              { text: 'Контактные лица', align: 'center', name: 'group1' },
                            ]

                    }));
                    
                    $('#ls-btn-create-contact').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-update-contact').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-refresh-contact').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-delete-contact').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    ls.objectgroupcontacts.refresh(true);
                    
                    $('#ls-btn-refresh-contact').on('click', function() {
                        $("#ls-objectgroupcontacts-grid").jqxGrid('updatebounddata');
                    });
                    
                    $('#ls-btn-create-contact').on('click', function() {
                        if ($('#ls-btn-create-contact').jqxButton('disabled') || ls.lock_operation) return;
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objectgroupcontacts/create')) ?>,
                            type: 'POST',
                            async: false,
                            data: {
                                params: {
                                    objectgr_id: ls.objectgroups.row.objectgr_id
                                }
                            },
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
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
                    
                    $('#ls-btn-update-contact').on('click', function() {
                        if ($('#ls-btn-update-contact').jqxButton('disabled') || ls.lock_operation) return;
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objectgroupcontacts/update')) ?>,
                            type: 'POST',
                            async: false,
                            data: {
                                contact_id: ls.objectgroupcontacts.row.contact_id
                            },
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
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
                    
                    $('#ls-btn-delete-contact').on('click', function() {
                        if ($('#ls-btn-delete-contact').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.objectgroupcontacts.row == undefined) return;            
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objectgroupcontacts/delete')) ?>,
                            type: 'POST',
                            data: {
                                contact_id: ls.objectgroupcontacts.row.contact_id
                            },
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
                                    var idx = $('#ls-objectgroupcontacts-grid').jqxGrid('selectedrowindex'); 
                                    var row = $('#ls-objectgroupcontacts-grid').jqxGrid('getrowdata', (idx-1));
                                    
                                    if (row != undefined)
                                        ls.objectgroupcontacts.id = row['contact_id'];
                                            
                                    $('#ls-btn-refresh-contact').click();
                                } else
                                    ls.showerrormassage('Ошибка! ' + Res.error);
                            },
                            error: function(Res) {
                                ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                            }
                        });
                    });
                break;
                case 1:
                    
                    
                    var checkbuttonobjects = function() {
                        $('#ls-btn-update-object').jqxButton({disabled: !(ls.objects.row != undefined)})
                        $('#ls-btn-delete-object').jqxButton({disabled: !(ls.objects.row != undefined)})
                    };
                    
                    $("#ls-objects-grid").on('bindingcomplete', function() {
                        var idx = $('#ls-objects-grid').jqxGrid('selectedrowindex'); 
                        
                        if (ls.objects.rowid != undefined) {
                            idx = $("#ls-objects-grid").jqxGrid('getrowboundindexbyid', ls.objects.rowid);
                            ls.objects.rowid = 0;
                        }

                        if (idx == -1)
                            idx = 0;
                        
                                                
                        $("#ls-objects-grid").jqxGrid('selectrow', idx);
                        $("#ls-objects-grid").jqxGrid('ensurerowvisible', idx);

                        checkbuttonobjects();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-objects-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.objects.index = args.rowindex;
                        ls.objects.row = args.row;
                        ls.objectequips.refresh(1);
                        checkbuttonobjects();
                    });
                    
                    $("#ls-objects-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'Номер', columngroup: 'group1', datafield: 'doorway', width: 180},    
                                
                            ],
                            columngroups: [
                              { text: 'Подъезды', align: 'center', name: 'group1' },
                            ]

                    }));
                    
                    $('#ls-btn-create-object').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-update-object').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-refresh-object').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-delete-object').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    ls.objects.refresh(true);
                    
                    $('#ls-btn-refresh-object').on('click', function() {
                        $("#ls-objects-grid").jqxGrid('updatebounddata');
                    });
                    
                    $('#ls-btn-create-object').on('click', function() {
                        if ($('#ls-btn-create-object').jqxButton('disabled') || ls.lock_operation) return;
                        $('#ls-dialog').jqxWindow({width: 600, height: 300});
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objects/create')) ?>,
                            type: 'POST',
                            async: false,
                            data: {
                                params: {
                                    objectgr_id: ls.objectgroups.row.objectgr_id
                                }
                            },
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
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
                    
                    $('#ls-btn-update-object').on('click', function() {
                        if ($('#ls-btn-update-object').jqxButton('disabled') || ls.lock_operation) return;
                        $('#ls-dialog').jqxWindow({width: 600, height: 300});
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objects/update')) ?>,
                            type: 'POST',
                            async: false,
                            data: {
                                object_id: currentrow_objects.object_id
                            },
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
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
                    
                    $('#ls-btn-delete-object').on('click', function() {
                        if ($('#ls-btn-delete-object').jqxButton('disabled') || ls.lock_operation) return;
                        if (currentrow_objects == undefined) return;            
                        $.ajax({
                            url: <?php echo json_encode(Yii::app()->createUrl('objects/delete')) ?>,
                            type: 'POST',
                            data: {
                                object_id: currentrow_objects.object_id
                            },
                            async: false,
                            success: function(Res) {
                                Res = JSON.parse(Res);
                                if (Res.state == 0) {
                                    var idx = $('#ls-objects-grid').jqxGrid('selectedrowindex'); 
                                    var row = $('#ls-objects-grid').jqxGrid('getrowdata', (idx-1));
                                    
                                    if (row != undefined)
                                        ls.object.id = row['object_id'];
                                            
                                    $('#ls-btn-refresh-object').click();
                                } else
                                    ls.showerrormassage('Ошибка! ' + Res.error);
                            },
                            error: function(Res) {
                                ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                            }
                        });
                    });
                    
                    var initWidgets2 = function(tab) {
                        switch(tab) {
                            case 0: 
                                var currentrow_objectequips1;
                    
                                
                                
                                var checkbuttonobjectequips1 = function() {
                                    $('#ls-btn-update-objectequip').jqxButton({disabled: !(currentrow_objectequips1 != undefined)})
                                    $('#ls-btn-delete-objectequip').jqxButton({disabled: !(currentrow_objectequips1 != undefined)})
                                };

                                $("#ls-objectequips-grid").on('bindingcomplete', function() {
                                    var idx = $('#ls-objectequips-grid').jqxGrid('selectedrowindex'); 

                                    if (ls.objectequips.rowid != 0) {
                                        idx = $("#ls-objectequips-grid").jqxGrid('getrowboundindexbyid', ls.objectequips.rowid);
                                        ls.objectequips.rowid = 0;
                                    }
                                    if (idx == -1)
                                        idx = 0;
                                    
                                    $("#ls-objectequips-grid").jqxGrid('selectrow', idx);
                                    $("#ls-objectequips-grid").jqxGrid('ensurerowvisible', idx);

                                    checkbuttonobjectequips1();
                                    ls.lock_operation = false;
                                });
                                
                                $("#ls-objectequips-grid").on('rowselect', function (event) {
                                    currentrow_objectequips1 = $('#ls-objectequips-grid').jqxGrid('getrowdata', event.args.rowindex);
                                    checkbuttonobjectequips1();
                                });
                                
                                $("#ls-objectequips-grid").jqxGrid(
                                    $.extend(true, {}, ls.settings['grid'], {
//                                        source: objectequips_adapter,
                                        columns: [
                                            { text: 'Оборудование', datafield: 'equipname', width: 180},
                                            { text: 'Ед. изм.', datafield: 'unit_name', width: 80},    
                                            { text: 'Кол-во', datafield: 'quant', width: 120, cellsformat: 'f2'},    
                                            { text: 'Дата установки', datafield: 'install', width: 120, cellsformat: 'dd.MM.yyyy'},    

                                        ]
                                }));
                                
                                $('#ls-btn-create-objectequip').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-update-objectequip').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-refresh-objectequip').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-delete-objectequip').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                
                                $('#ls-btn-refresh-objectequip').on('click', function() {
                                    $("#ls-objectequips-grid").jqxGrid('updatebounddata');
                                });
                                
                                $('#ls-btn-create-objectequip').on('click', function() {
                                    if ($('#ls-btn-create-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    $('#ls-dialog').jqxWindow({width: 600, height: 320});
                                    $.ajax({
                                        url: <?php echo json_encode(Yii::app()->createUrl('objectequips/create')) ?>,
                                        type: 'POST',
                                        async: false,
                                        data: {
                                            params: {
                                                object_id: currentrow_objects.object_id,
                                                objectgr_id: ls.objectgroups.row.objectgr_id
                                            }
                                        },
                                        success: function(Res) {
                                            Res = JSON.parse(Res);
                                            if (Res.state == 0) {
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
                                
                                $('#ls-btn-update-objectequip').on('click', function() {
                                    if ($('#ls-btn-update-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    $('#ls-dialog').jqxWindow({width: 600, height: 320});
                                    $.ajax({
                                        url: <?php echo json_encode(Yii::app()->createUrl('objectequips/update')) ?>,
                                        type: 'POST',
                                        async: false,
                                        data: {
                                            objeq_id: currentrow_objectequips1.objeq_id
                                        },
                                        success: function(Res) {
                                            Res = JSON.parse(Res);
                                            if (Res.state == 0) {
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
                            break;
                        };
                    };
                    
                    /* Оборудование на подъездах */
                    $('#ls-objectequips-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], { width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets2}));
                break;
            };
        };
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 260}));
        
        $('#ls-objectgroup-tab').on('selected', function(event) {
            var idx = event.args.item;
            settabindex(idx);
        });
        
        var idx = gettabindex();
        if (isNaN(idx))
            idx = 0;
            
        $('#ls-objectgroup-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], {selectedItem: idx, width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets}));
    });
    
</script>

<?php
    $this->pageTitle = $model->address;
    $this->pageName = 'Карточка объекта: ' . $model->address;
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Объекты' => 'objectgroups',
            $model->address => '',
    );
?>

<div class="ls-row" style="height: calc(100% - 182px);">
    <div id='ls-objectgroup-tab'>
        <ul>
            <li style="margin-left: 30px;">Общие</li>
            <li style="">Подъезды и оборудование</li>
            <li style="">Коммерческие предложение и сметы</li>
        </ul>
        <div style="padding: 10px;">
            <div class='ls-row' style="height: 190px">
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Клиент:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-clientname"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Адрес:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-address"/></div>
                </div>
                <div class="ls-row">Примечание:</div>
                <div class="ls-row" style="height: 70px;"><textarea readonly="readonly" id="ls-og-note"></textarea></div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;"><input type="button" id="ls-og-edit" value="Изменить"/></div>
                </div>
            </div>
            <div class='ls-row' style="height: calc(100% - 218px)">
                <div class="ls-row" style="height: calc(100% - 34px)">
                    <div class="ls-grid" id="ls-objectgroupcontacts-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-create-contact" value="Создать" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-update-contact" value="Изменить" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-refresh-contact" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-delete-contact" value="Удалить" /></div>
                </div>
            </div>
        </div>
        <div style="padding: 10px;">
            <div class='ls-row' style="height: 250px">
                <div class="ls-row" style="height: calc(100% - 34px)">
                    <div class="ls-grid" id="ls-objects-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-create-object" value="Создать" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-update-object" value="Изменить" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-refresh-object" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-delete-object" value="Удалить" /></div>
                </div>
            </div>
            <div class='ls-row' style="height: calc(100% - 280px)">
                <div id='ls-objectequips-tab'>
                    <ul>
                        <li style="margin-left: 30px;">Оборудование на подъезде</li>
                        <li style="">Оборудование на доме</li>
                    </ul>
                    <div style="padding: 10px;">
                        <div class="ls-row" style="height: calc(100% - 64px)">
                            <div class="ls-grid" id="ls-objectequips-grid"></div>
                        </div>
                        <div class="ls-row">
                            <div class="ls-row-column"><input type="button" id="ls-btn-create-objectequip" value="Создать" /></div>
                            <div class="ls-row-column"><input type="button" id="ls-btn-update-objectequip" value="Изменить" /></div>
                            <div class="ls-row-column"><input type="button" id="ls-btn-refresh-objectequip" value="Обновить" /></div>
                            <div class="ls-row-column-right"><input type="button" id="ls-btn-delete-objectequip" value="Удалить" /></div>
                        </div>
                    </div>
                    <div style="padding: 10px;"></div>
                </div>
            </div>
        </div>
        <div style="padding: 10px;">
            
        </div>
    </div>
</div>