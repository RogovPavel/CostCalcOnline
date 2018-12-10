<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var datatemplatetypes;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: true,
            data: {
                Models: ['TemplateTypes']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                datatemplatetypes = Res[0];
                
                $("#ls-templates-type").jqxComboBox({source: datatemplatetypes});
                
                $("#ls-templates-type").jqxComboBox('val', model.type_id);
                
            }
        });
        
        $("#ls-templates-name").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: 'calc(100% - 8px)', height: 25}));
        $("#ls-templates-type").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {displayMember: "typename", valueMember: "type_id", width: '200px'}));
        $("#ls-templates-active").jqxCheckBox($.extend(true, {}, ls.settings['checkbox'], {theme: ls.defaults.theme, width: '300px', height: 25}));
        $('#ls-templates-editor').jqxEditor($.extend(true, {}, ls.settings['editor'], {height: "calc(100% - 2px)", width: 'calc(100% - 2px)'}));
        $("#ls-templates-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-templates-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'templates',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<div class="ls-row" style="width: 1024px; height: 100%">
    <div style="margin-bottom: 12px;">
        <div class="ls-row">
            <div class="ls-row-column">
                <div class="ls-form-label">Имя шаблона:</div>
                <div class="ls-row-column"><input type="text" id="ls-templates-name" name="templates[templatename]" autocomplete="off"/></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'templatename'); ?></div>
            </div>
        </div>
        <div class="ls-row">

            <div class="ls-row-column">
                <div class="ls-form-label">Тип:</div>
                <div class="ls-row-column"><div id="ls-templates-type" name="templates[type_id]" autocomplete="off"></div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'type_id'); ?></div>
            </div>
            <div class="ls-row-column">
                <div class="ls-form-column"><div id="ls-templates-active" name="templates[active]">Активно</div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'active'); ?></div>
            </div>
        </div>
    </div>
    <div class="ls-row" style="height: calc(100% - 104px);">
        <textarea name="editor" id="ls-templates-editor"></textarea>
    </div>
    <div class="ls-row">
        <div class="ls-row-column"><input type="button" id="ls-templates-save" value="Сохранить"/></div>
        <div class="ls-row-column-right"><input type="button" id="ls-templates-cancel" value="Отмена"/></div>
    </div>
</div>
    
<?php $this->endWidget(); 

/**
 * @param $dateStart string format "d.m.Y"
 * @param $dateEnd string format "d.m.Y"
 * @param array $hollydays mixed, string format "d.m.Y"
 * @return int
 */
function getHollydaysCount($dateStart, $dateEnd, $hollydays = []) : int
{
    $dateStart = (new DateTime($dateStart, new DateTimeZone("Europe/Moscow")));
    $dateEnd = new DateTime($dateEnd, new DateTimeZone("Europe/Moscow"));
    $hollydaysCount = 0;

    $hollydays = array_map(function ($v) {
        return new DateTime($v, new DateTimeZone("Europe/Moscow"));
    },$hollydays);

    while ($dateStart <= $dateEnd)
    {
        if ($dateStart->format("N") >= 6 || in_array($dateStart, $hollydays))
        {
            $hollydaysCount++;
        }

        $dateStart->modify("+ 1 day");
    }

    return $hollydaysCount;
}

$hollydays = [
    "02.01.2000",
    "03.01.2000",
    "04.01.2000",
    "05.01.2000",
];

echo "<pre>";
var_export(getHollydaysCount("01.01.2000", "30.01.2000", $hollydays));
echo "</pre>";

?>

