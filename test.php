<?php
date_default_timezone_set("Asia/Manila");
$x = date("Gi");
$z = date("G:i");
$y = pow(9999 - $x, 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZK bypass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            backdrop-filter: blur(25px);
        }

        .card-header {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card w-50">
        <div class="card-header">
            <h2 class="card-title">ZK bypass</h2>
        </div>
        <div class="card-body">
            <p class="card-text">Time: <span class="fw-bold"><?= $z ?></span></p>
            <p class="card-text">Username: <span class="fw-bold">8888</span></p>
            <p class="card-text">Pass: <strong><?= $y ?></strong></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        setTimeout(function () {
            window.location.reload(1);
        }, 30000);
    </script>
</body>

</html>




<!-- dropdown -->

<div class="nav-item dropdown">
    <a class="btn btn-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="../assets/image/profile.png" style="width: 30px; height: 30px;" name="profile"
            class="rounded-circle mr-2">
    </a>
    <div class="dropdown-menu dropdown-menu-dark profile">
        <div style="display: flex; align-items: center; justify-content: center;">
            <img src="../assets/image/Neologo.png" class="rounded-circle mt-3" alt="User Image"
                style="width: 70px; height: 70px;">
        </div>
        <h6 class="dropdown-item fw-bold text-center"><?= $name; ?></h6>
        <h6 class="dropdown-item fw-bold text-center text-muted small" style="margin-top: -15px;">
            <u><?= $username; ?></u>
        </h6>
        <span id="totalneo"></span>
        <span id="totalgen"></span>
        <span id="total"></span>
        <div id="totals"></div>
        <h6 style="font-size: 9px; letter-spacing: 2px" class="text-muted text-uppercase text-center fw-bold">
            <i><u>Based on Current Date</u></i>
        </h6>
        <div class="dropdown-divider"></div>
        <?php if ($branchid != 1) { ?>
            <a class="dropdown-item text-dark small" href="submitapproval.php"><i class="text-success fa fa-plus-circle"
                    aria-hidden="true"></i> <b>Submit Borrower</b></a>
        <?php } ?>
        <!-- <a class="dropdown-item text-dark small" href="#" id="editprofile" data-toggle="modal"
            data-target="#editprofileModal"><i class="fa fa-edit" aria-hidden="true"></i> <b>Edit Profile</b></a> -->
        <a class="dropdown-item text-danger small" href="../logout.php" id="logoutButton"><i class="fa fa-sign-out"
                aria-hidden="true"></i> <b>Logout</b></a>
    </div>
</div>