(function($, window) {
	"use strict";

  function _nav(){

    var _sidemenu = Cookies.get('nav');

    if(_sidemenu=='1'){
      $('nav').removeClass('collapsed');
      $('header').removeClass('full');
      $('section').removeClass('full');
    }else{
      $('nav').addClass('collapsed');
      $('header').addClass('full');
      $('section').addClass('full');
    }

    $('.navicon').on("click",function(){
			/*
  		if(_sidemenu=='1'){
  			Cookies.set('nav', '0', { expires: 365 });
  		}else{
  			Cookies.set('nav', '1', { expires: 365 });
  		}
			*/

  		if($('nav').hasClass('collapsed')){
  			$('nav').removeClass('collapsed');
  			$('header').removeClass('full');
  			$('section').removeClass('full');
  			$('nav ul li.current ul').css('display','block');
  			$('nav ul li.current > i').addClass('ion-ios-arrow-up');
  		}else{
  			$('nav').addClass('collapsed');
  			$('nav ul li ul').css('display','none');
  			$('nav ul li > i').removeClass('ion-ios-arrow-up');
  			$('header').addClass('full');
  			$('section').addClass('full');
  		}
  	});

  	$('nav ul li').hover(function(){
  		if($('nav').hasClass('collapsed')){
  			$(this).find('ul').slideDown();
  		}
  	},function(){
  		if($('nav').hasClass('collapsed')){
  			$(this).find('ul').slideUp();
  		}
  	});

  	$('.show-ul').on("click",function(){
  		if($(this).next().is(':visible')){
  			$(this).next().slideUp();
  			$(this).toggleClass('ion-ios-arrow-up');
  		}else{
  			$(this).next().slideDown();
  			$(this).toggleClass('ion-ios-arrow-up');
  		}
  	});

  	$('nav ul li.current > i').addClass('ion-ios-arrow-up');


		$(window).scroll(function(){

			if($('body').scrollTop()>20){
				$('header').addClass('shadow');
			}else{
				$('header').removeClass('shadow');
			}

		});


  }


  function _elements(){

    var ink, d, x, y;
  	$("a, button").click(function(e){
      if($(this).find(".ink").length === 0){
          $(this).prepend("<span class='ink'></span>");
      }

      ink = $(this).find(".ink");
      ink.removeClass("inkAnimate");

      if(!ink.height() && !ink.width()){
          d = Math.max($(this).outerWidth(), $(this).outerHeight());
          ink.css({height: d, width: d});
      }

      x = e.pageX - $(this).offset().left - ink.width()/2;
      y = e.pageY - $(this).offset().top - ink.height()/2;

      ink.css({top: y+'px', left: x+'px'}).addClass("inkAnimate");
    });

    $('[data-widget="collapse"]').on("click",function(){
  		var collapse_id = $(this).attr('data-id');
  		$('#'+collapse_id).slideToggle('fast');
  		if($(this).hasClass('ion-ios-arrow-up')){
  			$(this).removeClass('ion-ios-arrow-up');
  			$(this).addClass('ion-ios-arrow-down');
  		}else{
  			$(this).addClass('ion-ios-arrow-up');
  			$(this).removeClass('ion-ios-arrow-down');
  		}
  	});

    

  	$('[data-widget="fullscreen"]').on("click",function(){
  		var collapse_id = $(this).attr('data-id');
  		$('#'+collapse_id).toggleClass('fullscreen');
  		$(this).toggleClass('ion-arrow-shrink');
  	});


		$('[data-widget="remove"]').on("click",function(e){
      e.preventDefault();
			var _url = $(this).attr('href');
			var _text = $(this).attr('data-text');
      var isGood=confirm(_text);
       if(isGood){
        var result 	= $(this).attr('data-id').split(':');
        var rm 		= result[1];
        $('#'+rm).css('background', '#FF5F6E');
        $('#'+rm).fadeOut('slow');
        $.post(_url, { request: 'remove-'+result[0], request_id: rm }, function(data){ $('#opt-'+rm).remove(); $('#modal'+rm).remove(); });
      }else{
            return false;
       }
    });


		$('[data-widget="accept"]').on("click",function(e){
      e.preventDefault();
			var _url = $(this).attr('href');
      var result 	= $(this).attr('data-id').split(':');
      var rm 		= result[1];
      $.post(_url, { request: 'accept-'+result[0], request_id: rm }, function(data){ window.location.reload(); });
    });


		$('[data-widget="ajax"]').on("click",function(e){
			e.preventDefault();
			var ajax_id 		= $(this).attr('data-id');
			var ajax_width 	= $(this).attr('data-width');
			var ajax_href 		= $(this).attr('href');
			var ajax_overlay	= $('<div class="dialog" id="'+ajax_id+'"></div>');
			var _w = $(window).width();
			$.ajax({
	  			url: ajax_href,
	  			cache: false,
	  			beforeSend:function(xhr){
	  				ajax_overlay.appendTo('body').end().fadeIn('fast');
	  				$('#'+ajax_id).append('<div class="cssload-speeding-wheel" id="'+ajax_id+'"></div>');
	  			},
	  			success:function(html){
	  				$('#'+ajax_id+'.cssload-speeding-wheel').remove();
						if(_w>ajax_width){
							$('#'+ajax_id).append('<div class="dialog-main" style="width:'+ajax_width+';margin-left:-'+ajax_width/2+'px;">'+html+'</div>');
						}else{
								$('#'+ajax_id).append('<div class="dialog-main" style="width:100%;margin-left:-'+_w/2+'px;">'+html+'</div>');
						}
						if($('body').height()>$('div#'+ajax_id).find('.dialog-main').height()){
							var ajax_top 		= ($('body').height()-$('div#'+ajax_id).find('.dialog-main').height())/2;
							$('#'+ajax_id).find('.dialog-main').css('top',ajax_top+'px');
						}
	  			},
	  			error:function(xhr,status,error){
	  				$('#'+ajax_id+'.cssload-speeding-wheel').remove();
	  				$('#'+ajax_id).append('<div class="dialog-error"><big><i class="ion-alert-circled"></i> GREÅ KA</big><br/>'+error+'<br/><br/><a href="#" class="btn close" data-widget="close-ajax" data-id="'+ajax_id+'"><i class="ion-android-close"></i> Zatvori</a></div>');
	  			}
			});
		});
		$('body').on("click",'[data-widget="close-ajax"]',function(){
			var option_id = $(this).attr('data-id');
			$('#'+option_id).fadeOut('fast',function(){
				$(this).remove();
				window.location.reload();
			});
		});


		$("body").on('click', '#add', function() {
	 		var click_id = $(this).attr('rel');
	 		$('#'+click_id).clone(true).insertAfter('#'+click_id).find("input:text").val("").attr('required',false).end().fadeIn();
	 	});

  }


  function __ready(){

    _nav();
    _elements();




		var today = new Date();
		var startDate = new Date(today.getFullYear(), 7, 1);
		var endDate = new Date(today.getFullYear(), 8, 31);

		$('.input-date').datepicker({
			todayBtn: "linked",
			format: 'yyyy-mm-dd'
		});

		$('input[type=radio]').iCheck({
	    checkboxClass: 'icheckbox_square-blue',
	    radioClass: 'iradio_square-blue',
	    increaseArea: '20%' // optional
	  });

		$("input.num").TouchSpin({
				min: 0,
				max: 1000,
        step: 0.1,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10
		});

		$("#form").validate({
			focusCleanup: true
		});

  }


	$(document).ready(function(){
		__ready();
	});

})(jQuery, window);



/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

'use strict';

;( function( $, window, document, undefined )
{
	$( '.inputfile' ).each( function()
	{
		var $input	 = $( this ),
			$label	 = $input.next( 'label' ),
			labelVal = $label.html();

		$input.on( 'change', function( e )
		{
			var fileName = '';

			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else if( e.target.value )
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName ){
				$label.find( 'span' ).html( fileName );
        $input.addClass('success');
			}else{
				$label.html( labelVal );
        $input.removeClass('success');
      }
		});

		// Firefox bug fix
		$input
		.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
		.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
	});
})( jQuery, window, document );
