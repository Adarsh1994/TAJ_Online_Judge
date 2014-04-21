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
$pathpre = '../';
$error="";
if(!isset($_SESSION['userid']))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if(isset($_REQUEST["action"]))
{
    $act = $_REQUEST["action"];
    if($act==2 || $act==3)
    {
        if($_SESSION["type"]==0)
        {
            header('Location: problem_error.php?message=1');
        }
    }
}
else
{
    $act=1;
}
include $pathpre.'authentication/dbconnection.php';
if(isset($_POST["prob_id_input"]))
{
    $pid = mysql_real_escape_string($_POST["prob_id_input"]);
    $query = "SELECT * FROM `taj_problems` WHERE `id`='$pid'";
    $result = mysql_query($query);
    if(mysql_num_rows($result)>0)
    {
        if($act==2)
        {
            header("Location: edit_problem.php?pid=".$pid);
        }
        elseif($act==3)
        {
            header("Location: delete_problem.php?pid=".$pid);
        }
        else
        {
            header("Location: view_problem.php?pid=".$pid);
        }
    }
    else
    {
        $error .= "No Such Problem Found !!";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - Search Problem</title>
        <script type="text/javascript">
            function check_form()
            {
                var probid = document.forms["taj_search_prob_form"]["prob_id_input"].value;
                if(probid==="")
                {
                    alert("Please Enter a Problem ID");
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
                Search Problem
            </div>
            
            <?php
            if($error!="")
            {
            ?>
                <div class="taj_search_error">
                    <?php echo $error; ?>
                </div>
            <?php
            }
            ?>
            
            <form id="taj_search_prob_form" name="taj_search_prob_form" method="post" onsubmit="return check_form()">
                <input type="hidden" name="action" value="<?php echo $act; ?>" >
                <table class="taj_search_prob_table">
                    <tr>
                        <td><label for="prob_id_input">Enter Problem ID: </label></td>
                        <td><input id="prob_id_input" name= "prob_id_input" type="text" maxlength="15"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Search"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>