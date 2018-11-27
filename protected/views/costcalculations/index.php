<script type="text/javascript">
    ls.costcalculations = {
        rowid: undefined,
        row: undefined,
        rowindex: undefined,
        refresh: function(reset) {
            if (reset == undefined)
                reset = false;
            if (!$("#ls-costcalculations-grid").jqxGrid('isBindingCompleted'))
                return;
            if (reset) {
                var adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['costcalculations'], {
                    filter: function () {
                        $("#ls-costcalculations-grid").jqxGrid('updatebounddata', 'filter');
                    },
                    sort: function () {
                        $("#ls-costcalculations-grid").jqxGrid('updatebounddata', 'sort');
                    }
                }), {loadError: ls.loaderror});
                $("#ls-costcalculations-grid").jqxGrid({source: adapter});
            }
            else
                $("#ls-costcalculations-grid").jqxGrid('updatebounddata');
        }
    };
    
    $(document).ready(function() {
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(ls.costcalculations.row != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(ls.costcalculations.row != undefined)})
        };
        
        $("#ls-costcalculations-grid").on('rowselect', function (event) {
            var args = event.args;
            ls.costcalculations.rowindex = args.rowindex;
            ls.costcalculations.row = args.row;
            $('#ls-costcalculations-demandtext').val('');
            if (ls.costcalculations.row != undefined) {
                $('#ls-costcalculations-demandtext').val(args.row.demand_text);
            }
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            ls.costcalculations.refresh(false);
        });
        
        $("#ls-costcalculations-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-costcalculations-grid").on('bindingcomplete', function() {
            var idx  = ls.costcalculations.rowindex;
                        
            if (ls.costcalculations.rowid != undefined) {
                idx = $("#ls-costcalculations-grid").jqxGrid('getrowboundindexbyid', ls.costcalculations.rowid);
                ls.costcalculations.rowid = undefined;
            }

            var rows = $("#ls-costcalculations-grid").jqxGrid('getrows');

            if (idx == undefined || idx >= rows.length) 
                idx = 0;

            $("#ls-costcalculations-grid").jqxGrid('selectrow', idx);
            $("#ls-costcalculations-grid").jqxGrid('ensurerowvisible', idx);

            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (ls.costcalculations.row == undefined) return;            
            ls.delete('costcalculations', 'delete', {contact_id: ls.costcalculations.row.calc_id}, function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.costcalculations.rowindex--;
                    ls.costcalculations.refresh(false);
                }
                else {
                    ls.showerrormassage('Ошибка! ' + Res.responseText);
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            ls.wopen('costcalculations/view', {calc_id: ls.costcalculations.row.calc_id}, 'costcalculations_' + ls.costcalculations.row.calc_id);
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            ls.opendialogforedit('costcalculations', 'create', {params: {objectgr_id: 22}}, 'POST', false, {width: '600px', height: '558px'});
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 350}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-costcalculations-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                virtualmode: true,
                pagesizeoptions: ['10', '200', '500', '1000'],
                filterable: true,
                pageable: true,
                sortable: true,
                pagesize: 200,
                columns: [
                    { text: 'Номер', datafield: 'calc_id', width: 70},    
                    { text: 'Тип', datafield: 'typename', width: 130},
                    { text: 'Адрес', datafield: 'address', width: 250},    
                ]

        }));
        
        ls.costcalculations.refresh(true);
    });
</script>

<?php
    $this->pageTitle = 'Сметы';
    $this->pageName = 'Сметы';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Сметы' => 'costcalculations',
    );
?>
<div style="height: 100%">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-costcalculations-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

