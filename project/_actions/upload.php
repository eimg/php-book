<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;
use Helpers\Auth;

$auth = Auth::check();

$table = new UsersTable(new MySQL());

$name = $_FILES['photo']['name'];
$error = $_FILES['photo']['error'];
$tmp = $_FILES['photo']['tmp_name'];
$type = $_FILES['photo']['type'];

if ($error) {
	HTTP::redirect("/profile.php", "error=file");
}

if ($type === "image/jpeg" or $type === "image/png") {

	$table->updatePhoto($auth->id, $name);

	move_uploaded_file($tmp, "photos/$name");

	$auth->photo = $name;

	HTTP::redirect("/profile.php");
} else {
	HTTP::redirect("/profile.php", "error=type");
}
