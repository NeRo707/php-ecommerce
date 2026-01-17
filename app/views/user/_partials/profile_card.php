<div class="profile-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <h2>Account Information</h2>
    <button class="btn btn-secondary" onclick="window.location.href='?edit=true'">Edit Profile</button>
  </div>
  <hr color="#3498db" style="margin-bottom: 10px;">

  <div class="profile-info">
    <label>Balance</label>
    <span style="color: #27ae60; font-weight: bold; font-size: 1.3rem;">$<?= number_format($user->getBalance(), 2) ?></span>
    <a href="balance" class="btn btn-success btn-small" style="margin-left: 10px;">Add Funds $</a>
  </div>

  <div class="profile-info">
    <label>First Name</label>
    <span><?= $user->getName() ?></span>
  </div>

  <div class="profile-info">
    <label>Last Name</label>
    <span><?= $user->getLastname() ?></span>
  </div>

  <div class="profile-info">
    <label>Username</label>
    <span><?= $user->getUsername() ?></span>
  </div>

  <div class="profile-info">
    <label>Email</label>
    <span><?= $user->getEmail() ?></span>
  </div>

  <br>
  <a href="../items/shop" class="btn btn-primary">Continue Shopping</a>
  <a href="../cart/orders" class="btn btn-success">View My Orders</a>
</div>