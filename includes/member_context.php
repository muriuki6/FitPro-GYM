<?php
$memberUserId = $_SESSION['user_id'] ?? 0;

$memberUserStmt = $conn->prepare("
SELECT *
FROM users
WHERE id=?
");
$memberUserStmt->bind_param("i", $memberUserId);
$memberUserStmt->execute();
$memberUser = $memberUserStmt->get_result()->fetch_assoc();

$memberProfileStmt = $conn->prepare("
SELECT
m.*,
mp.plan_name,
mp.duration_days,
mp.description plan_description,
mp.benefits plan_benefits
FROM members m
LEFT JOIN membership_plans mp
ON m.plan_id = mp.id
WHERE m.email=?
ORDER BY
CASE WHEN m.status='Active' THEN 0 ELSE 1 END,
m.expiry_date DESC,
m.id DESC
LIMIT 1
");
$memberProfileStmt->bind_param("s", $memberUser['email']);
$memberProfileStmt->execute();
$memberProfile = $memberProfileStmt->get_result()->fetch_assoc();

function member_money($amount)
{
    return 'KES ' . number_format((float)$amount, 2);
}

function member_date($date)
{
    return $date ? date('d M Y', strtotime($date)) : '-';
}

function member_days_left($expiryDate)
{
    if(!$expiryDate){
        return null;
    }

    $today = new DateTime(date('Y-m-d'));
    $expiry = new DateTime($expiryDate);

    return (int)$today->diff($expiry)->format('%r%a');
}

function member_status_badge($status)
{
    if($status == 'Active'){
        return '<span class="badge bg-success">Active</span>';
    }

    if($status == 'Expired'){
        return '<span class="badge bg-danger">Expired</span>';
    }

    return '<span class="badge bg-warning text-dark">' . htmlspecialchars($status ?: 'Pending') . '</span>';
}
?>
