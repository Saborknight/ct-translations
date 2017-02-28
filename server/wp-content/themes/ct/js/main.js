var interval_logos;

jQuery(window).load(function($){

	BgInterval = setInterval(ChangeBg, 3000);

});

jQuery(document).ready(function($) {

	$('#language ul li.active').on("click", function() {
		if (!$(this).hasClass("open")){
			$(this).addClass("open");
			$("#language ul").children().each(function() {
				if(!$(this).hasClass("active")){
					$(this).slideToggle(150);
				}
			});
		}
		else {
			$(this).removeClass("open");
			$("#language ul").children().each(function() {
				if(!$(this).hasClass("active")){
					$(this).slideToggle(150);
				}
			});
		}
		return false;		
	});

	var totalwidth = $(window).width();
	var offset = 0;
	var countLeft = 0;
	var countRight = ($('#clients_scrollable ul').width() - $('#clients_scrollable').width())/200;
	var logosVisible = ($('#clients_scrollable').width())/200;

	$( window ).resize(function() {
		$('#clients_scrollable ul').css('margin-left', 0 + 'px');
		countRight = ($('#clients_scrollable ul').width() - $('#clients_scrollable').width())/200;
		logosVisible = ($('#clients_scrollable').width())/200;
		offset = 0;
	});

	interval_logos = setInterval(function(){$('.clients_btn.right').click();},5000);

	$('.clients_btn').on("click", function(){
		clearInterval(interval_logos);

		if($(this).hasClass('right')){
			if(countRight < logosVisible){
				if(countRight == 0){
					offset = 0;
					countRight += countLeft;
					countLeft = 0;
				}
				else{
					offset += countRight*200
					countLeft += countRight;
					countRight -= countRight;
				}
			}
			else{
				offset += logosVisible*200;
				countRight -= logosVisible;
				countLeft += logosVisible;
			}
		}
		else{
			if(countLeft < logosVisible){
				if(countLeft == 0){
					offset = $('#clients_scrollable ul').width() - (logosVisible*200);
					countLeft += countRight;
					countRight = 0;
				}
				else{
					offset -= countLeft*200;
					countRight += countLeft;
					countLeft -= countLeft;
				}
			}
			else{
				offset -= logosVisible*200;
				countLeft -= logosVisible;
				countRight += logosVisible;
			}
		}
		$('#clients_scrollable ul').animate(
			{'margin-left': '-' + offset + 'px'},
			'slow'
		);
		interval_logos = setInterval(function(){$('.clients_btn.right').click();},5000);
	});

	$('#menu_show').click(function(){
		if($(this).hasClass('open')){
			$('.menu ul').slideUp(500);
			$(this).removeClass('open');
		} else {
			$('.menu ul').slideDown(500);
			$(this).addClass('open');
		}
	});
	
	$('#bottom_button').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 500);
	});
});

function ChangeBg($){
	(function($) {
		// If not on homepage, exit and stop the interval loop!
		if( $('body.home').length === 0 ) {
			clearInterval(BgInterval);
			console.log('Not on Homepage, returning peacefully');

			return;
		}

		$current = $('#backgrounds').find('.active');
		$first = $('#backgrounds').children('.bg').first();
		$next = $current.next();

		$ID = $current.attr('id').substr(11);

		if($next.length != 0) {
			$next.addClass('active').css('z-index', Number($ID)-1);
		} else {
			$first.addClass('active').css('z-index', Number($ID)-1);
		}

		$current.css('z-index', $ID).addClass('fadeOut').delay(2500).queue(function(next){
			$(this).removeClass('fadeOut active');
			
			if($next.length != 0) {
				$next.removeAttr('z-index');
			} else {
				$first.removeAttr('z-index');
			}
			next();
		});

	})(jQuery);
}
