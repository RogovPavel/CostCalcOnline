var ls = {};

ls.defaults = {
    theme: 'ui-sunny'
};

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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
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
    async: false,
    pagenum: 0,
    pagesize: 200,
    beforeprocessing: function (data) {
        this.totalrecords = data[0].TotalRows;
    }
};