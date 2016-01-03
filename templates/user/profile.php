<?php
$user = $this->get('user');
?>
<span>Login: <?php echo $user->login ?></span><br/>
<span>Email: <?php echo $user->email ?></span>

<br/>
<br/>
<br/>
<strong><a class="btn btn-success" href="<?php echo $this->generateUrl('user', 'photos'); ?>">Moje zdjęcia</a></strong>

<br/><br/>

<a class="btn" href="<?php echo $this->generateUrl('authorization','logout'); ?>">WYLOGUJ</a>