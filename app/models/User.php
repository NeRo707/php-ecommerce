<?php

class User {
  private ?int $user_id;
  private string $role;
  private string $name;
  private string $lastname;
  private string $username;
  private string $email;
  private ?string $password;
  private float $balance;

  public function __construct(?int $userId, string $role="customer", string $name, string $lastname, string $username, string $email, ?string $password = null, float $balance = 0.00) {
    $this->user_id = $userId;
    $this->role = $role;
    $this->name = $name;
    $this->lastname = $lastname;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->balance = $balance;
  }

  public function getUserId(): ?int {
    return $this->user_id;
  }

  public function getRole(): string {
    return $this->role;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getLastname(): string {
    return $this->lastname;
  }

  public function getUsername(): string {
    return $this->username;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getPassword(): ?string {
    return $this->password;
  }

  public function getBalance(): float {
    return $this->balance;
  }

  public function setName(string $name): void {
    $this->name = $name;
  }

  public function setLastname(string $lastname): void {
    $this->lastname = $lastname;
  }

  public function setUsername(string $username): void {
    $this->username = $username;
  }

  public function setEmail(string $email): void {
    $this->email = $email;
  }

  public function setPassword(string $password): void {
    $this->password = $password;
  }
}
