var $spacemanInner = $('#spaceman #spaceman-inner');

var expandedSubNavsSelector = ".subnav-container.collapse.in";
var collapsingSubNavsSelector = ".subnav-container.collapsing";

$(document).ready(function() {
  $('.subnav-container').on('show.bs.collapse', function(event) {

    
    $clicked = $(document).find("[href='#" + $(event.target).attr('id') + "']")
    
    /* dont allow mulitple items to collapse at the same time */
    if ($(collapsingSubNavsSelector).length > 0) {
      event.preventDefault();
      return false;
    }

    $spacemanInner.css("height", $(this).height() + "px");

    /* if a item is alredy expanded */
    if ($(expandedSubNavsSelector).length > 0) {
      $spacemanInner.addClass("collapsing");
      //this).addClass(collaspseNoAnimationClass);
      event.preventDefault();
      $(this).addClass('in');
      $clicked.attr("aria-expanded","true");

    } else {
      /* show spaceman */
      $('#spaceman').collapse('show');
    }

    /* hide other visible items */
    $(expandedSubNavsSelector).not(this).removeClass('in');
    $(".nav-link").not($clicked).attr("aria-expanded","false");

  });


  $('.subnav-container').on('hidden.bs.collapse', function() {
    //$(this).removeClass(collaspseNoAnimationClass);
    $(this).css("height", "auto");
  });

  $('.subnav-container').on('hide.bs.collapse', function() {
    /* length will be 2 if item is hidden to show another */
    if ($("." + collaspseNoAnimationClass).length == 0) {
      /* collapse spaceman */
      $('#spaceman').collapse('hide');
    }
  })

  $(window).on('resize', function() {
    SetSpacemanHeight();
  });

  $("#collapseFooterText").on("shown.bs.collapse", function() {
    $("html, body").animate({
      scrollTop: $(document).height()
    }, "fast");
  });

  $("#bigger-text").on("click", function() {
    var fontSize = parseInt($("#collapseExample").css("font-size"));
    fontSize = fontSize + 1 + "px";
    $("#collapseExample").css({
      'font-size': fontSize
    });
  });

  $("#smaller-text").on("click", function() {
    var fontSize = parseInt($("#collapseExample").css("font-size"));
    fontSize = fontSize - 1 + "px";
    $("#collapseExample").css({
      'font-size': fontSize
    });
  });

});

function SetSpacemanHeight() {

  /* if a item is expanded */
  if ($(expandedSubNavsSelector).length > 0) {

    $("#spaceman").collapse("show");

    /* if height has changed */
    if ($spacemanInner.height() != $(expandedSubNavsSelector).eq(0).height()) {
      $spacemanInner.addClass("collapsing");
      $spacemanInner.css("height", $(expandedSubNavsSelector).eq(0).height() + "px");
    }
  }
}