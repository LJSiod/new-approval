<?php
session_start();
include '../config/db.php';
include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<style>
  .fileThumbnail {
    width: 200px;
    height: 100px;
    margin-bottom: 10px;
    border: 1px solid #e5e5e5;
  }

  .br-pagebody {
    margin-top: 10px;
    margin-left: auto;
    margin-right: auto;
    max-width: 1300px;
  }

  .br-section-wrapper {
    background-color: #fff;
    padding: 20px;
    margin-left: 0px;
    margin-right: 0px;
    box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
    opacity: 95%;
  }

  .teal {
    background-color: #1CAF9A;
    color: white;
  }

  .form-layout-footer .btn,
  .form-layout-footer .sp-container button,
  .sp-container .form-layout-footer button {
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
    font-weight: 500;
    padding: 12px 20px;
  }

  .form-layout-2 .form-group,
  .form-layout-3 .form-group {
    position: relative;
    border: 1px solid #ced4da;
    padding: 20px 20px;
    margin-bottom: 0;
    height: 100%;
    transition: all 0.2s ease-in-out;
  }

  .form-layout-2 .form-group-active,
  .form-layout-3 .form-group-active {
    background-color: #f8f9fa;
  }

  .form-layout-2 .form-control-label,
  .form-layout-3 .form-control-label {
    margin-bottom: 8px;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
    display: block;
  }

  .form-layout-2 .form-control,
  .form-layout-2 .dataTables_filter input,
  .dataTables_filter .form-layout-2 input,
  .form-layout-3 .form-control,
  .form-layout-3 .dataTables_filter input,
  .dataTables_filter .form-layout-3 input {
    border: 0;
    padding: 0;
    background-color: transparent;
    color: #343a40;
    border-radius: 0;
    font-weight: 500;
  }

  .form-layout-2 .select2-container--default .select2-selection--single,
  .form-layout-3 .select2-container--default .select2-selection--single {
    background-color: transparent;
    border-color: transparent;
    height: auto;
  }

  .form-layout-2 .select2-container--default .select2-selection--single .select2-selection__rendered,
  .form-layout-3 .select2-container--default .select2-selection--single .select2-selection__rendered {
    padding: 0;
    font-weight: 500;
  }

  .form-layout-2 .select2-container--default .select2-selection--single .select2-selection__arrow,
  .form-layout-3 .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
  }
</style>

<body>
  <div>
    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <h6 class="tx-gray-800 text-uppercase font-weight-bold tx-14 mg-b-10">Borrower's Information</h6>

        <form id="formsubmit" method="post" action="#" enctype="multipart/form-data">

          <div class="form-layout form-layout-2">
            <div class="row no-gutters">

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Borrower's Name: <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="name" required="" value="" placeholder="Enter Name"
                    tabindex="1">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-control-label mg-b-0-force">Source of Fund: <span
                      class="text-danger">*</span></label>
                  <select class="form-control" name="sourceoffund" data-placeholder="Choose source of fund" tabindex="2"
                    aria-hidden="true">
                    <option>Employed</option>
                    <option>Self-Employed</option>
                  </select>
                </div>
              </div><!-- col-8 -->

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-control-label mg-b-0-force">Account Type: <span
                      class="text-danger">*</span></label>
                  <select class="form-control" name="type" id="accounttype" data-placeholder="Choose account type"
                    tabindex="3" aria-hidden="true">
                    <option>New Account</option>
                    <option>Renewal</option>
                  </select>
                </div>
              </div><!-- col-8 -->

              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Borrower's Address: <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="address" required="" value="" tabindex="4"
                    placeholder="Enter Address">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">Estimated Monthly Income: <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="monthlyincome" required="" value=""
                    placeholder="Enter estimated monthly income" tabindex="5">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Purpose of Loan: <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="purposeofloan" required="" value="" tabindex="6"
                    placeholder="Enter Purpose of Loan">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-control-label mg-b-0-force">Account Allocation: <span
                      class="text-danger">*</span></label>
                  <select class="form-control" name="allocation" data-placeholder="Choose account allocation"
                    tabindex="7" aria-hidden="true">
                    <option>Neo</option>
                    <option>Gen</option>
                  </select>
                </div>
              </div><!-- col-8 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">Previous Loan Amount: <span class="text-danger">*</span></label>
                  <input class="form-control" type="number" name="previous" required="" value="0" tabindex="8"
                    placeholder="Enter Previous Loan Amount">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-4 mg-t--1 mg-md-t-0">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label">Proposed Loan Amount: <span class="text-danger">*</span></label>
                  <input class="form-control" type="number" name="proposed" required="" tabindex="9" value=""
                    placeholder="Enter Proposed Loan Amount">
                </div>
              </div><!-- col-4 -->


              <div class="col-md-4 mg-t--1 mg-md-t-0">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label">Approved Loan Amount: <span class="text-danger">*</span></label>
                  <input class="form-control" type="number" name="approved" required="" value="" tabindex="10"
                    placeholder="Enter Approved Loan Amount">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Name of Credit Investigator: <span
                      class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="ci" value="" required="" tabindex="12"
                    placeholder="Enter credit investigator">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Requirements Passed: <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="requirement" required="" tabindex="11" value=""
                    placeholder="Enter requirements passed">
                </div>
              </div><!-- col-8 -->

              <div class="col-md-3" id="requirement1">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 1: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail" src="" alt="File Thumbnail">
                  <input class="form-control" id="file" type="file" name="file" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement2" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 2: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail2" src="" alt="File Thumbnail">
                  <input class="form-control" id="file2" type="file" name="file1" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement3" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 3: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail3" src="" alt="File Thumbnail">
                  <input class="form-control" id="file3" type="file" name="file2" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement4" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 4: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail4" src="" alt="File Thumbnail">
                  <input class="form-control" id="file4" type="file" name="file3" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement5" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 5: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail5" src="" alt="File Thumbnail">
                  <input class="form-control" id="file5" type="file" name="file4" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement6" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 6: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail6" src="" alt="File Thumbnail">
                  <input class="form-control" id="file6" type="file" name="file5" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement7" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 7: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail7" src="" alt="File Thumbnail">
                  <input class="form-control" id="file7" type="file" name="file6" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement8" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 8: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail8" src="" alt="File Thumbnail">
                  <input class="form-control" id="file8" type="file" name="file7" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>
              <div class="col-md-3" id="requirement9" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 9: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail9" src="" alt="File Thumbnail">
                  <input class="form-control" id="file9" type="file" name="file8" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement10" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 10: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail10" src="" alt="File Thumbnail">
                  <input class="form-control" id="file10" type="file" name="file9" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement11" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 11: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail11" src="" alt="File Thumbnail">
                  <input class="form-control" id="file11" type="file" name="file10" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3" id="requirement12" style="display: none;">
                <div class="form-group">
                  <label class="form-control-label">Requirements No. 12: <span class="text-danger"
                      style="font-size: 0.6rem">Image/PDF Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnail12" src="" alt="File Thumbnail">
                  <input class="form-control" id="file12" type="file" name="file11" value="" tabindex="12"
                    placeholder="Upload Requirements">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group" style="display: flex; align-items: center;">
                  <span style="font-size: 0.6rem" class="tx-danger">Max of 12 Files*</span>
                  <button type="button" class="btn btn-secondary" id="addMoreFiles" style="width: 100%;">Add More
                    Files</button>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group" id="accountstatus">
                  <label class="form-control-label mg-b-0-force">Account Status:</label>
                  <select class="form-control" name="accountstatus" data-placeholder="Choose account allocation"
                    tabindex="13" aria-hidden="true">
                    <option value=""></option>
                    <option value="Updated">Updated</option>
                    <option value="Days-Delayed">Days-Delayed</option>
                    <option value="Past-due">Past-due</option>
                    <option value="Expired">Expired</option>
                  </select>
                </div>
              </div><!-- col-4 -->


              <div class="col-md-3">
                <div class="form-group" id="cycle">
                  <label class="form-control-label">Number of Cycle: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" tabindex="14" required name="cycle" value="0"
                    placeholder="Enter Approved Loan Amount">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-3">
                <div class="form-group" id="paid">
                  <label class="form-control-label">Remaining Payment Count: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" tabindex="14" required name="paids" value="0"
                    placeholder="Enter Amount Paid">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-3">
                <div class="form-group" id="balance">
                  <label class="form-control-label">Remaining Balance: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" tabindex="14" multiple name="balances" value="0"
                    placeholder="Enter Remaining Balance">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-3">
                <div class="form-group" id="ledgerf">
                  <label class="form-control-label">Ledger Card Front: <span class="tx-danger"
                      style="font-size: 0.6rem">Image Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnailLedgerf" src="" alt="File Thumbnail">
                  <input class="form-control" type="file" id="ledgerF" name="ledgerf" tabindex="12"
                    placeholder="Upload Ledger">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group" id="ledgerb">
                  <label class="form-control-label">Ledger Card Back: <span class="tx-danger"
                      style="font-size: 0.6rem">Image Only</span></label>
                  <img class="fileThumbnail" id="fileThumbnailLedgerb" src="" alt="File Thumbnail">
                  <input class="form-control" type="file" id="ledgerB" name="ledgerb" tabindex="12"
                    placeholder="Upload Ledger">
                </div>
              </div>


            </div><!-- row -->
            <div class="form-layout-footer">
              <br>
              <input type="text" name="save" value="Submit Borrower" hidden>
              <button class="btn btn-info" type="submit" id="save">Submit Borrower</button>
            </div><!-- form-group -->
          </div>
        </form>

      </div>
    </div><!-- br-pagebody -->
  </div><!-- br-mainpanel -->

</body>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>



<script>

  const fileInputs = document.querySelectorAll('input[id^="file"]');
  const fileThumbnails = document.querySelectorAll('img[id^="fileThumbnail"]');

  fileInputs.forEach((fileInput, index) => {
    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        if (file.type === 'application/pdf') {
          const fileReader = new FileReader();
          fileReader.onload = function (e) {
            const loadingTask = pdfjsLib.getDocument(e.target.result);
            loadingTask.promise.then(function (pdf) {
              pdf.getPage(1).then(function (page) {
                const viewport = page.getViewport({ scale: 1.0 });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                page.render({
                  canvasContext: context,
                  viewport: viewport
                }).promise.then(function () {
                  fileThumbnails[index].src = canvas.toDataURL('image/png');
                });
              });
            });
          };
          fileReader.readAsArrayBuffer(file);
        } else {
          const reader = new FileReader();
          reader.onload = function (e) {
            fileThumbnails[index].src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      }
    });
  });

  const fileInputf = document.getElementById('ledgerF');
  const fileThumbnailf = document.getElementById('fileThumbnailLedgerf');

  fileInputf.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      const file = this.files[0];
      if (file.type === 'application/pdf') {
        const fileReader = new FileReader();
        fileReader.onload = function (e) {
          const loadingTask = pdfjsLib.getDocument(e.target.result);
          loadingTask.promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
              const viewport = page.getViewport({ scale: 1.0 });
              const canvas = document.createElement('canvas');
              const context = canvas.getContext('2d');
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              page.render({
                canvasContext: context,
                viewport: viewport
              }).promise.then(function () {
                fileThumbnailf.src = canvas.toDataURL('image/png');
              });
            });
          });
        };
        fileReader.readAsArrayBuffer(file);
      } else {
        const reader = new FileReader();
        reader.onload = function (e) {
          fileThumbnailf.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  });

  const fileInputb = document.getElementById('ledgerB');
  const fileThumbnailb = document.getElementById('fileThumbnailLedgerb');

  fileInputb.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      if (this.files[0].type === 'application/pdf') {
        const fileReader = new FileReader();
        fileReader.onload = function (e) {
          const loadingTask = pdfjsLib.getDocument(e.target.result);
          loadingTask.promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
              const viewport = page.getViewport({ scale: 1.0 });
              const canvas = document.createElement('canvas');
              const context = canvas.getContext('2d');
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              page.render({
                canvasContext: context,
                viewport: viewport
              }).promise.then(function () {
                fileThumbnailb.src = canvas.toDataURL('image/png');
              });
            });
          });
        };
        fileReader.readAsArrayBuffer(this.files[0]);
      } else {
        const reader = new FileReader();
        reader.onload = function (e) {
          fileThumbnailb.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
      }
    }
  });

  document.getElementById('addMoreFiles').addEventListener('click', function () {
    const nextRequirement = document.querySelector('div[id^="requirement"][style*="display: none"]');
    if (nextRequirement) {
      nextRequirement.style.display = 'block';
    }
  });

  const $purposeSelect = $('#purposeselect');
  $purposeSelect.change(function () {
    if ($(this).val() === 'Others') {
      $('#othertext').show();
    } else {
      $('#othertext').hide();
    }
  });
  $purposeSelect.trigger('change');

  const $accountType = $('#accounttype');
  $accountType.change(function () {
    if ($(this).val() === 'Renewal') {
      $('#accountstatus').show();
      $('#cycle').show();
      $('#paid').show();
      $('#balance').show();
      $('#ledgerf').show();
      $('#ledgerb').show();
    } else {
      $('#accountstatus').hide();
      $('#cycle').hide();
      $('#paid').hide();
      $('#balance').hide();
      $('#ledgerf').hide();
      $('#ledgerb').hide();
    }
  });
  $accountType.trigger('change');

  $('#formsubmit').submit(function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    Swal.fire({
      title: 'Uploading...',
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });
    $.ajax({
      url: '../actions/submit.php',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Upload Success',
          timer: 1500,
          showConfirmButton: false
        }).then(function () {
          window.location.href = 'dashboard.php';
        });
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred. Please try again.'
        });
      }
    });
  });

</script>

</html>