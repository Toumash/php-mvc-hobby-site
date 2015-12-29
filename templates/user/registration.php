<form action="<?php echo $this->generateUrl('authorization', 'register'); ?>" method="post">
    <input type="text" name="login" placeholder="login"/>
    <input type="email" name="email" placeholder="someone@example.com"/>
    <input type="password" name="password" placeholder="xxxxxxx"/>
    <input type="password" name="password_repeat" placeholder="xxxxxxx"/>
    <input type="submit" value="OK"/>
</form>


<?php
$error = $this->get('error');
if ($error != null) {
    echo "<span style=\"color:red;font-size:130%;\">{$error}</span>";
}