<?php
session_start();
$name = $_SESSION['name'];
$userid = $_SESSION['id'];
$branchid = $_SESSION['branchid'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../assets/image/NLI.ico">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="../assets/css/styles.css" rel="stylesheet">
  <title>NLI</title>
  <style>
    
    .navbar {
      background-color:rgb(234, 255, 0); 
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
      color: #fff; 
    }

    .navbar-nav .nav-link {
      color: #fff; 
    }

    .strong {
      font-weight: bolder;
    }

    .white {
      color: white;
    }

    .footer {
      height: 35px;
    }
    
    .profile {
      width: 200px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-white shadow-sm">
    <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
      <img src="../assets/image/Neologo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
      <strong style="font-family: Century Gothic;">NEOCASH|Approval Site</strong>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <!-- <a class="nav-link text-dark" href="#"><i class="fa fa-edit text-success" aria-hidden="true"></i><strong> Submit Borrower </strong></a> -->
        </li>
      </ul>
      <h6 class="mr-2 small">Current User: <b><?= $name; ?></b></h6>
      <div class="dropdown">
        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="../assets/image/profile.png" style="width: 30px; height: 30px;" name="profile" class="rounded-circle mr-2">
        </button>
        <div class="dropdown-menu dropdown-menu-right profile" aria-labelledby="dropdownMenuButton">
          <div style="display: flex; align-items: center; justify-content: center;">
            <img src="../assets/image/Neologo.png" class="rounded-circle mt-3" alt="User Image" style="width: 70px; height: 70px;">
          </div>
          <h6 class="dropdown-item font-weight-bold text-center"><?= $name; ?></h6>
          <span class="dropdown-item font-weight-bold text-center text-muted small" style="margin-top: -15px;"><u><?= $username; ?></u></span>
          <span id="totalneo"></span>
          <span id="totalgen"></span>
          <span id="total"></span>
          <div id="totals"></div>
          <div class="dropdown-divider"></div>
          <?php if ($branchid != 1) { ?>
          <a class="dropdown-item text-dark small" href="submitapproval.php"><i class="text-success fa fa-plus-circle" aria-hidden="true"></i> <b>Submit Borrower</b></a>
          <?php } ?>
          <a class="dropdown-item text-dark small" href="#" id="editprofile" data-toggle="modal" data-target="#editprofileModal"><i class="fa fa-edit" aria-hidden="true"></i> <b>Edit Profile</b></a>
          <a class="dropdown-item text-danger small" href="../logout.php" id="logoutButton"><i class="fa fa-sign-out" aria-hidden="true"></i> <b>Logout</b></a>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="editprofileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-dark" id="editprofileModalLabel"><i class="fa fa-edit" aria-hidden="true"></i> Edit Profile</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="../actions/actions.php" id="editprofileform" method="get">
          <h6 class="text-dark">Username</h6>
          <input type="hidden" name="action" value="username">
          <input type="hidden" name="id" value="<?php echo $userid; ?>">
          <div class="form-group">
            <label class="small" for="username">New Username</label>
            <input type="text" class="form-control form-control-sm" id="username" name="username">
          </div>
          <div class="form-group">
            <label class="small" for="confirmusername">Confirm New Username</label>
            <input type="text" class="form-control form-control-sm" id="confirmusername" name="confirmusername">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
          </div>
          </form>
          <hr>
          <form action="../actions/actions.php" id="editpasswordform" method="get">
          <h6 class="text-dark">Password</h6>
            <input type="hidden" name="action" value="password">
            <input type="hidden" name="id" value="<?php echo $userid; ?>">
            <div class="form-group">
              <label class="small" for="password">New Password</label>
              <input type="password" class="form-control form-control-sm" id="password" name="password">
            </div>
            <div class="form-group">
              <label class="small" for="confirmpassword">Confirm New Password</label>
              <input type="password" class="form-control form-control-sm" id="confirmpassword" name="confirmpassword">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
            </div>
          </form>
        </div>
    </div>
  </div>
  </div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

    function loadtotals() {
        $.ajax({
            url: '../load/loadtotals.php',
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#totals').html(data);
            }
        });
    }

    $('#editprofileform').submit(function(event) {
      event.preventDefault(); 
            if ($('#username').val() !== $('#confirmusername').val()) {
                Swal.fire("Username does not match!", "Please enter the same username in both fields.", "error");
            } else {
                Swal.fire({
                    title: "Save Changes?",
                    text: "Are you sure you want to save changes to your profile?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            }
    });

    $('#editpasswordform').submit(function(event) {
      event.preventDefault(); 
            if ($('#password').val() !== $('#confirmpassword').val()) {
                Swal.fire("Password does not match!", "Please enter the same password in both fields.", "error");
            } else {
                Swal.fire({
                    title: "Save Changes?",
                    text: "Are you sure you want to save changes to your password?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            }
    });

    loadtotals();
    setInterval(() => {
      loadtotals();
    }, 10000);
    </script>