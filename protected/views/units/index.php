<script type="text/javascript">
    ls.units = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-units-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['units']), {loadError: ls.loaderror});
                $("#ls-units-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-units-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.units.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.units.row != undefined)})
        }
        
        $("#ls-units-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.units.rowindex = args.rowindex;
            ls.units.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.units.refresh(false);
        });
        
        $("#ls-units-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-units-grid").on('bindingcomplete', function() {
            var idx  = ls.units.rowindex;
                        
            if (ls.units.rowid != undefined) {
                idx = $("#ls-units-grid").jqxGrid('getrowboundindexbyid', ls.units.rowid);
                ls.units.rowid = undefined;
            }

            var rows = $("#ls-units-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-units-grid").jqxGrid('selectrow', idx);
            $("#ls-units-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.units.row == undefined) return;            
            if (ls.units.row == undefined) return;            
            ls.delete('units', 'delete', {unit_id: ls.units.row.unit_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.units.rowindex--;
                    ls.units.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.units.row == undefined) return;            
            ls.opendialogforedit('units', 'update', {unit_id: ls.units.row.unit_id}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('units', 'create', {}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-units-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Ед. изм.', datafield: 'unit_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.units.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Ед. измерения';
    $this->pageName = 'Справочник ед. измерения';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Ед. измерения' => 'units',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-units-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

