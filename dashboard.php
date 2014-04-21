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
$pathpre='';
session_start();
error_reporting(1);
include $pathpre.'authentication/dbconnection.php';
    if(!isset($_SESSION['userid']))
    {
       header('Location: index.php?message=1');
    }
    
    if($_SESSION['type']>0)
    {
        $adm=true;
    }
 
    else{
        $adm=false;
    }
   
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <title>TAJ - Dashboard</title>
        <script>
        function func()
        {
            if(confirm("Are you sure?"))
            {
                document.forms['formid'].submit(); 
            }
        }
        </script>
    </head>
    <body>
        <?php 
            include $pathpre.'templates/header.php';
            include $pathpre.'templates/sidebar.php';
            $result = mysql_query("SELECT * FROM taj_news");
            ?>
        <div class="taj_content">
            
            <div class="taj_content_heading" >
                Announcements
            </div>  
            <div style="margin-top: 20px;">
            <?php if($_SESSION['type']==0)
            {
                ?>
                <marquee behavior="scroll" direction="up" scrollamount='5' onmouseover="javascript:this.setAttribute('scrollamount','0');" onmouseout="javascript:this.setAttribute('scrollamount','4');">
                <?php
            }
            ?>
            <form action="news/delete.php" id="formid" method="post">
                <table class="taj_news_table" style="width:100%">
                    <tr>
                        <?php
                        if($adm)
                        {
                            ?>
                            <th>Mark</th>
                            <?php
                        }
                        ?>
                        <th>Time</th>
                        <th>News</th>
                        <th>Author</th>
                    </tr>
                    <?php 
                    $i=0;
                    while($resultarr = mysql_fetch_array($result))
                    {   
                        ?> 
                        <tr>
                        <?php  
                        if($adm)
                        { 
                            ?>
                            <td><input type="checkbox" name="<?php echo ++$i; ?>" value="<?php echo $resultarr[news_id];?>"></td>
                            <?php
                        }  
                        ?>   
                            <td><?php echo $resultarr['news_time'];?></td>
                            <td class="con"><?php echo $resultarr['news_content'];?></td>
                            <td><?php echo $resultarr['news_author'];?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table> 
            <input type='hidden' name='limit' value="<?php echo $i; ?>">
            </form>
            <?php if($_SESSION['type']==0) { ?> </marquee> <?php } ?>
            </div>
            <?php
            if($adm)
            {
                ?>
                <br/>
                <input type="submit" name="rem" onclick="func()" value="Remove marked items">
                <br/>            
                <form action="news/update.php" method="post">
                    <table class="taj_news_add_table">
                        <tr>
                            <td><label for="news">NEWS:</label></td>
                            <td><textarea name="new" id="news" rows="6" cols="40" placeholder="Enter news here"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="add" value="Add"></td>
                        </tr>
                    </table>
                </form>
                <?php 
                } 
                ?> 
        </div>
        <?php
            if(isset($_REQUEST['none']) && $_REQUEST['none'])
            {
                echo"<script>alert('Nothing Selected!!')</script>";
            }
            if(isset($_REQUEST['empty']) && $_REQUEST['empty'])
            {
                echo"<script>alert('Please enter something!!')</script>";
            }
        ?>
    </body>
</html>