<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 1){
    header("Location: ../login.php");
    exit();
}

$payments = $conn->query("
SELECT
p.*,
m.fullname
FROM payments p
JOIN members m
ON p.member_id = m.id
ORDER BY p.id DESC
");

include '../includes/header.php';
?>

<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">





<?php

$totalRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
")->fetch_assoc()['total'];

$todayRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
WHERE payment_date = CURDATE()
")->fetch_assoc()['total'];

$pendingPayments = $conn->query("
SELECT COUNT(*) total
FROM payments
WHERE status='Pending'
")->fetch_assoc()['total'];

$totalPayments = $conn->query("
SELECT COUNT(*) total
FROM payments
")->fetch_assoc()['total'];

?>

<div class="row mb-4">

<div class="col-md-3">
<div class="card shadow border-success">
<div class="card-body">
<h6>Total Revenue</h6>
<h3>KES <?= number_format($totalRevenue,2) ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-primary">
<div class="card-body">
<h6>Today's Revenue</h6>
<h3>KES <?= number_format($todayRevenue,2) ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-warning">
<div class="card-body">
<h6>Pending Payments</h6>
<h3><?= $pendingPayments ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-info">
<div class="card-body">
<h6>Total Transactions</h6>
<h3><?= $totalPayments ?></h3>
</div>
</div>
</div>

</div>






<div class="d-flex justify-content-between mb-3">

<h3>
<i class="fa fa-money-bill-wave"></i>
Payment Management
</h3>



<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#paymentModal">

<i class="fa fa-plus"></i>
Record Payment

</button>


</div>




<div class="card shadow mb-3">

<div class="card-body">

<div class="input-group">

<input
type="text"
id="searchPayment"
class="form-control"
placeholder="Search member, reference or payment method">

<button
class="btn btn-primary"
type="button"
id="searchBtn">

<i class="fa fa-search"></i>
Search

</button>

</div>

</div>

</div>





<div class="card shadow">

<div class="card-body">

<table
id="paymentTable"
class="table table-hover table-striped table-bordered align-middle">
<thead class="table-dark">

<tr>
<th>ID</th>
<th>Member</th>
<th>Amount</th>
<th>Date</th>
<th>Method</th>
<th>Reference</th>
<th>Status</th>
<th>Actions</th>

</tr>




</thead>

<tbody>

<?php while($row = $payments->fetch_assoc()): ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td>
KES <?= number_format($row['amount'],2) ?>
</td>

<td><?= $row['payment_date'] ?></td>

<td>

<?php

switch($row['payment_method']){

case 'Cash':
echo '<span class="badge bg-success">Cash</span>';
break;

case 'M-Pesa':
echo '<span class="badge bg-primary">M-Pesa</span>';
break;

case 'Bank':
echo '<span class="badge bg-dark">Bank</span>';
break;

case 'Card':
echo '<span class="badge bg-info text-dark">Card</span>';
break;

default:
echo $row['payment_method'];

}

?>

</td>
<td><?= htmlspecialchars($row['reference_number']) ?></td>

<td>

<?php if($row['status']=='Paid'): ?>

<span class="badge bg-success">
Paid
</span>

<?php elseif($row['status']=='Pending'): ?>

<span class="badge bg-warning text-dark">
Pending
</span>

<a
href="../api/mark_payment_paid.php?id=<?= $row['id'] ?>"
class="btn btn-success btn-sm ms-2">

Mark Paid

</a>

<?php else: ?>

<span class="badge bg-danger">
Failed
</span>

<?php endif; ?>

<td>

<div class="d-flex align-items-center gap-1">

<a
href="receipt.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

<i class="fa fa-file-invoice"></i>
Receipt

</a>

<button
class="btn btn-success btn-sm"
data-bs-toggle="modal"
data-bs-target="#paymentModal">

<i class="fa fa-plus"></i>
Payment

</button>

</div>

</td>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<!-- Payment Modal -->

<div
class="modal fade"
id="paymentModal"
tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">
Record Payment
</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<form id="paymentForm">

<div class="mb-3">

<label>Member</label>

<select
name="member_id"
class="form-control"
required>

<option value="">
Select Member
</option>

<?php

$members = $conn->query("
SELECT id, fullname
FROM members
ORDER BY fullname
");

while($member = $members->fetch_assoc()){

?>

<option value="<?= $member['id'] ?>">
<?= htmlspecialchars($member['fullname']) ?>
</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Amount</label>

<input
type="number"
step="0.01"
name="amount"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Payment Method</label>

<select
name="payment_method"
class="form-control"
required>

<option value="Cash">
Cash
</option>

<option value="M-Pesa">
M-Pesa
</option>

<option value="Bank">
Bank
</option>

<option value="Card">
Card
</option>

</select>

</div>

<div class="mb-3">

<label>Reference Number</label>

<input
type="text"
name="reference_number"
class="form-control">

</div>





<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control"
required>

<option value="Paid">
Paid
</option>

<option value="Pending">
Pay Later (Pending)
</option>

</select>

</div>







<button
type="submit"
class="btn btn-success">

Save Payment

</button>

</form>

</div>

</div>

</div>

</div>

<script>

/* ==========================
   SAVE PAYMENT
========================== */

const paymentForm =
document.getElementById('paymentForm');

if(paymentForm){

paymentForm.addEventListener('submit', function(e){

e.preventDefault();

const btn =
this.querySelector('button[type="submit"]');

btn.disabled = true;
btn.innerHTML =
'<span class="spinner-border spinner-border-sm"></span> Saving...';

fetch('../api/add_payment.php',{

method:'POST',
body:new FormData(this)

})

.then(res=>res.text())

.then(data=>{

if(data.includes('Successfully')){

showToast(
'Payment Recorded Successfully',
'success'
);

setTimeout(()=>{
location.reload();
},1000);

}else{

showToast(data,'danger');

btn.disabled = false;
btn.innerHTML = 'Save Payment';

}

})

.catch(error=>{

console.error(error);

showToast(
'Payment Failed',
'danger'
);

btn.disabled = false;
btn.innerHTML = 'Save Payment';

});

});

}

/* ==========================
   SEARCH
========================== */

function searchPayments(){

const input =
document.getElementById('searchPayment');

const table =
document.getElementById('paymentTable');

if(!input || !table) return;

const value =
input.value.toLowerCase();

const rows =
table.querySelectorAll('tbody tr');

rows.forEach(row=>{

row.style.display =
row.innerText.toLowerCase()
.includes(value)
? ''
: 'none';

});

}

const searchBtn =
document.getElementById('searchBtn');

if(searchBtn){

searchBtn.addEventListener(
'click',
searchPayments
);

}

const searchInput =
document.getElementById('searchPayment');

if(searchInput){

searchInput.addEventListener(
'keyup',
function(e){

if(e.key === 'Enter'){
searchPayments();
}

}
);

}

/* ==========================
   TOAST NOTIFICATION
========================== */

function showToast(
message,
type='success'
){

const toast =
document.createElement('div');

toast.className =
`alert alert-${type} position-fixed`;

toast.style.top='20px';
toast.style.right='20px';
toast.style.zIndex='9999';
toast.style.minWidth='250px';

toast.innerHTML = message;

document.body.appendChild(toast);

setTimeout(()=>{

toast.remove();

},3000);

}

</script>




<script>

function searchPayments(){

let value =
document.getElementById('searchPayment')
.value
.toLowerCase();

let rows =
document.querySelectorAll(
'#paymentTable tbody tr'
);

rows.forEach(row=>{

row.style.display =
row.innerText.toLowerCase()
.includes(value)
? ''
: 'none';

});

}

document
.getElementById('searchBtn')
.addEventListener('click', searchPayments);

document
.getElementById('searchPayment')
.addEventListener('keyup', function(e){

if(e.key === 'Enter'){
    searchPayments();
}

});


</script>

<?php include '../includes/footer.php'; ?>