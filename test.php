<?php

$filedir = 'uploads/';
$file = $_FILES['file'];
$filename = $file['name'];
$filetmp = $file['tmp_name'];
$filesize = $file['size'];
$filetype = $file['type'];

move_uploaded_file($filetmp, $filedir . $filename);

?>

<form action="test.php" method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" />
    <input type="submit" name="submit" value="Submit" />