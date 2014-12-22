/**
 * Created by hesk on 12/13/14.
 */
var keystone = require('keystone'),
    Types = keystone.Field.Types;

/**
 * PostCategory Model
 * ==================
 */

var Country = new keystone.List('Country', {
    autokey: { from: 'name', path: 'key', unique: true }
});

Country.add({
        name: { type: String, required: true }},
    'Country Flag', {
        image: { type: Types.CloudinaryImage }
    }
);
Country.relationship({ ref: 'Printer', path: 'countries' });


Country.register();
