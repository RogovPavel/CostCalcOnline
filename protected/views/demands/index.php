<script type="text/javascript">
    ls.demands = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-demands-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['demands'], {
                    filter: function () {
                        $("#ls-demands-grid").jqxGrid('updatebounddata', 'filter');
                    },
                    sort: function () {
                        $("#ls-demands-grid").jqxGrid('updatebounddata', 'sort');
                    }
                }), {loadError: ls.loaderror});
                $("#ls-demands-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-demands-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.demands.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.demands.row != undefined)})
        };
        
        $("#ls-demands-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.demands.rowindex = args.rowindex;
            ls.demands.row = args.row;
            $('#ls-demands-demandtext').val('');
            if (ls.demands.row != undefined) {
                $('#ls-demands-demandtext').val(args.row.demand_text);
            }
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.demands.refresh(false);
        });
        
        $("#ls-demands-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-demands-grid").on('bindingcomplete', function() {
            var idx  = ls.demands.rowindex;
                        
            if (ls.demands.rowid != undefined) {
                idx = $("#ls-demands-grid").jqxGrid('getrowboundindexbyid', ls.demands.rowid);
                ls.demands.rowid = undefined;
            }

            var rows = $("#ls-demands-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-demands-grid").jqxGrid('selectrow', idx);
            $("#ls-demands-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.demands.row == undefined) return;            
            ls.delete('demands', 'delete', {contact_id: ls.demands.row.demand_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.demands.rowindex--;
                    ls.demands.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            ls.wopen('demands/view', {demand_id: ls.demands.row.demand_id}, 'demands_' + ls.demands.row.demand_id);
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('demands', 'create', {}, 'POST', false, {width: '600px', height: '430px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 350}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-demands-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                virtualmode: true,
                pagesizeoptions: ['10', '200', '500', '1000'],
                filterable: true,
                pageable: true,
                sortable: true,
                pagesize: 200,
                width: 'calc(100% - 2px)',
                height: 'calc(100% - 2px)',
                columns: [
                    { text: 'Номер', datafield: 'demand_id', width: 70},    
                    { text: 'Адрес', datafield: 'address', width: 250},    
                    { text: 'Тип заявки', datafield: 'demandtype_name', width: 130},
                    { text: 'Приоритет', datafield: 'demandprior_name', width: 130},
                    { text: 'Исполнитель', datafield: 'executorname', width: 130},
                    { text: 'Предельная дата', datafield: 'deadline', columntype: 'date', filtertype: 'date', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                    { text: 'Дата вып.', datafield: 'date_exec', columntype: 'date', filtertype: 'date', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                    { text: 'Контакт', datafield: 'contact', width: 200},
                    { text: 'Клиент', datafield: 'clientname', width: 230},
                ]

        }));
        
        $("#ls-demands-demandtext").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '130px', width: 'calc(100% - 2px)'}));
        
        ls.demands.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Заявки ';
    $this->pageName = 'Заявки';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Заявки' => 'demands',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 194px)">
        <div class="ls-grid" id="ls-demands-grid"></div>
    </div>
    <div class="ls-row" style="height: 150px">
        <div>Текст заявки</div>
        <div>
            <textarea id="ls-demands-demandtext" autocomplete="off"></textarea>
        </div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

