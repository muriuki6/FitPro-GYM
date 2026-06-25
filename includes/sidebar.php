<div class="sidebar">

<div class="topbar d-flex align-items-center justify-content-between px-3">

    <!-- LEFT: Logo -->
    <div class="d-flex align-items-center">
        <img src="<?= $base ?>assets/images/FitPro Gym Logo.png" alt="Logo" style="height:40px; width:auto; margin-right:10px;">
        <h5 class="text-white m-0">FitPro Gym</h5>
    </div>

    <!-- RIGHT: existing icons/buttons -->
    <div>
        <!-- your menu / dark mode button -->
    </div>

</div>






<ul class="nav flex-column">

<li class="nav-item">
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<?php $roleId = $_SESSION['role_id'] ?? 0; ?>

<?php if($roleId == 2): ?>

<a href="dashboard.php" class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
<i class="fa fa-home"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a href="members.php" class="nav-link <?= $currentPage == 'members.php' ? 'active' : '' ?>">
<i class="fa fa-users"></i> Members
</a>
</li>

<li class="nav-item">
<a href="attendance.php" class="nav-link <?= $currentPage == 'attendance.php' ? 'active' : '' ?>">
<i class="fa fa-calendar-check"></i> Attendance
</a>
</li>

<li class="nav-item">
<a href="profile.php" class="nav-link <?= $currentPage == 'profile.php' ? 'active' : '' ?>">
<i class="fa fa-user-circle"></i> Profile
</a>
</li>

<?php elseif($roleId == 3): ?>

<a href="dashboard.php" class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
<i class="fa fa-home"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a href="membership.php" class="nav-link <?= $currentPage == 'membership.php' ? 'active' : '' ?>">
<i class="fa fa-id-card"></i> Membership
</a>
</li>

<li class="nav-item">
<a href="payments.php" class="nav-link <?= $currentPage == 'payments.php' ? 'active' : '' ?>">
<i class="fa fa-wallet"></i> Payments
</a>
</li>

<li class="nav-item">
<a href="attendance.php" class="nav-link <?= $currentPage == 'attendance.php' ? 'active' : '' ?>">
<i class="fa fa-calendar-check"></i> Attendance
</a>
</li>

<li class="nav-item">
<a href="trainers.php" class="nav-link <?= $currentPage == 'trainers.php' ? 'active' : '' ?>">
<i class="fa fa-user-tie"></i> Trainers
</a>
</li>

<li class="nav-item">
<a href="profile.php" class="nav-link <?= $currentPage == 'profile.php' ? 'active' : '' ?>">
<i class="fa fa-user-circle"></i> Profile
</a>
</li>

<?php else: ?>

<a href="dashboard.php" class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
<i class="fa fa-home"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a href="members.php" class="nav-link <?= in_array($currentPage, ['members.php','add_member.php','edit_member.php','member_profile.php','renew_membership.php']) ? 'active' : '' ?>">
<i class="fa fa-users"></i> Members
</a>
</li>

<li class="nav-item">
<a href="trainers.php" class="nav-link <?= in_array($currentPage, ['trainers.php','add_trainer.php','edit_trainer.php']) ? 'active' : '' ?>">
<i class="fa fa-user-tie"></i> Trainers
</a>
</li>

<li class="nav-item">
<a href="attendance.php" class="nav-link <?= $currentPage == 'attendance.php' ? 'active' : '' ?>">
<i class="fa fa-calendar-check"></i> Attendance
</a>
</li>


<li class="nav-item">
    <a href="memberships.php" class="nav-link <?= in_array($currentPage, ['memberships.php','add_membership.php','edit_membership.php']) ? 'active' : '' ?>">
        <i class="fa fa-id-card"></i>
        Membership Plans
    </a>
</li>





<li class="nav-item">
<a href="payments.php" class="nav-link <?= in_array($currentPage, ['payments.php','receipt.php']) ? 'active' : '' ?>">
<i class="fa fa-money-bill"></i> Payments
</a>
</li>

<li class="nav-item">
<a href="reports.php" class="nav-link <?= $currentPage == 'reports.php' ? 'active' : '' ?>">
<i class="fa fa-chart-bar"></i> Reports
</a>
</li>

<?php endif; ?>

<li class="nav-item">
<a href="../logout.php" class="nav-link text-danger">
<i class="fa fa-sign-out-alt"></i> Logout
</a>
</li>

</ul>

</div>
