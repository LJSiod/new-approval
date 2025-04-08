<?php
session_start();
include 'config/db.php';
date_default_timezone_set('Asia/Manila');
$_SESSION['version'] = 'Beta 1.0';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM useraccount WHERE username=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['ID'];
        $_SESSION['branchid'] = $user['BranchID'];
        $_SESSION['name'] = $user['Name'];
        $_SESSION['username'] = $user['Username'];
        if ($user['BranchID'] == 1) {
            $files = glob('uploads/*');
            foreach ($files as $file) {
                if (time() - filemtime($file) > 2 * 24 * 60 * 60) {
                    unlink($file);
                }
            }

            $files = glob('ledger/*');
            foreach ($files as $file) {
                if (time() - filemtime($file) > 2 * 24 * 60 * 60) {
                    unlink($file);
                }
            }

            $sql = "DELETE FROM approvalinfo WHERE dateadded < CURDATE()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql1 = "DELETE FROM requirements WHERE dateadded < CURDATE()";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();

            $sql2 = "DELETE FROM ledger WHERE date < CURDATE()";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();

        }
        $success = "Welcome! " . htmlspecialchars($user['Name']);
    } elseif (mysqli_num_rows($result) > 1) {
        $error = "Multiple users found, please contact your administrator.";

    } else {
        $error = "Invalid Credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="assets/image/NLI.ico" type="image/x-icon">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: "Fira Sans", sans-serif;
            background-image: url('assets/image/9.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #0D9849;
        }

        .form {
            background-color: #fff;
            display: flex;
            flex-direction: row;
            height: auto;
            max-width: 900px;
            width: 100%;
            border-radius: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            margin: 0 auto;
            overflow: hidden;
            opacity: 95%;
            backdrop-filter: blur(10px);
        }

        .form-logo {
            /* background-color: #f8f9fa; */
            background-image: url('assets/image/8.png');
            background-size: cover;
            background-position: center;
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-right: 1px solid #ddd;
        }

        .form-logo img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
        }

        .form-logo h5 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }

        .form-content {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-family: Raleway, sans-serif;
            line-height: 1.75rem;
            letter-spacing: 0.10rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            color: #0D9849;
            margin-bottom: 20px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .input-container label {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .input-container input {
            width: 100%;
            padding: 10px 15px;
            padding-left: 40px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 65%;
            transform: translateY(-50%);
            color: #0D9849;
        }

        .submit {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #0D9849;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .submit:hover {
            background-color: #0d8240;
        }

        .copyright {
            text-align: center;
            color: #555;
            margin-top: 15px;
            font-size: 0.9rem;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form {
                flex-direction: column;
                border-radius: 1rem;
            }

            .form-logo {
                border-right: none;
                border-bottom: 1px solid #ddd;
                padding: 20px;
            }

            .form-content {
                padding: 20px;
            }

            .form-logo img {
                max-height: 150px;
            }

            .form-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <form class="form mx-3" method="POST" action="">
        <div class="form-logo">
            <img src="assets/image/Neologo.png" alt="Logo" draggable="false">
            <h5>NEOCASH LENDING INC.</h5>
            <h6 style="margin-top: -10px; font-size: 0.8rem;">Approval Site</h6>
        </div>
        <div class="form-content">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <h6 class="font-weight-bold"><i
                            class="fa fa-exclamation-triangle text-danger mr-2"></i><?php echo $error; ?>!</h6>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <h2 class="form-title">ACCOUNT LOGIN</h2>
            <div class="input-container">
                <i class="fa fa-user fa-2x mr-2"></i>
                <label class="small m-0" for="username">Username</label>
                <input type="text" placeholder="Enter username" name="username" required style="padding-left: 3rem;">
            </div>
            <div class="input-container" style="position: relative;">
                <i class="fa fa-lock fa-2x mr-2"></i>
                <label class="small m-0" for="password">Password</label>
                <input type="password" placeholder="Enter password" name="password" id="password"
                    style="width: 100%; padding-left: 3rem;" required>
            </div>
            <button type="submit" class="submit">Sign in</button>
            <div class="copyright">
                NLI|Approval Site. &copy; <?php echo date('Y'); ?>. All rights reserved.
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (isset($success)): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo $success; ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            }).then(function () {
                window.location.href = "views/dashboard.php";
            })
        <?php endif; ?>

    </script>
</body>

</html>