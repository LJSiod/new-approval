<?php
session_start();
include('../config/db.php');
$uploadDir = '../uploads/';
$ledgerDir = '../ledger/';

//initializing variables
if (isset($_POST['save'])) {
    $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
    $dateresult = $date->format('Y-m-d');
    $timenodash = $date->format('dhi');
    $branchid = $_SESSION['branchid'];
    $status = "PENDING";

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $fundsource = mysqli_real_escape_string($conn, $_POST['sourceoffund']);
    $loanpurpose = mysqli_real_escape_string($conn, $_POST['purposeofloan']);
    $monthlyincome = mysqli_real_escape_string($conn, $_POST['monthlyincome']);
    $previousloanamount = mysqli_real_escape_string($conn, $_POST["previous"]);
    $proposedloanamount = mysqli_real_escape_string($conn, $_POST['proposed']);
    $approvedloanamount = mysqli_real_escape_string($conn, $_POST['approved']);
    $requirmentpassed = mysqli_real_escape_string($conn, $_POST['requirement']);
    $ci = mysqli_real_escape_string($conn, $_POST['ci']);
    $accountallocation = mysqli_real_escape_string($conn, $_POST['allocation']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if ($type == "Renewal") {
        $accstat = mysqli_real_escape_string($conn, $_POST['accountstatus']);
        $cycle = mysqli_real_escape_string($conn, $_POST['cycle']);
        $paid = mysqli_real_escape_string($conn, $_POST['paids']);
        $balance = mysqli_real_escape_string($conn, $_POST['balances']);
    } else {
        $accstat = "N/A";
        $cycle = "0";
        $paid = "0";
        $balance = "0";
    }

    //insert string datas
    $query1 = "INSERT INTO `ApprovalInfo`(
        `Borrower`, `Address`, `FundSource`, `MonthlyIncome`, 
        `LoanPurpose`, `PreviousLoanAmount`, `ProposedLoanAmount`, `ApprovedLoanAmount`, 
        `RequirementsPassed`, `NameofCI`, `AccountAllocation`, `Remarks`, `BranchID`, `Status`, 
        `AccountStatus`, `Cycle`, `AccountType`, `DateAdded`, `Paid`, `Balance`) 
        VALUES (
        '$name','$address','$fundsource','$monthlyincome','$loanpurpose',
        '$previousloanamount','$proposedloanamount','$approvedloanamount',
        '$requirmentpassed','$ci','$accountallocation', ' ',$branchid,'$status',
        '$accstat','$cycle','$type','$dateresult','$paid','$balance'
    )";

    //if success, upload files and insert filepath in database
    if (mysqli_query($conn, $query1)) {
        $rowID = mysqli_insert_id($conn);

        for ($i = 1; $i <= 12; $i++) {
            $fileTmp = $_FILES["file$i"]['tmp_name'];
            $fileName = $_FILES["file$i"]['name'];
            $filePath = $uploadDir . substr(str_shuffle(MD5(microtime())), 0, 4) . '_' . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                $reqquery = "INSERT INTO requirements (userId, File, DateAdded) VALUES ('$rowID', '$filePath', '$dateresult')";
                if (!mysqli_query($conn, $reqquery)) {
                    echo 'Error inserting file record: ' . mysqli_error($conn);
                }
            }
        }
        //ledger file upload and db insertion
        $fronttmp = $_FILES['ledgerf']['tmp_name'];
        $frontname = $_FILES['ledgerf']['name'];
        $backtmp = $_FILES['ledgerb']['tmp_name'];
        $backname = $_FILES['ledgerb']['name'];
        $front = $ledgerDir . substr(str_shuffle(MD5(microtime())), 0, 4) . '_' . $frontname;
        $back = $ledgerDir . substr(str_shuffle(MD5(microtime())), 0, 4) . '_' . $backname;

        if (!empty($fronttmp) || !empty($backtmp)) {
            $frontPath = null;
            $backPath = null;

            if (!empty($fronttmp)) {
                if (move_uploaded_file($fronttmp, $front)) {
                    $frontPath = $front;
                } else {
                    echo 'Error moving front file.';
                }
            }

            if (!empty($backtmp)) {
                if (move_uploaded_file($backtmp, $back)) {
                    $backPath = $back;
                } else {
                    echo 'Error moving back file.';
                }
            }

            if ($frontPath || $backPath) {
                $reqquery = "INSERT INTO ledger (userId, front, back, date) VALUES ('$rowID', '$frontPath', '$backPath', '$dateresult')";
                if (!mysqli_query($conn, $reqquery)) {
                    echo 'Error inserting file records: ' . mysqli_error($conn);
                }
            }
        }

    } else {
        echo json_encode(["error" => mysqli_error($conn), "query" => $query1]);
    }
    header("Location: ../views/dashboard.php");
    exit;
}

?>