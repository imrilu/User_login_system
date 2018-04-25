<?php

// opening connection to sql server
$db = new mysqli("localhost", "root", "", "userdb");
// init variables
$password = $password1 = $password2 = $Message = "";

// in case of redirect from 'forgot password' page, displaying message (password not matched)
if (!empty($_REQUEST['Message'])) {
    echo "<script>alert('" . $_REQUEST['Message'] . "');</script>";
}

// getting token and email from address bar
if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];
} else {
    $token = $email = "";
}

// handling the event of reset password
if (isset($_POST['pass_change'])) {
    $password1 = $db->real_escape_string($_POST["password1_recover"]);
    $password2 = $db->real_escape_string($_POST["password2_recover"]);
    // getting the correct user from db
    $result = $db->query("SELECT * FROM users WHERE email='$email' AND token='$token'");
    $user = $result->fetch_assoc();

    if ($password1 != $password2) {
        $Message = "The two passwords do not match";
        // redirecting to same page but with message to display
        header("Location: resetPassword.php?token=" . $token . "&" . "email=" . $email . "&" . "Message={$Message}");
    } else if (($password1 == $password2) && strlen($password1) < 6) {
        $Message = "Password should be at least 6 characters";
        // redirecting to same page but with message to display
        header("Location: resetPassword.php?token=" . $token . "&" . "email=" . $email . "&" . "Message={$Message}");
    } else if ($user['token'] == $token) {
        // verified token is the same as in db,
        // encrypting password, resetting the token and changing password
        $password = md5($password1);
        $db->query("UPDATE users SET password = '$password', token = NULL WHERE email='$email'");
        // passing confirmation message for changing pass
        $Message = "Your password has been changed";
        header("Location: login.php?Message={$Message}");
        exit();
    } else {
        $Message = "Email token has expired. please try again.";
        header("Location: login.php?Message={$Message}");
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot password</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="login-form">
    <!-- Start of reset password form -->
    <!-- re-adding token and email to address var -->
    <form action="resetPassword.php<?php echo "?token=" . $token . "&" . "email=" . $email ?>" method="post">
        <h2 class="text-center">Reset Password</h2>
        <div class="form-group">
            <input type="password" name="password1_recover" class="form-control" placeholder="Enter new password"
                   required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password2_recover" class="form-control" placeholder="Confirm password"
                   required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="pass_change" class="btn btn-primary btn-block">Change Password</button>
        </div>
    </form>
    <!-- End of reset password form -->
</div>

</body>
</html>