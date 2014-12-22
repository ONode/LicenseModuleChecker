/**
 * Created by hesk on 12/13/14.
 */
var keystone = require('keystone'),
    Types = keystone.Field.Types;

/**
 * PostCategory Model
 * ==================
 */

var Company = new keystone.List('Company', {
    autokey: { from: 'name', path: 'key', unique: true }
});
Company.add({
        name: { type: String },
        url: { type: Types.Url }
    },
    'Company Logo', {
        image: { type: Types.CloudinaryImage }
    }
);
Company.relationship({ ref: 'Printer', path: 'companies' });
Company.register();
