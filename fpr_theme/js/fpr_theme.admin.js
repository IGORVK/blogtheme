jQuery(document).ready(function($){

    // Uploading files
    var mediaUploader;

    $( '#upload-button' ).on('click', function (e) {
       e.preventDefault();

        // If the media frame already exists, reopen it.
       if( mediaUploader ){
           mediaUploader.open();
           return;
       }

        // Create the media frame.
       mediaUploader = wp.media.frames.file_frame = wp.media({
           title: 'Choose a Profile Picture',
           button: {
               text: 'Choose Picture'
           },
           multiple: false // Set to true to allow multiple files to be selected
       });

        // When an image is selected, run a callback.
       mediaUploader.on('select', function () {
          attachment = mediaUploader.state().get('selection').first().toJSON();


           // Do something with attachment.id and/or attachment.url here
          $( '#profile-picture' ).val(attachment.url)
           $( '#profile-picture-preview' ).css('background-image' , 'url(' + attachment.url + ')');
       });

       mediaUploader.open();

    });


    $('#remove-picture').on('click', function (e) {
       e.preventDefault();
       var answer = confirm("Are you sure you want to remove your Profile Picture?");
        if( answer == true ){
            $('#profile-picture').val('');
            $('.fpr_theme-general-form').submit();
        }
        return;
    });
});
