<script type="text/javascript">
    ls.streettypes = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-streettypes-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['streettypes']), {loadError: ls.loaderror});
                $("#ls-streettypes-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-streettypes-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.streettypes.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.streettypes.row != undefined)})
        }
        
        $("#ls-streettypes-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.streettypes.rowindex = args.rowindex;
            ls.streettypes.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.streettypes.refresh(false);
        });
        
        $("#ls-streettypes-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-streettypes-grid").on('bindingcomplete', function() {
            var idx  = ls.streettypes.rowindex;
                        
            if (ls.streettypes.rowid != undefined) {
                idx = $("#ls-streettypes-grid").jqxGrid('getrowboundindexbyid', ls.streettypes.rowid);
                ls.streettypes.rowid = undefined;
            }

            var rows = $("#ls-streettypes-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-streettypes-grid").jqxGrid('selectrow', idx);
            $("#ls-streettypes-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.streettypes.row == undefined) return;            
            ls.delete('streettypes', 'delete', {streettype_id: ls.streettypes.row.streettype_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.streettypes.rowindex--;
                    ls.streettypes.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.streettypes.row == undefined) return;            
            ls.opendialogforedit('streettypes', 'update', {streettype_id: ls.streettypes.row.streettype_id}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('streettypes', 'create', {}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-streettypes-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'streettype_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.streettypes.refresh(true);
    });
</script>

<?php
    $this->pageTitle = 'Типы улиц';
    $this->pageName = 'Справочник типов улиц';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Типы улиц' => 'streettypes',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-streettypes-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

