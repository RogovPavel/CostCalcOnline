var ls = {};

ls.defaults = {
    theme: 'ui-sunny'
};

ls.sources = [];
ls.settings = [];

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
