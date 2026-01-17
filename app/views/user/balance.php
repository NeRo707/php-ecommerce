<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login.php');
  exit();
}

$user = $auth->getUser();
$currentBalance = $auth->getBalance();

$hackResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hack'])) {
  $success = rand(1, 100) <= 70;

  if ($success) {
    $amount = rand(50, 500);
    $auth->addBalance($amount);
    $currentBalance = $auth->getBalance();
    $hackResult = [
      'success' => true,
      'amount' => $amount,
      'message' => "ACCESS GRANTED! You successfully extracted $$amount from Pentagon's secret budget!"
    ];
  } else {
    $hackResult = [
      'success' => false,
      'amount' => 0,
      'message' => "FIREWALL DETECTED! The Pentagon's cyber defense blocked your attack. Try again!"
    ];
  }
}

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
  $auth->clearBalance();
  $currentBalance = $auth->getBalance();
  header('Location: balance.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "My Balance";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">My Balance</h1>

    <div class="balance-card">
      <div class="balance-label">Current Balance</div>
      <div class="balance-amount">$<?= $currentBalance ?></div>
      <a href="../items/shop.php" class="btn btn-primary">Go Shopping</a>
      <a onclick="window.location.href='?clear=true'" class="btn btn-primary">Clear Balance</a>
    </div>

    <?php if ($hackResult): ?>
      <div class="hack-result <?= $hackResult['success'] ? 'success' : 'failed' ?>">
        <div class="hack-icon"><?= $hackResult['success'] ? '💰' : '🛡️' ?></div>
        <div class="hack-message"><?= $hackResult['message'] ?></div>
      </div>
    <?php endif; ?>

    <div class="hack-section">
      <div class="hack-header">
        <div class="pentagon-icon">🏛️</div>
        <h2>Pentagon Bank</h2>
        <div class="hack-status">STATUS: <span class="status-vulnerable">VULNERABLE</span></div>
      </div>

      <form method="POST" class="hack-form">
        <button type="submit" name="hack" class="hack-btn">
          <span class="hack-btn-text">START HACK</span>
          <span class="hack-btn-sub">Get Money from Pentagon</span>
        </button>
      </form>
    </div>
  </main>
</body>

</html>