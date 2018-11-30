var ls = {};

ls.defaults = {
    theme: 'ui-sunny'
};

ls.themes = [
    {id: 1, name: 'ui-sunny'},
    {id: 2, name: 'classic'},
    {id: 3, name: 'dark'},
    {id: 4, name: 'metro'},
];



var theme = $('[name="meta-theme"]').attr('theme');
ls.defaults.theme = theme;


ls.lock_operation = false;

ls.sources = [];
ls.settings = [];
ls.functions = {};

ls.wopen = function(url, params, wname) {
    var tmpurl = url;
    var i = 0;
    if (params != undefined)
        for (var key in params) {
            if (i == 0)
                tmpurl += '/' + params[key];
            else if (i == 1)
                tmpurl += '?' + key + '=' + params[key];
            else
                tmpurl += '&' + key + '=' + params[key];
            i++;
        }
    window.open('/' + tmpurl, wname);
};

ls.dateconverttosjs = function(datestr) {
    var Result = null;
    if (datestr === null) return null;
    
    if (typeof(datestr) != 'string')
        return null;    
    // Дата приводим к формату ГГГГ-ММ-ДД ЧЧ:ММ
    if (datestr === '' || datestr.length <  10) return null;
    datestr = datestr.slice(0, 16);
    if (datestr[4] === '-') {
        Result = new Date(datestr.replace(/-/g, '/'));
        return Result;
    }
    
    if (datestr[2] === '.') {
        // Считаем, что дата в формате ДД.ММ.ГГГГ ЧЧ:ММ
        Result = datestr[6] + datestr[7] + datestr[8] + datestr[9] + '/';
        Result += datestr[3] + datestr[4] + '/';
        Result += datestr[0] + datestr[1];
        if (datestr.length > 10) {
            Result += ' ' + datestr[11] + datestr[12] + ':' + datestr[14] + datestr[15];
        }
    } else Result = new Date(datestr);
    
    return Result;
};

ls.stringtobool = function(str) {
    var result = false;
    
    if (str == 'true' || str == '1')
        result = true;
    
    if (str == '0' || str == null || str == 'false')
        result = false;
    
    return result;
}

ls.showerrormassage = function(header, message) {
    
    $('#ls-error-dialog').jqxWindow($.extend(true, {}, ls.settings['dialog'], {width: 400, height: 160, initContent: function() {
            $('#ls-btn-error-close').jqxButton($.extend(true, {}, ls.settings['button'], { width: 120, height: 30 }));    
            $('#ls-error-message').jqxTextArea($.extend(true, {}, ls.settings['textarea'], { height: 'calc(100% - 2px)', width: 'calc(100% - 2px)'}));
            $('#ls-btn-error-close').on('click', function() {
                $('#ls-error-dialog').jqxWindow('close');
            });
        }
    }));
    $('#ls-error-dialog-header-text').html(header);
    $('#ls-error-message').html(message);
    $('#ls-error-dialog').jqxWindow('open');
}


ls.loaderror = function(jqXHR, status, error) {
    ls.showerrormassage('Ошибка', jqXHR.responseText);
    ls.lock_operation = false;
}

ls.opendialogforedit = function(controller, action, params, type, async, size) {
    if (controller == undefined || action == undefined)
        return;
    
    if (type == undefined)
        type = 'POST';
    
    if (params == undefined)
        params = {};
    
    if (async == undefined)
        async = false;
    
    if (size == undefined)
        size = {width: '600px', height: '300px'};
    
    var url = '/' + controller + '/' + action;
    $.ajax({
        url: url,
        type: type,
        data: params,
        async: async,
        success: function(Res) {
            Res = JSON.parse(Res);
            if (Res.state == 0) {
                $('#ls-dialog').jqxWindow(size);
                $("#ls-dialog-content").html(Res.responseText);
                $("#ls-dialog-header-text").html(Res.header);
                $('#ls-dialog').jqxWindow('open');
            } else
                ls.showerrormassage('Ошибка!', Res.responseText);
        },
        error: function(Res) {
            ls.showerrormassage('Ошибка', Res.responseText);
        }
    });
};

ls.save = function(controller, action, params, after, type, async) {
    if (controller == undefined || action == undefined)
        return;
    
    if (type == undefined)
        type = 'POST';
    
    if (params == undefined)
        params = {};
    
    if (async == undefined)
        async = false;
    
    if (after == undefined)
        after = function(Res) {
            Res = JSON.parse(Res);
            
            if (Res.state != 0)
                ls.showerrormassage('Ошибка! ' + Res.responseText);
        }
    
    var url = '/' + controller + '/' + action;
    
    $.ajax({
        url: url,
        type: type,
        data: params,
        async: async,
        success: after,
        error: function(Res) {
            ls.showerrormassage('Ошибка!', Res.responseText);
            ls.lock_operation = false;
        }
    });
};

ls.delete = function(controller, action, params, after, type, async) {
    if (controller == undefined || action == undefined)
        return;
    
    if (type == undefined)
        type = 'POST';
    
    if (params == undefined)
        params = {};
    
    if (async == undefined)
        async = false;
    
    if (after == undefined)
        after = function(Res) {
            Res = JSON.parse(Res);
            
            if (Res.state != 0)
                ls.showerrormassage('Ошибка! ' + Res.responseText);
        }
    
    var url = '/' + controller + '/' + action;
    
    $.ajax({
        url: url,
        type: type,
        data: params,
        async: async,
        success: after,
        error: function(Res) {
            ls.showerrormassage('Ошибка', Res.responseText);
        }
    });
};

ls.settings['datatable'] = {
    localization: getLocalization('ru'),
    enableBrowserSelection: true,
    altRows: true,
    sortable: true,
    width: 'calc(100% - 2px)',
    height: 'calc(100% - 2px)',
    theme: ls.defaults.theme
};

ls.settings['datetime'] = {
    theme: ls.defaults.theme,
    showFooter: true,
    todayString: 'Сегодня',
    clearString: 'Очистить',
    height: '25px',
    formatString: 'dd.MM.yyyy HH:mm',
    culture: 'ru-RU',
    readonly: false,
    max: new Date(2999, 12, 31)
};
    
ls.settings['textarea']  = {
    theme: ls.defaults.theme,
};


ls.settings['dialog']  = {
    theme: ls.defaults.theme,
    width: '500px',
    maxHeight: 2000,
    maxWidth: 2000,
    height: '230px',
    resizable: true,
    position: 'center',
    isModal: true,
    autoOpen: false,
    animationType: 'none'
};

ls.settings['grid'] = {
    width: 'calc(100% - 2px)',
    height: 'calc(100% - 2px)',
    pageable: false,
    virtualmode: false,
    theme: ls.defaults.theme,
    localization: getLocalization('ru'),
    columnsresize: true,
    columnsreorder: true,
    autosavestate: true,
    autoloadstate: true,
    
    rendergridrows: function (params) {
            return params.data;
    }    
};

ls.settings['button'] = {
    theme: ls.defaults.theme,
    width: 120,
    height: 30,
    imgPosition: "left",   
};

ls.settings['input'] = {
    theme: ls.defaults.theme,
    height: 25,
};

ls.settings['maskedinput'] = {
    theme: ls.defaults.theme,
    height: 25,
};

ls.settings['passwordinput'] = {
    theme: ls.defaults.theme,
    height: 25,
};

ls.settings['tab'] = {
    theme: ls.defaults.theme
};

ls.settings['numberinput'] = {
    theme: ls.defaults.theme,
    inputMode: 'simple',
    height: 25,
};

ls.settings['checkbox'] = {
    theme: ls.defaults.theme,
    
};

ls.settings['combobox'] = {
    theme: ls.defaults.theme,
    height: 25,
};

ls.settings['button'] = {
    theme: ls.defaults.theme,
    width: 120,
    height: 30,
    imgPosition: "left",   
};

ls.sources['users'] = {
    datatype: "json",
    datafields: [
        {name: 'user_id', type: 'int'},
        {name: 'login', type: 'string'},
        {name: 'password', type: 'string'},
        {name: 'rolename', type: 'string'},
        {name: 'rolenameyii', type: 'string'},
        {name: 'firstname', type: 'string'},
        {name: 'surname', type: 'string'},
        {name: 'lastname', type: 'string'},
        {name: 'fullname', type: 'string'},
        {name: 'shortname', type: 'string'},
        {name: 'birthday', type: 'date'},
        {name: 'sex', type: 'bool'},
        {name: 'work_phonenumber', type: 'string'},
        {name: 'home_phonenumber', type: 'string'},
        {name: 'work_email', type: 'string'},
        {name: 'role_id', type: 'int'},
        {name: 'rolename', type: ''},
        {name: 'rolenameyii', type: 'string'},
        {name: 'banned', type: 'date'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},
        
    ],
    id: 'user_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Users',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['regions'] = {
    datatype: "json",
    datafields: [
        {name: 'region_id', type: 'int'},
        {name: 'region_name', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'surname', type: 'string'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'}        
    ],
    id: 'region_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Regions',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['firms'] = {
    datatype: "json",
    datafields: [
        {name: 'firm_id', typr: 'int'},
        {name: 'firmname', typr: 'string'},
        {name: 'inn', typr: 'string'},
        {name: 'kpp', typr: 'string'},
        {name: 'account', typr: 'string'},
        {name: 'ogrn', typr: 'string'},
        {name: 'okpo', typr: 'string'},
        {name: 'bank_id', typr: 'int'},
        {name: 'bankname', typr: 'string'},
        {name: 'jur_address', typr: 'string'},
        {name: 'fact_address', typr: 'string'},
        {name: 'date_create', typr: 'date'},
        {name: 'user_create', typr: 'int'},
        {name: 'date_change', typr: 'date'},
        {name: 'user_change', typr: 'int'},
        {name: 'group_id', typr: 'int'},
        {name: 'deldate', typr: 'date'},       
    ],
    id: 'firm_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Firms',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['banks'] = {
    datatype: "json",
    datafields: [
        {name: 'bank_id', type: 'int'},
        {name: 'bankname', type: 'string'},
        {name: 'city', type: 'string'},
        {name: 'account', type: 'string'},
        {name: 'bik', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},      
    ],
    id: 'bank_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Banks',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: false,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['clients'] = {
    datatype: "json",
    datafields: [
        {name: 'client_id', typr: 'int'},
        {name: 'clientname', typr: 'string'},
        {name: 'inn', typr: 'string'},
        {name: 'kpp', typr: 'string'},
        {name: 'account', typr: 'string'},
        {name: 'ogrn', typr: 'string'},
        {name: 'okpo', typr: 'string'},
        {name: 'bank_id', typr: 'int'},
        {name: 'bankname', typr: 'string'},
        {name: 'jur_address', typr: 'string'},
        {name: 'fact_address', typr: 'string'},
        {name: 'date_create', typr: 'date'},
        {name: 'user_create', typr: 'int'},
        {name: 'date_change', typr: 'date'},
        {name: 'user_change', typr: 'int'},
        {name: 'group_id', typr: 'int'},
        {name: 'deldate', typr: 'date'},       
    ],
    id: 'client_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Clients',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['banks'] = {
    datatype: "json",
    datafields: [
        {name: 'bank_id', type: 'int'},
        {name: 'bankname', type: 'string'},
        {name: 'city', type: 'string'},
        {name: 'account', type: 'string'},
        {name: 'bik', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},      
    ],
    id: 'bank_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Banks',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: false,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['streets'] = {
    datatype: "json",
    datafields: [
        {name: 'street_id', type: 'int'},
        {name: 'streetname', type: 'string'},
        {name: 'streettype_id', type: 'int'},
        {name: 'streettype_name', type: 'string'},
        {name: 'region_id', type: 'int'},
        {name: 'region_name', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},      
    ],
    id: 'street_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Streets',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['streettypes'] = {
    datatype: "json",
    datafields: [
        {name: 'streettype_id', type: 'int'},
        {name: 'streettype_name', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},    
    ],
    id: 'streettype_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=StreetTypes',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['demandtypes'] = {
    datatype: "json",
    datafields: [
        {name: 'demandtype_id', type: 'int'},
        {name: 'demandtype_name', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},   
    ],
    id: 'demandtype_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=DemandTypes',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
ls.sources['demandpriors'] = {
    datatype: "json",
    datafields: [
        {name: 'demandprior_id', type: 'int'},
        {name: 'demandprior_name', type: 'string'},
        {name: 'time_exec', type: 'int'},
        {name: 'worktime', type: 'bool'},
        {name: 'weekend', type: 'bool'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},  
    ],
    id: 'demandprior_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=DemandPriors',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['roles'] = {
    datatype: "json",
    datafields: [
        {name: 'role_id', type: 'int'},
        {name: 'rolename', type: 'string'},
        {name: 'rolenameyii', type: 'string'},
        {name: 'group_id', type: 'int'},  
    ],
    id: 'demandprior_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Roles',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: false,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['objectgroups'] = {
    datatype: "json",
    datafields: [
        {name: 'objectgr_id', type: 'int'},
        {name: 'region_id', type: 'int'},
        {name: 'street_id', type: 'int'},
        {name: 'house', type: 'string'},
        {name: 'corp', type: 'string'},
        {name: 'address', type: 'string'},
        {name: 'client_id', type: 'int'},
        {name: 'clientname', type: 'string'},
        {name: 'manger_id', type: 'int'},
        {name: 'managername', type: 'string'},
        {name: 'quantdoorway', type: 'int'},
        {name: 'datebuild', type: 'date'},
        {name: 'note', type: 'string'}, 
    ],
    id: 'objectgr_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=ObjectGroups',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: false,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['objectgroupcontacts'] = {
    datatype: "json",
    datafields: [
        {name: 'contact_id', type: 'int'},
        {name: 'objectgr_id', type: 'int'},
        {name: 'firstname', type: 'string'},
        {name: 'surname', type: 'string'},
        {name: 'lastname', type: 'string'},
        {name: 'fullname', type: 'string'},
        {name: 'position_id', type: 'int'},
        {name: 'position_name', type: 'string'},
        {name: 'phonenumber', type: 'string'},
        {name: 'email', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},
    ],
    id: 'contact_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=ObjectGroupContacts',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['objects'] = {
    datatype: "json",
    datafields: [
        {name: 'object_id', type: 'int'},
        {name: 'objectgr_id', type: 'int'},
        {name: 'doorway', type: 'string'},
        {name: 'quant_flats', type: 'int'},
        {name: 'code', type: 'string'},
        {name: 'address', type: 'string'},
        {name: 'note', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'object_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Objects',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['units'] = {
    datatype: "json",
    datafields: [
        {name: 'unit_id', type: 'int'},
        {name: 'unit_name', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},
    ],
    id: 'unit_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Units',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['equips'] = {
    datatype: "json",
    datafields: [
        {name: 'equip_id', type: 'int'},
        {name: 'equipname', type: 'string'},
        {name: 'unit_id', type: 'int'},
        {name: 'unit_name', type: 'string'},
        {name: 'note', type: 'string'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
        {name: 'deldate', type: 'date'},
    ],
    id: 'equip_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=Equips',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['objectequips'] = {
    datatype: "json",
    datafields: [
        {name: 'objeq_id', type: 'int'},
        {name: 'object_id', type: 'int'},
        {name: 'objectgr_id', type: 'int'},
        {name: 'equip_id', type: 'int'},
        {name: 'equipname', type: 'string'},
        {name: 'unit_name', type: 'string'},
        {name: 'quant', type: 'float'},
        {name: 'install', type: 'date'},
        {name: 'note', type: 'string'},
        {name: 'user_create', type: 'int'},
        {name: 'date_create', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'deldate', type: 'date'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'objeq_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=ObjectEquips',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['demands'] = {
    datatype: "json",
    datafields: [
        {name: 'demand_id', type: 'int'},
        {name: 'date_reg', type: 'date'},
        {name: 'object_id', type: 'int'},
        {name: 'objectgr_id', type: 'int'},
        {name: 'address', type: 'string'},
        {name: 'client_id', type: 'int'},
        {name: 'clientname', type: 'string'},
        {name: 'status_id', type: 'int'},
        {name: 'status_name', type: 'string'},
        {name: 'demandtype_id', type: 'int'},
        {name: 'demandtype_name', type: 'string'},
        {name: 'prior_id', type: 'int'},
        {name: 'demandprior_name', type: 'string'},
        {name: 'deadline', type: 'date'},
        {name: 'demand_text', type: 'string'},
        {name: 'contact', type: 'string'},
        {name: 'date_exec', type: 'date'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'demand_id',
    url: '/index.php/AjaxData/DataJQX?ModelName=Demands',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['demandcomments'] = {
    datatype: "json",
    datafields: [
        {name: 'comment_id', type: 'int'},
        {name: 'demand_id', type: 'int'},
        {name: 'date', type: 'date'},
        {name: 'user_id', type: 'int'},
        {name: 'shortname', type: 'string'},
        {name: 'text', type: 'string'},
        {name: 'user_create', type: 'int'},
        {name: 'date_create', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'comment_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=DemandComments',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['costcalculations'] = {
    datatype: "json",
    datafields: [
        {name: 'calc_id', type: 'int'},
        {name: 'type', type: 'int'},
        {name: 'typename', type: 'string'},
        {name: 'date', type: 'date'},
        {name: 'status_id', type: 'int'},
        {name: 'client_id', type: 'int'},
        {name: 'clientname', type: 'string'},
        {name: 'objectgr_id', type: 'int'},
        {name: 'address', type: 'string'},
        {name: 'demand_id', type: 'int'},
        {name: 'firm_id', type: 'int'},
        {name: 'firmname', type: 'string'},
        {name: 'manager_id', type: 'int'},
        {name: 'shortname', type: 'string'},
        {name: 'contact', type: 'string'},
        {name: 'specnote', type: 'string'},
        {name: 'note', type: 'string'},
        {name: 'koef', type: 'float'},
        {name: 'discount', type: 'float'},
        {name: 'date_ready', type: 'date'},
        {name: 'user_ready', type: 'int'},
        {name: 'sum_materials_low', type: 'float'},
        {name: 'sum_materials_high', type: 'float'},
        {name: 'sum_works_low', type: 'float'},
        {name: 'sum_works_high', type: 'float'},
        {name: 'sum_equips_low', type: 'float'},
        {name: 'sum_equips_high', type: 'float'},
        {name: 'sum_low_full', type: 'float'},
        {name: 'sum_high_full', type: 'float'},
        {name: 'sum_marj', type: 'float'},
        {name: 'percent_marj', type: 'float'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'calc_id',
    url: '/index.php/AjaxData/DataJQX?ModelName=CostCalculations',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};

ls.sources['costcalcequips'] = {
    datatype: "json",
    datafields: [
        {name: 'cceq_id', type: 'int'},
        {name: 'calc_id', type: 'int'},
        {name: 'equip_id', type: 'int'},
        {name: 'equipname', type: 'string'},
        {name: 'unit_name', type: 'string'},
        {name: 'quant', type: 'float'},
        {name: 'price_low', type: 'float'},
        {name: 'price_high', type: 'float'},
        {name: 'sum_price_low', type: 'float'},
        {name: 'sum_price_high', type: 'float'},
        {name: 'sum_works_low', type: 'float'},
        {name: 'sum_works_high', type: 'float'},
        {name: 'note', type: 'string'},
        {name: 'sort', type: 'int'},
        {name: 'date_create', type: 'date'},
        {name: 'user_create', type: 'int'},
        {name: 'date_change', type: 'date'},
        {name: 'user_change', type: 'int'},
        {name: 'group_id', type: 'int'},
    ],
    id: 'cceq_id',
    url: '/index.php/AjaxData/DataJQXSimple?ModelName=CostCalcEquips',
    type: 'POST',
    root: 'Rows',
    cache: false,
    async: true,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};
