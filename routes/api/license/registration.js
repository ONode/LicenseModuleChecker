/**
 * Created by hesk on 12/21/2014.
 */
var keystone = require('keystone'),
    async = require('async'),
    _ = require('underscore'),
    License = keystone.list('License'),
    Product = keystone.list('Product'),
    utils = require('keystone-utils'),
    ObjectId = require('mongoose').Types.ObjectId
    ;

exports = module.exports = function (req, res) {
    var product = {},
        license = {},
        isError = false,
        message = "",
        Q = {},
        local = {
            license: false,
            product: false
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

            Product.model.findOne()
                .where('_id', Q.product_key)
                .exec(function (err, data) {

                    if (err) {
                        console.log('[api.app.reg]  - First Line Error...');
                        console.log('------------------------------------------------------------');
                        return next({message: err.message});
                    }

                    if (!data) {
                        console.log('[api.app.reg]  - Product not found...');
                        console.log('------------------------------------------------------------');
                        return next({message: 'Product not found'});
                    }

                    product = _.extend(product, data._doc);
                    local.product = data;

                    return next();
                });


        },

        function (next) {

            License.model.findOne()
                .where('_id', new ObjectId(product._id))
                .where('siteURL', Q.domain)
                .exec(function (err, data) {

                    if (err) {
                        console.log('[api.app.reg]  - First Line Error...');
                        console.log('------------------------------------------------------------');
                        return next({message: err.message});
                    }

                    if (!data) {
                        console.log('[api.app.reg]  - Product not found...');
                        console.log('------------------------------------------------------------');
                        return next({message: 'License not found'});
                    }

                    license = _.extend(license, data._doc);
                    local.license = data;

                    return next();
                });

        },

        function (next) {
            try {

                var time = new Date();
                local.handle.checked = time.getTime();
                local.handle.save(function (err, doc) {

                    if (err) {
                        return next({message: e.message});
                    }

                    if (doc) {

                        console.log('[api.app.reg]  - result ..', doc);
                        console.log('------------------------------------------------------------');

                        return next();
                    }


                });


            } catch (e) {
                console.log('------------------------------------------------------------');
                return next({message: e.message});
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
                session: false,
                message: (err && err.message ? err.message : false) || 'Sorry, there was an error from verifying your product, please try again.'
            });
        }
    });
};
