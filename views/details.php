<?php
session_start();
include '../config/db.php';
include '../includes/header.php';
$filename = $_GET['filename'];
?>

<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<style>
    iframe {
        width: 100%;
        height: 88vh;
        border-radius: 15px;
        opacity: 90%;
    }
</style>

<body>
    <div class="container mt-2">
        <?php if (isset($filename)) { ?>
            <iframe src="../details/<?= $filename; ?>"></iframe>
        <?php } else { ?>
            <div class="border border-warning p-4 text-warning">
                <h1 style="font-family: Raleway, sans-serif;" class="fw-bold text-center text-decoration-underline">Contract
                    not yet generated!</h1>
            </div>
        <?php } ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>