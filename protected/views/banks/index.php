<script type="text/javascript">
    ls.banks = {
        id: 0
    };
    
    $(document).ready(function() {
        var currentrow_banks;
        
        var banks_adapter = new $.jqx.dataAdapter($.extend(true, {}, ls.sources['banks']), {
            loadError: function(jqXHR, status, error) {
                ls.showerrormassage('Ошибка', 'При обновлении данных произошла ошибка. Повторите попытку позже.');
                ls.lock_operation = false;
            }
        });
        
        var checkbutton = function() {
            $('#ls-btn-update').jqxButton({disabled: !(currentrow_banks != undefined)})
            $('#ls-btn-delete').jqxButton({disabled: !(currentrow_banks != undefined)})
        }
        
        $("#ls-banks-grid").on('rowselect', function (event) {
            currentrow_banks = $('#ls-banks-grid').jqxGrid('getrowdata', event.args.rowindex);
            checkbutton();
        });
        
        $('#ls-btn-refresh').on('click', function() {
            if (ls.lock_operation) return;
            
            ls.lock_operation = true;
            $("#ls-banks-grid").jqxGrid('updatebounddata');
        });
        
        $("#ls-banks-grid").on('rowdoubleclick', function(){
            $('#ls-btn-update').click();
        });
        
        $("#ls-banks-grid").on('bindingcomplete', function() {
            var idx = $('#ls-banks-grid').jqxGrid('selectedrowindex'); 
            
            if (ls.banks.id != 0) {
                idx = $("#ls-banks-grid").jqxGrid('getrowboundindexbyid', ls.banks.id);
                ls.banks.id = 0;
            }
            
            if (idx == -1)
                idx = 0;
            
            $("#ls-banks-grid").jqxGrid('selectrow', idx);
            $("#ls-banks-grid").jqxGrid('ensurerowvisible', idx);
            
            checkbutton();
            ls.lock_operation = false;
        });
        
        $('#ls-btn-delete').on('click', function() {
            if ($('#ls-btn-delete').jqxButton('disabled') || ls.lock_operation) return;
            if (currentrow_banks == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('banks/delete')) ?>,
                type: 'POST',
                data: {
                    bank_id: currentrow_banks.bank_id
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
            if (currentrow_banks == undefined) return;            
            $.ajax({
                url: <?php echo json_encode(Yii::app()->createUrl('banks/update')) ?>,
                type: 'POST',
                data: {
                    bank_id: currentrow_banks.bank_id
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
                url: <?php echo json_encode(Yii::app()->createUrl('banks/create')) ?>,
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
        
        $('#ls-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 254}));
        
        $('#ls-btn-create').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-update').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-refresh').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        $('#ls-btn-delete').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));
        
        $("#ls-banks-grid").jqxGrid(
            $.extend(true, {}, ls.settings['grid'], {
                source: banks_adapter,
                columns: [
                    { text: 'Наименование', datafield: 'bankname', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Город', datafield: 'city', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Рас./Счет', datafield: 'account', filtercondition: 'CONTAINS', width: 150},
                    { text: 'БИК', datafield: 'bik', filtercondition: 'CONTAINS', width: 150},
                    { text: 'Дата создания', columntype: 'date', datafield: 'date_create', width: 130, cellsformat: 'dd.MM.yyyy'},
                    { text: 'Дата изменения', columntype: 'date', datafield: 'date_change', width: 130, cellsformat: 'dd.MM.yyyy'},
                ]

        }));
        
        
    });
</script>

<?php
    $this->pageTitle=Yii::app()->name . ' - Банки';
    $this->pageName = 'Банки';
    $this->breadcrumbs=array(
            'Главная' => 'site',
            'Банки' => 'banks',
    );
?>
<div style="height: calc(100% - 182px)">
    <div class="ls-row" style="height: calc(100% - 34px)">
        <div class="ls-grid" id="ls-banks-grid"></div>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-btn-create" value="Создать" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-update" value="Изменить" /></div>
        <div class="ls-row-column"><input type="button" id="ls-btn-refresh" value="Обновить" /></div>
        <div class="ls-row-column-right"><input type="button" id="ls-btn-delete" value="Удалить" /></div>
    </div>
</div>

