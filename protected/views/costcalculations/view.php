<script type="text/javascript">
    ls.costcalculations = {
        rowid: undefined,
        row: <?php echo json_encode($model); ?>,
        refresh: function(reset) {
            if (reset == undefined)
                reset = true;
            
            if (reset) {
                $.ajax({
                    url: '/costcalculations/getdata/' + ls.costcalculations.row.calc_id,
                    success: function(Res) {
                        ls.costcalculations.row = JSON.parse(Res);
                        ls.costcalculations.setvalues();
                        ls.costcalculations.checkbuttons();
                    },
                    error: function(Res) {
                        ls.showerrormassage('Ошибка', res.responseText);
                    }
                });
            }
            else {
                this.setvalues();
            }
        },
        setvalues: function() {
            $("#ls-costcalculations-calc").jqxInput('val', ls.costcalculations.row.calc_id);
            $("#ls-costcalculations-address").jqxInput('val', ls.costcalculations.row.address);
            $("#ls-costcalculations-date").jqxDateTimeInput('val', ls.dateconverttosjs(ls.costcalculations.row.date));
            $("#ls-costcalculations-name").jqxInput('val', ls.costcalculations.row.name);
            $("#ls-costcalculations-client").jqxInput('val', ls.costcalculations.row.clientname);
            $("#ls-costcalculations-manager").jqxInput('val', ls.costcalculations.row.shortname);
            $("#ls-costcalculations-demand").jqxInput('val', ls.costcalculations.row.demand_id);
            $("#ls-costcalculations-specnote").jqxTextArea('val', ls.costcalculations.row.specnote);
            
            
            $("#ls-costcalculations-sumexpenceslow").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_expences_low));
            $("#ls-costcalculations-sumexpenceshigh").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_expences_high));
            $("#ls-costcalculations-summaterialslow").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_materials_low));
            $("#ls-costcalculations-summaterialshigh").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_materials_high));
            $("#ls-costcalculations-sumstartworkslow").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_startworks_low));
            $("#ls-costcalculations-sumstartworkshigh").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_startworks_high));
            $("#ls-costcalculations-koef").jqxNumberInput('val', parseFloat(ls.costcalculations.row.koef));
            $("#ls-costcalculations-sumlowfull").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_low_full));
            $("#ls-costcalculations-sumhighfull").jqxNumberInput('val', parseFloat(ls.costcalculations.row.sum_high_full));
            $("#ls-costcalculations-marj").jqxNumberInput('val', parseFloat(ls.costcalculations.row.percent_marj));
            $("#ls-costcalculations-discount").jqxNumberInput('val', parseFloat(ls.costcalculations.row.discount));
        },
        checkbuttons: function() {
            $('#ls-costcalculations-edit').jqxButton({disabled: (this.row.date_ready != null)});
            $('#ls-btn-edit-details').jqxButton({disabled: (this.row.date_ready != null)});
            ls.costcalcequips.checkbutton();
            ls.costcalcworks.checkbutton();
        }
    };
    
    ls.costcalcequips = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-costcalcequips-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['costcalcequips']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.costcalculations.row.calc_id != null && ls.costcalculations.row.calc_id != undefined)
                            fltrs.push({field: 'e.calc_id', operand: 1, value: ls.costcalculations.row.calc_id});
                        else
                            fltrs.push({field: 'e.calc_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-costcalcequips-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-costcalcequips-grid").jqxGrid('updatebounddata');
        },
        checkbutton: function() {
            $('#ls-btn-add-costcalcequips').jqxButton({disabled: !((ls.costcalculations.row != undefined) && (ls.costcalculations.row.date_ready == null))});
            $('#ls-btn-edit-costcalcequips').jqxButton({disabled: !((ls.costcalcequips.row != undefined) && (ls.costcalculations.row.date_ready == null))});
            $('#ls-btn-del-costcalcequips').jqxButton({disabled: !((ls.costcalcequips.row != undefined) && (ls.costcalculations.row.date_ready == null))});
        }
    };
    
    ls.costcalcworks = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-costcalcworks-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['costcalcworks']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.costcalculations.row.calc_id != null && ls.costcalculations.row.calc_id != undefined)
                            fltrs.push({field: 'ccw.calc_id', operand: 1, value: ls.costcalculations.row.calc_id});
                        else
                            fltrs.push({field: 'ccw.calc_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-costcalcworks-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-costcalcworks-grid").jqxGrid('updatebounddata');
        },
        checkbutton: function() {
            $('#ls-btn-add-costcalcworks').jqxButton({disabled: !((ls.costcalculations.row != undefined) && (ls.costcalculations.row.date_ready == null))})
            $('#ls-btn-edit-costcalcworks').jqxButton({disabled: !((ls.costcalcworks.row != undefined) && (ls.costcalculations.row.date_ready == null))})
            $('#ls-btn-del-costcalcworks').jqxButton({disabled: !((ls.costcalcworks.row != undefined) && (ls.costcalculations.row.date_ready == null))})
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
        
        $("#ls-costcalculations-calc").jqxInput($.extend(true, {}, ls.settings['input'], {width: '100px', height: 25, disabled: false}));
        $("#ls-costcalculations-date").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm', readonly: true, showTimeButton: false, showCalendarButton: false}));
        $("#ls-costcalculations-address").jqxInput($.extend(true, {}, ls.settings['input'], {width: '350px', height: 25, disabled: false}));
        $("#ls-costcalculations-name").jqxInput($.extend(true, {}, ls.settings['input'], {width: '358px', height: 25, disabled: false}));
        $("#ls-costcalculations-client").jqxInput($.extend(true, {}, ls.settings['input'], {width: '358px', height: 25, disabled: false}));
        $("#ls-costcalculations-manager").jqxInput($.extend(true, {}, ls.settings['input'], {width: '158px', height: 25, disabled: false}));
        $("#ls-costcalculations-demand").jqxInput($.extend(true, {}, ls.settings['input'], {width: '80px', height: 25, disabled: false}));
        $("#ls-costcalculations-specnote").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        $("#ls-costcalculations-edit").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
        $("#ls-costcalculations-ready").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
        $("#ls-costcalculations-undo").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '140px', height: 30}));
        $("#ls-costcalculations-print").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '140px', height: 30}));
        
        $("#ls-costcalculations-summaterialslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-summaterialshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-sumexpenceslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-sumexpenceshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-sumstartworkslow").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-sumstartworkshigh").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-koef").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        
        $("#ls-costcalculations-sumlowfull").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-sumhighfull").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-discount").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        $("#ls-costcalculations-marj").jqxNumberInput($.extend(true, {}, ls.settings['numberinput'], {width: '130px', height: 25, readOnly: true}));
        
        
        $("#ls-btn-edit-details").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '130px', height: 30}));
        
        $("#ls-btn-edit-details").on('click', function() {
            if ($('#ls-btn-edit-details').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('costcalculations', 'updatedetails', {calc_id: ls.costcalculations.row.calc_id}, 'POST', false, {width: '600px', height: '564px'});
        });
        
        $('#ls-costcalculations-edit').on('click', function() {
            if ($('#ls-costcalculations-edit').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('costcalculations', 'update', {calc_id: ls.costcalculations.row.calc_id}, 'POST', false, {width: '600px', height: '564px'});
        });
        
        
        
        $('#ls-costcalculations-undo').on('click', function() {
            if ($('#ls-costcalculations-undo').jqxButton('disabled') || ls.lock_operation) return;
            ls.save('costcalculations', 'undo', {params: {calc_id: ls.costcalculations.row.calc_id}}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.costcalculations.refresh(true);
                }
                else
                    ls.showerrormassage('Ошибка!', Res.responseText);
            }, 'POST', true);
        });
        
        $('#ls-costcalculations-ready').on('click', function() {
            if ($('#ls-costcalculations-ready').jqxButton('disabled') || ls.lock_operation) return;
            ls.save('costcalculations', 'ready', {params: {calc_id: ls.costcalculations.row.calc_id}}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.costcalculations.refresh(true);
                }
                else
                    ls.showerrormassage('Ошибка!', Res.responseText);
            }, 'POST', true);
        });
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0:
                    
                    
                    $("#ls-costcalcequips-grid").on('bindingcomplete', function(event) {
                        var idx  = ls.costcalcequips.rowindex;
                        
                        if (ls.costcalcequips.rowid != undefined) {
                            idx = $("#ls-costcalcequips-grid").jqxGrid('getrowboundindexbyid', ls.costcalcequips.rowid);
                            ls.costcalcequips.rowid = undefined;
                        }
                        
                        var rows = $("#ls-costcalcequips-grid").jqxGrid('getrows');
                        
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        
                        $("#ls-costcalcequips-grid").jqxGrid('selectrow', idx);
                        $("#ls-costcalcequips-grid").jqxGrid('ensurerowvisible', idx);

                        ls.costcalcequips.checkbutton();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-costcalcequips-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.costcalcequips.rowindex = args.rowindex;
                        ls.costcalcequips.row = args.row;
                        ls.costcalcequips.checkbutton();
                    });
                    
                    $("#ls-costcalcequips-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            pageable: false,
                            showstatusbar: true,
                            showaggregates: true,
                            columns: [
                                {text: 'Наименование', columngroup: 'group1', datafield: 'equipname', width: 240},    
                                {text: 'Ед. изм.', columngroup: 'group1', datafield: 'unit_name', width: 80},
                                {text: 'Кол-во', columngroup: 'group1', datafield: 'quant', width: 80, cellsformat: 'f2'},    
                                {text: 'Цена за единицу', columngroup: 'group1', datafield: 'price_high', width: 120, cellsformat: 'f2'},    
                                {text: 'Стоимость', columngroup: 'group1', datafield: 'sum_price_high', width: 120, cellsformat: 'f2',
                                    aggregates: [
                                        { 'Сумма':
                                            function (aggregatedValue, currentValue) {
                                                return aggregatedValue + currentValue;
                                            }
                                        }
                                    ]
                                },
                                {text: 'Цена за единицу', columngroup: 'group2', datafield: 'price_low', width: 120, cellsformat: 'f2'},    
                                {text: 'Стоимость', columngroup: 'group2', datafield: 'sum_price_low', width: 120, cellsformat: 'f2',
                                    aggregates: [
                                        { 'Сумма':
                                            function (aggregatedValue, currentValue) {
                                                return aggregatedValue + currentValue;
                                            }
                                        }
                                    ]
                                },    
                            ],
                            columngroups: [
                                { text: 'Оборудование', align: 'center', name: 'group1' },
                                { text: 'Себестоимость', align: 'center', name: 'group2' },
                            ]
                    }));
                    
                    
                    $('#ls-btn-add-costcalcequips').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $("#ls-btn-edit-costcalcequips").jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $('#ls-btn-del-costcalcequips').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $('#ls-btn-refresh-costcalcequips').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    
                    ls.costcalcequips.refresh(true);
                    
                    $('#ls-btn-add-costcalcequips').on('click', function() {
                        if ($('#ls-btn-add-costcalcequips').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('costcalcequips', 'create', {params: {calc_id: ls.costcalculations.row.calc_id}}, 'POST', false, {width: '600px', height: '320px'});
                    });
                    
                    $('#ls-btn-edit-costcalcequips').on('click', function() {
                        if ($('#ls-btn-add-costcalcequips').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('costcalcequips', 'update', {cceq_id: ls.costcalcequips.row.cceq_id}, 'POST', false, {width: '600px', height: '320px'});
                    });
                    
                    $('#ls-btn-refresh-costcalcequips').on('click', function() {
                        ls.costcalcequips.refresh(false);
                    });
                    
                    $('#ls-btn-del-costcalcequips').on('click', function() {
                        ls.delete('costcalcequips', 'delete', {cceq_id: ls.costcalcequips.row.cceq_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.costcalcequips.rowindex--;
                                ls.costcalcequips.refresh(false);
                            }
                            else
                                ls.showerrormassage('Ошибка!', Res.responseText);
                        }, 'POST', true)
                    });
                    break;
                case 1:
                    
                    
                    $("#ls-costcalcworks-grid").on('bindingcomplete', function(event) {
                        var idx  = ls.costcalcworks.rowindex;
                        
                        if (ls.costcalcworks.rowid != undefined) {
                            idx = $("#ls-costcalcworks-grid").jqxGrid('getrowboundindexbyid', ls.costcalcworks.rowid);
                            ls.costcalcworks.rowid = undefined;
                        }
                        
                        var rows = $("#ls-costcalcworks-grid").jqxGrid('getrows');
                        
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        
                        $("#ls-costcalcworks-grid").jqxGrid('selectrow', idx);
                        $("#ls-costcalcworks-grid").jqxGrid('ensurerowvisible', idx);

                        ls.costcalcworks.checkbutton();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-costcalcworks-grid").on('rowselect', function (event) {
                        var args = event.args;
                        ls.costcalcworks.rowindex = args.rowindex;
                        ls.costcalcworks.row = args.row;
                        ls.costcalcworks.checkbutton();
                    });
                    
                    $('#ls-btn-add-costcalcworks').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $("#ls-btn-edit-costcalcworks").jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $('#ls-btn-del-costcalcworks').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    $('#ls-btn-refresh-costcalcworks').jqxButton($.extend(true, {}, ls.settings['button'], {width: 120, height: 30}));
                    
                    $("#ls-costcalcworks-grid").jqxGrid(
                        $.extend(true, {}, ls.settings['grid'], {
                            pageable: false,
                            showstatusbar: true,
                            showaggregates: true,
                            columns: [
                                {text: 'Наименование работ', columngroup: 'group1', datafield: 'worknamefull', width: 240},
                                {text: 'Оборудование', columngroup: 'group1', datafield: 'equipname', width: 140},    
                                {text: 'Ед. изм.', columngroup: 'group1', datafield: 'unit_name', width: 80},
                                {text: 'Кол-во', columngroup: 'group1', datafield: 'quant', width: 80, cellsformat: 'f2'},    
                                {text: 'Цена за единицу', columngroup: 'group1', datafield: 'price_high', width: 120, cellsformat: 'f2'},    
                                {text: 'Стоимость', columngroup: 'group1', datafield: 'sum_price_high', width: 120, cellsformat: 'f2',
                                    aggregates: [
                                        { 'Сумма':
                                            function (aggregatedValue, currentValue) {
                                                return aggregatedValue + currentValue;
                                            }
                                        }
                                    ]
                                },
                                {text: 'Цена за единицу', columngroup: 'group2', datafield: 'price_low', width: 120, cellsformat: 'f2'},    
                                {text: 'Итого', columngroup: 'group2', datafield: 'sum_price_low', width: 120, cellsformat: 'f2',
                                    aggregates: [
                                        { 'Сумма':
                                            function (aggregatedValue, currentValue) {
                                                return aggregatedValue + currentValue;
                                            }
                                        }
                                    ]
                                },    
                            ],
                            columngroups: [
                                { text: 'Работы', align: 'center', name: 'group1' },
                                { text: 'Себестоимость', align: 'center', name: 'group2' },
                            ]
                    }));
                    
                    
                    
                    
                    ls.costcalcworks.refresh(true);
                    
                    $('#ls-btn-add-costcalcworks').on('click', function() {
                        if ($('#ls-btn-add-costcalcworks').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('costcalcworks', 'create', {params: {calc_id: ls.costcalculations.row.calc_id}}, 'POST', false, {width: '700px', height: '380px'});
                    });
                    
                    $('#ls-btn-edit-costcalcworks').on('click', function() {
                        if ($('#ls-btn-add-costcalcworks').jqxButton('disabled') || ls.lock_operation) return;
                        ls.opendialogforedit('costcalcworks', 'update', {ccwk_id: ls.costcalcworks.row.ccwk_id}, 'POST', false, {width: '700px', height: '380px'});
                    });
                    
                    $('#ls-btn-refresh-costcalcworks').on('click', function() {
                        ls.costcalcworks.refresh(false);
                    });
                    
                    $('#ls-btn-del-costcalcworks').on('click', function() {
                        ls.delete('costcalcworks', 'delete', {ccwk_id: ls.costcalcworks.row.ccwk_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.costcalcworks.rowindex--;
                                ls.costcalculations.refresh(true);
                                ls.costcalcworks.refresh(false);
                            }
                            else
                                ls.showerrormassage('Ошибка!', Res.responseText);
                        }, 'POST', true)
                    });
                    break;
            };
        };
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 524}));
        
        $('#ls-costcalculations-tab').on('selected', function(event) {
            var idx = event.args.item;
            settabindex(idx);
        });
        
        var idx = gettabindex();
        if (isNaN(idx))
            idx = 0;
        
        $('#ls-costcalculations-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], {selectedItem: idx, width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets}));
        
        ls.costcalculations.setvalues();
        ls.costcalculations.checkbuttons();
    });
    
</script>

<?php
    $this->pageTitle = $model->typename . ' №' . $model->calc_id;
    $this->pageName = $model->typename . ' №' . $model->calc_id;
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Объекты' => 'costcalculations',
            $model->typename . ' №' . $model->calc_id => '',
    );
?>
<div class="ls-row" style="height: 100%;">
    <div class="ls-row">
        <div class="ls-row">
            <div class="ls-row-column" style="width: 70px;">Номер:</div>
            <div class="ls-row-column"><input type="text" id="ls-costcalculations-calc" style="text-align: right" readonly="readonly"/></div>
            <div class="ls-row-column" style="width: 94px; text-align: right;">Дата рег.:</div>
            <div class="ls-row-column"><div type="text" id="ls-costcalculations-date"></div></div>

            <div class="ls-row-column">Адрес:</div>
            <div class="ls-row-column"><input type="text" id="ls-costcalculations-address" style="" readonly="readonly"/></div>
        </div>
        <div class="ls-row">
            <div class="ls-row-column">
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 70px;">Наимен.:</div>
                    <div class="ls-row-column"><input type="text" id="ls-costcalculations-name" style="" readonly="readonly"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 70px;">Клиент:</div>
                    <div class="ls-row-column"><input type="text" id="ls-costcalculations-client" readonly="readonly"/></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column" style="width: 70px;">Менеджер:</div>
                    <div class="ls-row-column"><input type="text" id="ls-costcalculations-manager" readonly="readonly"/></div>
                    <div class="ls-row-column">Номер заявки:</div>
                    <div class="ls-row-column"><input type="text" id="ls-costcalculations-demand" style="" readonly="readonly"/></div>
                </div>
            </div>
            <div class="ls-row-column" style="width: calc(100% - 480px)">
                <div>Техническое задание:</div>
                <div>
                    <textarea id="ls-costcalculations-specnote" autocomplete="off"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-costcalculations-edit" value="Изменить"/></div>
        <div class="ls-row-column"><input type="button" id="ls-costcalculations-ready" value="Готово"/></div>
        <div class="ls-row-column"><input type="button" id="ls-costcalculations-undo" value="Снять готовность"/></div>
        <div class="ls-row-column-right"><input type="button" id="ls-costcalculations-print" value="Печать"/></div>
    </div>
    <div class="ls-row" style="height: calc(100% - 286px); min-height: 200px;">
        <div id='ls-costcalculations-tab'>
            <ul>
                <li style="margin-left: 30px;">Оборудование</li>
                <li style="">Перечень работ</li>
            </ul>
            <div style="padding: 10px;">
                <div class="ls-row" style="height: calc(100% - 54px)">
                    <div class="ls-grid" id="ls-costcalcequips-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-add-costcalcequips" value="Создать" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-edit-costcalcequips" value="Изменить" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-refresh-costcalcequips" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-del-costcalcequips" value="Удалить" /></div>
                </div>
            </div>
            <div style="padding: 10px;">
                <div class="ls-row" style="height: calc(100% - 54px)">
                    <div class="ls-grid" id="ls-costcalcworks-grid"></div>
                </div>
                <div class="ls-row">
                    <div class="ls-row-column"><input type="button" id="ls-btn-add-costcalcworks" value="Создать" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-edit-costcalcworks" value="Изменить" /></div>
                    <div class="ls-row-column"><input type="button" id="ls-btn-refresh-costcalcworks" value="Обновить" /></div>
                    <div class="ls-row-column-right"><input type="button" id="ls-btn-del-costcalcworks" value="Удалить" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="ls-row" style="height: 120px;">
        <div class="ls-row-column">
            <div class="ls-row">
                <div class="ls-row-column" style="width: 200px; font-weight: bold;">Расходные материалы:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-summaterialslow"></div></div>
                <div class="ls-row-column" style="width: 105px; font-weight: bold;">Для клиента:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-summaterialshigh"></div></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column" style="width: 200px; font-weight: bold;">Трансп. расходы:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-sumexpenceslow"></div></div>
                <div class="ls-row-column" style="width: 105px; font-weight: bold;">Для клиента:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-sumexpenceshigh"></div></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column" style="width: 200px; font-weight: bold;">Пускн. работы:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-sumstartworkslow"></div></div>
                <div class="ls-row-column" style="width: 105px; font-weight: bold;">Для клиента:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-sumstartworkshigh"></div></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column" style="width: 200px; font-weight: bold;">Коэф. накрутки на ФОТ:</div>
                <div class="ls-row-column"><div id="ls-costcalculations-koef"></div></div>
                <div class="ls-row-column" style="width: 105px; height: 1px;"></div>
                <div class="ls-row-column"><input type="button" id="ls-btn-edit-details" value="Изменить" /></div>
            </div>
        </div>
        <div class="ls-row-column" style="margin-left: 60px;">
            <div class="ls-row">
                <div class="ls-row-column-right"><div id="ls-costcalculations-sumlowfull"></div></div>
                <div class="ls-row-column-right" style="font-weight: bold;">Себестоимость:</div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column-right"><div id="ls-costcalculations-sumhighfull"></div></div>
                <div class="ls-row-column-right" style="font-weight: bold;">Стоимость:</div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column-right"><div id="ls-costcalculations-discount"></div></div>
                <div class="ls-row-column-right" style="font-weight: bold;">Скидка:</div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column-right"><div id="ls-costcalculations-marj"></div></div>
                <div class="ls-row-column-right" style="font-weight: bold;">Маржа %:</div>
            </div>
        </div>
    </div>
</div>