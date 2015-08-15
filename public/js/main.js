/* --------------------
 * - PantryCar 
 * --------------------
 */

$.PC = {};

$.PC.options = {

  screenSizes: {
    xs: 480,
    sm: 768,
    md: 992,
    lg: 1200
  }
};

/*
-------------------------------------------------------
* On DOM ready events
-------------------------------------------------------
*/

$(document).ready(function() {

  var nowDate = new Date();
  var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
  $('.date-time-picker').datepicker({
    autoclose: true,
    todayBtn: true,
    format: 'dd-mm-yyyy',
    startDate: today
  });
  /*

      -------------------------------------------------------
      Each train selection process
      -------------------------------------------------------
      */

  $('body').on('click', '.select-train-button a', function(event) {
    var form = $(document.createElement('form')).css({
      display: 'none'
    }).attr("method", "GET").attr("action", BASE_PATH + '/selectStation');
    var input = $(document.createElement('input')).attr('name', 'train_num').val($(this).data('train-code'));
    form.append(input);
    input = $(document.createElement('input')).attr('name', 'source_station').val($(this).data("source-station"));
    form.append(input);
    input = $(document.createElement('input')).attr('name', 'destination_station').val($(this).data("destination-station"));
    form.append(input);
    input = $(document.createElement('input')).attr('name', 'journey_date').val($(this).data("doj"));
    form.append(input);
    input = $(document.createElement('input')).attr('name', 'search_type').val("train_search");
    form.append(input);
    $("body").append(form);
    form.submit();
  });

  $('body').on('click', '#proceed-to-pay', function(event) {
    event.preventDefault();
    window.location.href = BASE_PATH + "/processPayment";
  });



  /* // Javascript to enable link to tabb
        var url = document.location.toString();
        if (url.match('#')) {
                $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
            } 

            // Change hash for page-reload
        $('body').on('shown.bs.tab','.nav-tabs a', function (e) {
                window.location.hash = e.target.hash;
            });/*

      /* ------------------------------------------------
       * - button loading text on click implementation
       * -------------------------------------------------
       */
  $('form').on('submit', function() {
    if ($(this).find('button[data-loading-text]').length > 0) {
      $(this).find('button[data-loading-text]').button('loading');
    }
  });

  $('.loading-text-button').on('click', function() {
    $(this).button('loading');
  });


  $('body').on('click', '.res-category .all a', function(event) {
    event.preventDefault();
    $(".res-category li ").removeClass("active");
    eClass("active");
    $(this).parent().addClass("active");
    $('#res-menu-item-container .each-menu-category-wrap').addClass('active');

  });


  $('#view-hide-order-summary').click(function() {
    if ($('#view-hide-order-summary span').hasClass('glyphicon-chevron-down')) {
      $('#view-hide-order-summary').html("Hide Order Details <span class='glyphicon glyphicon-chevron-up'></span>");
    } else {
      $('#view-hide-order-summary').html("View Order Details <span class='glyphicon glyphicon-chevron-down'></span>");
    }
  });

  if ($('#view-hide-order-summary-container').is(":visible")) {
    $("#cart-summary-container").addClass('collapse');
  }

  /* Animation starts for how it work section */
  function isElementInViewport(elem) {
    var $elem = $(elem);
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    var elemTop = Math.round($elem.offset().top);
    var elemBottom = elemTop + $elem.height();
    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
  }

  // Check if it's time to start the animation.
  function checkAnimation() {
    var $elem = $('.each-how-it-works-block');
    if (!$elem.length) {
      return;
    }
    if ($elem.hasClass('animated')) {
      return;
    }
    if (isElementInViewport($elem)) {
      $elem.addClass('animated fadeInUp');
    }
  }

  // Capture scroll events
  $(window).scroll(function() {
    if ($(window).width() > $.PC.options.screenSizes.xs) {
      checkAnimation();
    }
  });


  if(Utils.getParameterByName('login') == 1){
          bootbox.dialog({
              title: "Login",
              message: $('#pc-signin-signup-form').html()
            });
  }

  if(Utils.getParameterByName('completeDetails') == 1){

            bootbox.dialog({
                title: "Complete Details",
                message: $('#complete-journey-detail-popup').html()
            });

           $('.date-time-picker').datepicker({
                  autoclose: true,
                  todayBtn: true,
                  format: 'dd-mm-yyyy',
                  startDate: today
            });
   }
   


}); //DOM Ends