<?php
session_start();
include '../config/db.php';
include '../includes/header.php';
$today = date('Y-m-d');
$id = $_GET['id'];
$branchid = $_SESSION['branchid'];
$filequery = "SELECT File FROM Requirements WHERE userID = '$id' ORDER BY ID DESC";
$fileresult = mysqli_query($conn, $filequery);
$countquery = "SELECT COUNT(File) as filecount FROM Requirements WHERE userID = '$id' AND File != ''";
$countresult = mysqli_query($conn, $countquery);
$count = mysqli_fetch_assoc($countresult);
$query = "SELECT 
    a.ID,
    b.Name AS BranchName,
    a.PreviousLoanAmount,
    a.AccountStatus,
    a.AccountType,
    a.Cycle,
    a.AccountAllocation,
    a.Address,
    a.ApprovedLoanAmount,
    a.Borrower,
    DATE_FORMAT(a.DateAdded, '%b %d, %Y') AS DateAdded,
    a.FundSource,
    a.LoanPurpose,
    a.MonthlyIncome,
    a.NameofCI,
    a.ProposedLoanAmount,
    a.Remarks,
    a.RequirementsPassed,
    a.Status,
    a.Paid,
    a.Balance,
    l.front as front,
    l.back as back
FROM
    ApprovalInfo AS a 
JOIN
    Branch AS b
ON
    a.BranchID = b.ID
LEFT JOIN
    Ledger AS l ON a.ID = l.userID
WHERE
    a.DateAdded >= '$today' 
AND a.ID = '$id'
ORDER BY a.ID DESC";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/viewerjs@1.11.7/dist/viewer.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<style>
  .br-pagebody {
    margin-left: auto;
    margin-right: auto;
    max-width: 1700px;
  }

  .br-section-wrapper {
    padding: 20px;
    margin-left: 0px;
    margin-right: 0px;
    box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
    opacity: 90%;
  }

  .imagelist {
    width: 120px;
    height: 120px;
    max-width: 120px;
    max-height: 120px;
    border: 1px solid #595757;
    margin: 2px;
  }

  .ledgerprev {
    width: 350px;
    height: 230px;
    max-width: 350px;
    max-height: 230px;
    border: 1px solid #595757;
    margin: 2px;
  }
</style>

<div class="br-pagebody">
  <div class="br-section-wrapper bg-dark mt-3">
    <?php if ($branchid == 1) { ?>
      <div class="d-flex justify-content-between">
        <h6 class="text-uppercase fw-bold">Update</h6>
        <h5 class="fw-bold text-uppercase" style="font-family: Raleway, sans-serif">
          <u><?= $row['BranchName'] ?> Branch</u>
        </h5>
      </div>
      <hr>
    <?php } ?>
    <form method="post" action="../actions/edit.php">
      <input type="hidden" name="rowids" value="<?= $row['ID'] ?>">

      <h6 class="mt-1 text-uppercase">Borrowers Information</h6>
      <div class="row">
        <div class="col">
          <strong><label class="text-muted">Name of Borrower</label></strong>
          <input type="text" name="name" id="names" required class="form-control form-control-sm"
            value="<?= $row['Borrower'] ?>">
        </div>

        <div class="col">
          <strong><label class="text-muted">Borrower's Address</label></strong>
          <input type="text" name="address" id="addresss" required class="form-control form-control-sm"
            value="<?= $row['Address'] ?>">
        </div>
        <div class="col">
          <strong><label class="text-muted">Source of Fund:</label></strong>
          <select class="form-select form-select-sm" id="asourceoffunds" name="sourceoffund">
            <option>Employed</option>
            <option>Self-Employed</option>
          </select>
        </div>

        <div class="col">
          <strong><label class="text-muted">Purpose of Loan</label></strong>
          <input type="text" name="purposeofloan" id="purposeofloans" required class="form-control form-control-sm"
            value="<?= $row['LoanPurpose'] ?>">
        </div>

        <div class="col">
          <strong><label class="text-muted">Requirements Passed</label></strong>
          <input type="text" name="requirement" id="requirements" required class="form-control form-control-sm"
            value="<?= $row['RequirementsPassed'] ?>">
        </div>
      </div>
      <div class="row">
        <div class="col">
          <strong><label class="text-muted">Name of Credit Investigator</label></strong>
          <input type="text" name="ci" id="cis" required class="form-control form-control-sm"
            value="<?= $row['NameofCI'] ?>">
        </div>
        <div class="col">
          <strong><label class="text-muted">Estimated Monthly Income</label></strong>
          <input type="number" name="monthlyincome" id="monthlyincomes" required class="form-control form-control-sm"
            value="<?= $row['MonthlyIncome'] ?>">
        </div>
        <div class="col">
          <strong><label class="text-muted">Previous Loan Amount</label></strong>
          <input type="number" name="prevs" id="prevs" required class="form-control form-control-sm"
            value="<?= $row['PreviousLoanAmount'] ?>">
        </div>

        <div class="col">
          <strong><label class="text-muted">Proposed Loan Amount</label></strong>
          <input type="number" name="proposed" id="proposeds" required class="form-control form-control-sm"
            value="<?= $row['ProposedLoanAmount'] ?>">
        </div>

        <div class="col">
          <strong><label class="text-muted">Approved Loan Amount</label></strong>
          <input type="number" name="approved" id="approveds" required class="form-control form-control-sm"
            value="<?= $row['ApprovedLoanAmount'] ?>">
        </div>
      </div>

      <div class="row" style="height: 40vh;">
        <div class="col">
          <strong><label class="text-muted" for="filelist"><?= $count['filecount'] ?> files uploaded</label></strong>
          <ol id="fileList" name="fileList">
            <div class="row">
              <div class="col">
                <div class="row" id="images">
                  <?php while ($files = mysqli_fetch_assoc($fileresult)):
                    if ($files['File'] == null) {
                    } else {
                      if (strpos($files['File'], '.pdf') !== false) { ?>
                        <div>
                          <div class="pdf-image" data-src="<?= $files['File'] ?>"></div>
                        </div>
                      <?php } else { ?>
                        <img class="imagelist" src="<?= $files['File'] ?>" alt="<?= $files['File'] ?>">
                      <?php }
                    }
                  endwhile; ?>
                </div>
              </div>
            </div>
          </ol>
        </div>


        <div class="col">
          <strong><label class="text-muted" for="ledgers">Ledgers</label></strong>
          <div class="row" name="ledgers" id="ledgers">
            <?php if ($row['front'] == null) {
            } else {
              if (strpos($row['front'], '.pdf') !== false) { ?>
                <div class="pdf-image" data-src="<?= $row['front'] ?>"></div>
              <?php } else { ?>
                <img class="ledgerprev" src="<?= $row['front'] ?>" alt="<?= $row['front'] ?>">
              <?php }
            } ?>

            <?php if ($row['back'] == null) {
            } else {
              if (strpos($row['back'], '.pdf') !== false) { ?>
                <div class="pdf-image" data-src="<?= $row['back'] ?>"></div>
              <?php } else { ?>
                <img class="ledgerprev" src="<?= $row['back'] ?>" alt="<?= $row['back'] ?>">
              <?php }
            } ?>
          </div>
        </div>
      </div>

      <h6 class="text-uppercase">Account Information</h6>
      <div class="row">
        <div class="col" id="nocycle">
          <strong><label class="text-muted" for="cycle">No. of Cycle</label></strong>
          <input type="number" name="cycle" id="cycles" required class="form-control form-control-sm"
            value="<?= $row['Cycle']; ?>">
        </div>
        <div class="col" id="paidss">
          <strong><label class="text-muted" for="paid">Remaining Payment Count</label></strong>
          <input type="number" name="paid" id="paids" class="form-control form-control-sm" value="<?= $row['Paid']; ?>">
        </div>
        <div class="col" id="balancess">
          <strong><label class="text-muted" for="balance">Remaining Balance</label></strong>
          <input type="number" name="balance" id="balances" class="form-control form-control-sm"
            value="<?= $row['Balance']; ?>">
        </div>

        <div class="col" id="accountstatuss">
          <strong><label class="text-muted" for="accountstatus">Account Status:</label></strong>
          <select class="form-select form-select-sm" id="accstats" name="accountstatus">
            <option value=""></option>
            <option value="Updated">Updated</option>
            <option value="Days-Delayed">Days-Delayed</option>
            <option value="Past-due">Past-due</option>
            <option value="Expired">Expired</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <strong><label class="text-muted">Account Type:</label></strong>
          <select class="form-select form-select-sm" name="type" id="acctype">
            <option>New Account</option>
            <option>Renewal</option>
          </select>
        </div>

        <div class="col">
          <strong><label class="text-muted">Account Allocation:</label></strong>
          <select class="form-select form-select-sm" id="allocations" name="allocation">
            <option>Neo</option>
            <option>Gen</option>
          </select>
        </div>

        <?php if ($branchid == 1) { ?>
          <div class="col">
            <strong><label class="text-muted">Borrower Status</label></strong>
            <select class="form-select form-select-sm" id="statuss" name="status">
              <option>APPROVED</option>
              <option>REJECTED</option>
              <option>PENDING</option>
            </select>
          </div>
        <?php } else { ?>
          <div class="col">
            <strong><label class="text-muted">Borrower Status</label></strong>
            <input type="text" id="statuss" name="status" class="form-control form-control-sm"
              value="<?= $row['Status']; ?>" readonly>
          </div>
        <?php } ?>

        <div class="col">
          <strong><label class="text-muted">Remarks</label></strong>
          <input type="text" id="remarkss" name="remark" class="form-control form-control-sm"
            value="<?= $row['Remarks']; ?>" <?php if ($branchid != 1) {
                echo 'readonly';
              } ?>>
        </div>
      </div>
      <div class="d-flex justify-content-end mt-2">
        <button type="submit" name="save"
          class="btn btn-sm btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save Changes</button>
        <button type="button" class="btn btn-sm btn-secondary ms-2 tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
          onclick="window.history.back()">Close</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://unpkg.com/viewerjs@1.11.7/dist/viewer.min.js"></script>
<script>
  const requirements = new Viewer(document.getElementById('images'), {
    viewed() {
      const image = requirements.image;
      image.style.border = '1px solid #595757';
      image.style.borderRadius = '5px';
    },
    transition: false,
    toolbar: {
      zoomIn: 1,
      zoomOut: 1,
      oneToOne: 0,
      reset: 0,
      prev: 1,
      play: 0,
      next: 1,
      rotateLeft: 1,
      rotateRight: 1,
      flipHorizontal: 0,
      flipVertical: 0,
    },
  });

  const ledgers = new Viewer(document.getElementById('ledgers'), {
    viewed() {
      const image = ledgers.image;
      image.style.border = '1px solid  #595757';
      image.style.borderRadius = '5px';
    },
    transition: false,
    toolbar: {
      zoomIn: 1,
      zoomOut: 1,
      oneToOne: 0,
      reset: 0,
      prev: 1,
      play: 0,
      next: 1,
      rotateLeft: 1,
      rotateRight: 1,
      flipHorizontal: 0,
      flipVertical: 0,
    },
  });

  const processPDFs = (selector, imageClass) => {
    const elements = document.querySelectorAll(selector + ' .pdf-image');
    elements.forEach(element => {
      const link = element.getAttribute('data-src');
      const loadingTask = pdfjsLib.getDocument(link);
      loadingTask.promise.then(pdf => {
        pdf.getPage(1).then(page => {
          const viewport = page.getViewport({ scale: 1.0 });
          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          page.render({
            canvasContext: context,
            viewport: viewport
          }).promise.then(() => {
            const img = document.createElement('img');
            img.src = canvas.toDataURL('image/png');
            img.className = imageClass;
            element.parentNode.appendChild(img);
            requirements.update();
            ledgers.update();
          });
        });
      });
    });
  };

  processPDFs('#images', 'imagelist');
  processPDFs('#ledgers', 'ledgerprev');

  document.addEventListener('keydown', function (event) {
    if (event.keyCode === 27) {
      console.log('Esc key pressed');
      window.history.back();
    }
  });

  $(document).ready(function () {
    $('#asourceoffunds').val('<?= $row['FundSource']; ?>');
    $('#accstats').val('<?= $row['AccountStatus']; ?>');
    $('#acctype').val('<?= $row['AccountType']; ?>');
    $('#allocations').val('<?= $row['AccountAllocation']; ?>');
    $('#statuss').val('<?= $row['Status']; ?>');

    if ($('#acctype').val() == 'Renewal') {
      $('#accountstatuss').show();
      $('#nocycle').show();
      $('#paidss').show();
      $('#balancess').show();
    } else {
      $('#accountstatuss').hide();
      $('#nocycle').hide();
      $('#paidss').hide();
      $('#balancess').hide();
    }

    $('#acctype').change(function () {
      if ($(this).val() == "Renewal") {
        $('#accountstatuss').show();
        $('#nocycle').show();
        $('#paidss').show();
        $('#balancess').show();
      } else {
        $('#accountstatuss').hide();
        $('#nocycle').hide();
        $('#paidss').hide();
        $('#balancess').hide();
      }
    });
  });

</script>