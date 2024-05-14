<?php 
    
require_once('classes/database.php');

$con = new database();

session_start();
if (isset($_SESSION['username'])){
  header ('location:index.php');
}
 
if (isset($_POST['Login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $result = $con->check($username, $password);
    if ($result) {
        if ($result['user_name'] == $_POST['user'] && $result
        ['user_pass'] == $_POST['pass']) {
            $_SESSION['username'] = $result['user_name'];
            header('location:index.php');
            $_SESSION['username'] = $result['user_name'];
        } else {
            echo 'An error has occured';
        }
    } else {
        echo 'An error has occured';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styIe.css">
</head>
<body>

<div class="container-fluid rounded shadow login-container">
  <h2 class="text-center mb-4">Login</h2>
  <form method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="user" placeholder="Enter Username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" name="pass" placeholder="Enter Password">
    </div>
    <div class="container">
      <div class="row gx-1">
        <div class="col"><input type="submit" value="Login" name="Login" class="btn btn-primary btn-block"></div>
        <div class="col"><a href="multisave.php" input type="submit" class="btn btn-danger btn-block" name ="signup">Sign Up</a></div>
      </div>
    </div>
  </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
