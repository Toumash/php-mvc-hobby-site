<?php
$user = $this->get('user');
?>
<span>Login: <?php echo $user->login ?></span><br/>
<span>Email: <?php echo $user->email ?></span>

<br/>
<strong><a href="<?php echo $this->generateUrl('user', 'photos'); ?>">Moje zdjęcia</a></strong>

<br/><br/>

<a href="<?php echo $this->generateUrl('authorization','logout'); ?>">WYLOGUJ</a>