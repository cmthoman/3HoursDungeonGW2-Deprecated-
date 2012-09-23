<div class="containerContent">
	<div id="containerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<!--<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton"><img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' New Article',array('controller' => 'Articles', 'action' => 'create', 'full_base' => true));?></div>
	</div>-->
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<div id="containerContentLeft">
		<div class="containerTwoThirds">
			<div class="containerTwoThirds" style="height: 50px; background-image: url('/img/layouts/default/elements/grunge_small.png')">
			</div>
			<!-- category Block Begins-->
			<div class="categoryContainer">
				<div class="categoryContainerBackgroundTop"></div>
				<div class="categoryContainerBackgroundBottom"></div>
				<div class="categorySpacer">
					<div class="categoryHeader">
						<div class="categoryTitle"><?php echo "Guild Wars 2 General"; ?></div>
					</div>
					<div class="categoryBody">
						<div class="forum">
							
						</div>
					</div>
					<div class="categoryControls">
						<?php if($globalUserData['Admin'] == 'true'): ?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/delete.png", array("alt" => "Delete")),
							    array("controller" => "Articles", "action"=>"delete/"),
							    array('escape' => false), "Delete this news post?"
							);
						?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
							    array("controller" => "Articles", "action"=>"edit/"),
							    array('escape' => false)
							);
						?>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="categorySpacer">
					<div class="categoryHeader">
						<div class="categoryTitle"><?php echo "[THD] Guild"; ?></div>
					</div>
					<div class="categoryBody">
						
					</div>
					<div class="categoryControls">
						<?php if($globalUserData['Admin'] == 'true'): ?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/delete.png", array("alt" => "Delete")),
							    array("controller" => "Articles", "action"=>"delete/"),
							    array('escape' => false), "Delete this news post?"
							);
						?>
						<?php
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
							    array("controller" => "Articles", "action"=>"edit/"),
							    array('escape' => false)
							);
						?>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- category Block Ends-->
		</div>
	</div>
	<div id="containerContentRight">
		<div class="containerOneThird" style="height:500px; background-image: url('/img/layouts/default/elements/flag.png'); left: -3px; ">
			<div class="forumPostsTitle">Recent Forum Activity</div>
			<div class="forumPostsBorderThick"></div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
			<div class="forumPost">
				<div class="forumPostTopic">Topic</div>
				<div class="forumPostDetail">General Discussion</div>
			</div>
		</div>
	</div>
	<div id="bottomSpacer"></div>
</div>
	