<?php echo $this->data['User']['username']?>,

Thank you for registering your account with 3 Hours Dungeon. To begin using your account you must activate it by following the link provided in this email.
If you have any questions or problems please contact us at support@3hoursdungeon.com. We hope you enjoy the site!

Sincerely,
The 3HD Team.

Activation Link: <?php echo 'http://gw2.3hoursdungeon.com/users/activateAccount?username='.$this->data['User']['username'].'&key='.$this->request->data['User']['activate_hash']; ?>

