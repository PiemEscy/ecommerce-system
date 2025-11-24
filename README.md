# E-Comm Platform

A simple e-commerce platform built with **Vue 3**, **Tailwind CSS**, and **Laravel**.  
Users can browse products, add them to the cart, checkout, and receive email notifications. Admin and authentication functionality are included.

---

## **Features**

- User registration and login
- Product catalog browsing
- Add products to cart
- Modify quantity in cart
- Checkout with order confirmation
- Email notification for order summary
- Responsive design (desktop & mobile)
- Loader and disabled buttons during API processes

---

## **Tech Stack**

- **Frontend:** Vue 3, Tailwind CSS, Vue Router, Vuex (optional)
- **Backend:** Laravel 10, PHP 8.1
- **Database:** MySQL / PostgreSQL
- **Authentication:** JWT Token based
- **Email Service:** External email API (customizable)
- **HTTP Requests:** Axios

---

## **Project Setup**

### 1. Clone the repository
git clone https://github.com/PiemEscy/ecommerce-system.git

### 2. Create the database
CREATE DATABASE IF NOT EXISTS ecom_system_db;

### 3. run the bash script for built-time installation (composer, npm, artisan migrations)
./setup.sh

