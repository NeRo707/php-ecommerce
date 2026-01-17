<?php

class Cart {
  private int $user_id;
  private int $item_id;
  private int $quantity;
  private ?string $added_at;

  private ?string $item_name;
  private ?float $item_price;
  private ?string $item_image;

  public function __construct(
    int $userId,
    int $itemId,
    int $quantity = 1,
    ?string $addedAt = null,
    ?string $itemName = null,
    ?float $itemPrice = null,
    ?string $itemImage = null
  ) {
    $this->user_id = $userId;
    $this->item_id = $itemId;
    $this->quantity = $quantity;
    $this->added_at = $addedAt;
    $this->item_name = $itemName;
    $this->item_price = $itemPrice;
    $this->item_image = $itemImage;
  }

  public function getUserId(): int {
    return $this->user_id;
  }

  public function getItemId(): int {
    return $this->item_id;
  }

  public function getQuantity(): int {
    return $this->quantity;
  }

  public function getAddedAt(): ?string {
    return $this->added_at;
  }

  public function getItemName(): ?string {
    return $this->item_name;
  }

  public function getItemPrice(): ?float {
    return $this->item_price;
  }

  public function getItemImage(): ?string {
    return $this->item_image;
  }

  public function getSubtotal(): float {
    return $this->quantity * ($this->item_price ?? 0);
  }

  public function setQuantity(int $quantity): void {
    $this->quantity = $quantity;
  }
}
