/**
 * Created by hesk on 12/16/14.
 */
//https://github.com/JedWatson/sydjs-site/tree/master/routes
var async = require('async'),
    moment = require('moment'),
    keystone = require('keystone'),
    Maker = keystone.list('Maker'),
    Printer = keystone.list('Printer'),
    User = keystone.list('User'),
    Job = keystone.list('Job');

exports = module.exports = function (req, res) {
    var stats = {};
    async.parallel([
        /* function(next) {
         Maker.model.findOne()
         .where('startDate').gte(moment().startOf('day').toDate())
         .where('state', 'published')
         .sort('startDate')
         .exec(function(err, meetup) {

         RSVP.model.count({
         meetup: meetup,
         attending: true
         })
         .exec(function(err, count) {
         stats.rsvps = count;
         return next();
         });
         });
         },*/
        function (next) {
            User.model.count()
                .exec(function (err, count) {
                    stats.members = count;
                    return next();
                });
        },
        function (next) {
            Job.model.count()
                .exec(function (err, count) {
                    stats.job_posts = count;
                    return next();
                });
        }
    ],
        function (err) {
            return res.apiResponse(stats);
        });
}

