 <?php
//+-----------------+------------------------------------------------------------+
//| Improved by woodchucker , original author Arash Hemmat, info: FileName: split.php
//|  Functions      | Split File script
//|  Authors        | Arash Hemmat (originator),
//|                 | Codex-M (removing classes and developing real application interface
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
//+--------------------------------------------------------------------------------------+

//Place this script in your Apache --PHP localhost HTDOCS directory like XAMPP
//In the form, type the CORRECT filename including CORRECT extension.
//Also enter the maximum file upload limit, the script will automatically compute for the number of parts
if (!isset($_POST['submit']))
{
//form not submitted, display form
?>
<font face="Courier new" size="2.5">
<h3> File Splitting PHP Script by Arash Hemmat & Codex-M (www.php-developer.org) </h3>
<b>Purpose:</b> To split large file into parts which is less than FTP maximum file upload limit.<br />
<b>Instructions:</b> Place this script in your Apache localhost htdocs (this should be inside the "Split Folder" directory.)
<br />
And then place the file to be split in that directory also. Enter details below as accurate as possible. After that press the submit button.<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"
method="post">
<br />
<b>Enter the filename</b>  (exact file name including extension, example: <i>file.wav</i>):<input type="text" name="filenametosplit" size="50">
<br /><br />
<b>Enter FTP hosting server maximum file upload limit in kilobytes</b> :example if file upload limit is 500 KB, enter <i>500</i> only<input type="text" name="maxuploadlimit" size="10">
<br /><br />
<input type="submit" name="submit" value="Split this large file into parts which is less than file upload limit">
</form>
</font>
<?php
}
else
{
//form submitted get the POST data
$file_name = trim($_POST['filenametosplit']);
$maximumuploadlimit = trim($_POST['maxuploadlimit']);
//compute the number of parts
$filesize = ((filesize($file_name))/1000);
$parts_num = ($filesize/$maximumuploadlimit)*2;
$parts_num= floor($parts_num);
function splitthisfile($file_name,$parts_num)
{
$handle = fopen($file_name, 'rb') or die("error opening file");
$file_size =filesize($file_name);
$parts_size = floor($file_size/$parts_num);
$modulus=$file_size % $parts_num;
for($i=0;$i<$parts_num;$i++)
{
if($modulus!=0 & $i==$parts_num-1)
$parts[$i] = fread($handle,$parts_size+$modulus) or die("error reading file");
else
$parts[$i] = fread($handle,$parts_size) or die("error reading file");
}
//close file handle
fclose($handle) or die("error closing file handle");
//writing to splitted files
for($i=0;$i<$parts_num;$i++)
{
$handle = fopen('MergeFolder/splited_'.$i, 'wb') or die("error opening file for writing");
fwrite($handle,$parts[$i]) or die("error writing splited file");
}
//close file handle
fclose($handle) or die("error closing file handle");
return 'OK';
}
splitthisfile($file_name,$parts_num) or die('Error spliting file');
echo '<font face="Courier new" size="2.5">File Splitted succesfully. Take note of the important details which you will use for merging files:';
echo '<br />';
echo 'The filename to be used for merging should be: '.'<b>'.$file_name.'</b>';
echo '<br />';
echo 'The number of splitted parts should be: '.'<b>'.$parts_num.'</b>';
echo '</font>';
}
?>
