<?php
/**
 * Created by PhpStorm.
 * User: isuru
 * Date: 12/28/2018
 * Time: 9:26 AM
 */
include_once 'PageHeader.php';
include('Server.php');
?>

 <title>Register - CMC</title>
    <link rel="stylesheet" type="text/css" href="AccountsStyle.css">
<hr>
&nbsp;
    <form class="content" method="post" action="Register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>UserType</label>
            <select type="text" name="usertype">
                <option>Volunteer</option>
                <option>Captain</option>
                <option>Staff</option>
            </select>
        </div>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Contact Number</label>
            <input type="text" name="contact">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <label>Admin's password</label>
            <input type="password" name="AdminPassword" placeholder="Required only for Staff and Captain Sign-Ups">
        </div>
        <div class="input-group" align="center">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
    <p>
        Already a member? <a href="Login.php">Sign in</a>
    </p>
</form>


<?php
include_once 'PageFooter.php'
?>
