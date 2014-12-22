/**
 * Created by hesk on 12/14/14.
 */

var keystone = require('keystone'),
    Types = keystone.Field.Types,
    Maker = new keystone.List('Maker', {
        nocreate: false,
        noedit: false
    });
Maker.add({
    makerName: { type: Types.Relationship, ref: 'User', required: true, initial: true},
    phone: { type: String },
    apiKey: { type: String },
    location: { type: Types.Location },
    machine: { type: Types.Relationship, ref: 'Printer' },
    message: { type: Types.Markdown  },
    createdAt: { type: Date, default: Date.now },
    machineReady: { type: Boolean, default: false }
});
Maker.defaultColumns = 'machine|20%, makerName, phone|5%, machineReady';
Maker.register();