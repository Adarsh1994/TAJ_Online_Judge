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
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <title> Taj - Access Denied !! </title>
        <link rel="stylesheet" href="style/templates.css">
        <link rel="stylesheet" href="style/login.css">
    </head>
    <body class="taj_login">
        <?php
            include 'templates/header.php';
        ?>
        <div class="taj_outside_cont">
            <?php
                if(isset($_REQUEST["message"]))
                {
                    ?>
                    <div class="taj_access_message">
                    <?php
                        switch($_REQUEST["message"])
                        {
                            case 1: echo 'You do not have access right for the page requested!!';
                                    break;
                        }
                    ?>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <h1>Access Forbidden!!</h1>
                    <p><a href="index.php">Click Here</a> to go back</p>
                    <?php
                }
            ?>
        </div>
    </body>
</html>