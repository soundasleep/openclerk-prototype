<?php

// page logic
$user = Users\UserPassword::tryLogin(db(), "jevon@jevon.org", "jevon");

// page render
page_header("Login", "page_login");
require_template("login/password", array("user" => $user));
page_footer();
