/**
 * Created by Hesk on 14年12月19日.
 */
var keystone = require('keystone'),
    Taxi = keystone.list('Taxi');

module.exports.default = {
    "httpMethods": "get",

    "httpGroupMethods": "get",
    "defaultKey": "_id",
    // "permanentFilter": "machineReady:true",
    "columns": {
        "visible": [
            "licensePlate"
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
