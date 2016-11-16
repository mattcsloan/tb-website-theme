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

  if($('.feature-gallery').length && $('.feature-gallery > img').length > 1) {
    buildGallery();
  }
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

$(document).on('change', '.vendor-category-dropdown', function() {
  var selectedLink = $(this).val();
  window.location.href = selectedLink;
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

$(document).on('click', '.feature-thumbs a', function() {
  var itemNum = $(this).index() + 1;
  $('.feature-images img.active').removeClass('active').fadeOut(400, function() {
    $('.feature-images img:nth-child(' + itemNum + ')').addClass('active').fadeIn(400);
    $('.feature-thumbs a.active').removeClass('active');
    $('.feature-thumbs a:nth-child(' + itemNum + ')').addClass('active');
  });
  return false;
});

// Build Image gallery for Vendor pages
function buildGallery() {
  var galleryImgs = [];

  $('.feature-gallery > img').each(function() {
    var imgSrc = $(this).attr('src');
    var imgAlt = $(this).attr('alt');
    var imgBase = imgSrc.replace(/\.[^/.]+$/, "");
    var imgExt = imgSrc.split('.').pop();
    var thumbSrc = imgBase + '-150x150.' + imgExt;
    var item = {
      "imgSrc": imgSrc,
      "imgAlt": imgAlt,
      "thumbSrc": thumbSrc
    }
    galleryImgs.push(item);
  });

  $('.feature-gallery').empty();
  $('.feature-gallery').append('<div class="feature-images"></div>');
  $('.feature-gallery').append('<div class="feature-thumbs"></div>');
  for(i=0; i<galleryImgs.length;i++) {
    $('.feature-images').append('<img src="' + galleryImgs[i].imgSrc + '" alt="' + galleryImgs[i].imgAlt + '" />');
    $('.feature-thumbs').append('<a><img src="' + galleryImgs[i].thumbSrc + '" alt="' + galleryImgs[i].imgAlt + '" /></a>');
  }

  $('.feature-images img').each(function() {
    $(this).hide();
  });
  $('.feature-images img:first-child').addClass('active').show();
  $('.feature-thumbs a:first-child').addClass('active');
}

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
    $('.menu-primary-navigation-container').hide();
  } else {
    $('.menu-primary-navigation-container').show();
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
