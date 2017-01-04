$(document).ready(function() {
  $('.accordion h4').each(function() {
    if(!$(this).hasClass('open')) {
      $(this).next().hide();
    }
  });

  var windowWidth = $(window).width();
  hideMenuForMobile(windowWidth, true);

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

  var galleryItems = $('.feature-gallery > img').length;
  if($('.feature-video').length) {
    galleryItems++;
  }
  if($('.feature-gallery').length && galleryItems > 1) {
    buildGallery();
  }

  // Responsive YouTube/Vimeo Videos
  var $allVideos = $('iframe[src^="https://www.youtube.com/embed"], iframe[src^="https://player.vimeo.com/video"]');
  // Figure out and save aspect ratio for each video
  $allVideos.each(function() {
    $(this).data('aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');
  });
  
  if($allVideos.length) { // only run this resize script if there are videos to resize
    $(window).resize(function() {
      var newWidth = $allVideos.parent().width();
      // Resize all videos according to their own aspect ratio
      $allVideos.each(function() {
        $(this).width(newWidth).height(newWidth * $(this).data('aspectRatio'));
      });
    // Kick off one resize to fix all videos on page load
    }).resize();
  }

  // Hide Request A Quote Form
  $('.request-quote').hide();

  // add slider navigation
  if($('.hero').length) {
    var numPanels = $('.hero .panel').length;
    if(numPanels > 1) {

      //set rotation timing of hero gallery
      var heroRotate = setInterval(function() {
        transition("hero");
      }, 8000);

      $('.hero').append('<ul class="slide-nav"></ul>');
      for(i=1;i<=numPanels;i++) {
        $('.slide-nav').append('<li><a href="#">' + i + '</a></li>');
      }
      $('.hero').append('<a class="prev-slide-nav" href="#"></a>');
      $('.hero').append('<a class="next-slide-nav" href="#"></a>');
    }
  }

  $('.hero').each(function() {
    $('.panel', this).each(function(index) {
      // remove any 'active' classes from panels that may have been manually added accidentally
      if($(this).hasClass('active')) {
        $(this).removeClass('active');
      }
      $(this).addClass('transition');

      // add active class to first panel so it displays
      if(index == 0) {
        $(this).addClass('first').addClass('active');
      }

    });
  });

  //add selected class to first indicator
  $('.slide-nav li').each(function(i) {
    if(i == 0) {
      $(this).addClass('selected');
    }
  });

  $('.slide-nav a').click(function() {
    var numSlide = $(this).parent().index() + 1;
    clearInterval(heroRotate);
    transition("hero", numSlide);
    $('.slide-nav li.selected').removeClass('selected');
    $(this).parent().addClass('selected');
    return false;
  });

  $('.next-slide-nav').click(function() {
    clearInterval(heroRotate);
    transition('hero');
    return false;
  });

  $('.prev-slide-nav').click(function() {
    $('.slide-nav li').each(function(i) {
      if($(this).hasClass('selected')) {
        $('.slide-nav li.selected').removeClass('selected');
        var currentSlide = i;
        clearInterval(heroRotate);
        if(currentSlide == 0) {
          var numPanels = parseInt($('.hero .panel').length);
          transition('hero', numPanels);
        } else {
          transition('hero', currentSlide);
        }
      }
    });
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

$(document).on('click', '.request-quote-btn', function() {
  // Fill in Vendor Name textbox on Request A Quote form
  // if($('.quote-request-vendor-name')) {
  //   var vendorName = $('.vendor-name').html();
  //   console.log(vendorName);
  //   $('.quote-request-vendor-name').val(vendorName);
  // }
  $('.request-quote').show();
  scrollToDiv($('a[name="request-quote-form"]'));
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
  $('.feature-images .active').removeClass('active').fadeOut(400, function() {
    $('.feature-images *:nth-child(' + itemNum + ')').addClass('active').fadeIn(400);
    $('.feature-thumbs a.active').removeClass('active');
    $('.feature-thumbs a:nth-child(' + itemNum + ')').addClass('active');
  });
  return false;
});

// Build Image gallery for Vendor pages
function buildGallery() {
  var galleryImgs = [];
  var featureVideo = ''
  if($('.feature-video').length) {
    var featureVideo = $('.feature-video')[0].outerHTML;
  }

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
  if(featureVideo !== '') {
    $('.feature-images').append(featureVideo);
  }
  $('.feature-gallery').append('<div class="feature-thumbs"></div>');


  for(i=0; i<galleryImgs.length;i++) {
    $('.feature-images').append('<img src="' + galleryImgs[i].imgSrc + '" alt="' + galleryImgs[i].imgAlt + '" />');
    $('.feature-thumbs').append('<a><img src="' + galleryImgs[i].thumbSrc + '" alt="' + galleryImgs[i].imgAlt + '" /></a>');
  }

  $('.feature-images img').each(function() {
    $(this).hide();
  });
  if(featureVideo !== '') {
    $('.feature-video').addClass('active');
    $('.feature-thumbs').prepend('<a class="feature-video-thumb active"></a>');
  } else {
    $('.feature-images img:first-child').addClass('active').show();
  }
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

function hideMenuForMobile(windowWidth, load) {
  if(!$(document).data('resize-width')) {
    $(document).data('resize-width', windowWidth);
  }
  var existingWidth = $(document).data('resize-width');
  var newWidth = $(document).width();
  if(existingWidth !== newWidth || load) {
    if($(window).width() < 600) {
      $('.menu-primary-navigation-container').hide();
      $('.menu-link').removeClass('opened');
    } else {
      $('.menu-primary-navigation-container').show();
      $('.menu-link').addClass('opened');
    }
  }
  $(document).data('resize-width', newWidth);
}

//transitions the active element to the next element when called
function transition(elem, navJump, display) {
  // add min-height to element equal to the current height
  // this prevents the page from jumping while it hides 
  // the first panel and shows the next
  $('.' + elem).css('min-height', $('.' + elem).height());

  $('.' + elem + ' .active').animate({ opacity: 0 }, 200, function() {
    if(!display) {
      display = 'flex';  
    }
    if(navJump) {   //if the navJump parameter has been provided - i.e. the hero nav has been called to jump to specified slide
      $(this).removeClass('active');
      // $('.slide-nav li:nth-child(' + navJump + ')').addClass('selected');
      $('.' + elem + ' .transition:nth-child(' + navJump + ')').animate({ opacity: 1 }, 200, function() {
        $(this).addClass('active');
        // remove the min-height now that the new content has loaded in
        $('.' + elem).css('min-height', 0);
        $('.slide-nav li:nth-child(' + navJump + ')').addClass('selected');
      });
    } else {    // if no navJump parameter has been provided
      $(this).removeClass('active');
      if($(this).next().hasClass('transition')) {
        $(this).next().animate({ opacity: 1 }, 200, function() {
          $(this).addClass('active');
          if(elem == 'hero') { //if this is the hero element, we need to update the slide-nav number
            $('.slide-nav li.selected').removeClass('selected');
            $('.panel').each(function() {
              if($(this).hasClass('active')) {
                var currentSlide = $(this).index() + 1;
                $('.slide-nav li:nth-child(' + currentSlide + ')').addClass('selected');
              }
            });
          }
          // remove the min-height now that the new content has loaded in
          $('.' + elem).css('min-height', 0);
        });
      } else {
        $('.' + elem + ' .first').animate({ opacity: 1 }, 200, function() {
          $(this).addClass('active');
          if(elem == 'hero') { //if this is the hero element, we need to update the slide-nav number
            $('.slide-nav li.selected').removeClass('selected');
            $('.slide-nav li:nth-child(1)').addClass('selected');
          }
          // remove the min-height now that the new content has loaded in
          $('.' + elem).css('min-height', 0);
        });
      }
    }

  });
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
    var windowWidth = $(window).width();
    hideMenuForMobile(windowWidth);
  }
}
