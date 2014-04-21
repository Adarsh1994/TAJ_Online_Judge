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
include $pathpre.'authentication/dbconnection.php';
if (!isset($_SESSION["userid"]))
{
    header('Location: '.$pathpre.'index.php?message=1');
}
if((!isset($_REQUEST['sortby'])) || $_REQUEST['sortby']>6 || $_REQUEST['sortby']<1 )
{
    $sortby = 1;
}
else
{
    $sortby = $_REQUEST['sortby'];
}
if($sortby<4)
{
    $way='ASC';
}
else
{
    $way='DESC';
    $sortby = $sortby - 3;
}
$query = "SELECT * FROM `taj_problems` ORDER BY `";
switch($sortby)
{
    case 1: $query .= "name";
            break;
    case 2: $query .= "id";
            break;
    case 3: $query .= "successful_submission";
            break;
}
$query .= "` ".$way;
$result = mysql_query($query);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - View Problem </title>
    </head>
    <body>
        <?php
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
        ?>
        <div class="taj_content">
            <div class="taj_content_heading">
                Problems
            </div>
            <?php
            if($_SESSION["type"]>0)
            {
                if(isset($_REQUEST["message"]))
                {
                    ?>
                    <div class="taj_problem_message">
                    <?php
                    switch ($_REQUEST["message"])
                    {
                        case 1: echo 'Problem Deleted Successfully !!';
                                break;
                        case 2: echo 'Problem Updated Successfully !!';
                                break;
                    }
                    ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="taj_problem_control_list">
                <a href="search_problem.php?action=1">Search Problem</a>
                <?php
                if($_SESSION["type"]>0)
                {
                ?>
                <a href="search_problem.php?action=2">Edit Problem</a>
                <a href="search_problem.php?action=3">Delete Problem</a>
                <a href="add_problem.php">Add New Problem</a>
                <?php
                }
                ?>
            </div>
            
            <table class="taj_problem_list">
                <tr class="taj_problem_list_heading">
                    <td><a href="index.php?sortby=<?php if($way=="DESC"){echo '2';} else {echo '5';}?>"><div>ID</div></a></td>
                    <td><a href="index.php?sortby=<?php if($way=="DESC"){echo '1';} else {echo '4';}?>"><div>Name</div></a></td>
                    <td><a href="index.php?sortby=<?php if($way=="DESC"){echo '3';} else {echo '6';}?>"><div>Submissions</div></a></td>
                </tr>
                <?php
                while($row = mysql_fetch_array($result))
                {
                    ?>
                    <tr>
                        <td class="taj_problist_idtd"><a href="view_problem.php?pid=<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></a></td>
                        <td class="taj_problist_nametd"><a href="view_problem.php?pid=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a></td>
                        <td class="taj_problist_subtd"><?php echo $row["successful_submission"]; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </body>
</html>