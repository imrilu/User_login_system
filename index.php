<?php
session_start();

if (isset($_SESSION['success'])) {
    echo "<script>alert('".$_SESSION['success']."');</script>";
    unset($_SESSION['success']);
}
if (!isset($_SESSION['fullname'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['fullname']);
    header("location: login.php");
}

// connect to the database
$db = new mysqli("localhost", "root", "", "userdb");
$email = $_SESSION['email'];
$fullname = $_SESSION['fullname'];
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<br/><br/><br/>
<div class="container">

    <div class="row">

        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked admin-menu">
                <li class="active"><a href="" data-target-id="profile"><i class="glyphicon glyphicon-user"></i> Profile</a>
                </li>
                <li><a href="index.php?logout='1'" data-target-id="logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                </li>
            </ul>
        </div>

        <div class="col-md-9  admin-content" id="profile">
            <div class="panel panel-info" style="margin: 1em;">
                <div class="panel-heading">
                    <h3 class="panel-title">Name</h3>
                </div>
                <div class="panel-body">
                    <?php echo $fullname ?>
                </div>
            </div>
            <div class="panel panel-info" style="margin: 1em;">
                <div class="panel-heading">
                    <h3 class="panel-title">Email</h3>
                </div>
                <div class="panel-body">
                    <?php echo $email ?>
                </div>
            </div>
            <div class="panel panel-info" style="margin: 1em;">
                <div class="panel-heading">
                    <h3 class="panel-title">User Login History:</h3>

                </div>
                <div class="panel-body">
                    <!-- php code for obtaining login history for specific user -->
                    <?php
                    // checking and displaying all errors
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    if ($db) {
                        $result = $db->query("SELECT * FROM login_history WHERE email='$email'");
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo $row['time'] . "<br />";
                            }
                        } else {
                            echo "query execution failed because of" . mysqli_error($db);
                        }
                    } else {
                        echo "db connection error because of" . mysqli_connect_error();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

