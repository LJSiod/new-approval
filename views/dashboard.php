<?php
session_start();
include '../config/db.php';
include '../includes/header.php';
date_default_timezone_set('Asia/Manila');

$dateformat = date('F j, Y');
$id = $_SESSION['id'];
$branchid = $_SESSION['branchid'];
$currentdate = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/sc-2.4.3/datatables.min.css" rel="stylesheet"
        integrity="sha384-4YCf35SCoNErxKb3uZGFlBfNxnFh2r1O1NaAO7wl6CIB2geJDtriZeLwca3usiAR" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <title>NLI</title>
    <style>
        table {
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
        }

        .br-pagebody {
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1360px;
        }

        .br-section-wrapper {
            border-radius: 3px;
            padding: 20px;
            /* background-color: #fff; */
            height: 89vh;
            text-wrap: ;
            margin-left: 0px;
            margin-right: 0px;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
            opacity: 95%;
            /* backdrop-filter: blur(10px); */
        }

        .btn {
            border-radius: 50px;
        }

        .approved {
            background-color: #86de86 !important;
            color: black !important
        }

        .pending {
            background-color: #efdfae !important;
            color: black !important
        }

        .rejected {
            background-color: #ebbab9 !important;
            color: black !important
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="br-pagebody">
            <div class="br-section-wrapper bg-dark mt-3">
                <div class="d-flex">
                    <h6 class="text-uppercase fw-bold me-auto" style="font-family: Raleway, sans-serif">
                        Borrowers Information</h6>
                    <span class="text-uppercase fw-bold small"><?php echo $dateformat; ?></span>
                </div>
                <div class="d-flex">
                    <p class="me-auto text-muted border p-2">
                        <i class="fa fa-square" style="color: #86de86"></i><span class="small fw-bold">
                            :Approved</span>
                        <i class="fa fa-square ms-3" style="color: #ebbab9"></i><span class="small fw-bold">
                            :Disapproved</span>
                        <i class="fa fa-square ms-3" style="color: #efdfae"></i><span class="small fw-bold">
                            :Pending</span>
                    </p>
                    <?php if ($branchid == 1) { ?>
                        <span class="text-uppercase text-muted small" id="counter"></span>
                    <?php } ?>
                </div>
                <table id="approvaltable" class="table table-hover">
                    <thead title="Click to Sort">
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
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/sc-2.4.3/datatables.min.js"
        integrity="sha384-1zOgQnerHMsipDKtinJHWvxGKD9pY4KrEMQ4zNgZ946DseuYh0asCewEBafsiuEt"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
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
                rowCallback: function (row, data, index) {
                    if (data.Status === 'APPROVED') {
                        $('td', row).addClass('approved');
                    } else if (data.Status === 'REJECTED') {
                        $('td', row).addClass('rejected');
                    } else {
                        $('td', row).addClass('pending');
                    }
                },
                order: false,
                <?php if ($branchid == 1) { ?>columns: [
                        { data: 'BranchName', render: function (data, type, row) { return "<b class='text-uppercase'>" + data + "</b>"; } },
                        { data: 'Borrower' },
                        { data: 'PreviousLoanAmount' },
                        { data: 'ProposedLoanAmount' },
                        { data: 'ApprovedLoanAmount' },
                        { data: 'AccountStatus' },
                        { data: 'AccountAllocation' },
                        { data: 'Remarks' },
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                return "<div class='btn-group btn-group-sm' role='group' aria-label='Basic example'><a href='preview.php?id=" + data.ID + "' type='button' id='edit' class='btn btn-sm teal'>Edit</a><a href='../actions/actions.php?id=" + data.ID + "&action=disapprove' type='button' id='del' class='btn btn-sm btn-danger'>Del</a></div>";
                            }
                        }
                    ],
                <?php } else { ?>columns: [
                        { data: 'Borrower', render: function (data, type, row) { return "<b>" + data + "</b>"; } },
                        { data: 'PreviousLoanAmount' },
                        { data: 'ProposedLoanAmount' },
                        { data: 'ApprovedLoanAmount' },
                        { data: 'AccountStatus' },
                        { data: 'Remarks', render: function (data, type, row) { return "<b class='text-uppercase'>" + data + "</b>"; } },
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                if (data.Status === 'APPROVED') {
                                    return "<div></div>";
                                } else {
                                    return "<div class='btn-group btn-group-sm' role='group' aria-label='Basic example'><a href='preview.php?id=" + data.ID + "' type='button' id='edit' class='btn btn-sm teal'>Edit</a></div>";
                                }
                            }
                        }
                    ],
                <?php } ?>
            deferRender: true,
                scrollY: '67vh',
                scroller: true,
                drawCallback: function () {
                    $('.dts_label').hide();
                    $('.dt-scroll-body').css('background-image', 'none');
                    $('.dt-layout-start').css({
                        'font-size': '17px',
                        'font-weight': 'bold'
                    });
                },
            });

            function counter() {
                $.ajax({
                    url: '../load/loadcounter.php',
                    success: function (data) {
                        $('#counter').html(data);
                    }
                })
            }

            $(document).on('click', '#del', function (e) {
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