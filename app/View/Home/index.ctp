<div class="containerContent">
	<div id="containerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<div class="pageControls" style="top: -25px;">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton"><?php echo $this->Html->image('/img/layouts/default/elements/plus.png', array("alt" => "Avatar")); ?><?php echo $this->Html->link(' New Article',array('controller' => 'articles', 'action' => 'create', 'full_base' => true));?></div>
		<!--<div class="pageControlsButton"><img src="/img/layouts/default/elements/plus.png"> Edit Banner</div>-->
	</div>
	<?php endif; ?>
	<div style="position: relative; top: -25px;"><?php echo $this->Session->flash(); ?></div>
	<div class="containerContentLeft" style="top: -25px;">
		<div class="containerTwoThirds" style="height: 291px; background-image: url('/img/layouts/default/elements/grunge_small.png')">
			<!--Slide Show Beginning of Create view HTML -->
			<div id="slideShowContainer">
				<div id="slideShow">
					<img src="#" id="slideShowSlide" alt=""/>
				</div>
				<div id="slideShowNavigation"></div><div class="clear"></div>
			</div>
			<!--Slide Show End of Create view HTML -->
			<!-- 
			*****Adds banner one-third containers if wanted *****
			<div class="containerOneThirdBanner" style="height:100px; margin-left: 10px;">
				<div class="bannerTitle">Official Streams</div>
			</div>
			<div class="containerOneThirdBanner" style="height:100px; margin-left: 10px;">
				<div class="bannerTitle">Latest Patch Notes</div>
			</div>
			<!-- -->
		</div>
		<div class="containerTwoThirds" style="height: 55px; background-image: url('/img/layouts/default/elements/grunge_small.png')">
		</div>
		<div class="containerTwoThirds" style="margin-top: 0px;">
			<!-- News Block Begins-->
			<?php
				foreach($articles as $article): 
			?>
			<div class="articleContainer">
				<div class="articleContainerBackgroundTop"></div>
				<div class="articleContainerBackgroundBottom"></div>
				<div class="articleSpacer">
					<div class="articleHeader">
						<div class="articleTitle"><?php echo $article['Article']['title']; ?></div>
						<div class="articlePoster">
							by 
							<?php
								echo $this->Html->link($article['Article']['user_name'] ,array('controller' => 'UserProfiles', 'action' => 'view/'.$article['Article']['user_id'], 'full_base' => true));
							?>
							 on <?php echo $this->Time->format('F jS, Y', $article['Article']['created']); ?></div>
					</div>
					<div class="articleBody">
						<?php echo $article['Article']['body_short']; ?>
					</div><div class="clear"></div>
					<div class="readMore"><?php echo $this->Html->link('Read More',array('controller' => 'articles', 'action' => 'read/'.$article['Article']['id'], 'full_base' => true));?></div>
					<div class="articleControls">
						<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/delete.png", array("alt" => "Delete")),
							    array("controller" => "articles", "action"=>"delete/".$article['Article']['id']),
							    array('escape' => false), "Delete this news post?"
							);
						?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
							    array("controller" => "articles", "action"=>"edit/".$article['Article']['id']),
							    array('escape' => false)
							);
						?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php 
				endforeach; 
			?>
			<!-- News Block Ends-->
			<div class="articleArchiveContainer">
				<div class="articleContainerBackgroundTop"></div>
				<div class="articleContainerBackgroundBottom"></div>
				<div class="articleArchiveSpacer">
					<?php
						echo $this->Html->image("layouts/default/buttons/archive.png", array(
						    "alt" => "Edit",
						    'url' => array('controller' => 'articles', 'action'=>'archive')
						));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="containerContentRight" style="top: -25px;">
		<div class="containerOneThird" style="height:500px; background-repeat: no-repeat; background-image: url('http://media.3hoursdungeon.com/images/Style%20Images/BannerNoHolesv2.png'); left: -3px; ">
			<div class="forumPostsTitle">Recent Forum Activity</div>
			<div class="forumPostsBorderThick"></div>
			<?php foreach($recentTopics as $topic): ?>
			<div class="forumPost">
				<div class="forumPostTopic"><?php echo $this->Html->link($this->Text->truncate($topic['FTopic']['title'], 40, array('exact' => true)), array('controller'=>'forums','action'=>'viewTopic/'.$topic['FTopic']['id'])); ?></div>
				<div class="forumPostDetail"><?php echo $topic['FForum']['title']; ?></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div id="bottomSpacer"></div>
</div>