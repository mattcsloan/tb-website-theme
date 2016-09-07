$(document).ready(function() {
  $('.accordion h4').each(function() {
    if(!$(this).hasClass('open')) {
      $(this).next().hide();
    }
  });
  
  $('.accordion h4 a').click(function() {
    if($(this).parent().hasClass('open')) {
      $(this).parent().next().slideUp();
      $(this).parent().removeClass('open');
    } else {
      $('.accordion .open').each(function() {
        $(this).next().slideUp();
        $(this).removeClass('open');
      });

      $(this).parent().next().slideDown();
      $(this).parent().addClass('open');
    }
    return false;
  });
});