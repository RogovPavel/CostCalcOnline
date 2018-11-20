<script type="text/javascript">
    ls.objectgroups = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_objectgroups;
        
        var objectgroups_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['objectgroups']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_objectgroups != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_objectgroups != undefined)})
        }
        
        $("#ls-objectgroups-grid").on('rowselect', function (event) {
            currentrow_objectgroups = $('#ls-objectgroups-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-objectgroups-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-objectgroups-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-objectgroups-grid").on('bindingcomplete', function() {
            var idx = $('#ls-objectgroups-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.objectgroups.id != 0) {
                idx = $("#ls-objectgroups-grid").jqxGrid('getrowboundindexbyid', ls.objectgroups.id);
                ls.objectgroups.id = 0;
            }
                       
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-objectgroups-grid").jqxGrid('selectrow', idx);
            $("#ls-objectgroups-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_objectgroups == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('objectgroups/delete')) ?>,
                type: 'POST',
                data: {
                    objectgroup_id: currentrow_objectgroups.objectgroup_id
                },
                async: false,
                success: function(Res) {
                    Res = JSON.parse(Res);
                    if (Res.state == 0) {
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
            ls.wopen('objectgroups/view', {objectgr_id: currentrow_objectgroups.objectgr_id}, 'objectgroups_' + currentrow_objectgroups.objectgr_id);
        });
        
        $('#ls-btn-create').on('click', function() {
            if ($('#ls-btn-create').jqxButton('disabled') || ls.lock_operation) return;
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('objectgroups/create')) ?>,
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 600, height: 300}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-objectgroups-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: objectgroups_adapter,
                columns: [
                    { text: 'Адрес', datafield: 'address', width: 250},    
                    { text: 'Клиент', datafield: 'clientname', width: 230},
                ]

        }));
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Объекты ';
    $this->pageName = 'Объекты';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Объекты' => 'objectgroups',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-objectgroups-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

