<script type="text/javascript">
    ls.clients = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-clients-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['clients']), {loadError: ls.loaderror});
                $("#ls-clients-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-clients-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.clients.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.clients.row != undefined)})
        }
        
        $("#ls-clients-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.clients.rowindex = args.rowindex;
            ls.clients.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.clients.refresh(false);
        });
        
        $("#ls-clients-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-clients-grid").on('bindingcomplete', function() {
            var idx  = ls.clients.rowindex;
                        
            if (ls.clients.rowid != undefined) {
                idx = $("#ls-clients-grid").jqxGrid('getrowboundindexbyid', ls.clients.rowid);
                ls.clients.rowid = undefined;
            }

            var rows = $("#ls-clients-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-clients-grid").jqxGrid('selectrow', idx);
            $("#ls-clients-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.clients.row == undefined) return;            
            ls.delete('clients', 'delete', {client_id: ls.clients.row.client_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.clients.rowindex--;
                    ls.clients.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('clients', 'update', {client_id: ls.clients.row.client_id}, 'POST', false, {width: '400px', height: '404px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('clients', 'create', {}, 'POST', false, {width: '400px', height: '404px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 404}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-clients-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'clientname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ИНН', datafield: 'inn', filtercondition: 'CONTAINS', width: 150},
                    { text: 'КПП', datafield: 'kpp', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Рас./Счет', datafield: 'account', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ОГРН', datafield: 'ogrn', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ОКПО', datafield: 'okpo', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Банк', datafield: 'bankname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Юр. адрес', datafield: 'jur_address', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Факт. адрес', datafield: 'fact_address', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Дата создания', columntype: 'date', datafield: 'date_create', width: 130, cellsformat: 'dd.MM.yyyy'},
                    { text: 'Дата изменения', columntype: 'date', datafield: 'date_change', width: 130, cellsformat: 'dd.MM.yyyy'},
                ]

        }));
        
        ls.clients.refresh(true);        
    });
</script>

<?php
    $this->pageTitle='Клиенты';
    $this->pageName = 'Клиенты';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Клиенты' => 'clients',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-clients-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

