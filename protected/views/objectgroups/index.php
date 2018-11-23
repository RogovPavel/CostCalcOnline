<script type="text/javascript">
    ls.objectgroups = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-objectgroups-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objectgroups']), {loadError: ls.loaderror});
                $("#ls-objectgroups-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-objectgroups-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.objectgroups.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.objectgroups.row != undefined)})
        };
        
        $("#ls-objectgroups-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.objectgroups.rowindex = args.rowindex;
            ls.objectgroups.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.objectgroups.refresh(false);
        });
        
        $("#ls-objectgroups-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-objectgroups-grid").on('bindingcomplete', function() {
            var idx  = ls.objectgroups.rowindex;
                        
            if (ls.objectgroups.rowid != undefined) {
                idx = $("#ls-objectgroups-grid").jqxGrid('getrowboundindexbyid', ls.objectgroups.rowid);
                ls.objectgroups.rowid = undefined;
            }

            var rows = $("#ls-objectgroups-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-objectgroups-grid").jqxGrid('selectrow', idx);
            $("#ls-objectgroups-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.objectgroups.row == undefined) return;            
            ls.delete('objectgroups', 'delete', {contact_id: ls.objectgroups.row.objectgr_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.objectgroups.rowindex--;
                    ls.objectgroups.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            ls.wopen('objectgroups/view', {objectgr_id: ls.objectgroups.row.objectgr_id}, 'objectgroups_' + ls.objectgroups.row.objectgr_id);
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('objectgroups', 'create', {}, 'POST', false, {width: '600px', height: '300px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 300}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-objectgroups-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Адрес', datafield: 'address', width: 250},    
                    { text: 'Клиент', datafield: 'clientname', width: 230},
                ]

        }));
        
        ls.objectgroups.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Объекты ';
    $this->pageName = 'Объекты';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Объекты' => 'objectgroups',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-objectgroups-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

