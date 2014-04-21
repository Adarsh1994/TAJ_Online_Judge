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
$pathpre = "../";
if (!isset($_SESSION["userid"]))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if(!isset($_REQUEST["pid"]))
{
    header('Location: problem_error.php?message=2');
}
include $pathpre.'authentication/dbconnection.php';
$pid = mysql_real_escape_string($_REQUEST["pid"]);
$query1 = "SELECT * FROM `taj_problems` WHERE `id`='$pid'";
$res1 = mysql_query($query1);
if(mysql_num_rows($res1)==0)
{
    header('Location: problem_error.php?message=3');
}
$prob = mysql_fetch_array($res1);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - View Problem </title>
        <?php
        if($_SESSION["type"]>0)
        {
        ?>
        <script type="text/javascript">
            function confirm_delete()
            {
                var probid = "<?php echo $_REQUEST['pid']; ?>";
                var x = confirm("Are you sure you want to delete " + probid);
                return x;
            }
        </script>
        <?php
        }
        ?>
    </head>
    <body>
        <?php
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
        ?>
        <div class="taj_content">
            <div class="taj_content_heading">
                <?php
                    echo $prob["name"];
                ?>
            </div>
            
            <div class="taj_problem_statement">
                <?php
                    echo $prob["statement"];
                ?>
            </div>
            
            <?php
            if($prob["comment"])
            {
            ?> 
            <div class="taj_problem_comment">
                Comment :
                <?php
                    echo $prob["comment"];
                ?>
            </div>
            <?php
            }
            ?>    
            <div class="taj_problem_author">
                Author :
                <?php
                    echo $prob["author"];
                ?>
            </div>
            <div class="taj_problem_time_add">
                Time Added :
                <?php
                    echo $prob["time_added"];
                ?>
            </div>
            
            <div class="taj_problem_isjudge">
                Judgment :
                <?php
                    if($prob["isjudge"]==0)
                    {
                        echo 'Problem will not be judged';
                    }
                    else
                    {
                        echo 'Problem will be judged';
                    }
                ?>
            </div>
            
            <div class="taj_problem_lang">
                Languages : 
                <?php
                    if($prob["allow_c"]==1)
                    {
                        echo 'C, C++';
                    }
                    if($prob["allow_java"]==1)
                    {
                        echo ', Java';
                    }
                ?>
            </div>
            
            <div class="taj_problem_time_limit">
                Time Limit : 
                <?php
                    if($prob["isjudge"]==1)
                    {
                        if($prob["allow_c"]==1)
                        {
                            echo $prob["time_limit_c"]."s (C, C++)";
                        }
                        if($prob["allow_java"]==1)
                        {
                            echo $prob["time_limit_java"]."s (Java)";
                        }
                    }
                    else
                    {
                        echo 'No Limit Specified';
                    }
                ?>
            </div>
            
            <div class="taj_problem_mem_limit">
                Memory Limit : 
                <?php
                    if($prob["isjudge"]==1)
                    {
                        if($prob["allow_c"]==1)
                        {
                            echo $prob["memory_limit_c"]."MB (C, C++)";
                        }
                        if($prob["allow_java"]==1)
                        {
                            echo $prob["memory_limit_java"]."MB (Java)";
                        }
                    }
                    else
                    {
                        echo 'No Limit Specified';
                    }
                ?>
            </div>
            
            <div class="taj_problem_control_view">
                <form id="taj_problem_submit" method="post" action="submit_solution.php">
                    <input type="hidden" name="submit_pid" id="submit_pid" value="<?php echo $pid; ?>">
                    <input type="submit" value="Submit Solution">
                </form>
                <?php
                if($_SESSION["type"]>0)
                {
                    ?>
                    <form id="taj_problem_edit" method="post" action="edit_problem.php">
                        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                        <input type="submit" value="Edit Problem">
                    </form>
                    <form id="taj_problem_del" method="post" action="delete_problem.php" onsubmit="return confirm_delete()">
                        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                        <input type="submit" value="Delete Problem">
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>