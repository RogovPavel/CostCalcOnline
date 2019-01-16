<script type="text/javascript">
    ls.demands = {
        rowid: undefined,
        row: <?php echo json_encode($model); ?>,
        refresh: function(reset) {
            if (reset == undefined)
                reset = true;
            
            if (reset) {
                $.ajax({
                    url: '/demands/getdata/' + ls.demands.row.demand_id,
                    success: function(Res) {
                        ls.demands.row = JSON.parse(Res);
                        ls.demands.setvalues();
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
            $("#ls-demands-demand").jqxInput('val', ls.demands.row.demand_id);
            $("#ls-demands-address").jqxInput('val', ls.demands.row.address);
            $("#ls-demands-demandtype").jqxInput('val', ls.demands.row.demandtype_name);
            $("#ls-demands-demandprior").jqxInput('val', ls.demands.row.demandprior_name);
            $("#ls-demands-deadline").jqxDateTimeInput('val', ls.dateconverttosjs(ls.demands.row.deadline));
            $("#ls-demands-datereg").jqxDateTimeInput('val', ls.dateconverttosjs(ls.demands.row.date_reg));
            $("#ls-demands-client").jqxInput('val', ls.demands.row.clientname);
            $("#ls-demands-contact").jqxInput('val', ls.demands.row.contact);
            $("#ls-demands-executorname").jqxInput('val', ls.demands.row.executorname);
            
            $("#ls-demands-dateexec").jqxDateTimeInput('val', ls.dateconverttosjs(ls.demands.row.date_exec));
            $("#ls-demands-demandtext").jqxTextArea('val', ls.demands.row.demand_text);
        }
    };
    ls.demandcomments = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-demandcomments-grid").jqxDataTable('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['demandcomments']), {
                    loadError: ls.loaderror,
                    formatData: function (data) {
                        var fltrs = [];
                        if (ls.demands.row.demand_id != null && ls.demands.row.demand_id != undefined)
                            fltrs.push({field: 'dc.demand_id', operand: 1, value: ls.demands.row.demand_id});
                        else
                            fltrs.push({field: 'dc.demand_id', operand: 1, value: -1});
                        $.extend(data, {filters: fltrs});
                        return data;
                    },
                });
                $("#ls-demandcomments-grid").jqxDataTable({source: adapter});
            }
            else
                $("#ls-demandcomments-grid").jqxDataTable('updateBoundData');
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
        
        $("#ls-demands-demand").jqxInput($.extend(true, {}, ls.settings['input'], {width: '100px', height: 25, disabled: false}));
        $("#ls-demands-address").jqxInput($.extend(true, {}, ls.settings['input'], {width: '350px', height: 25, disabled: false}));
        $("#ls-demands-demandtype").jqxInput($.extend(true, {}, ls.settings['input'], {width: '200px', height: 25, disabled: false}));
        $("#ls-demands-demandprior").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25, disabled: false}));
        $("#ls-demands-deadline").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy', readonly: true, showTimeButton: false, showCalendarButton: false}));
        $("#ls-demands-datereg").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm', readonly: true, showTimeButton: false, showCalendarButton: false}));
        $("#ls-demands-client").jqxInput($.extend(true, {}, ls.settings['input'], {width: '358px', height: 25, disabled: false}));
        $("#ls-demands-contact").jqxInput($.extend(true, {}, ls.settings['input'], {width: '358px', height: 25, disabled: false}));
        $("#ls-demands-dateexec").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm', readonly: true, showTimeButton: false, showCalendarButton: false}));
        $("#ls-demands-demandtext").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-demands-edit").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '100px', height: 30}));
        $("#ls-demands-send").jqxButton($.extend(true, {}, ls.settings['button'], {theme: ls.defaults.theme, width: '300px', height: 30}));
        
        $("#ls-demands-executorname").jqxInput($.extend(true, {}, ls.settings['input'], {width: '150px', height: 25, disabled: false}));
        
        $("#ls-demands-send").on('click', function() {
            var sources = {
                demands: ls.demands.row,
                demandcommnets: $('#ls-demandcomments-grid').jqxGrid('getRows'),
            };
            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('demands/send')); ?>,
                type: 'POST',
                data: {
                    user_id: ls.demands.row.user_id,
                    sources: JSON.stringify(sources)
                },
                success: function(Res) {
                    Res = JSON.parse(Res);
                    
                    if (Res.state == 0)
                        ls.showerrormassage('Успешно', 'Письмо отправлено успешно.');
                }
            });
        });
        
        $('#ls-demands-edit').on('click', function() {
            if ($('#ls-demands-edit').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('demands', 'update', {demand_id: ls.demands.row.demand_id}, 'POST', false, {width: '600px', height: '470px'});
        });
        
        var initWidgets = function(tab) {
            switch(tab) {
                case 0: 
                    var checkbuttoncomments = function() {
                        $('#ls-btn-add-message').jqxButton({disabled: !(ls.demands.row != undefined)})
                    };
                    
                    $("#ls-demandcomments-grid").on('bindingComplete', function(event) {
                        var idx  = ls.demandcomments.rowindex;
                        
                        if (ls.demandcomments.rowid != undefined) {
                            idx = $("#ls-demandcomments-grid").jqxDataTable('getrowboundindexbyid', ls.demandcomments.rowid);
                            ls.demandcomments.rowid = undefined;
                        }
                        
                        var rows = $("#ls-demandcomments-grid").jqxDataTable('getRows');
                        
                        if (idx == undefined || idx >= rows.length) 
                            idx = 0;
                        
                        $("#ls-demandcomments-grid").jqxDataTable('selectRow', idx);
                        $("#ls-demandcomments-grid").jqxDataTable('ensureRowVisible', idx);

                        checkbuttoncomments();
                        ls.lock_operation = false;
                    });
                    
                    $("#ls-demandcomments-grid").on('rowSelect', function (event) {
                        var args = event.args;
                        ls.demandcomments.rowindex = args.rowindex;
                        ls.demandcomments.row = args.row;
                        checkbuttoncomments();
                    });
                    
                    $("#ls-demandcomments-grid").jqxDataTable(
                        $.extend(true, {}, ls.settings['datatable'], {
                            columns: [
                                {text: 'Дата сообщения', datafield: 'date', width: 180, cellsformat: 'dd.MM.yyyy HH:mm ddd'},    
                                {text: 'Создал', datafield: 'shortname', width: 150},
                                {text: 'Текст', datafield: 'text', width: 500},
                            ],
                    }));
                    
                    $("#ls-demands-message").jqxInput($.extend(true, {}, ls.settings['input'], {width: 'calc(100% - 2px)', height: 25, disabled: false}));
                    $('#ls-btn-add-message').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    $('#ls-btn-del-message').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
                    
                    $('#ls-demands-message').on('keydown', function(e) {
                        var keyCode = e.keyCode || e.which;
                        if (keyCode === 13)
                            $("#ls-btn-add-message").click();
                        return true;
                    });
                    
                    
                    ls.demandcomments.refresh(true);
                    
                    $('#ls-btn-add-message').on('click', function() {
                        ls.save('demandcomments', 'create', {demandcomments: {demand_id: ls.demands.row.demand_id, text: $("#ls-demands-message").val()}}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0) {
                                ls.demandcomments.refresh(false);
                                $("#ls-demands-message").val('');
                                $("#ls-demands-message").focus();
                            }
                            else
                                ls.showerrormassage('Ошибка!', Res.responseText);
                        }, 'POST', true)
                    });
                    
                    $('#ls-btn-del-message').on('click', function() {
                        ls.delete('demandcomments', 'delete', {comment_id: ls.demandcomments.row.comment_id}, function(Res) {
                            Res = JSON.parse(Res);
                            if (Res.state == 0)
                                ls.demandcomments.refresh(false);
                            else
                                ls.showerrormassage('Ошибка!', Res.responseText);
                        }, 'POST', true)
                    });
                    
                    break;
            };
        };
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 400}));
        
        $('#ls-demands-tab').jqxTabs($.extend(true, {}, ls.settings['tab'], { width: 'calc(100% - 2px)', height: 'calc(100% - 2px)', position: 'top', initTabContent: initWidgets}));
        
        ls.demands.setvalues();
    });
    
</script>

<?php
    $this->pageTitle = 'Заявка №' . $model->demand_id;
    $this->pageName = 'Карточка заявки №' . $model->demand_id;
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Объекты' => 'demands',
            'Заявка №' . $model->demand_id => '',
    );
?>

<div class="ls-row">
    <div class="ls-row">
        <div class="ls-row-column" style="width: 70px;">Номер:</div>
        <div class="ls-row-column"><input type="text" id="ls-demands-demand" style="text-align: right" readonly="readonly"/></div>
        <div class="ls-row-column">Адрес:</div>
        <div class="ls-row-column"><input type="text" id="ls-demands-address" style="" readonly="readonly"/></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column" style="width: 70px; height: 1px"></div>
        <div class="ls-row-column">
            <div>Дата рег.:</div>
            <div><div type="text" id="ls-demands-datereg"></div></div>
        </div>
        <div class="ls-row-column">
            <div>Тип заявки:</div>
            <div><input type="text" id="ls-demands-demandtype" readonly="readonly"/></div>
        </div>
        <div class="ls-row-column">
            <div>Приоритет:</div>
            <div><input type="text" id="ls-demands-demandprior" readonly="readonly"/></div>
        </div>
        <div class="ls-row-column">
            <div>Предельная дата:</div>
            <div><div type="text" id="ls-demands-deadline"></div></div>
        </div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column" style="width: 70px;">Клиент:</div>
        <div class="ls-row-column"><input type="text" id="ls-demands-client" readonly="readonly"/></div>
        <div class="ls-row-column" style="width: 158px; text-align: right; font-weight: bold;">Дата выполнения:</div>
        <div class="ls-row-column"><div type="text" id="ls-demands-dateexec"></div></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column" style="width: 70px;">Контакт:</div>
        <div class="ls-row-column"><input type="text" id="ls-demands-contact" readonly="readonly"/></div>
        <div class="ls-row-column" style="width: 158px; text-align: right; font-weight: bold;">Исполнитель:</div>
        <div class="ls-row-column"><input type="text" id="ls-demands-executorname" readonly="readonly"/></div>
    </div>
    <div class="ls-row">
        <div>Текст заявки:</div>
        <div>
            <textarea id="ls-demands-demandtext" autocomplete="off"></textarea>
        </div>
    </div>
</div>
<div class="ls-row">
    <div class="ls-row-column"><input type="button" id="ls-demands-edit" value="Изменить"/></div>
    <div class="ls-row-column"><input type="button" id="ls-demands-send" value="Отправить на почту исполнителю"/></div>
</div>
<div class="ls-row" style="height: calc(100% - 266px)">
    <div id='ls-demands-tab'>
        <ul>
            <li style="margin-left: 30px;">Ход работы</li>
            <li style="">Документы</li>
        </ul>
        <div style="padding: 10px;">
            <div class="ls-row" style="height: calc(100% - 64px)">
                <div class="ls-grid" id="ls-demandcomments-grid"></div>
            </div>
            <div class="ls-row">
                <div class="ls-row-column" style="width: calc(100% - 260px)"><input type="text" id="ls-demands-message"/></div>
                <div class="ls-row-column-right"><input type="button" id="ls-btn-del-message" value="Удалить" /></div>
                <div class="ls-row-column-right"><input type="button" id="ls-btn-add-message" value="Написать" /></div>
            </div>
        </div>
        <div style="padding: 10px;">
            
        </div>
    </div>
</div>
