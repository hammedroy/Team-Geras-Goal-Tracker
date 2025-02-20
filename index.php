<?php
include_once('dbcon.php');

$error = false;
$firstname = $email = $phoneno = "";

if (isset($_POST['btn-signup'])) {

  // clean user input to prevent sql injections
  $firstname = trim($_POST['firstname']);
  $firstname = htmlspecialchars(strip_tags($firstname));

  $email = trim($_POST['email']);
  $email = htmlspecialchars(strip_tags($email));

  $pwd = $_POST['pwd'];
  $pwd = strip_tags($pwd);
  $pwd = htmlspecialchars($pwd);

  $cpwd = $_POST['cpwd'];
  $cpwd = strip_tags($cpwd);
  $cpwd = htmlspecialchars($cpwd);

  $phoneno = trim($_POST['phoneno']);
  $phoneno = htmlspecialchars(strip_tags($phoneno));

  // To validate
  if (empty($firstname)) {
    $error = true;
    $errorfirstname = '<h6>Please input firstname</h6>';
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $errorEmail = '<h6>Please a valid input email</h6>';
  }

  if ($pwd != $cpwd) {
    $error = true;
    $cpwdpwd = '<h6>Your passwords do not match</h6>';
  }

  if (!is_numeric($phoneno) || (strlen($phoneno) != 11)) {
    $error = true;
    $errorphone = '<h6>Please enter a valid Mobile Number</h6>';
  }

  // check if users already exist

  //insert data if no error
  if (!$error) {
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $pwd = md5("$salt1$pwd$salt2");
    $sql1 = "INSERT INTO user(user_id, firstname, email, password, phoneno, day, month, year, gender) VALUES(NULL, '$firstname', '$email', '$pwd', '$phoneno', '$day', '$month', '$Year', '$gender')";
    if (mysqli_query($conn, $sql1)) {
      $msg4 = '<h5>Register successfully</h5>';
      header("location:login.php");
    } else {
      echo "Error " . mysqli_error($conn);
    }
  }
}
?>

<html>

<head>
  <title>Goal Tracker | Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <form class="box" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" autocomplete="off">
            <h2>Sign Up</h2>
            <p>You already have an account? <a href="login.php">Sign in</a></p>
            <?php
            if (isset($msg4)) {
              ?>
              <div class="alert alert-success">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php echo $msg4; ?>
              </div>
            <?php
            }

            ?>
            <input type="text" class="name" name="firstname" value="<?php echo $firstname ?>" placeholder="Fullname">
            <span class="text-danger"><?php if (isset($errorfirstname)) echo $errorfirstname; ?></span>

            <input type="email" class="email" name="email" value="<?php echo $email ?>" placeholder="Email">
            <span class="text-danger"><?php if (isset($errorEmail)) echo $errorEmail; ?></span>

            <input type="password" name="pwd" placeholder="Password">

            <input type="password" name="cpwd" placeholder="Confirm Password">
            <span class="text-danger"><?php if (isset($cpwdpwd)) echo $cpwdpwd; ?></span>

            <input type="number" name="phoneno" value="<?php echo $phoneno ?>" placeholder="Mobile Number">
            <span class="text-danger"><?php if (isset($errorphone)) echo $errorphone; ?></span>

            <input type="submit" name="btn-signup" Value="Sign Up">
            <div class="col-md-12" id="social">
              <ul class="social-network social-circle">
                <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>