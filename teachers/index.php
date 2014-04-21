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
//error_reporting(E_ALL);
session_start();
$pathpre = '../';
if(!isset($_SESSION['userid']))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if($_SESSION['type']<2)
{
    header('Location: '.$pathpre.'access_error?message=1');
}
include $pathpre.'authentication/dbconnection.php';
$query = "SELECT * FROM `taj_users` WHERE `type`=1";
$result = mysql_query($query);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/users.css">
        <title>TAJ - Manage Users</title>
    </head>
    <body>
       <?php
       include $pathpre.'templates/header.php';
       include $pathpre.'templates/sidebar.php'
       ?>
        <div class="taj_content">
            <div class="taj_content_heading">
                Manage Teachers
            </div>
            <?php
            if($_SESSION["type"]>1)
            {
                if(isset($_REQUEST["message"]))
                {
                    ?>
                    <div class="taj_user_message">
                    <?php
                    switch ($_REQUEST["message"])
                    {
                        case 1: echo 'New Teacher Added Successfully !!';
                                break;
                    }
                    ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="taj_teacher_control">
                <a href="add_teacher.php">Add New Teacher</a>
            </div>
            <table class="taj_teacher_list_table">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Problems Added</th>
                </tr>
                <?php
                while($row = mysql_fetch_array($result))
                {
                    ?>
                    <tr>
                        <td><a href="<?php echo $pathpre ?>profile/viewprofile.php?id=<?php echo $row['userid'] ?>"><?php echo $row['userid'] ?></a></td>
                        <td><?php echo $row['name'] ?></td>
                        <td>
                        <?php
                            $res1 = mysql_query("SELECT * FROM `taj_problems` WHERE `author`='".$row['userid']."'");
                            echo mysql_num_rows($res1);
                        ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </body>
</html>