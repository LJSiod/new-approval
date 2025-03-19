<?php
session_start();
include('../config/db.php');
$uploadDir = '../uploads/';
$ledgerDir = '../ledger/';

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

    $query1 = "INSERT INTO `ApprovalInfo`(
        `Borrower`, `Address`, `FundSource`, `MonthlyIncome`, 
        `LoanPurpose`, `PreviousLoanAmount`, `ProposedLoanAmount`, `ApprovedLoanAmount`, 
        `RequirementsPassed`, `NameofCI`, `AccountAllocation`, `BranchID`, `Status`, 
        `AccountStatus`, `Cycle`, `AccountType`, `DateAdded`, `Paid`, `Balance`) 
        VALUES (
        '$name','$address','$fundsource','$monthlyincome','$loanpurpose',
        '$previousloanamount','$proposedloanamount','$approvedloanamount',
        '$requirmentpassed','$ci','$accountallocation',$branchid,'$status',
        '$accstat','$cycle','$type','$dateresult','$paid','$balance'
    )";

    if (mysqli_query($conn, $query1)) {
        $reqID = mysqli_insert_id($conn);

        for ($i = 0; $i <= 11; $i++) {
            $fileKey = 'file' . ($i === 0 ? '' : $i);
            $filePathVariable = 'file' . ($i === 0 ? '' : $i) . 'Path';
            $fileNameVariable = 'fileName' . ($i === 0 ? '' : $i);
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
                $file = $_FILES[$fileKey];
                $$fileNameVariable = $file['name'];
                $$filePathVariable = $uploadDir . pathinfo($$fileNameVariable, PATHINFO_FILENAME) . '_' . $branchid . '.' . pathinfo($$fileNameVariable, PATHINFO_EXTENSION);
                $filename = $$filePathVariable;
                if (!move_uploaded_file($file['tmp_name'], $$filePathVariable)) {
                    error_log('Error uploading file: ' . $file['name'] . ' to ' . $$filePathVariable);
                    echo 'Error uploading file: ' . $file['name'] . ' to ' . $$filePathVariable;
                } else {
                    $reqquery = "INSERT INTO requirements (userId, File, DateAdded) VALUES ('$reqID', '$filename', '$dateresult')";
                    if (!mysqli_query($conn, $reqquery)) {
                        echo 'Error inserting file record: ' . mysqli_error($conn);
                    }
                }
            } else {
                $$filePathVariable = null;
                $$fileNameVariable = null;
            }
        }

        if (isset($_FILES['ledgerf']) && $_FILES['ledgerf']['error'] == 0) {
            $ledgerfFile = $_FILES['ledgerf'];
            $ledgerfFileName = $ledgerfFile['name'];
            $ledgerfFilePath = $ledgerDir . 'LEDGEF' . '_' . $branchid . $timenodash . '.' . pathinfo($ledgerfFileName, PATHINFO_EXTENSION);
            if (!move_uploaded_file($ledgerfFile['tmp_name'], $ledgerfFilePath)) {
                echo 'Error uploading ledger file';
            }
        }

        if (isset($_FILES['ledgerb']) && $_FILES['ledgerb']['error'] == 0) {
            $ledgerbFile = $_FILES['ledgerb'];
            $ledgerbFileName = $ledgerbFile['name'];
            $ledgerbFilePath = $ledgerDir . 'LEDGEB' . '_' . $branchid . $timenodash . '.' . pathinfo($ledgerbFileName, PATHINFO_EXTENSION);
            if (!move_uploaded_file($ledgerbFile['tmp_name'], $ledgerbFilePath)) {
                echo 'Error uploading ledger file';
            }
        }

        $ledgerquery = "INSERT INTO `ledger` (`userId`, `front`, `back`, `date`) VALUES ('$reqID', '$ledgerfFilePath', '$ledgerbFilePath', '$dateresult')";
        mysqli_query($conn, $ledgerquery);

    } else {
        echo "Error: " . $query1 . "<br>" . mysqli_error($conn);
    }
    header("Location: ../views/dashboard.php");
    exit;
}

?>