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
error_reporting(1);
if(!isset($_SESSION['userid']))
{
    header('Location: ../index.php?message=1');
}
include 'dbconnection.php';
date_default_timezone_set('Asia/Calcutta');
$currtime = date("Y-m-d H:i:s");
$query = "UPDATE  `taj_users` SET `last_logout`='$currtime', `islogin`=0 WHERE `userid`='".$_SESSION['userid']."'";
mysql_query($query);
session_destroy();
header('Location: ../index.php?message=3');