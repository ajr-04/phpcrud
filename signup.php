<?php
require_once('classes/database.php');

$con = new database();

if (isset($_POST['signup'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $confirm = $_POST['conpass'];
    $first = $_POST['fn'];
    $last = $_POST['ln'];
    $bday = $_POST['birthday'];
    $sex = $_POST['sex'];

    if ($password == $confirm) {
      if ($con->signup($username, $password, $first, $last, $bday, $sex)) {
        header('location:login.php');
      } else {
        echo "Username already exists. Please choose a different username.";
      }
    } else {
      echo "Password did not match";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styIe.css">
</head>
<body>

<div class="container-fluid rounded shadow login-container">
  <h2 class="text-center mb-4">Sign Up</h2>
  <form method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="user" placeholder="Enter Username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" name="pass" placeholder="Enter Password">
    </div>
    <div class="form-group">
      <label for="password">Confirm Password:</label>
      <input type="password" class="form-control" name="conpass" placeholder="Enter Password">
    <div class="mb-3">
      <label for="birthday" class="form-label">Birthday:</label>
      <input type="date" class="form-control" name="birthday">
    </div>
    <div class="form-group">
      <label for="first">First Name:</label>
      <input type="text" class="form-control" name="fn" placeholder="Enter your first name">
    </div>
    <div class="form-group">
      <label for="last">Last Name:</label>
      <input type="text" class="form-control" name="ln" placeholder="Enter your last name">
    </div>
    <div class="mb-3">
      <label for="sex" class="form-label">Sex:</label>
      <select class="form-select" name="sex">
        <option selected disabled>Select your sex</option>
        <option value="M">Male</option>
        <option value="F">Female</option>
      </select>
    </div>
    </div>
    <div class="container">
      <div class="row gx-1">
        <div class="col"><input type="submit" class="btn btn-danger btn-block" name="signup"></input></div>
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
