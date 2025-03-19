<?php
session_start();
$branchid = $_SESSION['BranchID'];
include('../config/db.php');
if (isset($_POST['save'])) {
    $id = $_POST['rowids'];


    $compname = getenv('COMPUTERNAME');


    if ($_POST['purposeofloan'] == "Others") {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $fundsource = mysqli_real_escape_string($conn, $_POST['sourceoffund']);
        $monthlyincome = mysqli_real_escape_string($conn, $_POST['monthlyincome']);
        $loanpurpose = mysqli_real_escape_string($conn, $_POST['others']);
        $previousloanamount = mysqli_real_escape_string($conn, $_POST['prevs']);
        $proposedloanamount = mysqli_real_escape_string($conn, $_POST['proposed']);
        $approvedloanamount = mysqli_real_escape_string($conn, $_POST['approved']);
        $requirmentpassed = mysqli_real_escape_string($conn, $_POST['requirement']);
        $ci = mysqli_real_escape_string($conn, $_POST['ci']);
        $accountallocation = mysqli_real_escape_string($conn, $_POST['allocation']);
        $stat = mysqli_real_escape_string($conn, $_POST['status']);
        $remark = mysqli_real_escape_string($conn, $_POST['remark']);
        $accstat = mysqli_real_escape_string($conn, $_POST['accountstatus']);
        $cycle = mysqli_real_escape_string($conn, $_POST['cycle']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $paid = mysqli_real_escape_string($conn, $_POST['paid']);
        $balance = mysqli_real_escape_string($conn, $_POST['balance']);

        mysqli_query($conn, "UPDATE `ApprovalInfo` SET `Borrower`='$name',`Address`='$address',`FundSource`='$fundsource',`MonthlyIncome`='$monthlyincome',`LoanPurpose`='$loanpurpose',`PreviousLoanAmount`='$previousloanamount',`ProposedLoanAmount`='$proposedloanamount',`ApprovedLoanAmount`='$approvedloanamount',`RequirementsPassed`='$requirmentpassed',`NameofCI`='$ci',`AccountAllocation`='$accountallocation',`Status` = '$stat',`Remarks`='$remark',`AccountStatus`='$accstat',`Cycle`='$cycle',`AccountType`='$type', `Paid` = '$paid', `Balance` = '$balance', `approvebycomp` = '$compname'  WHERE `ID` = '$id'");

    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $fundsource = mysqli_real_escape_string($conn, $_POST['sourceoffund']);
        $monthlyincome = mysqli_real_escape_string($conn, $_POST['monthlyincome']);
        $loanpurpose = mysqli_real_escape_string($conn, $_POST['purposeofloan']);
        $previousloanamount = mysqli_real_escape_string($conn, $_POST['prevs']);
        $proposedloanamount = mysqli_real_escape_string($conn, $_POST['proposed']);
        $approvedloanamount = mysqli_real_escape_string($conn, $_POST['approved']);
        $requirmentpassed = mysqli_real_escape_string($conn, $_POST['requirement']);
        $ci = mysqli_real_escape_string($conn, $_POST['ci']);
        $accountallocation = mysqli_real_escape_string($conn, $_POST['allocation']);
        $stat = mysqli_real_escape_string($conn, $_POST['status']);
        $remark = mysqli_real_escape_string($conn, $_POST['remark']);
        $accstat = mysqli_real_escape_string($conn, $_POST['accountstatus']);
        $cycle = mysqli_real_escape_string($conn, $_POST['cycle']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $paid = mysqli_real_escape_string($conn, $_POST['paid']);
        $balance = mysqli_real_escape_string($conn, $_POST['balance']);

        mysqli_query($conn, "UPDATE `ApprovalInfo` SET `Borrower`='$name',`Address`='$address',`FundSource`='$fundsource',`MonthlyIncome`='$monthlyincome',`LoanPurpose`='$loanpurpose',`PreviousLoanAmount`='$previousloanamount',`ProposedLoanAmount`='$proposedloanamount',`ApprovedLoanAmount`='$approvedloanamount',`RequirementsPassed`='$requirmentpassed',`NameofCI`='$ci',`AccountAllocation`='$accountallocation',`Status` = '$stat',`Remarks`='$remark',`AccountStatus`='$accstat',`Cycle`='$cycle',`AccountType`='$type',`Paid` = '$paid',`Balance` = '$balance' , `approvebycomp` = '$compname' WHERE `ID` = '$id'");
    }
    header("Location: ../views/dashboard.php");
}
?>