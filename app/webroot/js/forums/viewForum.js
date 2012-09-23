$(document).ready(function(){
	$(".paginationPage:not(:has(a))").removeClass('paginationPage').addClass('paginationPageSelected');
	$(".paginationPage").mouseover(function(){
		$(this).removeClass('paginationPage').addClass('paginationPageSelected').css('cursor', 'pointer');
		$(this).click(function(){
			window.location = $(this).children('a').attr('href');
		});
	})
	$(".paginationPage").mouseout(function(){
		$(this).removeClass('paginationPageSelected').addClass('paginationPage');
	})
	
});