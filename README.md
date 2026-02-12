# PHP Ecommerce

php e-commerce platform built with PHP. 
This is a "toy" project with

- user authentication 
- shopping cart management
- admin product/order control.

## Structure
```
app/
 ┣ controllers/
 ┣ core/
 ┣ models/
 ┣ public/
 ┣ services/
 ┣ views/
 ┣ .htaccess
 ┣ app.php
 ┣ index.php
 ┗ shop_db.sql
```
## Setup Instructions

1. Clone the repository:
	```bash
	git clone https://github.com/NeRo707/php-ecommerce.git
	```
2. Import `shop_db.sql` into your MySQL database.
3. Configure database connection in `app/core/db.php`.
4. Start your local server (e.g., XAMPP, WAMP) and access the project via `index.php`.

## Usage

- Register a new user or login.
- Browse products, add to cart, and place orders.
- Admin users can manage products and view order stats.
- Edit your profile and check your balance.