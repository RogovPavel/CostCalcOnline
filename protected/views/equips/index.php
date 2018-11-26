<script type="text/javascript">
    ls.equips = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-equips-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['equips']), {loadError: ls.loaderror});
                $("#ls-equips-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-equips-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.equips.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.equips.row != undefined)})
        }
        
        $("#ls-equips-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.equips.rowindex = args.rowindex;
            ls.equips.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.equips.refresh(false);
        });
        
        $("#ls-equips-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-equips-grid").on('bindingcomplete', function() {
            var idx  = ls.equips.rowindex;
                        
            if (ls.equips.rowid != undefined) {
                idx = $("#ls-equips-grid").jqxGrid('getrowboundindexbyid', ls.equips.rowid);
                ls.equips.rowid = undefined;
            }

            var rows = $("#ls-equips-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-equips-grid").jqxGrid('selectrow', idx);
            $("#ls-equips-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.equips.row == undefined) return;            
            ls.delete('equips', 'delete', {equip_id: ls.equips.row.equip_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.equips.rowindex--;
                    ls.equips.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.equips.row == undefined) return;            
            ls.opendialogforedit('equips', 'update', {equip_id: ls.equips.row.equip_id}, 'POST', false, {width: '400px', height: '260px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('equips', 'create', {equip_id: ls.equips.row.equip_id}, 'POST', false, {width: '400px', height: '260px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 260}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-equips-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'equipname', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Ед. изм.', datafield: 'unit_name', filtercondition: 'CONTAINS', width: 80},
                    { text: 'Примечание', datafield: 'note', filtercondition: 'CONTAINS', width: 200},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.equips.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Оборудование';
    $this->pageName = 'Оборудование';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Оборудование' => 'equips',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-equips-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

