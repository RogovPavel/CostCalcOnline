<script type="text/javascript">
    ls.regions = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_regions;
        
        var regions_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['regions']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_regions != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_regions != undefined)})
        }
        
        $("#ls-regions-grid").on('rowselect', function (event) {
            currentrow_regions = $('#ls-regions-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            console.log(ls.lock_operation);
            ls.lock_operation = true;
            $("#ls-regions-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-regions-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-regions-grid").on('bindingcomplete', function() {
            var idx = $('#ls-regions-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.regions.id != 0) {
                idx = $("#ls-regions-grid").jqxGrid('getrowboundindexbyid', ls.regions.id);
            }
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-regions-grid").jqxGrid('selectrow', idx);
            $("#ls-regions-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_regions == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('regions/delete')) ?>,
                type: 'POST',
                data: {
                    region_id: currentrow_regions.region_id
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
            if (currentrow_regions == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('regions/update')) ?>,
                type: 'POST',
                data: {
                    region_id: currentrow_regions.region_id
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
                url: <?php echo json_encode(Yii::app()->createUrl('regions/create')) ?>,
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 124}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-regions-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: regions_adapter,
                columns: [
                    { text: 'Наименование', datafield: 'region_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.mm.yyyy HH:mm'},
                ]

        }));
        
        
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
<div>
    <div class="ls-row" style="height: 500px;">
        <div class="ls-grid" id="ls-regions-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

