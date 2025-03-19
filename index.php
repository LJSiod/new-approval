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
        header("Location: views/dashboard.php");
        exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLI|Approval Site</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="assets/image/neocash.ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#FFF500,
                    #34A18B);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #34A18B,
                    #FFF500);
            right: -30px;
            bottom: -80px;
        }

        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
            letter-spacing: 2px;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #FFFFF0;
        }

        .error {
            color: #ff512f;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="index.php" method="post">
        <h3>Login</h3>
        <label for="username">Username</label>
        <input type="text" placeholder="Username" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password" required>

        <button>Log In</button>
        <div class="d-flex justify-content-between">
            <span class="small">Version <?php echo $_SESSION['version']; ?></span>
            <span class="small">&copy; <?php echo date('Y'); ?> NLI|Approval Site</span>
        </div>
    </form>

    <script src="https://unpkg.com/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        <?php if (isset($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error; ?>',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
</body>

</html>