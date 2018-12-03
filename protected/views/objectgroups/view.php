<script type="text/javascript">
    ls.objectgroups = {
        rowid: undefined,
        row: <?php echo json_encode($model); ?>,
        refresh: function(reset, refreshgeneralequips) {
            if (reset == undefined)
                reset = true;
            
            if (refreshgeneralequips == undefined)
                refreshgeneralequips = false;
            
            if (reset) {
                $.ajax({
                    url: '/objectgroups/getdata/' + ls.objectgroups.row.objectgr_id,
                    success: function(Res) {
                        ls.objectgroups.row = JSON.parse(Res);
                        if (refreshgeneralequips)
                            ls.objectequipsgeneral.refresh(false);
                        else
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
            $("#ls-og-quantdoorway").jqxInput('val', ls.objectgroups.row.quantdoorway);
            $("#ls-og-datebuild").jqxDateTimeInput('val', ls.objectgroups.row.datebuild);
            $("#ls-og-managername").jqxInput('val', ls.objectgroups.row.managername);
            
        }
    };
    ls.objectgroupcontacts = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
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
    ls.objectequipsgeneral = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-objectequipsgeneral-grid").jqxGrid('isBindingCompleted'))
                return;
            
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objectequips']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.objectgroups.row != undefined && ls.objectgroups.row.object_id != null)
                            fltrs.push({field: 'oe.object_id', operand: 1, value: ls.objectgroups.row.object_id});
                        else
                            fltrs.push({field: 'oe.object_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-objectequipsgeneral-grid").jqxGrid({source: adapter});
            }
            else 
                $("#ls-objectequipsgeneral-grid").jqxGrid('updatebounddata');
        }
    };
    ls.costcalculations = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-costcalculations-grid").jqxGrid('isBindingCompleted'))
                return;
            
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['costcalculations']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.objectgroups.row != undefined && ls.objectgroups.row.objectgr_id != null)
                            fltrs.push({field: 'c.objectgr_id', operand: 1, value: ls.objectgroups.row.objectgr_id});
                        else
                            fltrs.push({field: 'c.object_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-costcalculations-grid").jqxGrid({source: adapter});
            }
            else 
                $("#ls-costcalculations-grid").jqxGrid('updatebounddata');
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
                    $("#ls-og-quantdoorway").jqxInput($.extend(true, {}, ls.settings['input'], {width: '140px', height: 25, disabled: false}));
                    $("#ls-og-datebuild").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '130px', height: 25, formatString: 'dd.MM.yyyy'}));
                    $("#ls-og-managername").jqxInput($.extend(true, {}, ls.settings['input'], {width: '140px', height: 25, disabled: false}));
                    
                    
                    $("#ls-og-edit").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
                    ls.objectgroups.refresh(false);
                    
                    $('#ls-og-edit').on('click', function() {
                        if ($('#ls-og-edit').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('objectgroups', 'update', {objectgr_id: ls.objectgroups.row.objectgr_id}, 'POST', false, {width: '600px', height: '400px'});
                    });
                    
                    var checkbuttoncontacts = function() {
                        $('#ls-btn-update-contact').jqxButton({disabled: !(ls.objectgroupcontacts.row != undefined)})
                        $('#ls-btn-delete-contact').jqxButton({disabled: !(ls.objectgroupcontacts.row != undefined)})
                    };
                    
                    $("#ls-objectgroupcontacts-grid").on('bindingcomplete', function(event) {
                        var idx  = ls.objectgroupcontacts.rowindex;
                        
                        if (ls.objectgroupcontacts.rowid != undefined) {
                            idx = $("#ls-objectgroupcontacts-grid").jqxGrid('getrowboundindexbyid', ls.objectgroupcontacts.rowid);
                            ls.objectgroupcontacts.rowid = undefined;
                        }
                        
                        var rows = $("#ls-objectgroupcontacts-grid").jqxGrid('getrows');
                        
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        
                        $("#ls-objectgroupcontacts-grid").jqxGrid('selectrow', idx);
                        $("#ls-objectgroupcontacts-grid").jqxGrid('ensurerowvisible', idx);

                        checkbuttoncontacts();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-objectgroupcontacts-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.objectgroupcontacts.rowindex = args.rowindex;
                        ls.objectgroupcontacts.row = args.row;
                        checkbuttoncontacts();
                    });
                    
                    $("#ls-objectgroupcontacts-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'ФИО', columngroup: 'group1', datafield: 'fullname', width: 240},    
                                { text: 'Должность', columngroup: 'group1', datafield: 'positionname', width: 220},
                                { text: 'Телефон', columngroup: 'group1', datafield: 'phonenumber', width: 140},
                                { text: 'Почта', columngroup: 'group1', datafield: 'email', width: 220},
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
                        ls.objectgroupcontacts.refresh(false);
                    });
                    
                    $('#ls-btn-create-contact').on('click', function() {
                        if ($('#ls-btn-create-contact').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('objectgroupcontacts', 'create', {params: {objectgr_id: ls.objectgroups.row.objectgr_id}}, 'POST', false, {width: '600px', height: '260px'});
                    });
                    
                    $('#ls-btn-update-contact').on('click', function() {
                        if ($('#ls-btn-update-contact').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('objectgroupcontacts', 'update', {contact_id: ls.objectgroupcontacts.row.contact_id}, 'POST', false, {width: '600px', height: '260px'});
                    });
                    
                    $('#ls-btn-delete-contact').on('click', function() {
                        if ($('#ls-btn-delete-contact').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.objectgroupcontacts.row == undefined) return; 
                        ls.delete('objectgroupcontacts', 'delete', {contact_id: ls.objectgroupcontacts.row.contact_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.objectgroupcontacts.rowindex--;
                                 ls.objectgroupcontacts.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
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
                        var idx = ls.objects.rowindex;
                        
                        if (ls.objects.rowid != undefined) {
                            idx = $("#ls-objects-grid").jqxGrid('getrowboundindexbyid', ls.objects.rowid);
                            ls.objects.rowid = undefined;
                        }

                        var rows = $("#ls-objects-grid").jqxGrid('getrows');
                        
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        
                        $("#ls-objects-grid").jqxGrid('selectrow', idx);
                        $("#ls-objects-grid").jqxGrid('ensurerowvisible', idx);

                        checkbuttonobjects();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-objects-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.objects.rowindex = args.rowindex;
                        ls.objects.row = args.row;
                        ls.objectequips.refresh(true);
                        checkbuttonobjects();
                    });
                    
                    $("#ls-objects-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'Номер', columngroup: 'group1', datafield: 'doorway', width: 180},
                                { text: 'Кол-во квартир', columngroup: 'group1', datafield: 'quant_flats', width: 110},
                                { text: 'Номера квартир', columngroup: 'group1', datafield: 'numberflats', width: 110},
                                { text: 'Код домофона', columngroup: 'group1', datafield: 'code', width: 110},
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
                        ls.objects.refresh(false);
                    });
                    
                    $('#ls-btn-create-object').on('click', function() {
                        if ($('#ls-btn-create-object').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('objects', 'create', {params: {objectgr_id: ls.objectgroups.row.objectgr_id}}, 'POST', false, {width: '600px', height: '300px'});
                    });
                    
                    $('#ls-btn-update-object').on('click', function() {
                        if ($('#ls-btn-update-object').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('objects', 'update', {object_id: ls.objects.row.object_id}, 'POST', false, {width: '600px', height: '300px'});
                    });
                    
                    $('#ls-btn-delete-object').on('click', function() {
                        if ($('#ls-btn-delete-object').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.objects.row == undefined) return;
                        
                        ls.delete('objects', 'delete', {object_id: ls.objects.row.object_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.objects.rowindex--;
                                ls.objects.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
                            }
                        });
                    });
                    
                    var initWidgets2 = function(tab) {
                        switch(tab) {
                            case 0: 
                                var checkbuttonobjectequips = function() {
                                    $('#ls-btn-update-objectequip').jqxButton({disabled: !(ls.objectequips.row != undefined)})
                                    $('#ls-btn-delete-objectequip').jqxButton({disabled: !(ls.objectequips.row != undefined)})
                                };

                                $("#ls-objectequips-grid").on('bindingcomplete', function() {
                                    var idx = ls.objectequips.rowindex;

                                    if (ls.objectequips.rowid != undefined) {
                                        idx = $("#ls-objectequips-grid").jqxGrid('getrowboundindexbyid', ls.objectequips.rowid);
                                        ls.objectequips.rowid = undefined;
                                    }
                                    
                                    var rows = $("#ls-objectequips-grid").jqxGrid('getrows');
                                    if (idx == undefined || idx >= rows.length) 
                                        idx = 0;
                                    $("#ls-objectequips-grid").jqxGrid('selectrow', idx);
                                    $("#ls-objectequips-grid").jqxGrid('ensurerowvisible', idx);

                                    checkbuttonobjectequips();
                                    ls.lock_operation = false;
                                });
                                
                                $("#ls-objectequips-grid").on('rowselect', function (event) {
                                    var args = event.args;
                                    ls.objectequips.rowindex = args.rowindex;
                                    ls.objectequips.row = args.row;
                                    checkbuttonobjectequips();
                                });
                                
                                $("#ls-objectequips-grid").jqxGrid(
                                    $.extend(true, {}, ls.settings['grid'], {
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
                                    ls.objectequips.refresh(false);
                                });
                                
                                $('#ls-btn-create-objectequip').on('click', function() {
                                    if ($('#ls-btn-create-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    ls.opendialogforedit('objectequips', 'create', {params: {object_id: ls.objects.row.object_id, objectgr_id: ls.objectgroups.row.objectgr_id}}, 'POST', false, {width: '600px', height: '320px'});
                                });
                                
                                $('#ls-btn-update-objectequip').on('click', function() {
                                    if ($('#ls-btn-update-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    ls.opendialogforedit('objectequips', 'update', {objeq_id: ls.objectequips.row.objeq_id}, 'POST', false, {width: '600px', height: '320px'});
                                });
                                
                                $('#ls-btn-delete-objectequip').on('click', function() {
                                    if ($('#ls-btn-delete-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    if (ls.objectequips.row == undefined) return;

                                    ls.delete('objectequips', 'delete', {objeq_id: ls.objectequips.row.objeq_id}, function(Res) {
                                        Res = JSON.parse(Res);
                                        if (Res.state == 0) {
                                            ls.objectequips.rowindex--;
                                            ls.objectequips.refresh(false);
                                        }
                                        else {
                                            ls.showerrormassage('Ошибка! ' + Res.responseText);
                                        }
                                    });
                                });
                            break;
                            case 1: 
                                var checkbuttonobjectequipsgeneral = function() {
                                    $('#ls-btn-update-objectequipgeneral').jqxButton({disabled: !(ls.objectequipsgeneral.row != undefined)})
                                    $('#ls-btn-delete-objectequipgeneral').jqxButton({disabled: !(ls.objectequipsgeneral.row != undefined)})
                                };

                                $("#ls-objectequipsgeneral-grid").on('bindingcomplete', function() {
                                    var idx = ls.objectequipsgeneral.rowindex;

                                    if (ls.objectequipsgeneral.rowid != undefined) {
                                        idx = $("#ls-objectequipsgeneral-grid").jqxGrid('getrowboundindexbyid', ls.objectequipsgeneral.rowid);
                                        ls.objectequipsgeneral.rowid = undefined;
                                    }
                                    
                                    var rows = $("#ls-objectequipsgeneral-grid").jqxGrid('getrows');
                                    if (idx == undefined || idx >= rows.length) 
                                        idx = 0;
                                    $("#ls-objectequipsgeneral-grid").jqxGrid('selectrow', idx);
                                    $("#ls-objectequipsgeneral-grid").jqxGrid('ensurerowvisible', idx);

                                    checkbuttonobjectequipsgeneral();
                                    ls.lock_operation = false;
                                });
                                
                                $("#ls-objectequipsgeneral-grid").on('rowselect', function (event) {
                                    var args = event.args;
                                    ls.objectequipsgeneral.rowindex = args.rowindex;
                                    ls.objectequipsgeneral.row = args.row;
                                    checkbuttonobjectequipsgeneral();
                                });
                                
                                $("#ls-objectequipsgeneral-grid").jqxGrid(
                                    $.extend(true, {}, ls.settings['grid'], {
                                        columns: [
                                            { text: 'Оборудование', datafield: 'equipname', width: 180},
                                            { text: 'Ед. изм.', datafield: 'unit_name', width: 80},    
                                            { text: 'Кол-во', datafield: 'quant', width: 120, cellsformat: 'f2'},    
                                            { text: 'Дата установки', datafield: 'install', width: 120, cellsformat: 'dd.MM.yyyy'},    

                                        ]
                                }));
                                
                                $('#ls-btn-create-objectequipgeneral').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-update-objectequipgeneral').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-refresh-objectequipgeneral').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                $('#ls-btn-delete-objectequipgeneral').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                                
                                ls.objectequipsgeneral.refresh(true);
                                
                                $('#ls-btn-refresh-objectequipgeneral').on('click', function() {
                                    ls.objectequipsgeneral.refresh(false);
                                });
                                
                                $('#ls-btn-create-objectequipgeneral').on('click', function() {
                                    if ($('#ls-btn-create-objectequipgeneral').jqxButton('disabled') || ls.lock_operation) return;
                                    ls.opendialogforedit('objectequips', 'create', {params: {objectgr_id: ls.objectgroups.row.objectgr_id}}, 'POST', false, {width: '600px', height: '320px'});
                                });
                                
                                $('#ls-btn-update-objectequipgeneral').on('click', function() {
                                    if ($('#ls-btn-update-objectequip').jqxButton('disabled') || ls.lock_operation) return;
                                    ls.opendialogforedit('objectequips', 'update', {objeq_id: ls.objectequipsgeneral.row.objeq_id}, 'POST', false, {width: '600px', height: '320px'});
                                });
                                
                                $('#ls-btn-delete-objectequipgeneral').on('click', function() {
                                    if ($('#ls-btn-delete-objectequipgeneral').jqxButton('disabled') || ls.lock_operation) return;
                                    if (ls.objectequipsgeneral.row == undefined) return;

                                    ls.delete('objectequips', 'delete', {objeq_id: ls.objectequipsgeneral.row.objeq_id}, function(Res) {
                                        Res = JSON.parse(Res);
                                        if (Res.state == 0) {
                                            ls.objectequipsgeneral.rowindex--;
                                            ls.objectequipsgeneral.refresh(false);
                                        }
                                        else {
                                            ls.showerrormassage('Ошибка! ' + Res.responseText);
                                        }
                                    });
                                });
                            break;
                        case 2:
                            
                            break;
                        };
                    };
                    
                    /* Оборудование на подъездах */
                    $('#ls-objectequips-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], { width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets2}));
                break;
                case 2:
                    var checkbuttoncostcalculations = function() {
                        $('#ls-btn-info-costcalculations').jqxButton({disabled: !(ls.costcalculations.row != undefined)})
                        $('#ls-btn-delete-costcalculations').jqxButton({disabled: !(ls.costcalculations.row != undefined)})
                    };

                    $("#ls-costcalculations-grid").on('bindingcomplete', function() {
                        var idx = ls.costcalculations.rowindex;

                        if (ls.costcalculations.rowid != undefined) {
                            idx = $("#ls-costcalculations-grid").jqxGrid('getrowboundindexbyid', ls.costcalculations.rowid);
                            ls.costcalculations.rowid = undefined;
                        }

                        var rows = $("#ls-costcalculations-grid").jqxGrid('getrows');
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        $("#ls-costcalculations-grid").jqxGrid('selectrow', idx);
                        $("#ls-costcalculations-grid").jqxGrid('ensurerowvisible', idx);

                        checkbuttoncostcalculations();
                        ls.lock_operation = false;
                    });

                    $("#ls-costcalculations-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.costcalculations.rowindex = args.rowindex;
                        ls.costcalculations.row = args.row;
                        checkbuttoncostcalculations();
                    });

                    $("#ls-costcalculations-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            columns: [
                                { text: 'Номер', datafield: 'calc_id', width: 80},
                                { text: 'Тип', datafield: 'typename', width: 130},
                                { text: 'Наименование проекта', datafield: 'name', width: 280},
                                { text: 'Дата', datafield: 'date', width: 120, cellsformat: 'dd.MM.yyyy'},
                                { text: 'Составил', datafield: 'shortname', width: 150},
                                { text: 'Дата готовности', datafield: 'date_ready', width: 120, cellsformat: 'dd.MM.yyyy'},
                                { text: 'Сумма', datafield: 'sum_high_full', width: 120, cellsformat: 'f2', cellsalign: 'right'},
                            ]
                    }));

                    $('#ls-btn-create-costcalculations').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-info-costcalculations').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-refresh-costcalculations').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-delete-costcalculations').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));

                    ls.costcalculations.refresh(true);

                    $('#ls-btn-refresh-objectequipgeneral').on('click', function() {
                        ls.costcalculations.refresh(false);
                    });

                    $('#ls-btn-create-costcalculations').on('click', function() {
                        if ($('#ls-btn-create-costcalculations').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('costcalculations', 'create', {params: {objectgr_id: ls.objectgroups.row.objectgr_id}}, 'POST', false, {width: '600px', height: '320px'});
                    });

                    $('#ls-btn-info-costcalculations').on('click', function() {

                    });

                    $('#ls-btn-delete-costcalculations').on('click', function() {
                        if ($('#ls-btn-delete-objectequipgeneral').jqxButton('disabled') || ls.lock_operation) return;
                        if (ls.costcalculations.row == undefined) return;

                        ls.delete('costcalculations', 'delete', {objeq_id: ls.costcalculations.row.objeq_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.costcalculations.rowindex--;
                                ls.costcalculations.refresh(false);
                            }
                            else {
                                ls.showerrormassage('Ошибка! ' + Res.responseText);
                            }
                        });
                    });
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

<div class="ls-row" style="height: 100%">
    <div id='ls-objectgroup-tab'>
        <ul>
            <li style="margin-left: 30px;">Общие</li>
            <li style="">Подъезды и оборудование</li>
            <li style="">Коммерческие предложение и сметы</li>
        </ul>
        <div style="padding: 10px;">
            <div class='ls-row' style="height: 252px">
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Клиент:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-clientname"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Адрес:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-address"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Кол-во подъездов:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-quantdoorway"/></div>
                    <div class="ls-row-column">Дата постройки:</div>
                    <div class="ls-row-column"><div readonly="readonly" autocomplete="off" id="ls-og-datebuild"></div></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;">Менеджер:</div>
                    <div class="ls-row-column"><input type="text" readonly="readonly" autocomplete="off" id="ls-og-managername"/></div>
                </div>
                <div class="ls-row">Примечание:</div>
                <div class="ls-row" style="height: 70px;"><textarea readonly="readonly" id="ls-og-note"></textarea></div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 130px;"><input type="button" id="ls-og-edit" value="Изменить"/></div>
                </div>
            </div>
            <div class='ls-row' style="height: calc(100% - 280px)">
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
                    <div style="padding: 10px;">
                        <div class="ls-row" style="height: calc(100% - 64px)">
                            <div class="ls-grid" id="ls-objectequipsgeneral-grid"></div>
                        </div>
                        <div class="ls-row">
                            <div class="ls-row-column"><input type="button" id="ls-btn-create-objectequipgeneral" value="Создать" /></div>
                            <div class="ls-row-column"><input type="button" id="ls-btn-update-objectequipgeneral" value="Изменить" /></div>
                            <div class="ls-row-column"><input type="button" id="ls-btn-refresh-objectequipgeneral" value="Обновить" /></div>
                            <div class="ls-row-column-right"><input type="button" id="ls-btn-delete-objectequipgeneral" value="Удалить" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 10px;">
            <div class="ls-row" style="height: calc(100% - 64px)">
                <div class="ls-grid" id="ls-costcalculations-grid"></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column"><input type="button" id="ls-btn-create-costcalculations" value="Создать" /></div>
                <div class="ls-row-column"><input type="button" id="ls-btn-info-costcalculations" value="Карточка" /></div>
                <div class="ls-row-column"><input type="button" id="ls-btn-refresh-costcalculations" value="Обновить" /></div>
                <div class="ls-row-column-right"><input type="button" id="ls-btn-delete-costcalculations" value="Удалить" /></div>
            </div>
        </div>
    </div>
</div>