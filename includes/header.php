<?php
session_start();
$name = $_SESSION['name'];
$userid = $_SESSION['id'];
$branchid = $_SESSION['branchid'];
$username = $_SESSION['username'];
?>

<head>
  <link rel="icon" type="image/x-icon" href="../assets/image/NLI.ico">
  <title>NLI</title>
  <style>
    .light {
      background-image: url("../assets/image/10.png");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

    .dark {
      background-image: url("../assets/image/12.png");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

    .profile {
      width: 220px;
    }
  </style>
</head>

<body id="body">
  <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary py-0 shadow-sm me-auto">
    <a class="navbar-brand d-flex align-items-center ms-1" href="dashboard.php">
      <img src="../assets/image/Neologo.png" width="30" height="30" class="d-inline-block align-top me-2" alt="">
      <strong style="font-family: Century Gothic;">NEOCASH|Approval Site</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <input class="form-check-input me-1 d-none" type="checkbox" id="darkModeSwitch" checked>
          <span class="ms-2" style="font-size: 0.7rem;" for="darkModeSwitch">Press
            <kbd>F2</kbd> to
            Toggle <u><b>Dark mode</b></u></span>
          <!-- <div class="form-check form-switch d-flex align-items-center ms-1">
            <input class="form-check-input me-1" type="checkbox" id="darkModeSwitch" checked>
            <label class="form-check-label mt-1 me-1" style="font-size: 0.7rem;" for="darkModeSwitch">Press
              <kbd>F2</kbd> or
              click <u>button</u> to
              toggle <u><b>Dark mode</b></u></label>
          </div> -->
        </li>
      </ul>

      <div class="dropdown">
        <a class="btn btn-tertiary dropdown-toggle fw-bold" style="font-size: 0.8rem;" href="#" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../assets/image/profile.png" style="width: 30px; height: 30px;" name="profile"
            class="rounded-circle mr-2">
          <?= $name; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-end profile" aria-labelledby="dropdownMenuButton">
          <div style="display: flex; align-items: center; justify-content: center;">
            <img src="../assets/image/Neologo.png" class="rounded-circle mt-3" alt="User Image"
              style="width: 90px; height: 90px;">
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
            <a class="dropdown-item small" href="submitapproval.php"><i class="text-success fa fa-plus-circle"
                aria-hidden="true"></i> <b>Submit Borrower</b></a>
          <?php } ?>
          <a class="dropdown-item text-danger small" href="../logout.php" id="logoutButton"><i class="fa fa-sign-out"
              aria-hidden="true"></i> <b>Logout</b></a>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="editprofileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-dark" id="editprofileModalLabel"><i class="fa fa-edit" aria-hidden="true"></i>
            Edit Profile</h6>
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

  <nav class="navbar fixed-bottom navbar-light py-0 footer" style="z-index: 0;">
    <a class="navbar-brand strong mr-auto" href="#" style="font-size: 0.7rem; font-family: Fahkwang, sans-serif;">&copy;
      NLI, All Rights Reserved <?php echo date('Y'); ?></a>
    <span class="text-muted" style="font-size: 0.7rem; font-family: Fahkwang, sans-serif;">Dev: LJ | Version
      <?php echo $_SESSION['version']; ?></span>
  </nav>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>

    function loadtotals() {
      $.ajax({
        url: '../load/loadtotals.php',
        method: 'GET',
        dataType: 'html',
        success: function (data) {
          $('#totals').html(data);
        }
      });
    }

    $(document).ready(function () {
      const htmlElement = $('html');
      const switchElement = $('#darkModeSwitch');
      const wrapper = $('.br-section-wrapper');
      const body = $('#body');

      const currentTheme = localStorage.getItem('bsTheme') || 'dark';
      htmlElement.attr('data-bs-theme', currentTheme);
      switchElement.prop('checked', currentTheme === 'light');

      switchElement.on('change', function () {
        if ($(this).is(':checked')) {
          htmlElement.attr('data-bs-theme', 'light');
          localStorage.setItem('bsTheme', 'light');
          body.removeClass('dark');
          body.addClass('light');
          wrapper.removeClass('bg-dark');
          wrapper.addClass('bg-light');
        } else {
          htmlElement.attr('data-bs-theme', 'dark');
          localStorage.setItem('bsTheme', 'dark');
          body.removeClass('light');
          body.addClass('dark');
          wrapper.removeClass('bg-light');
          wrapper.addClass('bg-dark');
        }
      });

      if (currentTheme === 'dark') {
        body.removeClass('light');
        body.addClass('dark');
        wrapper.removeClass('bg-light');
        wrapper.addClass('bg-dark');

      } else {
        body.removeClass('dark');
        body.addClass('light');
        wrapper.removeClass('bg-dark');
        wrapper.addClass('bg-light');
      }

      $(document).keydown(function (e) {
        if (e.keyCode == 113) {
          switchElement.click();
        }
      });
    });

    $('#editprofileform').submit(function (event) {
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

    $('#editpasswordform').submit(function (event) {
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