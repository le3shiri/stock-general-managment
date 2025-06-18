<?php
// Modern dashboard header for all pages
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<nav class="navbar navbar-dark sticky-top">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
      <span class="brand-logo d-flex align-items-center justify-content-center">
        <i class="bi bi-box-seam"></i>
      </span>
      Inventory Dashboard
    </a>
    <span class="navbar-text d-flex align-items-center gap-2">
      <span class="user-avatar d-flex align-items-center justify-content-center" style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#43e97b 60%,#2196f3 100%);color:#fff;font-size:1.3em;box-shadow:0 1.5px 6px rgba(33,150,243,0.10);">
        <i class="bi bi-person-circle"></i>
      </span>
      Welcome, <?php echo htmlspecialchars($username ?: ''); ?> (<a href="../public/logout.php" style="color:#fff;">Logout</a>)
    </span>
  </div>
</nav>
