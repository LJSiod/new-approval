<?php
session_start();
include '../config/db.php';
include '../includes/header.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['branchid'])) {
    header("Location: ../index.php");
    exit();
}

$dateformat = date('F j, Y');
$id = $_SESSION['id'];
$branchid = $_SESSION['branchid'];
$currentdate = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs4/dt-2.2.2/sc-2.4.3/datatables.min.css" rel="stylesheet" integrity="sha384-CMEq2N2G7R4+EycxmPw6yNcPvSdUSaqF6a9t2CJSDxm1J0dVlOpZksuJwROd5KYo" crossorigin="anonymous">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <title>Queueing System</title>
    <style>
        table {
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
            background-color: black;
        }

        .br-pagebody {
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1300px;
        }

        .br-section-wrapper {
            border-radius: 3px;
            background-color: #fff;
            padding: 20px;
            height: 87vh;
            margin-left: 0px;
            margin-right: 0px;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
        }

        .teal {
            background-color: #1CAF9A;
            color: white;
        }

    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="br-pagebody">
            <div class="br-section-wrapper mt-3">
                <div class="d-flex">
                    <h6 class="text-uppercase font-weight-bold mr-auto">Borrowers Information</h6>
                    <span class="text-uppercase font-weight-bold small"><?php echo $dateformat; ?></span>
                </div>
                <div class="d-flex">
                    <p class="mr-auto text-muted">
                      <i class="fa fa-square" style="color: #98FB98"></i><span class="small font-weight-bold"> :Approved</span>
                      <i class="fa fa-square ml-3"style="color: #FFCCCB"></i><span class="small font-weight-bold"> :Disapproved</span>
                      <i class="fa fa-square ml-3" style="color: #FFEEBA"></i><span class="small font-weight-bold"> :Pending</span>
                    </p>
                    <?php if ($branchid == 1) { ?>
                    <span class="text-uppercase text-muted small" id="counter"></span>
                    <?php } ?>
                </div>
                    <table id="approvaltable" class="table table-hover">
                        <thead>
                            <tr>
                                <?php if ($branchid == 1) { ?>
                                <th>BRANCH</th>
                                <th>NAME</th>
                                <th>PREVIOUS</th>
                                <th>PROPOSED</th>
                                <th>APPROVED</th>
                                <th>ACCOUNT</th>
                                <th>ALLOCATION</th>
                                <th>REMARKS</th>
                                <th>ACTIONS</th>
                                <?php } else { ?>
                                <th>NAME</th>
                                <th>PREVIOUS</th>
                                <th>PROPOSED</th>
                                <th>APPROVED</th>
                                <th>ACCOUNT</th>
                                <th>REMARKS</th>
                                <th>ACTIONS</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.9rem" style="margin-top: -15px">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-2.2.2/sc-2.4.3/datatables.min.js" integrity="sha384-Axj01h5eDJyWVXqLtDiRNOjhaWBelga9RSnAFsuOD9x+40MK77FVvLxTihwPnt6B" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        var table = $('#approvaltable').DataTable({
            ajax: {
                url: '../load/loadapproval.php',
                method: 'GET',
                dataSrc: 'data'
            },
            layout: {
                topStart: false,
                topEnd: false,
                bottomEnd: false
            },
            rowCallback: function(row, data, index) {
                    if (data.Status === 'APPROVED') {
                        $(row).css('background-color', '#98FB98');
                    } else if (data.Status === 'REJECTED') {
                        $(row).css('background-color', '#FFCCCB');
                    } else {
                        $(row).css('background-color', '#FFEEBA');
                    }
            },
            order: false,
            <?php if ($branchid == 1) { ?>
            columns: [
                { data: 'BranchName' },
                { data: 'Borrower' },
                { data: 'PreviousLoanAmount' },
                { data: 'ProposedLoanAmount' },
                { data: 'ApprovedLoanAmount' },
                { data: 'AccountStatus' },
                { data: 'AccountAllocation' },
                { data: 'Remarks' },
                {
                    "data": null,
                    "render": function(data, type, row) {
                    return "<div class='btn-group' role='group' aria-label='Basic example'><a href='preview.php?id=" + data.ID + "' type='button' id='edit' class='btn btn-sm teal'>Edit</a><a href='../actions/actions.php?id=" + data.ID + "&action=disapprove' type='button' id='del' class='btn btn-sm btn-danger'>Del</a></div>";
                    }
                }
            ],
            <?php } else { ?>
            columns: [
                { data: 'Borrower' },
                { data: 'PreviousLoanAmount' },
                { data: 'ProposedLoanAmount' },
                { data: 'ApprovedLoanAmount' },
                { data: 'AccountStatus' },
                { data: 'Remarks' },
                {
                        "data": null,
                        "render": function(data, type, row) {
                        if (data.Status === 'APPROVED') {
                            return "<div></div>";
                        } else {
                            return "<div class='btn-group' role='group' aria-label='Basic example'><a href='preview.php?id=" + data.ID + "' type='button' id='edit' class='btn btn-sm teal'>Edit</a></div>";
                        }  
                    }
                }
            ],
            <?php } ?>
            deferRender: true,
            scrollY: '68vh',
            scroller: true,
            drawCallback: function() {
                $('.dts_label').hide();
                $('.dt-scroll-body').css('background-image', 'none');
                $('.dt-layout-start').css({
                  'font-size': '17px',
                  'font-weight': 'bold'
                });
            },
        });
            
        function counter(){
            $.ajax ({
                url: '../load/loadcounter.php',
                success: function(data) {
                    $('#counter').html(data);
                }
            })
        }

        $(document).on('click', '#del', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
        
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                text: 'Disapprove Application',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Disapprove'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });

        counter();
        setInterval(() => {
            counter();
            table.ajax.reload(null, false);
            console.log('%cTable Updated', 'color:red');
        }, 10000);
        }); 
    </script>
</body>
</html>

 