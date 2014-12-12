<div class="navigation">
<ul>
    <li><?php echo link_to(url_for("index"), "Home"); ?></li>
    <?php
    $user = Users\User::getInstance(db());
    if ($user) { ?>
    <li><?php echo link_to(url_for("security/logout"), "Logout"); ?></li>
    <?php } else { ?>
    <li><?php echo link_to(url_for("security/login/password"), "Login"); ?></li>
    <?php } ?>
</ul>
</div>
