<?php
$user = $this->get('user');
?>
<span>Login: <?php echo $user->login ?></span>
<span>Email: <?php echo $user->email ?></span>

<br/>
<strong><a href="<?php echo $this->generateUrl('user', 'photos'); ?>">Moje zdjęcia</a></strong>