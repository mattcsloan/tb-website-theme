/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;

  // Runs when the image button is clicked.
  $(document).on('click', '.image-upload-button', function(e){

    console.log($(this).attr('id'));

    // Prevents the default action from occuring.
    e.preventDefault();

    var meta_image = $(this).attr('id');

    var nextInput = $(this).next().attr('id');

    var nextImg = $(this).next().next().attr('id');

    var testInput = $('#' + nextInput);

    var testImg = $('#' + nextImg);

      console.log(nextInput);
      console.log(nextImg);

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


      testInput.val(media_attachment.url);
      testImg.attr('src', media_attachment.url);

    });

    // Opens the media library frame.
    meta_image_frame.open();
  });
});