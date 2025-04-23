<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $filePath = $uploadDir . $fileName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($fileTmp, $filePath)) {
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($fileExtension === 'pdf') {
            $outputFile = substr($filePath, 0, strrpos($filePath, '.')) . '.png';
            $command = "gswin64c -dNOPAUSE -dBATCH -sDEVICE=png16m -r100 -sOutputFile=" . escapeshellarg($outputFile) . " " . escapeshellarg($filePath);
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                echo "<h3>Converted PDF Page:</h3>";
                echo "<img src='$outputFile' style='max-width: 100%; margin-bottom: 10px;'><br>";
                unlink($filePath);
            } else {
                echo "Error converting PDF to PNG.";
            }
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<h3>Uploaded Image:</h3>";
            echo "<img src='$filePath' style='max-width: 100%;'><br>";
        } else {
            echo "Unsupported file type.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and Display</title>
</head>

<body>
    <h1><?= $outputFile ?></h1>
    <h1>Upload a File</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>

</html>