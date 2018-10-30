<script type="text/javascript">
    ls.clients = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_clients;
        
        var clients_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['clients']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_clients != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_clients != undefined)})
        }
        
        $("#ls-clients-grid").on('rowselect', function (event) {
            currentrow_clients = $('#ls-clients-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-clients-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-clients-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-clients-grid").on('bindingcomplete', function() {
            var idx = $('#ls-clients-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.clients.id != 0) {
                idx = $("#ls-clients-grid").jqxGrid('getrowboundindexbyid', ls.clients.id);
                ls.clients.id = 0;
            }
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-clients-grid").jqxGrid('selectrow', idx);
            $("#ls-clients-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_clients == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('clients/delete')) ?>,
                type: 'POST',
                data: {
                    client_id: currentrow_clients.client_id
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
            if (currentrow_clients == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('clients/update')) ?>,
                type: 'POST',
                data: {
                    client_id: currentrow_clients.client_id
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
                url: <?php echo json_encode(Yii::app()->createUrl('clients/create')) ?>,
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 404}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-clients-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: clients_adapter,
                columns: [
                    { text: 'Наименование', datafield: 'clientname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ИНН', datafield: 'inn', filtercondition: 'CONTAINS', width: 150},
                    { text: 'КПП', datafield: 'kpp', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Рас./Счет', datafield: 'account', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ОГРН', datafield: 'ogrn', filtercondition: 'CONTAINS', width: 150},
                    { text: 'ОКПО', datafield: 'okpo', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Банк', datafield: 'bankname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Юр. адрес', datafield: 'jur_address', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Факт. адрес', datafield: 'fact_address', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Дата создания', columntype: 'date', datafield: 'date_create', width: 130, cellsformat: 'dd.MM.yyyy'},
                    { text: 'Дата изменения', columntype: 'date', datafield: 'date_change', width: 130, cellsformat: 'dd.MM.yyyy'},
                ]

        }));
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Клиенты';
    $this->pageName = 'Клиенты';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Клиенты' => 'clients',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-clients-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

