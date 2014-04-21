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
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - Submit Solution </title>
        <script type="text/javascript">
            function validate_submit()
            {
                var subid = document.forms["taj_submit_solution_form"]["submit_probid"].value;
                if(subid==="")
                {
                    alert('Please specify a problem id');
                    return false;
                }
                
                var file1 = document.forms["taj_submit_solution_form"]["taj_sol_file_upload"].value;
                if(file1==="")
                {
                    alert("Please select a solution file");
                    return false;
                }
                var sp = file1.split(".").pop();
                var lang = document.forms["taj_submit_solution_form"]["taj_sol_lang_sel"].value;
                if(sp!==lang)
                {
                    alert("File extension and language selected do not match");
                    return false;
                }
                return false;
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
                Submit a Solution
            </div>
            <form id="taj_submit_solution_form" onsubmit="return validate_submit()" method="post" action="">
                <table class="taj_submit_solution_table">
                    <tr>
                        <td><label for="submit_probid">Problem ID:</label></td>
                        <td><input type="text" name="submit_probid" id="submit_probid" value="<?php if(isset($_REQUEST['submit_pid'])){echo $_REQUEST['submit_pid'];} ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_sol_file_upload">Select File :</label></td>
                        <td><input type="file" name="taj_sol_file_upload" id="taj_sol_file_upload"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_sol_lang_sel">Select Language :</label></td>
                        <td>
                            <select id="taj_sol_lang_sel" name="taj_sol_lang_sel">
                                <option value="c">C</option>
                                <option value="cpp">C++</option>
                                <option value="java">Java</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>