<script type="text/javascript">
    ls.clientpositions = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-clientpositions-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['clientpositions']), {loadError: ls.loaderror});
                $("#ls-clientpositions-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-clientpositions-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.clientpositions.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.clientpositions.row != undefined)})
        }
        
        $("#ls-clientpositions-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.clientpositions.rowindex = args.rowindex;
            ls.clientpositions.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.clientpositions.refresh(false);
        });
        
        $("#ls-clientpositions-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-clientpositions-grid").on('bindingcomplete', function() {
            var idx  = ls.clientpositions.rowindex;
                        
            if (ls.clientpositions.rowid != undefined) {
                idx = $("#ls-clientpositions-grid").jqxGrid('getrowboundindexbyid', ls.clientpositions.rowid);
                ls.clientpositions.rowid = undefined;
            }

            var rows = $("#ls-clientpositions-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-clientpositions-grid").jqxGrid('selectrow', idx);
            $("#ls-clientpositions-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.clientpositions.row == undefined) return;            
            ls.delete('clientpositions', 'delete', {position_id: ls.clientpositions.row.position_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.clientpositions.rowindex--;
                    ls.clientpositions.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.clientpositions.row == undefined) return;            
            ls.opendialogforedit('clientpositions', 'update', {position_id: ls.clientpositions.row.position_id}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('clientpositions', 'create', {}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-clientpositions-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'positionname', filtercondition: 'CONTAINS', width: 250},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.clientpositions.refresh(true);
    });
</script>

<?php
    $this->pageTitle = 'Должности';
    $this->pageName = 'Справочник должностей';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Должности' => 'clientpositions',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-clientpositions-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

