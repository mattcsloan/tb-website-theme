/*
 * Attaches the image uploader to the input field
 */

 var $ = jQuery;
$(document).ready(function($){

  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;

  // Runs when the image button is clicked.
  $(document).on('click', '#vendor-logo-button', function(e){

    // Prevents the default action from occuring.
    e.preventDefault();

    // If the frame already exists, re-open it.
    if ( meta_image_frame ) {
      meta_image_frame.open();
      return;
    }

    // Sets up the media library frame
    meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
      title: meta_image.title,
      button: { text:  meta_image.button },
      library: { type: 'image' }
    });

    // Runs when an image is selected.
    meta_image_frame.on('select', function(){

      // Grabs the attachment selection and creates a JSON representation of the model.
      var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

      // Sends the attachment URL to our custom image input field.
      $('#vendor-logo').val(media_attachment.url);
      $('#vendor-logo-img').attr('src', media_attachment.url);
      // displayDeleteButton();
    });

    // Opens the media library frame.
    meta_image_frame.open();
  });

  // displayDeleteButton();

  $(document).on('click', '#vendor-logo-image-delete', function() {
      $('#vendor-logo').val('');
      $('#vendor-logo-img').attr('src', '');
      // displayDeleteButton();
  });
});

function displayDeleteButton() {
  var imgLink = $('#vendor-logo').val();
  if(!imgLink || imgLink === '') {
    $('#media-delete-btn-3').hide();
  } else {
    $('#media-delete-btn-3').show();
  }
}