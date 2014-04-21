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
if(!isset($_REQUEST["del_pid"]))
{
    header('Location: problem_error.php?message=1');
}
include $pathpre.'authentication/dbconnection.php';
$pid = $_REQUEST["pid"];
$query = "DELETE FROM `taj_problems` WHERE `id`='$pid'";
mysql_query($query);
header('Location: index.php?message=1');