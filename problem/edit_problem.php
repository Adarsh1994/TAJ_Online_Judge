<?php
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
session_start();
$pathpre = '../';
if(!isset($_SESSION['userid']))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if($_SESSION["type"]==0)
{
    header('Location: problem_error.php?message=1');
}
include $pathpre.'authentication/dbconnection.php';
if(isset($_POST["probid"]))
{
    $probid = $_POST["probid"];
    $probstate = $_POST["probstate"];
    $comment = $_POST["comment"];
    $probname = $_POST["probname"];
    $query = "UPDATE `taj_problems` SET `statement`='$probstate', `name`='$probname',`comment`='$comment' WHERE `id`='$probid'";
    mysql_query($query);
    header('Location: index.php?message=2');
}
else if(isset($_REQUEST["pid"]))
{
    $pid = mysql_real_escape_string($_REQUEST["pid"]);
    $query = "SELECT * FROM `taj_problems` WHERE `id`='$pid'";
    $result = mysql_query($query);
    if(mysql_num_rows($result)==0)
    {
        //header('Location: problem_error.php?message=3');
    }
    $row=  mysql_fetch_array($result);
}
else
{
    header('Location: problem_error.php?message=2');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - Edit Problem</title>
        <script type="text/javascript">
            function check_form()
            {
                //Checking name
                var name= document.forms["taj_edit_problem_form"]["probname"].value;
                if(name==="")
                {
                    alert("Please enter a problem name");
                    return false;
                }
            
                //Checking Problem Statement
                var statement= document.forms["taj_edit_problem_form"]["probstate"].value;
                if(statement==="")
                {
                    alert("Please enter a problem statement");
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
                Edit Problem
            </div>
            <form method="post" id="taj_edit_problem_form" name="taj_edit_problem_form" action="" onsubmit="return check_form()">
                <input type="hidden" name="probid" id="probid" value="<?php echo $row["id"]; ?>">
                <table class="taj_problem_edit_table">
                    <tr>
                        <td><label>Problem ID :</label></td>
                        <td><label><?php echo $row["id"]; ?></label></td>
                    </tr>
                    <tr>
                        <td><label for="probname">Problem Name :</label></td>
                        <td><input type="text" name="probname" id="probname" placeholder="Full problem name" value="<?php echo $row["name"]; ?>" ></td>
                    </tr>
                    <tr>
                        <td><label for="probstate">Statement :</label></td>
                        <td><textarea rows="7" cols="50" id="probstate" name="probstate" placeholder="Enter the problem statement here"><?php echo $row["statement"]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="comment">Comment :</label></td>
                        <td><input type="text" name="comment" id="comment" placeholder="Any Special Comment" value="<?php echo $row["comment"]; ?>" ></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type='submit'></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>