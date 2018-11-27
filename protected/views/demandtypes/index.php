<script type="text/javascript">
    ls.demandtypes = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-demandtypes-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['demandtypes']), {loadError: ls.loaderror});
                $("#ls-demandtypes-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-demandtypes-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.demandtypes.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.demandtypes.row != undefined)})
        }
        
        $("#ls-demandtypes-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.demandtypes.rowindex = args.rowindex;
            ls.demandtypes.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.demandtypes.refresh(false);
        });
        
        $("#ls-demandtypes-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-demandtypes-grid").on('bindingcomplete', function() {
            var idx  = ls.demandtypes.rowindex;
                        
            if (ls.demandtypes.rowid != undefined) {
                idx = $("#ls-demandtypes-grid").jqxGrid('getrowboundindexbyid', ls.demandtypes.rowid);
                ls.demandtypes.rowid = undefined;
            }

            var rows = $("#ls-demandtypes-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-demandtypes-grid").jqxGrid('selectrow', idx);
            $("#ls-demandtypes-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.demandtypes.row == undefined) return;            
            ls.delete('demandtypes', 'delete', {demandprior_id: ls.demandtypes.row.demandtype_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.demandtypes.rowindex--;
                    ls.demandtypes.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.demandtypes.row == undefined) return;            
            ls.opendialogforedit('demandtypes', 'update', {demandtype_id: ls.demandtypes.row.demandtype_id}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('demandtypes', 'create', {}, 'POST', false, {width: '400px', height: '124px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-demandtypes-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'demandtype_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.demandtypes.refresh(true);        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Типы заявок';
    $this->pageName = 'Справочник типов заявок';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Типы заявок' => 'demandtypes',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-demandtypes-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

