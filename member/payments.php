<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

$payments = [];
$totalPaid = 0;
$memberId = $memberProfile['id'] ?? 0;

if($memberId > 0){
    $stmt = $conn->prepare("
    SELECT *
    FROM payments
    WHERE member_id=?
    ORDER BY payment_date DESC, id DESC
    ");
    $stmt->bind_param("i", $memberId);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $payments[] = $row;
        $totalPaid += (float)$row['amount'];
    }
}

include '../includes/header.php';
?>

<div class="d-flex">
<?php include '../includes/sidebar.php'; ?>
<div class="content flex-grow-1">
<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="card management-hero shadow mb-4">
<div class="card-header bg-primary text-white">
<h3 class="mb-1"><i class="fa fa-wallet"></i> My Payments</h3>
<p class="mb-0 opacity-75">Review your payment history and outstanding balance.</p>
</div>
</div>

<div class="row mb-4">
<div class="col-md-4 mb-3">
<div class="card member-stat shadow h-100"><div class="card-body"><h6>Total Paid</h6><h4><?= member_money($totalPaid) ?></h4></div></div>
</div>
<div class="col-md-4 mb-3">
<div class="card member-stat shadow h-100"><div class="card-body"><h6>Current Balance</h6><h4><?= member_money($memberProfile['balance'] ?? 0) ?></h4></div></div>
</div>
<div class="col-md-4 mb-3">
<div class="card member-stat shadow h-100"><div class="card-body"><h6>Transactions</h6><h4><?= number_format(count($payments)) ?></h4></div></div>
</div>
</div>

<div class="card management-panel shadow">
<div class="card-header bg-primary text-white">Payment History</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle management-table">
<thead>
<tr>
<th>Date</th>
<th>Amount</th>
<th>Method</th>
<th>Reference</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php if(count($payments) > 0): ?>
<?php foreach($payments as $payment): ?>
<tr>
<td><?= member_date($payment['payment_date']) ?></td>
<td><?= member_money($payment['amount']) ?></td>
<td><?= htmlspecialchars($payment['payment_method']) ?></td>
<td><?= htmlspecialchars($payment['reference_number'] ?? '-') ?></td>
<td><span class="badge <?= $payment['status'] == 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= htmlspecialchars($payment['status']) ?></span></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="5" class="text-center text-muted">No payments found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>

</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
