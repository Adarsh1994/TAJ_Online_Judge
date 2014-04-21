<!--
/*
 * Copyright (C) 2014 Adarsh Mohata
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
$pathpre = '../';
include $pathpre.'authentication/dbconnection.php';
if(!isset($_SESSION['userid']))
{
    header('Location:'.$pathpre.'index.php?message=1');
}
if(!isset($_REQUEST['uid']))
{
    $user=$_SESSION['userid'];
}
else if($_SESSION['type']<2 && $_REQUEST['uid']!=$_SESSION['userid'])
{
    header('Location: viewprofile.php?err=1');
}
else
{
    $user=$_REQUEST['uid'];
}
$err = "";
if(isset($_POST["sub"]))
{
    $name = mysql_real_escape_string($_POST["taj_user_name"]);
    $email = mysql_real_escape_string($_POST["taj_email"]);
    $password = md5(mysql_real_escape_string($_POST["taj_user_password"]));
    $password_con = md5(mysql_real_escape_string($_POST["taj_user_password_con"]));
    if($_SESSION['type']==2 && $user!=$_SESSION['userid'])
    {
        $type=$_POST["account_type"];
    }
    if(!($email=="" || filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $err = "Invalid Email-ID";
    }
    elseif($password != $password_con)
    {
        $err = "Password Mismatch";
    }
    else
    {
        $re = mysql_fetch_array(mysql_query("SELECT * FROM `taj_users` WHERE `userid`='$user'"));
        if($email=="")
        {
            $email=$re["email"];
        }
        if($password==md5(""))
        {
            $password=$re["password"];
            
        }
        if(!($_SESSION['type']==2 && $user!=$_SESSION['userid']))
        {
            $type = $re['type'];
        }
        $query = "UPDATE `taj_users` SET `name`='$name', `email`='$email', `type`='$type', `password`='$password' WHERE `userid`='$user'";
        mysql_query($query);
        echo $query;
       header('Location: viewprofile.php?id='.$user);
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/profile.css">
        <title>TAJ- Edit Profile</title>
        <script type="text/javascript">
            function validate()
            {
                var p1 = document.forms["taj_edit_profile"]["taj_user_password"].value;
                var p2 = document.forms["taj_edit_profile"]["taj_user_password_con"].value;
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
            $result = mysql_query("SELECT * FROM `taj_users` WHERE `userid`='$user'");
            $resultarr = mysql_fetch_array($result);
        ?>
        <div class="taj_content">
            
            <div class="taj_content_heading" >
                Edit Profile
            </div>
            
           <form class="taj_edit_profile" id="taj_edit_profile" method="post" onsubmit="return validate()" action="">
              <table class="taj_view_profile_table">
                <tr>
                    <td><label>User Id:</label></td>
                    <td><label><?php echo $resultarr['userid'];?></label></td>
                </tr>
                <?php 
                if($_SESSION['type']==2)
                {
                ?>
                <tr>
                    <td><label>Account type:</label></td>
                    <?php
                    if($user==$_SESSION['userid'])
                    {
                    ?>
                    <td><label>Admin</label></td>
                    <?php
                    }
                    else
                    {
                    ?>
                    <td>
                       <div style='display:inline;'><input type="radio" name="account_type" id="account_type_stu" value="0" <?php if($resultarr['type']==0){echo "checked=\"checked\"";}?> >Student</div>
                       <div style='display:inline;'><input type="radio" name="account_type" id="account_type_tea" value="1" <?php if($resultarr['type']==1){echo "checked=\"checked\"";}?> >Teacher</div>
                    </td>
                    <?php
                    
                     }
                    ?>
                </tr>
               <?php 
               } ?>
                <tr>
                    <td><label>User name:</label></td>
                    <td><input type="text" id="taj_user_name" name="taj_user_name" value="<?php echo $resultarr['name']?>"></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="text" id="taj_email" name="taj_email" value="<?php echo $resultarr['email']?>"></td>
                </tr>
                 <tr>
                    <td><label for="taj_user_password">Password* :</label></td>
                    <td><input type="password" maxlength="32" id="taj_user_password" name="taj_user_password"></td>
                </tr>
                <tr>
                    <td><label for="taj_user_password_con">Confirm Password* :</label></td>
                    <td><input type="password" maxlength="32" id="taj_user_password_con" name="taj_user_password_con"></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="sub" value="Save">
                        <input type="button" onclick="window.location.href='viewprofile.php'" value="Cancel">
                    </td>
                    <td></td>
                </tr>
               </table>
           </form>
        </div>
    </body>
</html>