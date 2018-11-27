<script type="text/javascript">
    ls.streets = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-streets-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['streets']), {loadError: ls.loaderror});
                $("#ls-streets-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-streets-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.streets.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.streets.row != undefined)})
        }
        
        $("#ls-streets-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.streets.rowindex = args.rowindex;
            ls.streets.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.streets.refresh(false);
        });
        
        $("#ls-streets-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-streets-grid").on('bindingcomplete', function() {
            var idx  = ls.streets.rowindex;
                        
            if (ls.streets.rowid != undefined) {
                idx = $("#ls-streets-grid").jqxGrid('getrowboundindexbyid', ls.streets.rowid);
                ls.streets.rowid = undefined;
            }

            var rows = $("#ls-streets-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-streets-grid").jqxGrid('selectrow', idx);
            $("#ls-streets-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.streets.row == undefined) return;            
            ls.delete('streets', 'delete', {street_id: ls.streets.row.street_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.streets.rowindex--;
                    ls.streets.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.streets.row == undefined) return;            
            ls.opendialogforedit('streets', 'update', {street_id: ls.streets.row.street_id}, 'POST', false, {width: '400px', height: '194px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('streets', 'create', {}, 'POST', false, {width: '400px', height: '194px'});
            
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 194}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-streets-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'streetname', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Тип', datafield: 'streettype_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Регион', datafield: 'region_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.streets.refresh(true);
    });
</script>

<?php
    $this->pageTitle= 'Регионы';
    $this->pageName = 'Справочник регионов';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Регионы' => 'streets',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-streets-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

