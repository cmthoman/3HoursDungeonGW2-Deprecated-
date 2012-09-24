<?php echo $this->data['User']['username']?>,

We have received a request to change your email address on file. If this request did not originate from you please contact us at Support@3HoursDungeon.com

To change your email address to <?php echo $this->data['changeEmail']['email']; ?> simply click the link at the bottom of this email.

If you don't wish to change your email address at this time simply disregard this email and nothing will change!

Sincerely,
The 3HD Team.

Go here to change your email: <?php echo 'http://gw2.3hd.aswanmedia.com/UserProfiles/changeEmail?username='.$this->request->data['User']['username'].'&key='.$this->request->data['User']['activate_hash'].'&email='.$this->data['changeEmail']['email']; ?>