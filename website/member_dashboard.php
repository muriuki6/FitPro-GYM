<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if(($_SESSION['role_id'] ?? 0) != 3){
    header('Location: login.php');
    exit();
}

function portal_h($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function portal_money($amount){
    return 'KES ' . number_format((float)$amount, 2);
}

function portal_date($date){
    return $date ? date('d M Y', strtotime($date)) : '-';
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$userStmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$userStmt->bind_param('i', $userId);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();

$memberProfile = null;
$payments = [];
$attendance = [];

if($user){
    $memberStmt = $conn->prepare("
        SELECT m.*, mp.plan_name, mp.duration_days, mp.description plan_description, mp.benefits plan_benefits
        FROM members m
        LEFT JOIN membership_plans mp ON m.plan_id = mp.id
        WHERE m.email=?
        ORDER BY CASE WHEN m.status='Active' THEN 0 ELSE 1 END, m.expiry_date DESC, m.id DESC
        LIMIT 1
    ");
    $memberStmt->bind_param('s', $user['email']);
    $memberStmt->execute();
    $memberProfile = $memberStmt->get_result()->fetch_assoc();
    $memberStmt->close();
}

$memberId = (int)($memberProfile['id'] ?? 0);

if(isset($_GET['receipt']) && $memberId > 0){
    $paymentId = (int)$_GET['receipt'];
    $receiptStmt = $conn->prepare("
        SELECT p.*, m.fullname, m.member_code, mp.plan_name
        FROM payments p
        JOIN members m ON p.member_id=m.id
        LEFT JOIN membership_plans mp ON m.plan_id=mp.id
        WHERE p.id=? AND p.member_id=?
    ");
    $receiptStmt->bind_param('ii', $paymentId, $memberId);
    $receiptStmt->execute();
    $receipt = $receiptStmt->get_result()->fetch_assoc();

    if($receipt){
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="fitpro-receipt-' . $paymentId . '.txt"');
        echo "FitPro Gym Receipt\n";
        echo "Receipt No: FIT-" . date('Ymd', strtotime($receipt['payment_date'])) . '-' . str_pad((string)$receipt['id'], 5, '0', STR_PAD_LEFT) . "\n";
        echo "Member: " . $receipt['fullname'] . "\n";
        echo "Member Code: " . $receipt['member_code'] . "\n";
        echo "Plan: " . ($receipt['plan_name'] ?? 'Membership') . "\n";
        echo "Date: " . $receipt['payment_date'] . "\n";
        echo "Amount: " . portal_money($receipt['amount']) . "\n";
        echo "Method: " . $receipt['payment_method'] . "\n";
        echo "Status: " . $receipt['status'] . "\n";
        exit();
    }
}

if($memberId > 0){
    $paymentStmt = $conn->prepare("SELECT * FROM payments WHERE member_id=? ORDER BY payment_date DESC, id DESC");
    $paymentStmt->bind_param('i', $memberId);
    $paymentStmt->execute();
    $paymentResult = $paymentStmt->get_result();
    while($row = $paymentResult->fetch_assoc()){
        $payments[] = $row;
    }
    $paymentStmt->close();

    $attendanceStmt = $conn->prepare("
        SELECT a.*
        FROM attendance a
        JOIN (
            SELECT MAX(id) id
            FROM attendance
            WHERE member_id=?
            GROUP BY member_id, attendance_date
        ) latest ON latest.id=a.id
        ORDER BY a.attendance_date DESC, a.id DESC
        LIMIT 30
    ");
    $attendanceStmt->bind_param('i', $memberId);
    $attendanceStmt->execute();
    $attendanceResult = $attendanceStmt->get_result();
    while($row = $attendanceResult->fetch_assoc()){
        $attendance[] = $row;
    }
    $attendanceStmt->close();
}

$daysLeft = null;
if(!empty($memberProfile['expiry_date'])){
    $today = new DateTime(date('Y-m-d'));
    $expiry = new DateTime($memberProfile['expiry_date']);
    $daysLeft = (int)$today->diff($expiry)->format('%r%a');
}

$pageTitle = 'Member Portal | FitPro Gym';
$pageDescription = 'FitPro member portal for profile, membership status, payments, receipts, attendance, and renewals.';
$activePage = '';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
<div class="container position-relative">
<span class="eyebrow"><i class="fa fa-gauge-high"></i> Member Portal</span>
<h1 class="hero-title">Welcome, <span><?= h($_SESSION['fullname'] ?? 'Member') ?></span></h1>
<p class="page-copy">Your profile, membership status, payment history, receipts, attendance, and renewal actions in one connected dashboard.</p>
</div>
</section>

<section class="section-pad section-soft">
<div class="container">
<?php if(!$memberProfile): ?>
<div class="alert alert-warning reveal">Your login is active, but no member profile is linked to <?= h($user['email'] ?? '') ?> yet. Please contact the front desk.</div>
<?php else: ?>
<div class="row g-4 mb-4">
<div class="col-md-6 col-xl-3 reveal"><div class="premium-card p-4"><small class="text-muted">Membership</small><h4 class="fw-bold mb-0"><?= h($memberProfile['plan_name'] ?? 'No Plan') ?></h4></div></div>
<div class="col-md-6 col-xl-3 reveal"><div class="premium-card p-4"><small class="text-muted">Status</small><h4 class="fw-bold mb-0"><?= h($memberProfile['status'] ?? 'Pending') ?></h4></div></div>
<div class="col-md-6 col-xl-3 reveal"><div class="premium-card p-4"><small class="text-muted">Days Left</small><h4 class="fw-bold mb-0"><?= $daysLeft === null ? '-' : h($daysLeft) ?></h4></div></div>
<div class="col-md-6 col-xl-3 reveal"><div class="premium-card p-4"><small class="text-muted">Balance</small><h4 class="fw-bold mb-0"><?= portal_money($memberProfile['balance'] ?? 0) ?></h4></div></div>
</div>

<div class="row g-4">
<div class="col-lg-5 reveal">
<div class="premium-card p-4 h-100">
<h3 class="fw-bold">Profile</h3>
<p class="mb-2"><strong>Name:</strong> <?= h($memberProfile['fullname']) ?></p>
<p class="mb-2"><strong>Email:</strong> <?= h($memberProfile['email']) ?></p>
<p class="mb-2"><strong>Phone:</strong> <?= h($memberProfile['phone']) ?></p>
<p class="mb-2"><strong>Joined:</strong> <?= portal_date($memberProfile['join_date']) ?></p>
<p class="mb-0"><strong>Expires:</strong> <?= portal_date($memberProfile['expiry_date']) ?></p>
</div>
</div>
<div class="col-lg-7 reveal">
<div class="premium-card p-4 h-100">
<h3 class="fw-bold">Membership Status</h3>
<p class="text-muted"><?= h($memberProfile['plan_description'] ?? 'Your active FitPro membership.') ?></p>
<div class="row text-center">
<div class="col-md-4 mb-3"><div class="skill-pill w-100 justify-content-center">Plan <?= portal_money($memberProfile['plan_amount'] ?? 0) ?></div></div>
<div class="col-md-4 mb-3"><div class="skill-pill w-100 justify-content-center">Paid <?= portal_money($memberProfile['amount_paid'] ?? 0) ?></div></div>
<div class="col-md-4 mb-3"><div class="skill-pill w-100 justify-content-center"><?= h($memberProfile['duration_days'] ?? '-') ?> Days</div></div>
</div>
<a class="btn btn-gradient mt-2" href="contact.php?subject=Renew%20Membership">Renew Membership</a>
</div>
</div>
</div>

<div class="row g-4 mt-1">
<div class="col-lg-6 reveal">
<div class="premium-card p-4 h-100">
<h3 class="fw-bold">Payment History</h3>
<div class="table-responsive">
<table class="table table-modern table-bordered align-middle">
<thead><tr><th>Date</th><th>Amount</th><th>Status</th><th>Receipt</th></tr></thead>
<tbody>
<?php if(count($payments) > 0): ?>
<?php foreach($payments as $payment): ?>
<tr>
<td><?= portal_date($payment['payment_date']) ?></td>
<td><?= portal_money($payment['amount']) ?></td>
<td><?= h($payment['status']) ?></td>
<td><a class="btn btn-sm btn-outline-primary" href="member_dashboard.php?receipt=<?= (int)$payment['id'] ?>"><i class="fa fa-download"></i></a></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center text-muted">No payments found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
<div class="col-lg-6 reveal">
<div class="premium-card p-4 h-100">
<h3 class="fw-bold">Attendance History</h3>
<div class="table-responsive">
<table class="table table-modern table-bordered align-middle">
<thead><tr><th>Date</th><th>Check In</th><th>Check Out</th><th>Status</th></tr></thead>
<tbody>
<?php if(count($attendance) > 0): ?>
<?php foreach($attendance as $row): ?>
<tr>
<td><?= portal_date($row['attendance_date']) ?></td>
<td><?= $row['check_in'] ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
<td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
<td><?= h($row['status']) ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center text-muted">No attendance records found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php endif; ?>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
