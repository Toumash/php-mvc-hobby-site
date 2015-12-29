<form action="<?php echo $this->generateUrl('authorization', 'login'); ?>" method="post">
    <input type="text" name="login" placeholder="login"/>
    <input type="password" name="password" placeholder="xxxxxx"/>
    <input type="submit" value="OK"/>
</form>

<?php
$error = $this->get('error');
if ($error != null) {
    echo "<span>{$error}</span>";
}
?>