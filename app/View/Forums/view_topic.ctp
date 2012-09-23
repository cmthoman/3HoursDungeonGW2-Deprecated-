<?php
	$this->Html->addCrumb('Forums', '/forums');
	$this->Html->addCrumb($forumData['FCategory']['name'], '/forums');
	$this->Html->addCrumb($forumData['FForum']['title'], '/forums/viewForum/'.$forumData['FForum']['id']);
	$this->Html->addCrumb($topicTitle, '/forums/viewTopic/'.$topicID);
?>
<?php foreach($userData as $userData): ?>
<div class="userData" style="display: hidden;" StorageUserID = "<?php echo $userData['UserID']; ?>" 
	UserName = "<?php echo $userData['UserName']; ?>" UserGroup = "<?php echo $userData['Group']; ?>"
	UserServer = "<?php echo $userData['Server']; ?>" UserAvatar = "<?php echo $userData['Avatar']; ?>"
	UserRole = "<?php echo $userData['UserRole']; ?>">
</div>
<? endforeach; ?>
<div class="containerContent">
	<?php 
		echo $this->Form->create('FPost', array(
				'inputDefaults' => array(
					'label' => false,
				)
			)
		);
	?>
	<!-- Topic Header Begins-->
	<div id="CTopicContainerContentBackground"></div><div class="clear"></div>
	<?php echo $this->Session->flash(); ?>
	<?php if($this->Form->error('body')): ?>
		<div class="containerCentered" id="errors" style="margin-bottom: 10px;">
			<b>Please correct the following errors and resubmit:</b> <br />
			<?php echo $this->Form->error('body'); ?>
		</div>
	<?php endif; ?>
	<?php echo $this->Form->end(); ?>
	<div id="CTopicContainer">
		<div id="CTopicBackgroundTop"></div>
		<div class="CTopicPostContainer" style="margin-top: 30px; height: 100px;">
			<div class="CTopicThreadTopic" style="visibility: visible;"><?php echo $topicTitle; ?></div>
			<!-- Topic/Thread Moderator Controls Begin -->
			<?php if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true' or
						   $localUserData['Editor'] == 'true' or  $localUserData['Moderator'] == 'true'): ?>
			<div class="CTopicThreadTopicEditable" style="visibility: hidden;">
				<?php 
					echo $this->Form->create('FTopic', array(
							'inputDefaults' => array(
								'label' => false,
								'class' => 'topicField'
							)
						)
					);
				?>
				<?php 
					echo $this->Form->input('title', array(
						'default' => $topicTitle
					));
				?>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="CTopicThreadControls">
				<?php
					echo $this->Form->create('FTopicMove', array(
							'inputDefaults' => array(
								'label' => false,
								'class' => 'topicMove',
							)
						)
					);
					echo $this->Form->input('f_forum_id', array(
						'options' => $forumList,
						'default' => $topicData[0]['FPost']['f_forum_id']
					));					
					echo $this->Form->end();
					echo "<div style='clear: both; float: right; margin-left: 5px; margin-top: 5px;'>";
					if($topicSticky == 'false'){
						echo $this->Html->link(
							$this->Html->image("/img/layouts/default/buttons/sticky.png", array("alt" => "profile")),
							array('controller' => 'forums', 'action' => 'stickyTopic/'.$topicID),
							array('escape' => false)
						);
					}else{
						echo $this->Html->link(
							$this->Html->image("/img/layouts/default/buttons/unsticky.png", array("alt" => "profile")),
							array('controller' => 'forums', 'action' => 'unstickyTopic/'.$topicID),
							array('escape' => false)
						);
					}
					echo "</div>";
					echo "<div style='float: right; margin-left: 5px; margin-top: 5px;'>";
					if($topicLock == 'false'){
						echo $this->Html->link(
							$this->Html->image("/img/layouts/default/buttons/lock.png", array("alt" => "profile")),
							array('controller' => 'forums', 'action' => 'lockTopic/'.$topicID),
							array('escape' => false)
						);
					}else{
						echo $this->Html->link(
							$this->Html->image("/img/layouts/default/buttons/unlock.png", array("alt" => "profile")),
							array('controller' => 'forums', 'action' => 'unlockTopic/'.$topicID),
							array('escape' => false)
						);
					}
					echo "</div>";
				?>
			</div>
			<?php endif; ?>
			<!-- Topic/Thread Moderator Controls End -->
			<div class="CTopicReply">
				<?php 
					echo $this->Html->link(
						$this->Html->image("/img/layouts/default/buttons/forum_reply.png", array("alt" => "profile")),
						"#replyAnchor",
						array('escape' => false)
					);
				?>
			</div>
			<div class="CTopicPaginationHolder">
				<?php
					echo $this->Paginator->numbers(array(
						'first' => 1,
						'last' => 1,
						'tag' => "div class='paginationPage'",
						'separator' => "",
						'modulus' => 5,
						'ellipsis' => "<div class ='ellipsis'>...</div>"
					));
				?>
			</div>			
		</div>
		<!-- Topic Header Ends -->
		<!-- Topic Body Begins -->
		<?php foreach($topicData as $post): ?>
		<div class="CTopicPostContainer">
			<div class="CTopicLeftColumn">
				<div class="profileUserInfoContainer" style="margin-left: 10px; margin-top: 10px;">
						<div class="profileUserAvatar">
							<?php
								echo $this->Html->link(
								    $this->Html->image($post['FPost']['user_id'], array("alt" => $post['FPost']['user_id']."Avatar", "height" => "75px", "width" => "75px")),
								    array("controller" => "UserProfiles", "action"=>"view/".$post['FPost']['user_id']),
								    array('escape' => false)
								);
							?>
						</div>
					</div>
				<div class="profileUserInfoContainer" style="margin-top: 8px;">
					<div userID = "<?php echo $post['FPost']['user_id']; ?>" userInfo = "UserName" class="profileUserInfoText" style="font-size: 14px; margin-bottom: 5px;"><?php echo $this->Html->link($post['FPost']['user_id'], array("controller" => "UserProfiles", "action"=>"view/"), array('id' => $post['FPost']['user_id'])); ?></div>
					<div userID = "<?php echo $post['FPost']['user_id']; ?>" userInfo = "UserRole" class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"></div>
					<div userID = "<?php echo $post['FPost']['user_id']; ?>" userInfo = "UserGroup" class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"></div>
					<div userID = "<?php echo $post['FPost']['user_id']; ?>" userInfo = "UserServer" class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"></div>
				</div>
			</div>
			<div class="CTopicRightColumn" style="padding-top: 7px;">
				<div class="timeStamp"><?php echo $this->time->timeAgoInWords($post['FPost']['created'],  array('accuracy' => array('hour' => 'hour', 'day' => 'day', 'month' => 'month'), 'end' => '1 week')); ?></div>
				<?php if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true' or
						   $localUserData['Editor'] == 'true' or  $localUserData['Moderator'] == 'true' or  $globalUserData['id'] == $post['FPost']['user_id']): ?>
				<div class="postControls">
					<?php
						echo $this->Html->link(
						    $this->Html->image("/img/layouts/default/buttons/delete.png", array("alt" => "reply")),
						    array('controller' => 'forums', 'action' => 'deletePost/'.$post['FPost']['id']),
						    array('escape' => false)
						);
					?>
					<?php
						echo $this->Html->link(
						    $this->Html->image("/img/layouts/default/buttons/edit.png", array("alt" => "reply")),
						    array('controller' => 'forums', 'action' => 'editPost/'.$post['FPost']['id']),
						    array('escape' => false)
						);
					?> 
				</div>
				<?php endif; ?>
				<div class="replySmall">
					<?php
						echo $this->Html->link(
						    $this->Html->image("/img/layouts/default/buttons/reply.png", array("alt" => "reply")),
						    "#replyAnchor",
						    array('escape' => false)
						);
					?>
				</div>
				<div class="postBody"><?php echo nl2br($this->bb->parse($post['FPost']['body'])); ?></div>
			</div>
		</div>
		<?php endforeach; ?>
		<!-- Topic Body Ends -->
		<!-- If Thread is Locked -->
		<?php if($post['FTopic']['status_lock'] == 'true'): ?>
		<div class="CTopicPostContainer" id="replyAnchor">
			<div class="CTopicLeftColumn">
			</div>
			<div class="CTopicRightColumn">
				<div class="lockedText">
					This Topic Has Been Locked.<br/>
					=(
				</div>
			</div>
		</div>
		<!-- If Thread is unLocked and User Signed In-->
		<?php elseif($loggedIn == TRUE): ?>
		<div class="CTopicPostContainer">
			<div class="CTopicLeftColumn">
				<div style="margin-left: 10px; margin-top: 15px; width: 250px; margin-bottom: 15px;">
					<div style="font-weight: bold; font-size: 20px; color: #dfd0ab">Reply</div>
				</div>
				<div class="profileUserInfoContainer" style="margin-left: 10px; margin-top: 10px;">
						<div class="profileUserAvatar">
							<?php
								echo $this->Html->link(
								    $this->Html->image("/img/avatars/".$localUserData['Avatar'].".jpg", array("alt" => "Avatar", "height" => "75px", "width" => "75px")),
								    array("controller" => "UserProfiles", "action"=>"view/".$globalUserData['id']),
								    array('escape' => false)
								);
							?>
						</div>
					</div>
				<div class="profileUserInfoContainer" style="margin-top: 8px;">
					<div class="profileUserInfoText" style="font-size: 14px; margin-bottom: 5px;"><?php echo $this->Html->link($globalUserData['UserName'], array("controller" => "UserProfiles", "action"=>"view/".$globalUserData['id'])); ?></div>
					<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $globalUserData['RoleName']; ?></div>
					<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $localUserData['Group']; ?></div>
					<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $localUserData['Server']; ?></div>
				</div>
			</div>
			<div class="CTopicRightColumn" id="replyAnchor">
				<div class="formContainer">
					<?php 
						echo $this->Form->create('FPost', array(
								'inputDefaults' => array(
									'label' => false,
								)
							)
						);
					?>
					<div class="formField">
						<?php 
							echo $this->Form->input('body', array(
								"type" => "textarea",
								"class" => "CTopicBody"
							));
						?>
					</div>
					<div class="formField"><div class="formFieldSubmit" style="margin-bottom: 20px;"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<!-- If Thread is unLocked and User Signed Out-->
		<?php else: ?>
		<div class="CTopicPostContainer" id="replyAnchor">
			<div class="CTopicLeftColumn">
			</div>
			<div class="CTopicRightColumn">
				<div class="loginFirst">
					Log In To Reply
				</div>
				<div class="loginReply">
					<?php 
						echo $this->Html->link(
							$this->Html->image("/img/layouts/default/buttons/login_large.png", array("alt" => "profile")),
							array('controller' => 'users', 'action' => 'login'),
							array('escape' => false)
						);
					?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="CTopicPostContainer" style="height: 50px;">
			<div class="CTopicPaginationHolderFooter">
				<?php
					echo $this->Paginator->numbers(array(
						'first' => 1,
						'last' => 1,
						'tag' => "div class='paginationPage'",
						'separator' => "",
						'modulus' => 5,
						'ellipsis' => "<div class ='ellipsis'>...</div>"
					));
				?>
			</div>
		</div>
	</div>	
	<div id="CTopicBottomSpacer"></div>
</div>