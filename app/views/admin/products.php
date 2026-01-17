<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login');
  exit();
}

$user = $auth->getUser();
if ($user->getRole() !== 'admin') {
  header('Location: ../notfound');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
  $name = trim($_POST['name']);
  $description = trim($_POST['description']);
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $image = trim($_POST['image'] ?? '');

  if (!empty($name) && $price > 0 && $stock >= 0) {
    $items->addItem($name, $description, $price, $stock, $image);
  }
  header('Location: products');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
  $item_id = $_POST['item_id'];
  $name = trim($_POST['name']);
  $description = trim($_POST['description']);
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $image = trim($_POST['image'] ?? '');

  if (!empty($name) && $price > 0 && $stock >= 0) {
    $items->updateItem($item_id, $name, $description, $price, $stock, $image);
  }
  header('Location: products');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
  $item_id = $_POST['item_id'];
  $items->deleteItem($item_id);
  header('Location: products');
  exit();
}

$allItems = $items->getAllItemsAdmin();

$editingItem = null;
if (isset($_GET['edit_item'])) {
  $editItemId = $_GET['edit_item'];
  $editingItem = $items->getItem($editItemId);
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "Manage Products";
include_once '../_partials/header.php'; ?>

<body>
  <?php $a = 1;
  include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">Admin Panel</h1>

    <?php include_once './_partials/tabs.php' ?>

    <?php
    $response = $items->getResponse();
    if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <div class="admin-section">
      <h2><?= $editingItem ? 'Edit Item' : 'Add New Item' ?></h2>
      <?php include_once './_partials/products/item-form.php' ?>
    </div>

    <div class="admin-section">
      <h2>All Products (<?= count($allItems) ?>)</h2>

      <?php if (empty($allItems)): ?>
        <div class="cart-empty">
          <h3>No products yet</h3>
          <p>Add your first product using the form above.</p>
        </div>
      <?php else: ?>
        <div class="cart-container" style="padding: 0; box-shadow: none;">
          <?php include_once './_partials/products/item-table.php'; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>