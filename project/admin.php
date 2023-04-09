<?php

include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;

$table = new UsersTable(new MySQL());
$all = $table->getAll();

$auth = Auth::check();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Users</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div style="float: right">
			<a href="profile.php">Profile</a> |
			<a href="_actions/logout.php" class="text-danger">Logout</a>
		</div>

		<h1 class="mt-5 mb-5">
			Manage Users
			<span class="badge bg-danger text-white">
				<?= count($all) ?>
			</span>
		</h1>

		<table class="table table-striped table-bordered">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($all as $user) : ?>
				<tr>
					<td><?= $user->id ?></td>
					<td><?= $user->name ?></td>
					<td><?= $user->email ?></td>
					<td><?= $user->phone ?></td>
					<td>
						<?php if ($user->role_id === 1) : ?>
							<span class="badge text-bg-secondary">
								<?= $user->role ?>
							</span>
						<?php elseif ($user->role_id === 2) : ?>
							<span class="badge text-bg-primary">
								<?= $user->role ?>
							</span>
						<?php else : ?>
							<span class="badge text-bg-success">
								<?= $user->role ?>
							</span>
						<?php endif ?>
					</td>
					<td>
						<?php if ($auth->value > 1) : ?>
							<div class="btn-group dropdown">
								<a href="#" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
									Change Role
								</a>
								<div class="dropdown-menu dropdown-menu-dark">
									<a href="_actions/role.php?id=<?= $user->id ?>&role=1" class="dropdown-item">User</a>
									<a href="_actions/role.php?id=<?= $user->id ?>&role=2" class="dropdown-item">Manager</a>
									<a href="_actions/role.php?id=<?= $user->id ?>&role=3" class="dropdown-item">Admin</a>
								</div>

								<?php if ($user->suspended) : ?>
									<a href="_actions/unsuspend.php?id=<?= $user->id ?>" class="btn btn-sm btn-danger">Suspended</a>
								<?php else : ?>
									<a href="_actions/suspend.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-success">Active</a>
								<?php endif ?>

								<?php if ($user->id !== $auth->id) : ?>
									<a href="_actions/delete.php?id=<?= $user->id ?>" class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure?')">Delete</a>
								<?php endif ?>
							</div>
						<?php else : ?>
							###
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>

	<script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
