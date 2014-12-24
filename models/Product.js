/**
 * Created by Hesk on 22/12/2014.
 */

var keystone = require('keystone'),
    crypto = require('crypto'),
    Types = keystone.Field.Types;

var Product = new keystone.List('Product', {
    autokey: {path: 'slug', from: '_id', unique: true},
    map: {name: 'name'},
    defaultSort: '-createdAt'
});

var current_date = (new Date()).valueOf().toString();
var random = Math.random().toString();
var h1 = crypto.createHash('sha1').update(current_date + random + "2").digest('hex');
var h2 = crypto.createHash('sha1').update(current_date + random + "1").digest('hex');

Product.add({
        name: {type: String, required: true, initial: true},
        publishedDate: {type: Types.Date, noedit: true}
    },
    'Inventory', {
        limitEdition: {type: Boolean, default: false},
        stock: {type: Types.Number, format: false, label: 'the total stock in extension'}
        // extension: {type: Types.nested, noEdit: true}
    },
    'Version', {
        ver: {type: String, default: '0.0.1'},
        releaseDate: {type: Types.Date, noedit: true}
    }
);
//Product.relationship({ref: 'License', path: 'products'});
Product.defaultColumns = 'name|50%, ver|10%, releaseDate|20%, stock|20%';
Product.schema.pre('save', function (next) {
    if (this.isModified('ver') || !this.releaseDate) {
        this.releaseDate = new Date();
    }
    /*if (this.isPublished() && !this.publishedDate) {
     this.publishedDate = new Date();
     }*/
    /* if (this. == "") {
     this.createdAt = new Date();
     this.key = crypto.createHash('md5').update(value.toLowerCase().trim()).digest('hex');
     this.licenseHash = crypto.createHash('md5').update(value.toLowerCase().trim()).digest('hex');
     }*/
    next();
});
Product.register();
