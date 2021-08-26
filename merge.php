<?php
//+-----------------+------------------------------------------------------------+
//| Improved by woodchucker , original author Arash Hemmat, info: FileName: merge.php
//|  Functions      | File Merging Script                                                
//|  Authors        | Arash Hemmat (originator),                                        
//|                 | Codex-M (removing classes and developing real application interface|
//|  Last Modified  | 10 October 2009                                                    
//+-----------------+------------------------------------------------------------+
//|  This program is free software; you can redistribute it and/or                       
//|  modify it under the terms of the GNU General Public License                         
//|  as published by the Free Software Foundation; either version 2                     
//|  of the License, or (at your option) any later version.                              
//|                                                                                      
//|  This program is distributed in the hope that it will be useful,                     
//|  but WITHOUT ANY WARRANTY; without even the implied warranty of                      
//|  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      
//|  GNU General Public License for more details.                                        
//|  A link to authors site is useful but not required: http://www.php-developer.org     
//|                                                                                      
//+------------------------------------------------------------------------------+
//INSTRUCTIONS: Place this script in the desired location at your FTP server where the file should be uploaded.
//In the form, type the EXACT and intended file name to be used as well the EXACT Splitted number of parts used during the splitting process (in your localhost).
//Example, if you split it five times in your XAMPP localhost, you must enter 5 in the form.
if (!isset($_POST['submit']))
{
//form not submitted, display form
?>
<font face="Courier new" size="2.5">
<h3>PHP Merge Script by Arash Hemmat & Codex-M (www.php-developer.org) </h3>
<b>Purpose:</b> To merge splitted parts which are now placed in your FTP server.<br />
<b>Instructions:</b> Place this script in your your FTP server (Apache) containing the same path/directory as the split parts.
<br />
Enter details below as accurate as possible. After that press the submit button.<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"
method="post">
<br />
<b>Enter the filename:</b>(exact file name including extension, example: <i>file.wav</i>) <input type="text" name="filename" size="50">
<br /><br />
<b>Enter the number of splitted parts: </b>(the number of split parts according the file splitting results)<input type="text" name="parts" size="10">
<br /><br />
<input type="submit" name="submit" value="Merge the file">
</form>
</font>
<?php
}
else
{
//form is submitted receive the post data
$merged_file_name =trim($_POST['filename']);
$parts_num =trim($_POST['parts']);
function merge_file($merged_file_name,$parts_num)
{
$content='';
//put splited files content into content
for($i=0;$i<$parts_num;$i++)
{
$file_size = filesize('splited_'.$i);
$handle    = fopen('splited_'.$i, 'rb') or die("error opening file");
$content  .= fread($handle, $file_size) or die("error reading file");
}
//write content to merged file
$handle=fopen($merged_file_name, 'wb') or die("error creating/opening merged file");
fwrite($handle, $content) or die("error writing to merged file");
return 'OK';
}//end of function merge_file
//Set the merged file name
//call merge_file() function to merge the splited files
merge_file($merged_file_name,$parts_num) or die('Error merging files');
echo '<br>Files merged succesfully.';
}
?>
