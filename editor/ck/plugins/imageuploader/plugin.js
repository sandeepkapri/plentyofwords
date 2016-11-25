CKEDITOR.plugins.add( 'imageuploader', {
    init: function( editor ) {
        editor.config.filebrowserBrowseUrl = '../ck/plugins/imageuploader/imgbrowser.php';
    }
});
