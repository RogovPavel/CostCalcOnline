<script type="text/javascript">
    ls.functions.refresh_regions = function(_id) {
        $("#ls-regions-grid").jqxGrid('updatebounddata');
        var index = $("#ls-regions-grid").jqxGrid('getrowdatabyid', _id);
        $("#ls-regions-grid").jqxGrid('selectrow', index);
    };
    
    $(document).ready(function() {
        var currentrow_regions;
        
        var regions_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['regions']));
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_regions != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_regions != undefined)})
        }
        
        $("#ls-regions-grid").on('rowselect', function (event) {
            currentrow_regions = $('#ls-regions-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            ls.functions.refresh_regions();
        });
        
        $("#ls-regions-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-regions-grid").on('bindingcomplete', function() {
            checkbutton();
        });
        
        $('#ls-btn-create').on('click', function() {
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('Regions/Create')) ?>,
                type: 'POST',
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.state == 0) {
                        $("#ls-dialog-content").html(Res.content);
                        $("#ls-dialog-header-text").html(Res.dialog_header);
                        $('#ls-dialog').jqxWindow('open');
                    }
                },
                error: function(Res) {
//                    Aliton.ShowErrorMessage(Aliton.Message['ERROR_LOAD_PAGE'], Res.responseText);
                }
            });
        });
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 360}));
        
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

