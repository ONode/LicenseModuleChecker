/**
 * Created by Hesk on 14年12月19日.
 */
var keystone = require('keystone'),
    Printer = keystone.list('Printer');

module.exports.default = {
    "httpMethods": "get",
    "httpGroupMethods": "get",
    "defaultKey": "_id",
   // "permanentFilter": "listed:true",
    "columns": {
        "visible": [

            "technology",
            "manufacturer",
            "producedYear",
            "createdAt",

            "materialCost",
            "builtEffecticiency",
            "listed",
            "currentPrice",
            "printerName"

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
/*


"connectivity",
    "technology",
    "manufacturer",
    "producedYear",
    "countryMaker",

    "createdAt",

    "image",
    "currentPrice",
    "materialCost",
    "builtEffecticiency",
    "listed"

    */
