<?php

include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    exit("Invalid Request");
}

$member_id = $_POST['member_id'] ?? '';
$amount = $_POST['amount'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$reference_number = $_POST['reference_number'] ?? '';
$status = $_POST['status'] ?? 'Paid';

if(
    empty($member_id) ||
    empty($amount) ||
    empty($payment_method)
){
    exit("Please fill all required fields");
}

/* ==================================
   RECORD PAYMENT
================================== */

$stmt = $conn->prepare("
INSERT INTO payments
(
    member_id,
    amount,
    payment_date,
    payment_method,
    reference_number,
    status
)
VALUES
(
    ?,
    ?,
    CURDATE(),
    ?,
    ?,
    ?
)
");

$stmt->bind_param(
    "idsss",
    $member_id,
    $amount,
    $payment_method,
    $reference_number,
    $status
);

if(!$stmt->execute()){
    exit("Database Error: ".$stmt->error);
}

/* ==================================
   CREATE RECEIPT
================================== */

$payment_id = $conn->insert_id;

$receipt_no =
'FP-' .
date('Ymd') .
'-' .
str_pad($payment_id,5,'0',STR_PAD_LEFT);

/*
CREATE TABLE receipts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_no VARCHAR(50) UNIQUE,
    payment_id INT,
    member_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/

$receipt = $conn->prepare("
INSERT INTO receipts
(
    receipt_no,
    payment_id,
    member_id
)
VALUES
(
    ?, ?, ?
)
");

$receipt->bind_param(
    "sii",
    $receipt_no,
    $payment_id,
    $member_id
);

$receipt->execute();

/* ==================================
   GET MEMBER PAYMENT DETAILS
================================== */

$member = $conn->prepare("
SELECT
plan_amount,
amount_paid
FROM members
WHERE id = ?
");

$member->bind_param("i",$member_id);
$member->execute();

$result = $member->get_result();

if($result->num_rows == 0){
    exit("Member not found");
}

$row = $result->fetch_assoc();

$currentPaid = (float)$row['amount_paid'];
$planAmount = (float)$row['plan_amount'];

/* ==================================
   CALCULATE NEW TOTALS
================================== */

$newPaid = $currentPaid + $amount;

$newBalance = $planAmount - $newPaid;

if($newBalance < 0){
    $newBalance = 0;
}

/* ==================================
   DETERMINE STATUS
================================== */

$newStatus =
($newBalance <= 0)
? 'Paid'
: 'Pending';

/* ==================================
   UPDATE MEMBER PAYMENT SUMMARY
================================== */

$update = $conn->prepare("
UPDATE members
SET
amount_paid = ?,
balance = ?
WHERE id = ?
");

$update->bind_param(
    "ddi",
    $newPaid,
    $newBalance,
    $member_id
);

$update->execute();

/* ==================================
   UPDATE PAYMENT STATUS
================================== */

$updatePayments = $conn->prepare("
UPDATE payments
SET status = ?
WHERE member_id = ?
");

$updatePayments->bind_param(
    "si",
    $newStatus,
    $member_id
);

$updatePayments->execute();

/* ==================================
   SUCCESS MESSAGE
================================== */

echo "Payment Recorded Successfully.
Receipt No: ".$receipt_no."
 | Total Paid: KES ".number_format($newPaid,2)."
 | Balance: KES ".number_format($newBalance,2)."
 | Status: ".$newStatus;

$stmt->close();

if(isset($receipt)){
    $receipt->close();
}

if(isset($member)){
    $member->close();
}

if(isset($update)){
    $update->close();
}

if(isset($updatePayments)){
    $updatePayments->close();
}

$conn->close();

?>