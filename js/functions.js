jQuery(document).ready(function($){
  "use strict";
	var sidebar = $(".sidebar-1").html();
	var blogArea = $(".blog-area").html();

    $(window).scroll(function() {
        if($(this).scrollTop() > 350){
            $('#goTop').stop().animate({
                left: '38px'    
                }, 500);
        }
        else{
            $('#goTop').stop().animate({
               left: '-38px'    
            }, 500);
        }
    });

    $('#goTop').click(function() {
        $('html, body').stop().animate({
           scrollTop: 0
        }, 500, function() {
           $('#goTop').stop().animate({
               bottom: '-100px'    
           }, 500);
        });
    });

    // if admin bar is present or not
    // different height we will use
    var calcTop = 100;
    var calcTopPX = '100px';
    if($('body').hasClass('admin-bar'))
    {
      calcTop = 146;
      calcTopPX = '146px';

      $('.mobile-search, .mobile-menu').css({
        top: '146px'
      });
    }
    
    $(window).scroll(function() {
        if($(this).scrollTop() > calcTop){
            $('.mobile-search, .mobile-menu').css({
              position: 'fixed',
              top: 0
            });
        }
        else{
            $('.mobile-search, .mobile-menu').css({
               position: 'absolute',
               top: calcTopPX 
            });
        }
    });


    $('.search-icon, .mobile-search').click(function(){
      $(this).toggleClass('open-searchform');
      $(this).toggleClass('close-searchform');

      if($('.search-icon i, .mobile-search i').hasClass('fa-search')){
        $('.search-icon i, .mobile-search i').removeClass('fa-search');
        $('.search-icon i, .mobile-search i').addClass('fa-times');
      } else if ($('.search-icon i, .mobile-search i').hasClass('fa-times')) {
        $('.search-icon i, .mobile-search i').removeClass('fa-times');
        $('.search-icon i, .mobile-search i').addClass('fa-search');
      }
    });

    $(".search-icon, .mobile-search").click(function(){
      $(".search-form").slideToggle(300);
      //$(this).find(".search-input").focus();
    });

    $('.open-searchform').click(function(){
        $('html, body').stop().animate({
           scrollTop: 0
        });
    });


    // Mobile navigation
    $(".mobile-menu").click(function(){
      $(".mobile-navigation").slideToggle(300);
    });

    $('.mobile-menu').click(function(){
      $(this).toggleClass('open-menu');
      $(this).toggleClass('close-menu');

      if($('.mobile-menu i').hasClass('fa-bars')){
        $('.mobile-menu i').removeClass('fa-bars');
        $('.mobile-menu i').addClass('fa-times');
      } else if ($('.mobile-menu i').hasClass('fa-times')) {
        $('.mobile-menu i').removeClass('fa-times');
        $('.mobile-menu i').addClass('fa-bars');
      }
    });

    $('.open-menu').click(function(){
        $('html, body').stop().animate({
           scrollTop: 100
        });
    });
 

	$(".navbar-toggle").on("click", function () {
		$(this).toggleClass("active");
	});


  // comments
  $("footer.comment-meta").addClass("col-xs-4");
  $(".comment-body").addClass("row comment main-comment");
  $(".comment-content").addClass("col-xs-8 comment-content");

  /**
   * make every form on the page 
   * bootstrap forms
   */
  //$('button, input[type=submit], .button').addClass('btn btn-default');

  /**
   * Add Reply icon to Reply linnk in comment section
   */
  var majaleCommentReplyLink = $('.comment-reply-link').html();
  majaleCommentReplyLink =  '<i class="fa fa-reply"></i> ' + majaleCommentReplyLink;
  $('.comment-reply-link').html(majaleCommentReplyLink);

  $('.comment-respond').addClass('comment-form padding-15');
  $('#cancel-comment-reply-link').html('<i class="fa fa-times"></i>');
  $('.comment-awaiting-moderation').addClass('alert alert-info');


  /**
   * remove div with single-post-metadata
   * pages don't have tags or categories
   * so we don't need that section.
   */
  if ( $().hasClass('single-post-metadata'))
    if ( $('.single-post-metadata').html().trim() == "")
      $('.single-post-metadata').replaceWith();
  // calcute font size for post title in front page based on width and heigh of the box
  // $(".caption").fitText(1, { minFontSize: '20px', maxFontSize: '50px' })
  
  // product quick view
  $(".woocommerce div.products li.product, .woocommerce-page div.products div.product").hover(function(){
    var majaleClass = $(this) + ' .quick-view';
    $(this).find('.quick-view').animate({top: '15%', opacity: 1}, 500);
  }, function(){
    $(this).find('.quick-view').animate({top: '-15%', opacity: 0}, 500);
  });

  // initiating bootstrap tooltip
  $('[data-toggle="tooltip"]').tooltip();

  $.ajaxSetup({cache:false});
  $(".quick-view").click(function(){
      $('.modal').modal();
      var majaleProductLink = $(this).data('href') + '?ajax=1';

      $(".modal-content .modal-title").html($(this).data("title"));
      $(".modal-content .modal-body").html('<p class="text-center"><i class="fa fa-spinner fa-pulse"></i> ' + $(this).data("loading") + '</p>');
      $(".modal-content .modal-footer a").attr('href', $(this).data("href"));
      $(".modal-content .modal-body").load(majaleProductLink);
      return false;
  });

  var majalePriceFilter = $('.woocommerce .widget_price_filter .price_slider_amount .button').html();
  majalePriceFilter = '<i class="fa fa-filter"></i> ' + majalePriceFilter;
  $('.woocommerce .widget_price_filter .price_slider_amount .button').html(majalePriceFilter);

  $('input[type=search]').focusin(function(){
    $(this).removeAttr('placeholder');
  });

  $('input[type=search]').focusout(function(){
    $(this).attr('placeholder', $(this).data("placeholder"));
  });

  if($('div').hasClass('mega-menu-wrap')) {
    $('.mobile-menu').hide();
    $('.main-navigation').show();
  }

  // set default table style to Bootstrap table style
  $('table').addClass('table');
});