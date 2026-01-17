<?php
require_once __DIR__ . '/../core/db.php';

class CartService extends Dbh {

  public function __construct() {
    parent::__construct();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
  }

  public function add_to_cart($item_id, $quantity = 1) {
    if (isset($_SESSION['cart'][$item_id])) {
      $_SESSION['cart'][$item_id] += $quantity;
    } else {
      $_SESSION['cart'][$item_id] = $quantity;
    }
    return true;
  }

  public function get_cart() {
    $cart = [];

    if (empty($_SESSION['cart'])) {
      return $cart;
    }

    foreach ($_SESSION['cart'] as $item_id => $quantity) {
      $query = "SELECT item_id, name, price, stock FROM items WHERE item_id = ?";
      $stmt = $this->connection->prepare($query);
      $stmt->bind_param("i", $item_id);
      $stmt->execute();
      $result = $stmt->get_result();
      
      $item = $result->fetch_assoc();
      if ($item) {
        $item['quantity'] = $quantity;
        $cart[] = $item;
      }
      $stmt->close();
    }
    return $cart;
  }

  public function update_quantity($item_id, $quantity) {
    if ($quantity <= 0) {
      return $this->remove_from_cart($item_id);
    }
    $_SESSION['cart'][$item_id] = $quantity;
    return true;
  }

  public function remove_from_cart($item_id) {
    unset($_SESSION['cart'][$item_id]);
    return true;
  }

  public function clear_cart() {
    $_SESSION['cart'] = [];
    return true;
  }

  public function get_cart_total() {
    $cart = $this->get_cart();
    $total = 0;
    foreach ($cart as $item) {
      $total += $item['price'] * $item['quantity'];
    }
    return $total;
  }

  public function get_cart_count() {
    $count = 0;
    foreach ($_SESSION['cart'] as $quantity) {
      $count += $quantity;
    }
    return $count;
  }

  public function checkout($user_id) {
    $cart = $this->get_cart();
    if (empty($cart)) {
      return ['success' => false, 'error' => 'empty_cart'];
    }
    // checkout sum
    $total = $this->get_cart_total();

    // check user balance
    $query = "SELECT balance FROM users WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user['balance'] < $total) {
      return [
              'success' => false,
              'error' => 'low_balance',
              'balance' => $user['balance'],
              'total' => $total
             ];
    }

    // deduct balance and create order
    $query = "UPDATE users SET balance = balance - ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("di", $total, $user_id);
    $stmt->execute();
    $stmt->close();

    // create order
    $query = "INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $this->connection->insert_id;
    $stmt->close();

    // insert order items and update stock
    foreach ($cart as $item) {
      $query = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)";
      $stmt = $this->connection->prepare($query);
      $stmt->bind_param("iiid", $order_id, $item['item_id'], $item['quantity'], $item['price']);
      $stmt->execute();
      $stmt->close();

      $query = "UPDATE items SET stock = stock - ? WHERE item_id = ?";
      $stmt = $this->connection->prepare($query);
      $stmt->bind_param("ii", $item['quantity'], $item['item_id']);
      $stmt->execute();
      $stmt->close();
    }

    $this->clear_cart();
    return [
            'success' => true,
            'order_id' => $order_id
           ];
  }

  public function get_orders($user_id) {
    $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
      $orders[] = $row;
    }
    $stmt->close();
    return $orders;
  }

  public function get_all_orders() {
    $query = "SELECT o.*, u.username, u.email
              FROM orders o
              INNER JOIN users u ON o.user_id = u.user_id
              ORDER BY o.created_at DESC";

    $result = $this->connection->query($query);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
      $orders[] = $row;
    }
    return $orders;
  }

  public function update_order_status($order_id, $status) {
    $query = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }
}
