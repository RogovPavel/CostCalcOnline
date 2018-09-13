var ls = {};

ls.defaults = {
    theme: 'ui-sunny'
}

ls.sources = [];

ls.sources['users'] = {
    datatype: "json",
    datafields: [
        {name: 'user_id', type: 'int'},
        {name: 'login', type: 'string'},
        {name: 'password', type: 'string'},
        {name: 'rolename', type: 'string'},
        {name: 'rolenameyii', type: 'string'},
        
    ],
    id: 'user_id',
    url: '/index.php/AjaxData/DataJQXSimple&ModelName=Users',
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

