<script type="text/javascript">
    ls.streets = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_streets;
        
        var streets_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['streets']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_streets != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_streets != undefined)})
        }
        
        $("#ls-streets-grid").on('rowselect', function (event) {
            currentrow_streets = $('#ls-streets-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-streets-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-streets-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-streets-grid").on('bindingcomplete', function() {
            var idx = $('#ls-streets-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.streets.id != 0) {
                idx = $("#ls-streets-grid").jqxGrid('getrowboundindexbyid', ls.streets.id);
                ls.streets.id = 0;
            }
                       
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-streets-grid").jqxGrid('selectrow', idx);
            $("#ls-streets-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_streets == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('streets/delete')) ?>,
                type: 'POST',
                data: {
                    street_id: currentrow_streets.street_id
                },
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.error == 0) {
                        $('#ls-btn-refresh').click();
                    } else
                        ls.showerrormassage('Ошибка! ' + Res.error_type, Res.error_text);
                },
                error: function(Res) {
                    ls.showerrormassage('Ошибка', 'При попытке загрузить страницу произошла ошибка. Повторите попытку позже.');
                }
            });
        });
        
        $('#ls-btn-update').on('click', function() {
            if ($('#ls-btn-update').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_streets == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('streets/update')) ?>,
                type: 'POST',
                data: {
                    street_id: currentrow_streets.street_id
                },
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.error == 0) {
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
                url: <?php echo json_encode(Yii::app()->createUrl('streets/create')) ?>,
                type: 'POST',
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.error == 0) {
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 194}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-streets-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: streets_adapter,
                columns: [
                    { text: 'Наименование', datafield: 'streetname', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Тип', datafield: 'streettype_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Регион', datafield: 'region_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Регионы';
    $this->pageName = 'Справочник регионов';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Регионы' => 'streets',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-streets-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

