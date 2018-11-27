<script type="text/javascript">
    ls.regions = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-regions-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['regions']), {loadError: ls.loaderror});
                $("#ls-regions-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-regions-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.regions.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.regions.row != undefined)})
        }
        
        $("#ls-regions-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.regions.rowindex = args.rowindex;
            ls.regions.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.regions.refresh(false);
        });
        
        $("#ls-regions-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-regions-grid").on('bindingcomplete', function() {
            var idx  = ls.regions.rowindex;
                        
            if (ls.regions.rowid != undefined) {
                idx = $("#ls-regions-grid").jqxGrid('getrowboundindexbyid', ls.regions.rowid);
                ls.regions.rowid = undefined;
            }

            var rows = $("#ls-regions-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-regions-grid").jqxGrid('selectrow', idx);
            $("#ls-regions-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.regions.row == undefined) return;            
            ls.delete('regions', 'delete', {region_id: ls.regions.row.region_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.regions.rowindex--;
                    ls.regions.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.regions.row == undefined) return;            
            ls.opendialogforedit('regions', 'update', {region_id: ls.regions.row.region_id}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('regions', 'create', {}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-regions-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'region_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.regions.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Регионы';
    $this->pageName = 'Справочник регионов';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Регионы' => 'regions',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-regions-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

