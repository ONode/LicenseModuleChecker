/**
 * Created by hesk on 12/21/2014.
 */
var keystone = require('keystone'),
    async = require('async'),
    _ = require('underscore'),
    License = keystone.list('License'),
    Product = keystone.list('Product'),
    utils = require('keystone-utils'),
    crypto = require('crypto'),
    ObjectId = require('mongoose').Types.ObjectId
    ;

exports = module.exports = function (req, res) {
  /*  res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');*/


    var product = {},
        license = {},
        Q = {},
        local = {
            license: false,
            product: false,
            newissue: false
        };


    /*
     var input_sufficiency = function (Qu) {
     if (!Qu.domain) throw new Error('domain is missing');
     if (!Qu.key) throw new Error('key is missing');
     return Qu;
     };

     */
    /**
     *
     * @param Query
     * @param checkArr
     * @returns {*}
     */
    var input_checker = function (Query, checkArr) {
        _.each(checkArr, function (paramname) {
            if (!Query[paramname]) throw Error(paramname + " is missing.");
        });
        return Query;
    }
    var genkey = function (length) {
        var current_date = (new Date()).valueOf().toString();
        var random = Math.random().toString();
        if (length === -1) {
            return crypto.createHash('sha1').update(current_date + random + "2").digest('hex');
        } else {
            return crypto.createHash('sha1').update(current_date + random + "2").digest('hex').substr(0, length);
        }
    }
    var issueNewLicense = function (wwwSite, product_id, next) {
            var newLicense = new License.model({
                clientID: genkey(8),
                siteURL: wwwSite,
                product: new ObjectId(product_id.toString()),
                createdAt: new Date(),
                expire: new Date(),
                brandingRemoval: false,
                demoDisplay: true,
                useExpiration: false,
                licenseStatusLive: true,
                key: genkey(-1),
                licenseHash: genkey(-1),
                checked: new Date()
            });
            newLicense.save(function (err) {
                if (err) {
                    console.log('[api.app.reg]  - Error saving new license.', err);
                    console.log('------------------------------------------------------------');
                    return next({message: 'Sorry, there was an error processing your account, please try again.'});
                }
                console.log('[api.app.reg]  - Saved new license registration.');
                console.log('------------------------------------------------------------');
            });
            return newLicense;
        },
        findProduct = function (product_id, next) {
            Product.model.findOne()
                .where('_id', product_id)
                .exec(function (err, data) {

                    if (err) {
                        console.log('[api.app.reg]  - First Line Error...');
                        console.log('------------------------------------------------------------');
                        return next({message: err.message});
                    }

                    if (!data) {
                        console.log('[api.app.reg] key:' + product_id);
                        console.log('[api.app.reg]  - Product not found...');
                        console.log('------------------------------------------------------------');
                        return next({message: 'Product not found'});
                    }

                    product = _.extend(product, data._doc);
                    local.product = data;
                    console.log('[api.app.reg]  - Product  found...');
                    console.log('------------------------------------------------------------');
                    return next();
                });

        },
        licenseFind = function (product_id, site_url, next) {
            License.model.findOne()
                .where('product', product_id)
                .where('siteURL', site_url)
                .exec(function (err, data) {

                    if (err) {
                        console.log('[api.app.reg]  - First Line Error...');
                        console.log('------------------------------------------------------------');
                        return next({message: err.message});
                    }

                    if (!data) {
                        console.log('[api.app.reg] key:' + product_id);
                        console.log('[api.app.reg]  - License not found...');
                        console.log('------------------------------------------------------------');
                        local.license = issueNewLicense(site_url, product_id, next);
                        license = _.extend(license, local.license._doc);
                        local.newissue = true;
                    } else {
                        license = _.extend(license, data._doc);
                        local.license = data;
                        local.newissue = false;
                    }

                    return next();
                });
        };
    /**
     * async method run business logic
     */
    async.series([
        function (next) {
            try {
                Q = input_checker(req.query, ['domain', 'product_key']);
                next();
            } catch (e) {
                return next({message: e.message});
            }
        },
        function (next) {
            findProduct(Q.product_key, next);
        },
        function (next) {
            licenseFind(product._id, Q.domain, next);
        },
        function (next) {
            if (!local.newissue) {
                var time = new Date();
                local.license.checked = time.getTime();
                local.license.save(function (err, doc) {
                    if (err) {
                        return next({message: e.message});
                    }
                    if (doc) {
                        license = _.extend(license, doc._doc);
                        return next();
                    }
                });
            } else {
                next();
            }
        },

        function (next) {


            return res.apiResponse({
                success: true,
                timestamp: new Date().getTime(),
                license_detail: license
            });
        }
    ], function (err) {
        if (err) {
            console.log('[api.app.reg]  - verify your product failed.', err);
            console.log('------------------------------------------------------------');


            return res.apiResponse({
                success: false,
                timestamp: new Date().getTime(),
                message: (err && err.message ? err.message : false) || 'Sorry, there was an error from verifying your product, please try again.'
            });
        }
    });
};
