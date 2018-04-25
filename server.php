<?php
session_start();

// initializing variables
$email = "";
$fullname = "";
$errors = array();

// connect to the database
$db = new mysqli("localhost", "root", "", "userdb");

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $email = $db->real_escape_string($_POST["email"]);
    $fullname = $db->real_escape_string($_POST["fullname"]);
    $password1 = $db->real_escape_string($_POST["password1"]);
    $password2 = $db->real_escape_string($_POST["password2"]);

    // form validation: ensure that the form is correctly filled
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($fullname)) {
        array_push($errors, "Fullname is required");
    }
    if (empty($password1)) {
        array_push($errors, "Password is required");
    }
    if ($password1 != $password2) {
        array_push($errors, "The two passwords do not match");
    }
    if (($password1 == $password2) && strlen($password1) < 6) {
        array_push($errors, "Password should be at least 6 characters");
    }


    // first check the database to make sure
    // a user does not already exist with the same email
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $db->query($user_check_query);
    $user = $result->fetch_assoc();

    if ($user['email'] === $email) {
        array_push($errors, "email already exists");
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (email, fullname, password) 
  			  VALUES('$email', '$fullname', '$password')";
        $db->query($query);
        // updating the login history database
        $db->query("INSERT INTO login_history (email, time) 
		    VALUES('$email', NOW())");
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['login_time'] = $email;
        $_SESSION['success'] = "You are now registered and logged in";
        header('location: index.php');
    }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = $db->real_escape_string($_POST["login_mail"]);
    $password = $db->real_escape_string($_POST["login_password"]);
    // checking if login fields are not empty
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // if no errors, continuing to login validation
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = $db->query($query);
        // checking that query returned only 1 user from db
        if (mysqli_num_rows($results) == 1) {
            // getting the full name base on the email
            $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $result = $db->query($user_check_query);
            $user = $result->fetch_assoc();

            $db->query($query);
            // updating the login history database
            $db->query("INSERT INTO login_history (email, time) 
  			  VALUES('$email', NOW())");

            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong email/password combination");
        }
    }
}

?>

