/**
 * Created by Hesk on 14年12月17日.
 */
var keystone = require('keystone'),
    Maker = keystone.list('Maker');


module.exports.default = {
    "httpMethods": "get",

    "httpGroupMethods": "get",
    "defaultKey": "_id",
    "permanentFilter": "machineReady:true",
    "columns": {
        "visible": [
            "makerName"
        ],
        "no_filter": [
            "_id"
        ]
    }
}

module.exports.isAdmin = {
    "__extends__": "default",
    "httpMethods": "get",
    "httpGroupMethods": "get"                // true will result in duplicating httpMethods to httpGroupMethods
}
module.exports.authorized = {
    "__extends__": "default",
    "httpMethods": "get",
    "httpGroupMethods": "get",
    "permanentFilter": undefined
};
