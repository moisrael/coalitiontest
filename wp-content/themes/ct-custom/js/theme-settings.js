jQuery(document).ready(function ($) {

    // For logo upload
    let mediaUploader, fileURL, fileName;
	
    $('#upload-button').on('click', event => {
        event.preventDefault();
        if( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Website Logo',
            button: {
                text: 'Select'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function(){
            attachment = mediaUploader.state().get('selection').first().toJSON();
            fileURL = attachment.url;
            fileName = fileURL.substring(fileURL.lastIndexOf('/') + 1);
            $('#website-logo').val(fileURL);
            $('#file-name').html(fileName);
        });
        
        mediaUploader.open();
        
    });
});