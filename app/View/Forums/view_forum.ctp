<?php
	$this->Html->addCrumb('Forums', '/forums');
	$this->Html->addCrumb($forum['FCategory']['name'], '/forums');
	$this->Html->addCrumb($forum['FForum']['title'], '/forums/viewForum/'.$forum['FForum']['id']);
?>
<div class="containerContent">
	<div id="forumContainerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Admin'] == 'true'): ?>
	<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton"><img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Edit Forum',array('controller' => 'forums', 'action' => 'editForum/'.$forum['FForum']['id'], 'full_base' => true));?> </div>
	</div>
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<div id="forumContainer">
		<div id="forumContainerTop"></div>
		<div id="forumHeader">
			<div id="forumName"><?php echo $forum['FForum']['title']; ?></div>
			<div class="createTopicHeader">
				<?php
					echo $this->Html->link(
					    $this->Html->image("/img/layouts/default/buttons/new_thread.png", array("alt" => "profile")),
					    array("controller" => "forums", "action"=>"createTopic/".$forum['FForum']['id']),
					    array('escape' => false)
					);
				?>
			</div>
			<div class="paginationHolderHeader">
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
		<div class="forumRow" style="border-bottom: 1px solid #2e231c;">
			<div class="forumColumnSubject"><div style="margin-left: 10px; margin-top: 20px;">Subject</div></div>
			<div class="forumColumnAuthor"><div style="margin-top: 20px;">Author</div></div>
			<div class="forumColumnReplies"><div style="margin-top: 20px;">Replies</div></div>
			<div class="forumColumnViews"><div style="margin-top: 20px;">Views</div></div>
			<div class="forumColumnLast"><div style="margin-top: 20px;">Last Poster</div></div>
		</div>
		<?php foreach($stickies as $sticky): ?>
			<?php if($sticky['FTopic']['status_lock'] == 'true'){
				$title = "[Locked] ";
			}else{
				$title = " ";
			}
			?>
			<div class="forumRow" style="border-bottom: 1px solid #2e231c;">
				<div class="forumColumnSubject">
					<div style="margin-left: 10px;">
						<div class="topicTitle">
							<?php echo "[Sticky] ".$title; echo $this->Html->link($sticky['FTopic']['title'], array('controller' => 'forums', 'action' => 'viewTopic/'.$sticky['FTopic']['id'])); ?>
							<div style="float: right; margin-right: 20px; font-size: 11px">
								<?php
									$totalEntries = $sticky['FTopic']['replies'];
									$entrieserPage = 10;
									$showPages = 4;
									$pages = ceil($totalEntries/$entrieserPage);
									if($pages > 1){
										for($i = 1; $i <= $showPages; $i++){
											if($i == 1){
												echo "<a href='/forums/viewTopic/".$sticky['FTopic']['id']."/page:1'>1</a>";
											}
											
											if($i < $pages && $i < $showPages-1){
												$pageLink = $i+1;
												echo ", <a href='/forums/viewTopic/".$sticky['FTopic']['id']."/page:".$pageLink."'>".$pageLink."</a>";
											}else if($i == $showPages && $i > 1 && $i <= $pages){
												echo ", <a href='/forums/viewTopic/".$sticky['FTopic']['id']."/page:".$showPages."'>".$showPages."</a>";
											}
										}
										
										if($i > $showPages && $i <= $pages){
											echo " ... <a href='/forums/viewTopic/".$sticky['FTopic']['id']."/page:".$pages."'>".$pages."</a>";
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="forumColumnAuthor"><div class="topicText"><?php echo $sticky['FTopic']['author']; ?></div></div>
				<div class="forumColumnReplies"><div class="topicText"><?php echo $sticky['FTopic']['replies']; ?></div></div>
				<div class="forumColumnViews"><div class="topicText"><?php echo $sticky['FTopic']['views']; ?></div></div>
				<div class="forumColumnLast"><div class="topicText"><?php echo $sticky['FTopic']['last_poster']; ?></div></div>
			</div>
		<?php endforeach; ?>
		<?php foreach($topics as $topic): ?>
			<?php if($topic['FTopic']['status_lock'] == 'true'){
				$title = "[Locked] ";
			}else{
				$title = " ";
			}
			?>
			<div class="forumRow" style="border-bottom: 1px solid #2e231c;">
				<div class="forumColumnSubject">
					<div style="margin-left: 10px;">
						<div class="topicTitle">
							<?php echo $title; echo $this->Html->link($topic['FTopic']['title'], array('controller' => 'forums', 'action' => 'viewTopic/'.$topic['FTopic']['id'])); ?>
							<div style="float: right; margin-right: 20px; font-size: 11px">
								<?php
									$totalEntries = $topic['FTopic']['replies'];
									$entrieserPage = 10;
									$showPages = 4;
									$pages = ceil($totalEntries/$entrieserPage);
									if($pages > 1){
										for($i = 1; $i <= $showPages; $i++){
											if($i == 1){
												echo "<a href='/forums/viewTopic/".$topic['FTopic']['id']."/page:1'>1</a>";
											}
											
											if($i < $pages && $i < $showPages-1){
												$pageLink = $i+1;
												echo ", <a href='/forums/viewTopic/".$topic['FTopic']['id']."/page:".$pageLink."'>".$pageLink."</a>";
											}else if($i == $showPages && $i > 1 && $i <= $pages){
												echo ", <a href='/forums/viewTopic/".$topic['FTopic']['id']."/page:".$showPages."'>".$showPages."</a>";
											}
										}
										
										if($i > $showPages && $i <= $pages){
											echo " ... <a href='/forums/viewTopic/".$topic['FTopic']['id']."/page:".$pages."'>".$pages."</a>";
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="forumColumnAuthor"><div class="topicText"><?php echo $topic['FTopic']['author']; ?></div></div>
				<div class="forumColumnReplies"><div class="topicText"><?php echo $topic['FTopic']['replies']; ?></div></div>
				<div class="forumColumnViews"><div class="topicText"><?php echo $topic['FTopic']['views']; ?></div></div>
				<div class="forumColumnLast"><div class="topicText"><?php echo $topic['FTopic']['last_poster']; ?></div></div>
			</div>
		<?php endforeach; ?>
		<div id="forumFooter">
			<div class="createTopicFooter">
				<?php
					echo $this->Html->link(
					    $this->Html->image("/img/layouts/default/buttons/new_thread.png", array("alt" => "profile")),
					    array("controller" => "forums", "action"=>"createTopic/".$forum['FForum']['id']),
					    array('escape' => false)
					);
				?>
			</div>
			<div class="paginationHolderFooter">
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
	<div id="bottomSpacer"></div>
</div>