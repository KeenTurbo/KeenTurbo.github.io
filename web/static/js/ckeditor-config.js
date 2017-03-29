/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

    // The toolbar groups arrangement, optimized for a single toolbar row.
    config.toolbarGroups = [
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'blocks']},
        {name: 'links'},
        {name: 'insert'}
    ];

    // The default plugins included in the basic setup define some buttons that
    // are not needed in a basic editor. They are removed here.
    config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Strike,Subscript,Superscript';

    // Dialog windows are also simplified.
    config.removeDialogTabs = 'link:advanced;link:target;image:advanced;image:Link';

    config.language = 'zh-cn';

    config.filebrowserImageUploadUrl = '/uploader/upload'
};

CKEDITOR.on('dialogDefinition', function (ev) {
    ev.data.definition.resizable = CKEDITOR.DIALOG_RESIZE_NONE;

    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;
    var infoTab = dialogDefinition.getContents('info');

    if (dialogName == 'image') {
        infoTab.remove('txtHSpace');
        infoTab.remove('txtVSpace');
        infoTab.remove('txtBorder');
        infoTab.remove('cmbAlign');
        infoTab.remove('txtAlt');
    }
});