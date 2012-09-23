$(document).ready(function() {
	
	$("#FTopicBody").markItUp(mySettings);
	$("#FPostBody").markItUp(mySettings);
	$( 'textarea.inputTextArea' ).ckeditor();
	
	//Preload Images (http://stackoverflow.com/questions/476679/preloading-images-with-jquery)
	function preload(arrayOfImages) {
	    $(arrayOfImages).each(function(){
	        $('<img/>')[0].src = this;
	    });
	}
	
	preload([
		'../img/layouts/default/buttons/home_hover.png',
		'../img/layouts/default/buttons/streams_hover.png',
		'../img/layouts/default/buttons/community_hover.png',
		'../img/layouts/default/elements/content_background.png',
		'../img/layouts/default/elements/scroll_vertical.png',
		'../img/layouts/default/elements/scroll.png',
		'../img/layouts/default/elements/grunge_small.png',
		'../img/layouts/default/elements/news_background.png',
		'../img/layouts/default/background.jpg'
	]);
	
	//Portal Dropdown
	
	//Navigation Stuff
	
	//Search Bar Stuff	
	$('.searchField').attr('value', 'Search The GW2 Portal').focusin(function(){
		fieldText = $('.searchField').attr('value');
		if(fieldText == 'Search The GW2 Portal'){
		$(this).attr('value', '');
		}
	}).focusout(function(){
		fieldText = $('.searchField').attr('value');
		if(fieldText == ''){
		$(this).attr('value', 'Search The GW2 Portal');
		}
	});
	
	//Other Stuff
	$("#flashMessage").oneTime(5000, function(){
		$(this).fadeOut('5000');
	});

});