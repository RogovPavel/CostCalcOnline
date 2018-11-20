<script type="text/javascript">
    ls.equips = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_equips;
        
        var equips_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['equips']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_equips != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_equips != undefined)})
        }
        
        $("#ls-equips-grid").on('rowselect', function (event) {
            currentrow_equips = $('#ls-equips-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-equips-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-equips-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-equips-grid").on('bindingcomplete', function() {
            var idx = $('#ls-equips-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.equips.id != 0) {
                idx = $("#ls-equips-grid").jqxGrid('getrowboundindexbyid', ls.equips.id);
                ls.equips.id = 0;
            }
                       
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-equips-grid").jqxGrid('selectrow', idx);
            $("#ls-equips-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_equips == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('equips/delete')) ?>,
                type: 'POST',
                data: {
                    equip_id: currentrow_equips.equip_id
                },
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.state == 0) {
                        var idx = $('#ls-equips-grid').jqxGrid('selectedrowindex'); 
                        var row = $('#ls-equips-grid').jqxGrid('getrowdata', (idx-1));

                        if (row != undefined)
                            ls.equips.id = row['equip_id'];
                        
                        $('#ls-btn-refresh').click();
                    } else
                        ls.showerrormassage('Ошибка! ', Res.error);
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_equips == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('equips/update')) ?>,
                type: 'POST',
                data: {
                    equip_id: currentrow_equips.equip_id
                },
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.state == 0) {
                        $("#ls-dialog-content").html(Res.content);
                        $("#ls-dialog-header-text").html(Res.dialog_header);
                        $('#ls-dialog').jqxWindow('open');
                    } else
                        ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                }
            });
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('equips/create')) ?>,
                type: 'POST',
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.state == 0) {
                        $("#ls-dialog-content").html(Res.content);
                        $("#ls-dialog-header-text").html(Res.dialog_header);
                        $('#ls-dialog').jqxWindow('open');
                    } else
                        ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                }
            });
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 260}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-equips-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: equips_adapter,
//                height: 300,
                columns: [
                    { text: 'Наименование', datafield: 'equipname', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Ед. изм.', datafield: 'unit_name', filtercondition: 'CONTAINS', width: 80},
                    { text: 'Примечание', datafield: 'note', filtercondition: 'CONTAINS', width: 200},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        
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
<div style="height: calc(100% - 182px)">
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

