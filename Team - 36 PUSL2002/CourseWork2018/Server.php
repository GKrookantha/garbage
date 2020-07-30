<?php
session_start();

// initializing variables
$username = "";
$usertype = "";
$contact    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'cmcdb');

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $usertype = mysqli_real_escape_string($db,$_POST['usertype']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $admin = md5(mysqli_real_escape_string($db, $_POST['AdminPassword']));
    $err = mysqli_real_escape_string($db,$_POST['AdminPassword']);

    if (empty($username))
    {
        array_push($errors, "Username is required");
    }
    if (empty($contact))
    {
        array_push($errors, "Contact number is required");
    }
    if (empty($password_1))
    {
        array_push($errors, "Password is required");
    }
    if (empty($password_1))
    {
        array_push($errors, "Confirm password is required");
    }

    if (($usertype=='Captain' or $usertype=='Staff') and empty($err))
    {
        array_push($errors, "Admin Password is required");
    }

    if ($password_1 != $password_2)
    {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' AND usertype='$usertype' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user)
    { // if user exists
        if ($user['username'] === $username and $user['usertype'] === $usertype)
        {
            array_push($errors, "User already exists");
        }
    }


    $admin_query = "SELECT * FROM users WHERE usertype='Administrator' LIMIT 1";
    $find = mysqli_query($db, $admin_query);
    $pass = mysqli_fetch_assoc($find);


    // Finally, register user if there are no errors in the form

    if ($usertype=='Captain' or $usertype=='Staff')
    {
       if(count($errors) == 0 and $pass['password']==$admin)
        {
            $password = md5($password_1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (usertype,username, contact, password) VALUES('$usertype','$username','$contact','$password')";
            mysqli_query($db, $query);
            if($usertype=='Captain')
            {/////////*****************
                $_SESSION['username'] = $username;
                header('location: CaptainMap.php');
            }

            if($usertype=='Staff')
            {
                $_SESSION['username'] = $username;
                header('location: StaffMap.php');
            }
        }

        if($pass)
        {
            if($pass['password']!= $admin)
            {
                array_push($errors, "Admin password doesn't match");
            }
        }
    }

    if (count($errors) == 0 and $usertype=='Volunteer')
    {
        $password = md5($password_1);//encrypt the password before saving in the database
        $query = "INSERT INTO users (usertype,username, contact, password) VALUES('$usertype','$username','$contact','$password')";
        mysqli_query($db, $query);
        if($usertype=='Volunteer')
        {
            $_SESSION['username'] = $username;
            $_SESSION['usertype']=$usertype;
            header('location: VolunteerMap.php');//changed from VolunteerMap.php
        }
    }

}


// LOGIN USER

if (isset($_POST['login_user']))
    {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $chk_Pass = mysqli_real_escape_string($db, $_POST['password']);
        $password = md5(mysqli_real_escape_string($db, $_POST['password']));
        $user_type = mysqli_real_escape_string($db, $_POST['usertype']);

        if (empty($user_type))
        {
            array_push($errors, "User type is required");
        }
        if (empty($username))
        {
            array_push($errors, "User name is required");
        }
        if (empty($chk_Pass))
        {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0)
        {
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND usertype='$user_type'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1)
            {
                if($user_type=='Volunteer')
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['success'];
                    header('location: VolunteerMap.php');//changed from
                }
                if($user_type=='Captain')
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['success'];
                    header('location: CaptainMap.php');
                }
                if($user_type=='Staff')
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['success'];
                    header('location: StaffMap.php');
                }
            }
            else
                {
                array_push($errors, "Invalid Login Attempt");
            }
        }
    }


?>