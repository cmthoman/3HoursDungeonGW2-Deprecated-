/*********************************************************************************************
 *********************************************************************************************
 * Banner Widget by chris@aswanmedia.com for 3HD Gaming
 * Chris Thoman
 * Written in JQuery for JScript
 * Style controlled by /css/adbanner.css
 * This is a no-back-end version, change slide settings via the adBanner settings variables!
 * 
 * Date: Sat August 11, 2012
 * 
 * Includes jquery.js v1.6.1 minified
 * http://www.jquery.com/
 * 
 * Includes jQuery.timers
 *********************************************************************************************
 *********************************************************************************************/

/************************************************************************************
 ************************************************************************************
 * Banner Settings
 * Control slide count, duration and transition times, set slide images and urls
 * slideCount: Number of slides to display (THIS MUST BE SET ACCURATELY)
 * showTime: Time in ms to show one slide
 * fadeTime: Speed of slide transitions in ms 
 ************************************************************************************
 ************************************************************************************/
var slideCount = 2;
var showTime = 7500;
var fadeTime = 350;

/*Slide (image) locations; slideImg[0] = slide 1, slideImg[1] = slide 2 ... etc. */
var slideImg = new Array();
/*Slide 1*/ slideImg[0] = "/img/slides/launch_beta.jpg";
/*Slide 2*/ slideImg[1] = "/img/slides/recruiting.jpg";
/*Slide 3 slideImg[2] = "/img/slides/launch_beta.jpg"; */

/*Destinations (links) for slides; slideHref[0] = slide 1, slideHref[1] = slide 2 ... etc. */
var slideHref = new Array();
/*Slide 1*/ slideHref[0] = "articles/read/1";
/*Slide 2*/ slideHref[1] = "articles/read/2";
/*Slide 3 slideHref[2] = "#"; */

/*********************************
 *********************************
 * End of adBanner Settings
 * Do Not Alter Below This Point
 *********************************
 *********************************/

/**************************************************
 **************************************************
 *-- Banner Core and Logic ---- DO NOT ALTER ---*
 **************************************************
 **************************************************/
var slide = 0;
var playState = true;
$(document).ready(
	function(){
		//Set Start Conditions and Initialize
		if(slideCount > 1){
			changeSlide();
		}
		preload();
		init();
	}
);

//Initialize adBanner
function init(){
	//Set Startup Style and Functionality
	$('#slideShowSlide').click(function(){
		window.location = slideHref[0];
	});
	$('#slideShowContainer').hover(function(){
		$(this).css('cursor', 'pointer')
	});
	$('#slideShowSlide').attr('src', slideImg[0]);
	
	//Create the Play/Pause Button and appendTo the adNavigation div
	//$("<div id='adBannerPlayPause'></div>").appendTo('#adNavigation');
	//$("<img src='http://starkey-products.com/adbanner/img/pause.gif' id='adBannerPlayPauseButton'/>").appendTo('#adBannerPlayPause');
	//$('#adBannerPlayPause').click(function(){
		//if(playState == false){
			//play();
		//}else{
			//pause();
		//};
	//});
	
	/* Create Slide Navigation Buttons
	 * "$(array).each(dosomething(){})" is a JQuery foreach loop. Refference the slideImg array and include the index of each value to numerate the buttons
	 * Using appendTo, create a button div inside the adNavigation div containing the slide number and button functionality*/
	$(slideImg).each(function(index) {
		i = index + 1;
		$("<div class='slideShowButton' id='slideShowButton"+i+"'></div>").appendTo('#slideShowNavigation');
		$("#slideShowButton"+i).click(function(){
			$('.slideShowButton').css({'font-weight' : 'normal', 'background-color' : '#cdcdcd'});
			$(this).css({'font-weight' : 'bold', 'background-color' : '#FFFFFF'});
			$('#slideShowSlide').attr('src', slideImg[index]);
			slide = index;
			$('#slideShowSlide').click(function(){
				window.location = slideHref[index]
			});
			pause();
			$(this).oneTime(10000, function(){
				play();
			});
		});
	});
	//Set Button 1 Style on init() after building the navigation
	$('#slideShowButton1').css({'font-weight' : 'bold', 'background-color' : '#FFFFFF'});
}
//Slide Play Loop
function changeSlide(){
	if(playState = true && slideCount > 1){
		$('#slideShowSlide').oneTime(showTime, function(){
			$(this).stop().fadeOut(fadeTime);
			$(this).oneTime(fadeTime+100, function(){
				slide = (slide+1)%slideCount;
				$(this).attr('src', slideImg[slide]);
				$(this).click(function(){
					window.location = slideHref[slide]
				});
				$(this).stop().fadeIn(fadeTime);
				$('.slideShowButton').css({'font-weight' : 'normal', 'background-color' : '#cdcdcd'});
				buttonId = slide + 1;
				$('#slideShowButton'+buttonId).css({'font-weight' : 'bold', 'background-color' : '#FFFFFF'});
				changeSlide();
			});
		});
	};
}

//Pause
function pause(){
	playState = false;
	$('#slideShowSlide').stopTime();
	$('#slideShowPlayPauseButton').attr('src', 'img/play.gif');
}

//Play
function play(){
	$('#slideShowSlide').stopTime();
	playState = true;
	$('#slideShowPlayPauseButton').attr('src', 'img/pause.gif');
	changeSlide();
}

//Preload Images for the Banner
function preload() {
    $(slideImg).each(function(){
        $('<img/>')[0].src = this;
    });
}

/**************************************************
 **************************************************
 *--      END OF Banner Core and Logic --         *
 **************************************************
 **************************************************/
