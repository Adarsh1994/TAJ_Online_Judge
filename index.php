<!--
/* 
 * Copyright (C) 2014 Ashish Kedia
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * This file is a part of TAJ Online Judge, developed
 * @National Institute of Technology Karnataka, Surathkal
 */
-->
<?php
session_start();
$pathpre="";
if(isset($_SESSION["userid"]))
{
    header('Location: dashboard.php');
}
if(isset($_POST["loginid"]))
{
    include 'authentication/dbconnection.php';
    $loginid = mysql_real_escape_string($_POST["loginid"]);
    $password = md5(mysql_real_escape_string($_POST["password"]));
    $query="SELECT * FROM taj_users WHERE userid='$loginid' AND password='$password'";
    $queryres = mysql_query($query);
    if(mysql_num_rows($queryres)==1)
    {
        $resultarray = mysql_fetch_array($queryres);
        if($resultarray["islogin"]==1)
        {
            $query = "UPDATE `taj_users` SET `islogin`=0";
            mysql_query($query);
            $message=5;
        }
        else
        {
            $_SESSION['userid'] = $resultarray['userid'];
            $_SESSION['type'] = $resultarray['type'];
            $_SESSION['name'] = $resultarray['name'];
            date_default_timezone_set('Asia/Calcutta');
            $currtime = date("Y-m-d H:i:s");
            $query = "UPDATE  `taj_users` SET `last_login`='$currtime', `islogin`=1, `last_ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `userid`='".$_SESSION['userid']."'";
            mysql_query($query);
            header('Location: dashboard.php');
        }
    }
    else
    {
        $message=2;
    }
}
if(isset($_REQUEST["message"]))
{
    $message = $_REQUEST["message"];
    unset($_REQUEST['message']);

}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="style/login.css">
        <link rel="stylesheet" href="style/templates.css">
        <title>TAJ - Teaching Assisting Judging</title>
        <script type="text/javascript">
            function check_form()
            {
                var id = document.forms["taj_login_form"]["login"].value;
                if(id==="")
                {
                    alert("Please Enter Your Login ID");
                    return false;
                }
                var pass = document.forms["taj_login_form"]["password"].value;
                if(pass==="")
                {
                    alert("Please Enter Your Password");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body class="taj_login">
        <?php include 'templates/header.php';?>
        <form method="post" action="" class="login" id="taj_login_form" onsubmit="return check_form()">
            <p>
                <label for="login">User ID:</label>
                <input type="text" name="loginid" id="login" maxlength="50">
            </p>

            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" maxlength="32">
            </p>

            <p class="login-submit">
                <button type="submit" class="login-button">Login</button>
            </p>
        </form>
        <div class="taj_signup_div">
            <a href="signup.php">Sign Up</a>
        </div>
        <?php
        if(isset($message))
        {
            ?>
            <div class='taj_loginmessage'>
            <p>
            <?php    
            switch ($message) 
            {
                case 1: echo 'Please login to continue !!';
                        break;
                case 2: echo 'Invalid UserID or Password !!';
                        break;
                case 3: echo 'Successfully Logged Out !!';
                        break;
                case 4: echo 'Successfully Registered !!';
                        break;
                case 5: echo 'Session already active @'.$resultarray["last_ip"].' time = '.$resultarray["last_login"].' Contact Admin if account compromised';
                        break;
            }
            unset($message);
            ?>
            </p>
            </div>
            <?php
        }
        ?>
    </body>
</html>