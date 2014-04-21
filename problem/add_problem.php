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
    if(!isset($_SESSION['userid']))
    {
        header('Location: '.$pathpre.'index.php?message=1');
    }
    if($_SESSION["type"]==0)
    {
        header('Location: problem_error.php?message=1');
    }
include $pathpre.'authentication/dbconnection.php';
$error = '';
if(isset($_REQUEST["probid"]))
{
    $iserror = 0;
    $probquery = "SELECT * FROM `taj_problems` WHERE `id`='".mysql_real_escape_string($_REQUEST['probid'])."'";
    $probres = mysql_query($probquery);
    if(mysql_num_rows($probres)>0)
    {
        $error .= 'Problem ID already exists</br>';
        $iserror = 1;
    }
    date_default_timezone_set('Asia/Calcutta');
    $currtime = date("Y-m-d H:i:s");
    $probid = mysql_real_escape_string($_REQUEST["probid"]);
    $pname = mysql_real_escape_string($_REQUEST["probname"]);
    $pstate = mysql_real_escape_string($_REQUEST["probstate"]);
    $pcomm = mysql_real_escape_string($_REQUEST["comment"]);
    $pjudge = mysql_real_escape_string($_REQUEST["booljudge"]);
    $padder = $_SESSION["userid"];
    
    if(!$pjudge)
    {
        if(!$iserror)
        {
            $q = "INSERT INTO `taj_problems`(`id`, `statement`, `time_added`, `author`, `name`, `comment`, `isjudge`, `successful_submission`, `allow_c`,`allow_java`) VALUES ('$probid','$pstate','$currtime','$padder','$pname','$pcomm',$pjudge,0,0,0)";
            mysql_query($q);
            $error .= "Problem Added Successfully !!";
            unset($_REQUEST["probid"]);
            unset($_REQUEST["probname"]);
            unset($_REQUEST["probstate"]);
            unset($_REQUEST["comment"]);
            unset($_REQUEST["booljudge"]);
        }
    }
    elseif((!isset($_FILES["taj_testcaseupload"])) || $_FILES["taj_testcaseupload"]["error"]>0 || (!isset($_FILES["taj_outputupload"])) || $_FILES["taj_outputupload"]["error"]>0)
    {
        $error .= 'File Upload Error !!';
        $iserror=1;
    }
    else
    {
        $srctest = $_FILES["taj_testcaseupload"]["tmp_name"];
        $srcout = $_FILES["taj_outputupload"]["tmp_name"];
        $nametest = $_FILES["taj_testcaseupload"]["name"];
        $nameout = $_FILES["taj_outputupload"]["name"];
        
        $typetest = $_FILES["taj_testcaseupload"]["type"];
        $typeout = $_FILES["taj_outputupload"]["type"];
        
        //Checking file extension and file type
        $valid_type = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
        $okay1 = strtolower(end(explode(".", $_FILES["taj_testcaseupload"]["name"]))) == 'zip' ? true : false;
        $okay2 = strtolower(end(explode(".", $_FILES["taj_outputupload"]["name"]))) == 'zip' ? true : false;
        $okay3=$okay4=false;
        foreach($valid_type as $mtype)
        {
            if($mtype == $typetest) {$okay3=true;}
            if($mtype == $typeout) {$okay4=true;}
        }
        
        if(!$okay3) {$okay1 = false;}
        if(!$okay4) {$okay2 = false;}
        
        $okay = $okay1 && $okay2;
        if(!$okay)
        {
            $error .= 'File type unsupported. Choose .zip files</br>';
            $iserror=1;
        }
        else
        {
            $query1 = "SELECT * FROM `taj_settings` WHERE `setting`='input_path'";
            $result1 = mysql_query($query1);
            
            if(mysql_num_rows($result1)==0)
            {
                $error .= 'File Paths Not Set</br>';
                $iserror=1;
            }
            else
            {
                $row1 = mysql_fetch_array($result1);
                
                $path = $row1["value"];
                
                if($path == '')
                {
                    $error .= 'Invalid File Path Setting</br>';
                    $iserror=1;
                }
                else
                {
                    $succtest = move_uploaded_file($srctest, $path.$nametest);
                    $succout = move_uploaded_file($srcout, $path.$nameout);
                    if($succtest && $succout)
                    {
                        $ziptest = new ZipArchive();
                        $zipout = new ZipArchive();
                        $s1 = $ziptest->open($path.$nametest);
                        $s2 = $zipout->open($path.$nameout);
                        
                        if($s1 && $s2)
                        {
                            mkdir($path.$probid);
                            mkdir($path.$probid.'/input');
                            mkdir($path.$probid.'/output');
                            
                            $ziptest->extractTo($path.$probid.'/input');
                            $zipout->extractTo($path.$probid.'/output');
                            $ziptest->close();
                            $zipout->close();
                            
                            unlink($path.$nametest);
                            unlink($path.$nameout);
                            
                            //Adding To Database
                            $query2 = "INSERT INTO `taj_problems`(`id`, `statement`, `time_added`, `author`, `name`, `comment`, `isjudge`, `successful_submission`, `allow_c`,`allow_java`) VALUES ('$probid','$pstate','$currtime','$padder','$pname','$pcomm',$pjudge,0,0,0)";
                            echo $query2;
                            mysql_query($query2);
                            if(isset($_REQUEST["ccheck"]))
                            {
                                $pctlim = $_REQUEST["ctimelim"];
                                $pcmlim = $_REQUEST["cmemlim"];
                                unset($_REQUEST["ccheck"]);
                                unset($_REQUEST["cmemlim"]);
                                unset($_REQUEST["ctimelim"]);
                                $query3 = "UPDATE `taj_problems` SET `allow_c`=1,`time_limit_c`='$pctlim',`memory_limit_c`='$pcmlim' WHERE `id`='$probid'";
                                mysql_query($query3);
                            }
                            if(isset($_REQUEST["javacheck"]))
                            {
                                $pjtlim = $_REQUEST["jtimelim"];
                                $pjmlim = $_REQUEST["jmemlim"];
                                unset($_REQUEST["javacheck"]);
                                unset($_REQUEST["jmemlim"]);
                                unset($_REQUEST["jtimelim"]);
                                $query4 = "UPDATE `taj_problems` SET `allow_java`=1,`time_limit_java`='$pjtlim',`memory_limit_java`='$pjmlim' WHERE `id`='$probid'";
                                mysql_query($query4);
                            }
                            
                            unset($_REQUEST["probid"]);
                            unset($_REQUEST["probname"]);
                            unset($_REQUEST["probstate"]);
                            unset($_REQUEST["comment"]);
                            unset($_REQUEST["booljudge"]);
                            $error .= 'Problem Added Successfully </br>';
                        }
                        else
                        {
                            $error .= 'Unable to unzip !! Contact Admin</br>';
                            $iserror=1;
                        }
                    }
                    else
                    {
                        $error .= 'Unable to unzip !! Try Again Later </br>';
                        $iserror=1;
                    }
                }
            }
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png"  href="items/crown250.png">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/templates.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/inside.css">
        <link rel="stylesheet" href="<?php echo $pathpre; ?>style/problem.css">
        <title>TAJ - Add Problem</title>
        <script type='text/javascript'>
            function validate_upload()
            {
                //Checking for filling of forms
                var field1 = document.forms["taj_addprobform"]["probid"].value;
                if(field1==="")
                {
                    alert("Please fill the problem ID");
                    return false;
                }
                field1 = document.forms["taj_addprobform"]["probname"].value;
                if(field1==="")
                {
                    alert("Please fill the problem name");
                    return false;
                }
                field1 = document.forms["taj_addprobform"]["probstate"].value;
                if(field1==="")
                {
                    alert("Please fill the problem statement");
                    return false;
                }
                
                //Checking the Language specifications
                var clang = document.forms["taj_addprobform"]["ccheck"].checked;
                var javalang = document.forms["taj_addprobform"]["javacheck"].checked;
                var isjudge = document.forms["taj_addprobform"]["booljudgeyes"].checked;
                
                if(clang && isjudge)
                {
                    var ctlim = document.forms["taj_addprobform"]["ctimelim"].value;
                    var cmlim = document.forms["taj_addprobform"]["cmemlim"].value;
                    if(ctlim==="" || cmlim==="")
                    {
                        alert("Please Specify Limits for C, C++");
                        return false;
                    }
                }
                
                if(javalang && isjudge)
                {
                    var jtlim = document.forms["taj_addprobform"]["jtimelim"].value;
                    var jmlim = document.forms["taj_addprobform"]["jmemlim"].value;
                    
                    if(jtlim==="" || jmlim==="")
                    {
                        alert("Please Specify Limits for Java");
                        return false;
                    }
                }
                
                if(!clang && !javalang)
                {
                    alert ('Please Select atleast one language for submission');
                    return false;
                }
                
                //Checking for correct file upload
                if(isjudge)
                {
                    var file1 = document.forms["taj_addprobform"]["taj_testcaseupload"].value;
                    var sp = file1.split(".").pop();
                    if(sp!=="zip")
                    {
                        alert("Incorrect file type. Please upload only .zip files");
                        return false;
                    }
                
                    var file2 = document.forms["taj_addprobform"]["taj_outputupload"].value;
                    var sp = file2.split(".").pop();
                    if(sp!=="zip")
                    {
                        alert("Incorrect file type. Please upload only .zip files");
                        return false;
                    }
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
                Add New Problem
            </div>
            <div class="taj_addproberror">
                <?php echo $error; ?>
            </div>
            <form id="taj_addprobform" onsubmit="return validate_upload()" action="" method="post" enctype="multipart/form-data">
                <table class='taj_problemaddtable'>
                    <tr>
                        <td><label for="probid">Problem ID*:</label></td>
                        <td><input type="text" name="probid" maxlength="15" id="probid" placeholder="eg. MAXCOUNT" <?php if(isset($_REQUEST["probid"])){echo "value=\"".$_REQUEST["probid"]."\"";}?> ></td>
                    </tr>
                    <tr>
                        <td><label for="probname">Problem Name*:</label></td>
                        <td><input type="text" name="probname" id="probname" placeholder="Full problem name" <?php if(isset($_REQUEST["probname"])){echo "value=\"".$_REQUEST["probname"]."\"";}?> ></td>
                    </tr>
                    <tr>
                        <td><label for="probstate">Statement*:</label></td>
                        <td><textarea rows="7" cols="50" id="probstate" name="probstate" placeholder="Enter the problem statement here"><?php if(isset($_REQUEST["probstate"])){echo $_REQUEST["probstate"];} ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="comment">Comment :</label></td>
                        <td><input type="text" name="comment" id="comment" placeholder="Any Special Comment" <?php if(isset($_REQUEST["comment"])){echo "value=\"".$_REQUEST["comment"]."\"";}?> ></td>
                    </tr>
                    <tr>
                        <td><label>Judgment :</label></td>
                        <td>
                            <div style='display:inline;'><input type="radio" name="booljudge" id="booljudgeyes" value="1" <?php if(isset($_REQUEST["booljudge"]) && $_REQUEST["booljudge"]==1){echo "checked=\"checked\"";}?> >Yes</div>
                            <div style='display:inline;'><input type="radio" name="booljudge" id="booljudgeno" value="0" <?php if(isset($_REQUEST["booljudge"]) && $_REQUEST["booljudge"]==0){echo "checked=\"checked\"";}?> >No</div>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Languages :</label></td>
                        <td style="display: inline;">
                            <input type="checkbox" value="C" id="ccheck" name="ccheck" <?php if(isset($_REQUEST['ccheck'])) {echo "checked=\"checked\""; } ?> > C, C++
                            <input type="checkbox" value="Java" id="javacheck" name="javacheck" <?php if(isset($_REQUEST['ccheck'])) {echo "checked=\"checked\""; } ?> > Java
                        </td>
                    </tr>
                    <tr>
                        <td><label for="cmemlim">C, C++ Memory Limit :</label></td>
                        <td><input type="text" maxlength="5" placeholder="In MegaBytes" id="cmemlim" name="cmemlim" <?php if(isset($_REQUEST["cmemlim"])){echo "value=\"".$_REQUEST["cmemlim"]."\"";}?> ></td>
                    </tr>
                    <tr>
                        <td><label for="ctimelim">C, C++ Time Limit :</label></td>
                        <td><input type="text" maxlength="6" placeholder="In secs" id="ctimelim" name="ctimelim" <?php if(isset($_REQUEST["ctimelim"])){echo "value=\"".$_REQUEST["ctimelim"]."\"";}?>></td>
                    </tr>
                    <tr>
                        <td><label for="jmemlim">Java Memory Limit :</label></td>
                        <td><input type="text" maxlength="5" placeholder="In MegaBytes" id="jmemlim" name="jmemlim"<?php if(isset($_REQUEST["jmemlim"])){echo "value=\"".$_REQUEST["jmemlim"]."\"";}?> ></td>
                    </tr>
                    <tr>
                        <td><label for="jtimelim">Java Time Limit :</label></td>
                        <td><input type="text" maxlength="6" placeholder="In secs" id="jtimelim" name="jtimelim"<?php if(isset($_REQUEST["jtimelim"])){echo "value=\"".$_REQUEST["jtimelim"]."\"";}?>></td>
                    </tr>
                    <tr>
                        <td><label for="taj_testcaseupload">Test Case :</label></td>
                        <td><input type="file" id="taj_testcaseupload" name="taj_testcaseupload"></td>
                    </tr>
                    <tr>
                        <td><label for="taj_outputupload">Expected Output :</label></td>
                        <td><input type="file" id="taj_outputupload" name="taj_outputupload"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type='submit'></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>