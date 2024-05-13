<?php
require_once('classes/database.php');

$con = new database();

$id = $_POST['id'];

if (empty($id)) {
    header('location:index.php');
} else {
    $row = $con->viewdata($id);
    
} 
if (isset($_POST['update'])) {
  $username = $_POST['user'];
  $password = $_POST['pass'];
  $confirm = $_POST['c_pass'];
  $street = $_POST['street'];
  $barangay = $_POST['barangay'];
  $city = $_POST['city'];
  $province = $_POST['province'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $date = $_POST['date'];
  $sex = $_POST['sex'];
  $user_id = $_POST['id'];
  
  
  if ($password == $confirm) {
    if ($con->updateUser ( $user_id, $username, $password, $firstname, $lastname, $date, $sex)){
    if ($con->updateUserAddress($user_id, $street, $barangay, $city, $province)){
              header('location:index.php');
              exit();
          } else {
              // Address update failed, display error message
              $error = "Error occurred while updating user Address Please try again.";
          }
      } else {
          // User update failed, display error message
          $error = "Error occurred while updating the user's information. Please try again.";
      }
  } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    .custom-container{
        width: 800px;
    }
    body{
    font-family: 'Roboto', sans-serif;
    }
  </style>

</head>
<body>

<div class="container custom-container rounded-3 shadow my-5 p-3 px-5">
  <h3 class="text-center mt-4"> Edit Form</h3>
  <form method="post">
    <!-- Personal Information -->
    <div class="card mt-4">
      <div class="card-header bg-info text-white">Personal Information</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstname" value = "<?php echo $row['user_fn'];?>" placeholder="Enter first name">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastname" value = "<?php echo $row['user_ln'];?>" placeholder="Enter last name">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="birthday">Birthday:</label>
            <input type="date" class="form-control" id="birthday" name="date" value = "<?php echo $row['user_birth'];?>">
          </div>
          <div class="form-group col-md-6">
            <label for="sex">Sex:</label>
            <select class="form-control" id="sex" name="sex">
              <option selected>Select Sex</option>
              <option value = "Male" <?php if ($row ['user_sex']=='Male') echo 'selected';?>>Male</option>
              <option value = "Female" <?php if ($row ['user_sex']=='Female') echo 'selected';?>>Female</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" id="username" placeholder="Enter username" name="user" value = "<?php echo $row['user_name'];?>">
        </div>
        <div class="form-group">
          <label for="password">Enter New Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Enter password" name="pass" value = "<?php echo $row['user_pass'];?>">
        </div>
        <div class="form-group">
          <label for="password">Confirm New Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Confirm password" name="c_pass" value = "<?php echo $row['user_pass'];?>">
        </div>
      </div>
    </div>
    
    <!-- Address Information -->
    <div class="card mt-4">
      <div class="card-header bg-info text-white">Address Information</div>
      <div class="card-body">
        <div class="form-group">
          <label for="street">Street:</label>
          <input type="text" class="form-control" id="street" placeholder="Enter street" name="street" value = "<?php echo $row['user_street'];?>">
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="barangay">Barangay:</label>
            <input type="text" class="form-control" id="barangay" placeholder="Enter barangay" name="barangay" value = "<?php echo $row['user_barangay'];?>">
          </div>
          <div class="form-group col-md-6">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" value = "<?php echo $row['user_city'];?>">
          </div>
        </div>
        <div class="form-group">
          <label for="province">Province:</label>
          <input type="text" class="form-control" id="province" placeholder="Enter province" name="province" value = "<?php echo $row['user_province'];?>">
        </div>
      </div>
    </div>
    
    <!-- Submit Button -->
    
    <div class="container">
    <div class="row justify-content-center gx-0">
        <div class="col-lg-3 col-md-4"> 
            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
            <input type="submit" name="update" class="btn btn-outline-primary btn-block mt-4" value="Update"> 
        </div>
        <div class="col-lg-3 col-md-4"> 
            <a class="btn btn-outline-danger btn-block mt-4" href="index.php">Go Back</a>
        </div>
    </div>
</div>


  </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
