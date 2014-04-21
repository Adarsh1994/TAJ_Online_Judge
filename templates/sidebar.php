<?php
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
?>
<div class="taj_sidebar">
    <div>
        <ul class="taj_sidebarlist">
            <li><a href='<?php echo $pathpre; ?>dashboard.php'><div>Dashboard</div></a></li>
            <?php
            if($_SESSION['type']==0)
            {
                ?>
                <li><a href='<?php echo $pathpre; ?>profile/viewprofile.php'><div>Profile</div></a></li>
                <li><a href='<?php echo $pathpre; ?>problem/index.php'><div>Problem Arena</div></a></li>
                <!--<li><a href='assignment.php'><div>Assignment Arena</div></a></li>-->
                <li><a href='<?php echo $pathpre; ?>submission/index.php'><div>Submissions</div></a></li>
                <?php
            }
            else if($_SESSION['type']==1)
            {
                ?>
                <li><a href='<?php echo $pathpre; ?>profile/viewprofile.php'><div>Profile</div></a></li>
                <li><a href='<?php echo $pathpre; ?>problem/index.php'><div>Problem Arena</div></a></li>
                <!--<li><a href='assignment.php'><div>Assignment Arena</div></a></li>
                <li><a href='manage_assignment.php'><div>Manage Assignment</div></a></li>-->
                <li><a href='<?php echo $pathpre; ?>submission/index.php'><div>Submissions</div></a></li>
                <?php
            }
            else if($_SESSION['type']==2)
            {
                ?>
                <li><a href='<?php echo $pathpre; ?>profile/viewprofile.php'><div>Profile</div></a></li>
                <li><a href='<?php echo $pathpre; ?>problem/index.php'><div>Problem Arena</div></a></li>
                <!--<li><a href='assignment.php'><div>Assignment Arena</div></a></li>
                <li><a href='manage_assignment.php'><div>Manage Assignment</div></a></li>-->
                <li><a href='<?php echo $pathpre; ?>submission/index.php'><div>Submissions</div></a></li>
                <li><a href='<?php echo $pathpre; ?>teachers/index.php'><div>Manage Teachers</div></a></li>
                <?php
            }
            ?>
            <li><a href='<?php echo $pathpre?>authentication/logout.php'><div>Log Out</div></a></li> 
        </ul>
    </div>
    <div class="taj_welcome">Welcome!!<br/><?php echo $_SESSION['name'];?></div> 
</div>