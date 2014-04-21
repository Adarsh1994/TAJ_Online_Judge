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
if(!isset($_SESSION['userid']))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if($_SESSION['type']<2)
{
    header('Location: '.$pathpre.'access_error?message=1');
}
$pathpre="../";
$signup_err = "";
if(isset($_POST["taj_add_teacher_id"]))
{
    $id = mysql_real_escape_string($_POST["taj_add_teacher_id"]);
    $name = mysql_real_escape_string($_POST["taj_add_teacher_name"]);
    $email = mysql_real_escape_string($_POST["taj_add_teacher_email"]);
    $password = md5(mysql_real_escape_string($_POST["taj_add_teacher_password"]));
    $password_con = md5(mysql_real_escape_string($_POST["taj_add_teacher_password_con"]));
    if(!($email=="" || filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $signup_err .= "Invalid Email-ID";
    }
    elseif($id=="" || $password=="" || $password != $password_con)
    {
        $signup_err .= "Invalid Data";
    }
    else
    {
        include $pathpre."authentication/dbconnection.php";
        $query = "SELECT * FROM `taj_users` WHERE `userid`='$id'";
        if(mysql_num_rows(mysql_query($query))>0)
        {
            $signup_err .= "Userid Unavailable";
        }
        else
        {
            $query = "INSERT INTO `taj_users`(`userid`, `name`, `type`, `password`, `email`) VALUES ('$id','$name',1,'$password','$email')";
            $r = mysql_query($query);
            if($r)
            {
                header('Location: '.$pathpre."teachers/index.php?message=1");
            }
            else
            {
                $signup_err .= "Cannot Register Now !! Try again later !!";
            }
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TAJ - Add Teacher</title>
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/users.css">
        <script type="text/javascript">
            function check_form()
            {
                var f1 = document.forms["taj_add_teacher_form"]["taj_add_teacher_id"].value;
                if(f1==="")
                {
                    alert("Please enter a desired user id");
                    return false;
                }
                var p1 = document.forms["taj_add_teacher_form"]["taj_add_teacher_password"].value;
                var p2 = document.forms["taj_add_teacher_form"]["taj_add_teacher_password_con"].value;
                if(p1==="")
                {
                    alert("Please enter your password");
                    return false;
                }
                if(p2==="")
                {
                    alert("Please enter your password again to confirm");
                    return false;
                }
                if(p1!==p2)
                {
                    alert("Password Mis-match");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>
        <?php
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
        ?>
        <div class="taj_content">
            <div class="taj_content_heading">
                Add New Teacher
            </div>
            <div class="taj_add_teacher_error">
                <?php
                if($signup_err!="")
                {
                    echo $signup_err;
                }
                ?>
            </div>
            <form class="taj_add_teacher_form" id="taj_add_teacher_form" method="post" onsubmit="return check_form()" action="">
                <table class="taj_add_teacher_table">
                    <tr>
                        <td><label for="taj_add_teacher_id">USER ID* :</label></td>
                        <td><input type="text" maxlength="15" id="taj_add_teacher_id" name="taj_add_teacher_id" value="<?php if(isset($_POST['taj_add_teacher_id'])) {echo $_POST['taj_add_teacher_id'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_add_teacher_name">Name :</label></td>
                        <td><input type="text" id="taj_add_teacher_name" name="taj_add_teacher_name" value="<?php if(isset($_POST['taj_add_teacher_name'])) {echo $_POST['taj_add_teacher_name'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_add_teacher_email">Email :</label></td>
                        <td><input type="text" id="taj_add_teacher_email" name="taj_add_teacher_email" value="<?php if(isset($_POST['taj_add_teacher_email'])) {echo $_POST['taj_add_teacher_email'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_add_teacher_password">Password* :</label></td>
                        <td><input type="password" maxlength="32" id="taj_add_teacher_password" name="taj_add_teacher_password"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_add_teacher_password_con">Confirm Password* :</label></td>
                        <td><input type="password" maxlength="32" id="taj_add_teacher_password_con" name="taj_add_teacher_password_con"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Sign Up"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>