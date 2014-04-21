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
if(!isset($_SESSION["userid"]))
{
    header('Location: '.$pathpre.'index.php');
}
if(!isset($_REQUEST["message"]))
{
    header('Location: '.$pathpre.'dashboard.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - Problem Error</title>
    </head>
    <body>
        <?php
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
        ?>
        <div class="taj_content">
            <div class="taj_addproberror">
                <?php
                $msg = $_REQUEST["message"];
                switch($msg)
                {
                    case 1: echo 'You do not have access right to the requested page!!';
                            break;
                    case 2: echo 'No Problem ID Specified!!';
                            break;
                    case 3: echo 'Wrong Problem ID!!';
                            break;
                }
                unset($_REQUEST["message"]);
                ?>
            </div>
        </div>
    </body>
</html>