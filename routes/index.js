/**
 * This file is where you define your application routes and controllers.
 *
 * Start by including the middleware you want to run for every request;
 * you can attach middleware to the pre('routes') and pre('render') events.
 *
 * For simplicity, the default setup for route controllers is for each to be
 * in its own file, and we import all the files in the /routes/views directory.
 *
 * Each of these files is a route controller, and is responsible for all the
 * processing that needs to happen for the route (e.g. loading data, handling
 * form submissions, rendering the view template, etc).
 *
 * Bind each route pattern your application should respond to in the function
 * that is exported from this module, following the examples below.
 *
 * See the Express application routing documentation for more information:
 * http://expressjs.com/api.html#app.VERB
 */

var _ = require('underscore'),
    keystone = require('keystone'),
    middleware = require('./middleware'),
    importRoutes = keystone.importer(__dirname);

// Common Middleware
keystone.pre('routes', middleware.initLocals);
keystone.pre('render', middleware.flashMessages);

// Import Route Controllers
var routes = {
    views: importRoutes('./views'),
    api_register: importRoutes('./api/register'),
    license: importRoutes('./api/license'),
    download: importRoutes('./download')
};

// Setup Route Bindings
exports = module.exports = function (app) {
    // Views
    app.get('/', routes.views.index);
    app.get('/register/machine/', routes.views.blog);
    //app.get('/blog/post/:post', routes.views.post);
    // app.get('/ticket/:tid', routes.views.ticket);
    app.get('/gallery', routes.views.gallery);
    app.all('/contact', routes.views.contact);


    app.get('/download/users', routes.download.users);
    app.post('/api/register/addjob', routes.api_register.addjob);
    app.post('/api/license/checklicense', routes.license.checklicense);

    // app.all('/api/me/register', routes.api.register); dsfsdf
    // NOTE: To protect a route so that only admins can see it, use the requireUser middleware:
    // app.get('/protected', middleware.requireUser, routes.views.protected);


    // app.all('/me', routes.views.me);
    // API
    // app.all('/me*', middleware.requireUser);

    // API - App
    /*

     app.all('/api/app/status', routes.api.app.status);
     app.all('/api/app/rsvp', routes.api.app.rsvp);
     app.all('/api/app/signin-email', routes.api.app['signin-email']);
     app.all('/api/app/signup-email', routes.api.app['signup-email']);
     app.all('/api/app/signin-service', routes.api.app['signin-service']);
     app.all('/api/app/signin-service-check', routes.api.app['signin-service-check']);
     app.all('/api/app/signin-recover', routes.api.app['signin-recover']);

     */


    // API
    // app.get('/api*', keystone.initAPI);
    // app.get('/api/me/profile', routes.api.me.profile);
    // app.all('/api/stats', routes.api.stats);


};
