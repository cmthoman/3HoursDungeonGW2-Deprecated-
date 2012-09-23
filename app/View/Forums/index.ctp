<?php
	$this->Html->addCrumb('Forums', '/forums');
?>
<div class="containerContent">
	<div id="containerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Admin'] == 'true'): ?>
	<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton">
			<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' New Category',array('controller' => 'forums', 'action' => 'createCategory', 'full_base' => true));?>
			<img src="/img/layouts/default/elements/plus.png" style="margin-left: 5px;"><?php echo $this->Html->link(' New Forum',array('controller' => 'forums', 'action' => 'createForum', 'full_base' => true));?>
		</div>
	</div>
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<div class="containerContentLeft">
		<div class="containerTwoThirds">
			<div class="containerTwoThirds" style="height: 50px; background-image: url('/img/layouts/default/elements/grunge_small.png')">
			</div>
			<div class="categoryContainer">
				<div class="categoryContainerBackgroundTop"></div>
				<div class="categoryContainerBackgroundBottom"></div>
				<?php foreach($categories as $category): ?>
				<?php $forums = $category['FForum'] ?>
				<!-- category Block Begins-->
				<div class="categorySpacer">
					<div class="categoryHeader">
						<div class="categoryTitle"><?php echo $category['FCategory']['name']; ?></div>
						<div class="categoryControls">
							<?php if($globalUserData['Admin'] == 'true'): ?>
							<?php
								echo $this->Html->link(
								    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
								    array("controller" => "forums", "action"=>"editCategory/".$category['FCategory']['id']),
								    array('escape' => false)
								);
							?>
							<?php endif; ?>
						</div>
					</div>
					<div class="categoryBody">
						<?php foreach($forums as $forum): ?>
						<div class="forumContainer">
							<div class="forumTitle"><?php echo $this->Html->link($forum['title'], array("controller" => "forums", "action"=>"viewForum/".$forum['id']), array('escape' => false)); ?></div>
							<div class="forumDescription"><?php echo $forum['description']; ?></div>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="clear"></div>
				</div>
				<!-- category Block Ends-->
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="containerContentRight">
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
	