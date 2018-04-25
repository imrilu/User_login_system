<?php
include('server.php');
include('errors.php');
include('phpmailer.php');

// in case of redirect from 'forgot password' page, displaying message
if (!empty($_REQUEST['Message'])) {
    echo "<script>alert('".$_REQUEST['Message']."');</script>";
}
// code for forgetting password:
if (isset($_POST["forgotPass"])) {
    $connection = new mysqli("localhost", "root", "", "userdb");

    $email = $connection->real_escape_string($_POST["email_forgotpass"]);

    $data = $connection->query("SELECT id FROM users WHERE email='$email'");

    if ($data->num_rows > 0) {
        $str = "0123456789abcdefghijklmnopqrstuvwxyz";
        $str = str_shuffle($str);
        $str = substr($str, 0, 10);
        $url = "http://localhost/resetPassword.php?token=$str&email=$email";

        $mail->addAddress($email);
        $mail->Body = "To reset your password, please visit this link: $url";
        try {
            $mail->send();
            $connection->query("UPDATE users SET token='$str' WHERE email='$email'");
            echo "<script type='text/javascript'>alert('Message has been sent');</script>";

        } catch (Exception $e) {
            echo "<script type='text/javascript'>alert('Message could not be sent. Mailer Error: ' + $mail->ErrorInfo)</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please check your inputs');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Simple Login Form</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="login-form">
    <form action="login.php" method="post">
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="email" name="login_mail" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="login_password" class="form-control" placeholder="Password"
                   required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="login_user" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <a href="#forgotpassModal" data-toggle="modal">Forgot Password?</a>
        </div>
    </form>

    <p class="text-center"><a href="#myModal" class="btn btn-lg btn-primary" data-toggle="modal">Create an Account</a>
    </p>
</div>

<!-- Signing up modal -->
<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title">Sign Up</h2>
            </div>
            <div class="modal-body">
                <p>Please fill this form to create an account.</p>
                <!-- Beginning of form for signing up -->
                <form method="post" action="login.php" id="signupForm">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password1">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password2">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="reg_user" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                </form>
                <!-- End of form for signing up -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Forgot my password modal -->
<div id="forgotpassModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title">Forgot your password?</h2>
            </div>
            <div class="modal-body">
                <p>To reset your password, please enter your email address.</p>
                <!-- Beginning of form for 'forgot my password' -->
                <form method="post" action="login.php" id="forgotPassForm">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email_forgotpass" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="forgotPass" class="btn btn-primary" value="Submit">
                    </div>
                </form>
                <!-- End of form for 'forgot my password' -->
            </div>
        </div>
    </div>
</div>

</body>
</html>