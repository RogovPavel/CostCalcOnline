<script type="text/javascript">
    ls.firms = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-firms-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['firms']), {loadError: ls.loaderror});
                $("#ls-firms-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-firms-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.firms.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.firms.row != undefined)})
        }
        
        $("#ls-firms-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.firms.rowindex = args.rowindex;
            ls.firms.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.firms.refresh(false);
        });
        
        $("#ls-firms-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-firms-grid").on('bindingcomplete', function() {
            var idx  = ls.firms.rowindex;
                        
            if (ls.firms.rowid != undefined) {
                idx = $("#ls-firms-grid").jqxGrid('getrowboundindexbyid', ls.firms.rowid);
                ls.firms.rowid = undefined;
            }

            var rows = $("#ls-firms-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-firms-grid").jqxGrid('selectrow', idx);
            $("#ls-firms-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.firms.row == undefined) return;            
            ls.delete('firms', 'delete', {firm_id: ls.firms.row.firm_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.firms.rowindex--;
                    ls.firms.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('firms', 'update', {firm_id: ls.firms.row.firm_id}, 'POST', false, {width: '400px', height: '404px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('firms', 'create', {}, 'POST', false, {width: '400px', height: '404px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 404}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-firms-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'firmname', filtercondition: 'CONTAINS', width: 150},
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
        
        ls.firms.refresh(true);
    });
</script>

<?php
    $this->pageTitle='Мои организации';
    $this->pageName = 'Мои организации';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Мои организации' => 'firms',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-firms-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

