/**
 * Created by Hesk on 14年12月16日.
 */

var keystone = require('keystone'),
    crypto = require('crypto'),
    Types = keystone.Field.Types;

var License = new keystone.List('License', {
    nocreate: false,
    noedit: false
});

var current_date = (new Date()).valueOf().toString();
var random = Math.random().toString();
var h1 = crypto.createHash('sha1').update(current_date + random + "2").digest('hex');
var h2 = crypto.createHash('sha1').update(current_date + random + "1").digest('hex');
//http://stackoverflow.com/questions/18221473/mongoosejs-modify-document-during-pre-hook
//http://stackoverflow.com/questions/21767093/how-override-this-in-the-mongoose-schema-prevalidate-middleware
License.add({
    clientID: {type: String, initial: true, required: true},
    siteURL: {label: "Site URL Without WWW", type: String, initial: true, required: true},
    licensePerson: {type: Types.Relationship, ref: 'User', label: "License Issued By"},
    product: {type: Types.Relationship, ref: 'Product', label: "Licensed Product"},
    createdAt: {type: Date, default: Date.now, noedit: true, label: "Issue Date"},
    expire: {type: Date, default: new Date(), label: "Product Expiration"}
}, 'DRM protection implementation', {
    brandingRemoval: {type: Boolean, default: false},
    demoDisplay: {type: Boolean, default: true},
    useExpiration: {type: Boolean, default: true, label: "Apply Expiration Date"},
    licenseStatusLive: {type: Boolean, default: false}
}, 'Secrets keys', {
    key: {label: "License Key", type: String, default: h1},
    licenseHash: {type: String, default: h2}
});
License.defaultColumns = 'product|20%, licensePerson|20%, licenseStatusLive|20%, createdAt|30%';
License.schema.pre('save', function (next) {
    if (this.isModified('key') && this.isPublished() && !this.createdAt) {
        this.createdAt = new Date();
    }
    /*  if (this. == "") {
     this.createdAt = new Date();
     this.key = crypto.createHash('md5').update(value.toLowerCase().trim()).digest('hex');
     this.licenseHash = crypto.createHash('md5').update(value.toLowerCase().trim()).digest('hex');
     }*/
    next();
});

License.register();