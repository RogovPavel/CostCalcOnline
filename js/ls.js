var ls = {};

ls.defaults = {
    theme: 'ui-sunny'
};

ls.lock_operation = false;

ls.sources = [];
ls.settings = [];
ls.functions = {};

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
        {name: 'rolenameyii', type: 'string'}
        
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