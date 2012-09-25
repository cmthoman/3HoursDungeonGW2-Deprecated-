<div class="containerContent">
	<div id="containerContentBackground"></div>
	<div class="clear"></div>
	<div class = "containerCentered" style="height: 600px; color: #dfd0ab; margin-top: 100px;">
		<h2><?php echo 'Your account has been suspended!'; ?></h2>
		<p class="error">
			Your account is currently suspended until <?php echo $this->Time->nice($suspended['User']['suspended']); ?>.<br/><br/>
			
			Regretfully,<br/>
			The 3HD Team.
		</p>
	</div>
	<div id="bottomSpacer"></div>
</div>