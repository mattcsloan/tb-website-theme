$(document).ready(function() {
  $('.accordion h4').each(function() {
    if(!$(this).hasClass('open')) {
      $(this).next().hide();
    }
  });

  hideMenuForMobile();

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

$(document).on('hover', '.navigation li', function(e) {
  e.preventDefault();
});

$(document).on('click', '.menu-link', function() {
  if($(this).hasClass('opened')) {
    $(this).next().slideUp();
    $(this).removeClass('opened');
  } else {
    $(this).next().slideDown();
    $(this).addClass('opened');
  }
  return false;
});

// check any link starting with # and scroll page to that anchor
$(document).on('click', 'a[href^="#"]', function() {
  if($(this).attr('href') === "#") {
    var target = '';
    var elem = $('body');
  } else {
    var target = $(this).attr('href').split('#')[1];
    var elem = $('a[name="' + target + '"]');
  }
  scrollToDiv(elem);

  // if($(this).parent().hasClass('page-nav')) {
  //   var thisParent = $(this).parent();
  //   $('.active', thisParent).removeClass('active');
  //   $(this).addClass('active');
  // }

  return false;
});

function scrollToDiv(element) {
  var offset = element.offset();
  if($('body').hasClass('scrolled')) {
    var offsetTop = offset.top - 50;
  } else {
    var offsetTop = offset.top - 82;
  }
  $('body, html').animate({
    scrollTop: offsetTop
  }, 500);
}

function hideMenuForMobile() {
  if($(window).width() < 600) {
    $('.menu-main-navigation-container').hide();
  } else {
    $('.menu-main-navigation-container').show();
  }
}

var rtime = new Date(1, 1, 2000, 12,00,00);
var timeout = false;
var delta = 100;

$(window).resize(function() {
  rtime = new Date();
  if (timeout === false) {
    timeout = true;
    setTimeout(resizeend, delta);
  } 
});

function resizeend() {
  if (new Date() - rtime < delta) {
    setTimeout(resizeend, delta);
  } 
  else {
    timeout = false;
    hideMenuForMobile();
  }
}
