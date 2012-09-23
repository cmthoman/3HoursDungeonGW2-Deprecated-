$(document).ready(function(){
	//Post user Info dispersion (look for user info saved in userData class div and disperse it to otehr div's for each user **Saves Duplicate DB lookups!**)
	$(".userData").each(function(){
		UserName = $(this).attr('UserName');
		UserGroup = $(this).attr('UserGroup');
		UserServer = $(this).attr('UserServer');
		UserID = $(this).attr('StorageUserID');
		UserAvatar = $(this).attr('UserAvatar');
		UserRole = $(this).attr('UserRole');
		$("div[userID="+UserID+"]").each(function(){
			if($(this).attr('userInfo') == "UserGroup"){
				$(this).text(UserGroup);
			}
			if($(this).attr('userInfo') == "UserServer"){
				$(this).text(UserServer);
			}
			if($(this).attr('userInfo') == "UserRole"){
				$(this).text(UserRole);
			}
		})
		$("img[alt="+UserID+"Avatar]").each(function(){
			$(this).attr('src', '/img/avatars/'+UserAvatar+".jpg");
		});
		$("a[id="+UserID+"]").each(function(){
			$(this).text(UserName).attr('href', '/UserProfiles/view/'+UserID);
		});
	});
	
	//Post Pagination
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
	
	//Post Controls
	$(".CTopicPostContainer").mouseover(function(){
		$(this).children('.CTopicRightColumn').children('.postControls').css('visibility', 'visible');
		$(this).children('.CTopicRightColumn').children('.replySmall').css('visibility', 'visible');
	});
	$(".CTopicPostContainer").mouseout(function(){
		$(this).children('.CTopicRightColumn').children('.postControls').css('visibility', 'hidden')
		$(this).children('.CTopicRightColumn').children('.replySmall').css('visibility', 'hidden');
	});
	
	//Thread Controls
	if($(".CTopicThreadTopicEditable").length != 0){
		$(".CTopicThreadTopic").click(function(){
			$(this).css('visibility', 'hidden');
			$(".CTopicThreadTopicEditable").css('visibility', 'visible');
			$(".topicField").focus();
		})
		$(".topicField").focusout(function(){
			$(".CTopicThreadTopicEditable").css('visibility', 'hidden');
			$(".CTopicThreadTopic").css('visibility', 'visible');
		});
	}
	
	$('#FTopicMoveFForumId').change( function() { $('#FTopicMoveViewTopicForm').submit(); })
});