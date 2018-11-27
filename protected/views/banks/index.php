<script type="text/javascript">
    ls.banks = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-banks-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['banks']), {loadError: ls.loaderror});
                $("#ls-banks-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-banks-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.banks.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.banks.row != undefined)})
        }
        
        $("#ls-banks-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.banks.rowindex = args.rowindex;
            ls.banks.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.banks.refresh(false);
        });
        
        $("#ls-banks-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-banks-grid").on('bindingcomplete', function() {
            var idx  = ls.banks.rowindex;
                        
            if (ls.banks.rowid != undefined) {
                idx = $("#ls-banks-grid").jqxGrid('getrowboundindexbyid', ls.banks.rowid);
                ls.banks.rowid = undefined;
            }

            var rows = $("#ls-banks-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-banks-grid").jqxGrid('selectrow', idx);
            $("#ls-banks-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.banks.row == undefined) return;            
            ls.delete('banks', 'delete', {bank_id: ls.banks.row.bank_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.banks.rowindex--;
                    ls.banks.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('banks', 'update', {bank_id: ls.banks.row.bank_id}, 'POST', false, {width: '400px', height: '254px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('banks', 'create', {}, 'POST', false, {width: '400px', height: '254px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 254}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-banks-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'bankname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Город', datafield: 'city', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Рас./Счет', datafield: 'account', filtercondition: 'CONTAINS', width: 150},
                    { text: 'БИК', datafield: 'bik', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Дата создания', columntype: 'date', datafield: 'date_create', width: 130, cellsformat: 'dd.MM.yyyy'},
                    { text: 'Дата изменения', columntype: 'date', datafield: 'date_change', width: 130, cellsformat: 'dd.MM.yyyy'},
                ]

        }));
        
        ls.banks.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Банки';
    $this->pageName = 'Банки';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Банки' => 'banks',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-banks-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

