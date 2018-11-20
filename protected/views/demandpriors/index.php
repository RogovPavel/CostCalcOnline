<script type="text/javascript">
    ls.demandpriors = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_demandpriors;
        
        var demandpriors_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['demandpriors']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_demandpriors != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_demandpriors != undefined)})
        }
        
        $("#ls-demandpriors-grid").on('rowselect', function (event) {
            currentrow_demandpriors = $('#ls-demandpriors-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-demandpriors-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-demandpriors-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-demandpriors-grid").on('bindingcomplete', function() {
            var idx = $('#ls-demandpriors-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.demandpriors.id != 0) {
                idx = $("#ls-demandpriors-grid").jqxGrid('getrowboundindexbyid', ls.demandpriors.id);
                ls.demandpriors.id = 0;
            }
                       
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-demandpriors-grid").jqxGrid('selectrow', idx);
            $("#ls-demandpriors-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_demandpriors == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('demandpriors/delete')) ?>,
                type: 'POST',
                data: {
                    demandprior_id: currentrow_demandpriors.demandprior_id
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
            if (currentrow_demandpriors == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('demandpriors/update')) ?>,
                type: 'POST',
                data: {
                    demandprior_id: currentrow_demandpriors.demandprior_id
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
                url: <?php echo json_encode(Yii::app()->createUrl('demandpriors/create')) ?>,
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 224}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-demandpriors-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: demandpriors_adapter,
                columns: [
                    { text: 'Наименование', datafield: 'demandprior_name', width: 150},    
                    { text: 'Время на выполнение', datafield: 'time_exec', width: 150, cellsformat: 'n'},
                    { text: 'Учитывать рабочее время', datafield: 'worktime', columntype: 'checkbox', width: 200},    
                    { text: 'Учитывать выходные', datafield: 'weekend', columntype: 'checkbox', width: 200},    
                    { text: 'Дата создания', datafield: 'date_create', filtercondition: 'CONTAINS', width: 130, cellsformat: 'dd.MM.yyyy HH:mm'},
                ]

        }));
        
        
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
<div style="height: calc(100% - 182px)">
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

