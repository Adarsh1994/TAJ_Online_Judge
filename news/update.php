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
$pathpre ='../';
include $pathpre.'authentication/dbconnection.php';
$content = mysql_real_escape_string($_REQUEST["new"]);
//echo $content;
if($content=="")
{
//echo "empty";    
header('Location: '.$pathpre.'dashboard.php?empty=1');
}
else
{
    date_default_timezone_set('Asia/Calcutta');
    $time = date("Y-m-d H:i:s");
    $author = $_SESSION['userid'];
    $query = "INSERT INTO `taj_news` VALUES ('NULL','$time','$content','$author')";
    mysql_query($query);
    header('Location: '.$pathpre.'dashboard.php?');
} 
//header('Location: '.$pathpre.'dashboard.php?empty=1');