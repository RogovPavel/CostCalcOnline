<script type="text/javascript">
    ls.streettypes = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_streettypes;
        
        var streettypes_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['streettypes']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_streettypes != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_streettypes != undefined)})
        }
        
        $("#ls-streettypes-grid").on('rowselect', function (event) {
            currentrow_streettypes = $('#ls-streettypes-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-streettypes-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-streettypes-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-streettypes-grid").on('bindingcomplete', function() {
            var idx = $('#ls-streettypes-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.streettypes.id != 0) {
                idx = $("#ls-streettypes-grid").jqxGrid('getrowboundindexbyid', ls.streettypes.id);
                ls.streettypes.id = 0;
            }
                       
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-streettypes-grid").jqxGrid('selectrow', idx);
            $("#ls-streettypes-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_streettypes == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('streettypes/delete')) ?>,
                type: 'POST',
                data: {
                    streettype_id: currentrow_streettypes.streettype_id
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
            if (currentrow_streettypes == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('streettypes/update')) ?>,
                type: 'POST',
                data: {
                    streettype_id: currentrow_streettypes.streettype_id
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
                url: <?php echo json_encode(Yii::app()->createUrl('streettypes/create')) ?>,
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
        
        $("#ls-streettypes-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: streettypes_adapter,
//                height: 300,
                columns: [
                    { text: 'Наименование', datafield: 'streettype_name', filtercondition: 'CONTAINS', width: 150},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Типы улиц';
    $this->pageName = 'Справочник типов улиц';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Типы улиц' => 'streettypes',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-streettypes-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

