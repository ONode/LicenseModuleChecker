/**
 * Created by hesk on 12/21/2014.
 */
var keystone = require('keystone'),
    async = require('async'),
    _ = require('underscore'),
    Job = keystone.list('Job');

var model_construct = function (Q) {
    if (!Q.budget) throw new Error('budget is missing');
    if (!Q.material_selection) throw new Error('materialSelection is missing');
    if (!Q.phone_number) throw new Error('phone is missing');
    if (!Q.location) throw new Error('location is missing');
    if (!Q.l) throw new Error('dimension L is missing');
    if (!Q.w) throw new Error('dimension W is missing');
    if (!Q.h) throw new Error('dimension H is missing');
    return {
        budget: Q.budget,
        materialSelection: Q.material_selection,
        phone: Q.phone_number,
        location: Q.location,
        isVerified: false,
        expectDimension: {
            L: Q.l,
            W: Q.w,
            H: Q.h
        }
    };
};
exports = module.exports = function (req, res) {
    var locals = {
        newPrinter: false
    };
    async.series([
        function (next) {
            console.log('[api.app.addjob]  - Creating new printer...');
            console.log('------------------------------------------------------------');
            // console.log('[api.app.signup]  - New user data:', printerData );
            try {
                locals.newPrinter = new Job.model(model_construct(req.query));
            } catch (e) {
                console.log('[api.app.addjob]  - Error from getting param data from the url request ....');
                console.log('------------------------------------------------------------');
                return next({message: e.message});
            }
            locals.newPrinter.save(function (err) {
                if (err) {
                    console.log('[api.app.addjob]  - Error saving new addjob.', err);
                    console.log('------------------------------------------------------------');
                    return next({message: 'Sorry, there was an error processing your account, please try again.'});
                }
                console.log('[api.app.addjob]  - Saved new addjob.');
                console.log('------------------------------------------------------------');
                return next();
            });
        },
        function (next) {
            //  console.log('[api.app.addjob] - Saved new addjob:' + locals.newPrinter);
            //  console.log('------------------------------------------------------------');
            return res.apiResponse({
                success: true,
                timestamp: new Date().getTime(),
                new_job_id: locals.newPrinter._id
            });
        }
    ], function (err) {
        if (err) {
            console.log('[api.app.addjob]  - Issue add new print job.', err);
            console.log('------------------------------------------------------------');
            return res.apiResponse({
                success: false,
                session: false,
                message: (err && err.message ? err.message : false) || 'Sorry, there was an issue adding your job, please try again.'
            });
        }
    });
};
