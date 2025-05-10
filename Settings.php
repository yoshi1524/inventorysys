<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<li class="nav-item">
  <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addUserModal">
    <i class="fas fa-user-plus me-2"></i> Add User
  </a>
</li>
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="add_user.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="mb-3">
            <label for="user_level" class="form-label">User Role</label>
            <select class="form-select" name="user_level" required>
              <option value="owner">Owner</option>
              <option value="crew">Crew</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Temporary Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </div>
    </form>
  </div>
</div>
<a href="logout.php">Logout</a>
</body>
</html>

