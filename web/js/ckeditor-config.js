/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'links' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
    config.removeButtons = 'Subscript,Superscript,Strike,Table,HorizontalRule,SpecialChar,Anchor';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:Link;image:advanced';

    config.language = 'zh-cn';

    config.removePlugins = 'elementspath,resize,magicline';

    config.linkShowAdvancedTab = false;

    config.linkShowTargetTab = false;

    config.filebrowserImageUploadUrl = '/uploader/upload';
};
