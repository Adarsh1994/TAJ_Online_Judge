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

if(!isset($_REQUEST['id']))
{
    $user=$_SESSION['userid'];
}
else
{
    $user=$_REQUEST['id'];
    $result = mysql_query("SELECT * FROM `taj_users` WHERE `userid`='$user'");
    if(mysql_num_rows($result)==0)
    {
        header("Location: search_user.php?abs=1");
    }
}
?> 
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/profile.css">
        <title>TAJ- Profile</title>
        
    </head> 
    <body>
        <?php
            
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
            $result = mysql_query("SELECT * FROM `taj_users` WHERE `userid`='$user'");
            $resultarr = mysql_fetch_array($result);
            $problems=mysql_query("SELECT DISTINCT `problemid` FROM `taj_submissions` WHERE `userid`='$user' AND `result`=4 ORDER BY `problemid` ");
            $probres=mysql_fetch_array($problems);
        ?>
        <div class="taj_content">
            
            <div class="taj_content_heading" >
                <?php 
                    switch($resultarr['type'])
                    {
                        case 0: echo "STUDENT" ;
                                break;
                        case 1: echo "TEACHER";
                                break;
                        case 2: echo "ADMIN";
                                break;
                     }
                 ?>
            </div>
            <div class="taj_profile_buttons">
                <a href="search_user.php"><button>Search User</button></a>
                <?php if($user==$_SESSION['userid'] || $_SESSION['type']==2)
                {?>
                <a href="edit_profile.php?uid=<?php echo $user;?>"><button>Edit Profile</button></a>
                <?php
                }?>
            </div>
            <table class="taj_view_profile_table">
                <tr>
                    <td><label>User Id:</label></td>
                    <td><label><?php echo $resultarr['userid'];?></label></td>
                </tr>
                <tr>
                    <td><label>User name:</label></td>
                    <td><label><?php echo $resultarr['name'];?></label></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><label><?php echo $resultarr['email'];?></label></td>
                </tr>
                <tr>
                    <td><label>List of problems:</label></td>
                    <td>
                        <a href="<?php echo $pathpre ?>problem/view_problem.php?pid=<?php echo $probres['problemid'] ?>"><?php echo $probres['problemid'] ?></a>
                        <?php
                        while($probres=mysql_fetch_array($problems))
                        {
                            echo ","
                            ?>
                            <a href="<?php echo $pathpre ?>problem/view_problem.php?pid=<?php echo $probres['problemid'] ?>"><?php echo $probres['problemid'] ?></a>   
                            <?php
                        }
                        ?>  
                    </td>
                </tr>
            </table>
            <div class="taj_profile_stats">
                <table class="taj_submission_table">
                    <tr>
                        <th>Problems solved</th>
                        <th>Solutions submitted</th>
                        <th>Wrong Answers</th>
                        <th>Errors</th>
                    </tr>
                    <tr>
                        <td><?php echo $resultarr['correctprob'];?></td>
                        <td><?php echo $resultarr['totalprob'];?></td>
                        <td><?php echo $resultarr['wrongprob'];?></td>
                        <td><?php echo $resultarr['errorprob'];?></td>
                    </tr>
                </table> 
            </div>
          </div>
    </body>
    <?php if(isset($_REQUEST['err']) && $_REQUEST['err'])
        {
            echo "<script>alert('Access Denied')</script>";
        }?> 
</html>  
