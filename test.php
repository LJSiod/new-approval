<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple>
    <button type="submit">Upload</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numFiles = count($_FILES['files']['name']);
    echo "You have uploaded $numFiles files.";
}
