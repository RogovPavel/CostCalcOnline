<script type="text/javascript">
    ls.demandpriors = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-demandpriors-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['demandpriors']), {loadError: ls.loaderror});
                $("#ls-demandpriors-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-demandpriors-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.demandpriors.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.demandpriors.row != undefined)})
        }
        
        $("#ls-demandpriors-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.demandpriors.rowindex = args.rowindex;
            ls.demandpriors.row = args.row;
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.demandpriors.refresh(false);
        });
        
        $("#ls-demandpriors-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-demandpriors-grid").on('bindingcomplete', function() {
            var idx  = ls.demandpriors.rowindex;
                        
            if (ls.demandpriors.rowid != undefined) {
                idx = $("#ls-demandpriors-grid").jqxGrid('getrowboundindexbyid', ls.demandpriors.rowid);
                ls.demandpriors.rowid = undefined;
            }

            var rows = $("#ls-demandpriors-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-demandpriors-grid").jqxGrid('selectrow', idx);
            $("#ls-demandpriors-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.demandpriors.row == undefined) return;            
            if (ls.demandpriors.row == undefined) return;            
            ls.delete('demandpriors', 'delete', {demandprior_id: ls.demandpriors.row.demandprior_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.demandpriors.rowindex--;
                    ls.demandpriors.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.demandpriors.row == undefined) return;            
            ls.opendialogforedit('demandpriors', 'update', {demandprior_id: ls.demandpriors.row.demandprior_id}, 'POST', false, {width: '400px', height: '224px'});
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('demandpriors', 'create', {}, 'POST', false, {width: '400px', height: '224px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 224}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-demandpriors-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                columns: [
                    { text: 'Наименование', datafield: 'demandprior_name', width: 150},    
                    { text: 'Время на выполнение', datafield: 'time_exec', width: 150, cellsformat: 'n'},
                    { text: 'Учитывать рабочее время', datafield: 'worktime', columntype: 'checkbox', width: 200},    
                    { text: 'Учитывать выходные', datafield: 'weekend', columntype: 'checkbox', width: 200},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        ls.demandpriors.refresh(true);
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Приоритеты заявок';
    $this->pageName = 'Справочник приоритетов';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Приоритеты заявок' => 'demandpriors',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-demandpriors-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

