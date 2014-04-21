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
$pathpre = '../';
if(!isset($_SESSION['userid']))
{
    header('Location: '.$pathpre.'index.php?message=1');
}

if(isset($_REQUEST['sub']))
{
    header('Location:viewprofile.php?id='.$_REQUEST['user_id']);
}
?>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/profile.css">
        <title>TAJ - Search User</title>
        <script type="text/javascript">
            function validate()
            {
                var uid = document.forms["taj_search_user_form"]["user_id"].value;
                if(uid==="")
                {
                    alert("Please Enter a User ID");
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
                Search User
            </div>
            
            <?php
            if(isset($_REQUEST['abs']) && $_REQUEST['abs']==1)
            {
            ?>
                <div class="taj_search_error">
                    <?php echo "User not found"; ?>
                </div>
            <?php
            }
            ?>
            
            <form id="taj_search_user_form" name="taj_search_user_form" method="post" onsubmit="return validate()">
                <table class="taj_search_user_table">
                    <tr>
                        <td><label for="user_id">Enter User ID: </label></td>
                        <td><input id="user_id" name= "user_id" type="text" maxlength="15"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="sub" value="Search"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>