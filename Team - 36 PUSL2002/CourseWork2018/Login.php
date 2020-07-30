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

<title>Login - CMC</title>

<link href="AccountsStyle.css" rel="stylesheet" />
<hr>
&nbsp;
<form class="content" method="post" action="Login.php">
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
        <label>UserName</label>
        <input type="text" name="username">
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password">
    </div>
    <div class="input-group" align="center">
        <button type="submit" class="btn" name="login_user">Login</button>
    </div>
    <p>
        Not Yet a member? <a href="Register.php">Register</a>
    </p>
</form>

<?php
include_once 'PageFooter.php'
?>
