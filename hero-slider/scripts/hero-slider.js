$(document).ready(function() {

  // add slider navigation
  if($('.hero').length) {
    var numPanels = $('.hero .panel').length;
    if(numPanels > 1) {
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

  //set rotation timing of hero gallery
  var heroRotate = setInterval(function() {
    transition("hero");
  }, 10000);

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


//transitions the active element to the next element when called
function transition(elem, navJump, display) {
  // add min-height to element equal to the current height
  // this prevents the page from jumping while it hides 
  // the first panel and shows the next
  $('.' + elem).css('min-height', $('.' + elem).height());

  $('.' + elem + ' .active').hide(0, function() {
    if(!display) {
      display = 'flex';  
    }
    if(navJump) {   //if the navJump parameter has been provided - i.e. the hero nav has been called to jump to specified slide
      $(this).removeClass('active');
      // $('.slide-nav li:nth-child(' + navJump + ')').addClass('selected');
      $('.' + elem + ' .transition:nth-child(' + navJump + ')').show(0, function() {
        $(this).addClass('active');
        // remove the min-height now that the new content has loaded in
        $('.' + elem).css('min-height', 'auto');
        $('.slide-nav li:nth-child(' + navJump + ')').addClass('selected');
      }).css('display', display);
    } else {    // if no navJump parameter has been provided
      $(this).removeClass('active');
      if($(this).next().hasClass('transition')) {
        $(this).next().show(0, function() {
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
          $('.' + elem).css('min-height', 'auto');
        }).css('display', display);
      } else {
        $('.' + elem + ' .first').show(0, function() {
          $(this).addClass('active');
          if(elem == 'hero') { //if this is the hero element, we need to update the slide-nav number
            $('.slide-nav li.selected').removeClass('selected');
            $('.slide-nav li:nth-child(1)').addClass('selected');
          }
          // remove the min-height now that the new content has loaded in
          $('.' + elem).css('min-height', 'auto');
        }).css('display', display);
      }
    }

  });

}

// $(document).on('hover', '.navigation li', function(e) {
//   e.preventDefault();
// });