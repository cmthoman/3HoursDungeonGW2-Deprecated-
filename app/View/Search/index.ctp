<div class="containerContent">
	<div id="searchContainerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<!--<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton">
			<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Add News',array('controller' => 'News', 'action' => 'create', 'full_base' => true)); ?>
		</div>
	</div>-->
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<div id="searchContainer">
		<div id="searchBackgroundTop"></div>
		<div id="searchLeftColumn">
		<div id="searchLeftColumnBottom"></div>
		</div>
		<div id="searchRightColumn">
			<div id="searchbarContainer">
				<div class="headerSearch">
					<?php 
						echo $this->Form->create('Search', array(
								'inputDefaults' => array(
									'label' => false,
									'div' => 'search'
								),
								'url' => array(
									'controller' => 'search',
									'action' => 'index'
								)
							)
						);
						
						echo $this->Form->input('searchQuery', array(
							'type' => 'text',
							'class' => 'searchField1',
							'default' => $search
							)
						);
						?>
					<div class='searchButton'>
						<?php
							echo $this->Form->end('/img/layouts/default/elements/searchButton.png');
						?>
					</div>
				</div>
			</div><div class='clear'></div>
			<?php if(!empty($search)): ?>
				<div class="searchHeaderText">Search results for </div><div class="searchHeaderTextTerm"><?php echo $search; ?></div>
				<?php if(!empty($userResults)): ?>
				<div class="searchRightColumnContentTransparent">
					<div class="searchCategory">
					<div class="searchTextTitle">Users</div><div class="searchTextTitleCounter">(<?php echo $userCount; ?>)</div><div class="clear"></div>
					</div>
					<?php foreach($userResults as $user): ?>
						<div class="searchCatergoryUserResult">
							<div class="profileUserAvatar">
								<?php echo $this->Html->image('/img/avatars/'.$user['UserProfile']['avatar'].'.jpg', array("alt" => "Avatar", "height" => "65px", "width" => "65px")); ?>
							</div>
							<div class="profileUserInfoText">
								<?php echo $this->Html->link($user['User']['username'], array("controller" => "UserProfiles", "action"=>"view/".$user['User']['id']), array('escape' => false)); ?>
							</div><br />
							<div class="searchText" style="float: left; margin-left: 5px;"><?php echo $user['UserProfile']['display_name'] ?></div><br />
							<div class="searchText" style="float: left; margin-left: 5px;"><?php echo $user['UserProfile']['server'] ?></div>
							<div class="clear"></div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php if(!empty($articleResults)): ?>
				<div class="searchRightColumnContentTransparent">
					<div class="searchCategory">
					<div class="searchTextTitle">Articles</div><div class="searchTextTitleCounter">(<?php echo $articleCount; ?>)</div><div class="clear"></div>
					</div>
					<?php foreach($articleResults as $article): ?>
						<div class="searchCatergoryUserResult">
							<div class="profileUserInfoText">
								<?php echo $this->Html->link($article['Article']['title'], array("controller" => "articles", "action"=>"read/".$article['Article']['id']), array('escape' => false)); ?>
							</div><br />
							<div class="searchText" style="float: left; margin-left: 5px;">by <?php echo $article['Article']['user_name'] ?> on <?php echo $this->Time->format('M jS, Y', $article['Article']['created']); ?></div>
							<div class="clear"></div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<div id="searchBottomSpacer"></div>
</div>