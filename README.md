# 📦 Inventory Management System

A professional web-based **Inventory Management System** developed using **PHP and MySQL** to efficiently manage products, categories, suppliers, stock, and inventory-related operations through an easy-to-use admin dashboard.

This project demonstrates practical implementation of **CRUD operations, database management, authentication, session handling, and business logic** in a PHP-based web application.

---

## 🚀 Features

* 🔐 Admin Login & Authentication
* 📊 Admin Dashboard
* 📦 Product Management
* 🗂️ Category Management
* 🚚 Supplier Management
* 📈 Stock Management
* ➕ Add New Products
* ✏️ Update Product Information
* 🗑️ Delete Products
* 🔎 Product Search & Filtering
* 📋 Inventory Tracking
* 💾 MySQL Database Integration
* 🔄 Complete CRUD Operations
* 📱 Responsive User Interface

---

## 🛠️ Technologies Used

| Technology       | Purpose                       |
| ---------------- | ----------------------------- |
| **PHP**          | Backend Development           |
| **MySQL**        | Database Management           |
| **HTML5**        | Web Structure                 |
| **CSS3**         | Styling                       |
| **JavaScript**   | Client-Side Functionality     |
| **Bootstrap**    | Responsive UI                 |
| **Apache**       | Web Server                    |
| **XAMPP / WAMP** | Local Development Environment |

---

# ⚙️ Installation & Setup

Follow the steps below to run the **Inventory Management System** on your local machine.

## 1️⃣ Install XAMPP or WAMP

Download and install **XAMPP** or **WAMP** on your computer.

After installation, open the Control Panel and start:

```text
Apache
MySQL
```

Make sure both services are running successfully.

---

## 2️⃣ Download or Clone the Repository

Clone the project using Git:

```bash
git clone https://github.com/YOUR_USERNAME/inventory-management-system.git
```

Or download the repository as a ZIP file and extract it.

---

## 3️⃣ Move the Project to XAMPP

If you are using **XAMPP**, copy the extracted project folder into:

```text
C:\xampp\htdocs\
```

For example:

```text
C:\xampp\htdocs\inventory-management-system\
```

If you are using **WAMP**, place the project folder inside:

```text
C:\wamp64\www\
```

---

## 4️⃣ Create the Database

Open your browser and visit:

```text
http://localhost/phpmyadmin
```

Click on **New** and create a database with the following name:

```text
inventory_system
```

---

## 5️⃣ Import the Database

After creating the database:

1. Open the `inventory_system` database.
2. Click on the **Import** tab.
3. Select the `db.sql` file from the project folder.
4. Click **Import / Go**.
5. Wait for the database tables to be created successfully.

The `db.sql` file contains the required database structure and data for the application.

---

## 6️⃣ Configure Database Connection

Open the database configuration file in the project and verify the following settings:

```text
Host: localhost
Username: root
Password:
Database: inventory_system
```

If your MySQL username or password is different, update the database configuration accordingly.

---

## 7️⃣ Run the Application

Once Apache and MySQL are running and the database has been imported, open your browser and visit:

```text
http://localhost/inventory-management-system/
```

The application should now be running successfully on your local server.

---

# 🔐 Default Admin Login

Use the following credentials to access the Admin Panel:

```text
Username: admin
Password: admin123
```

### Admin Login

```text
http://localhost/inventory-management-system/
```

> ⚠️ **Security Note:** The default credentials are intended for local/demo purposes. Change the admin password before using the application in a production environment.

---

# 📂 Project Structure

```text
inventory-management-system/
│
├── admin/
├── assets/
├── css/
├── js/
├── images/
├── includes/
├── db.sql
├── index.php
└── README.md
```

> The actual folder structure may vary depending on the project implementation.

---

# 💡 Key Functionalities

### 👤 Admin Management

* Secure admin login
* Session-based authentication
* Admin dashboard

### 📦 Product Management

* Add products
* Update products
* Delete products
* View product details
* Search products

### 🗂️ Category Management

* Create categories
* Update categories
* Delete categories
* Organize products by category

### 🚚 Supplier Management

* Add supplier information
* Update supplier details
* Manage supplier records

### 📊 Inventory Management

* Track available products
* Manage stock records
* Monitor inventory information
* Maintain organized product data

---

# 🧠 Key Learning Outcomes

This project helped demonstrate practical knowledge of:

* PHP Web Development
* MySQL Database Management
* CRUD Operations
* SQL Queries
* Database Integration
* Form Handling
* Form Validation
* Authentication & Authorization
* Session Management
* Admin Dashboard Development
* Business Logic Implementation
* Frontend & Backend Integration
* Responsive Web Design

---

# 🔮 Future Improvements

The following features can be added in future versions:

* 🔑 Role-Based Access Control
* 📱 Mobile-Friendly Improvements
* 📊 Advanced Analytics Dashboard
* 🔔 Low Stock Notifications
* 🧾 Sales & Purchase Management
* 📄 PDF Report Generation
* 📊 Excel Report Export
* 🏷️ Barcode / QR Code Integration
* 🔌 REST API Integration
* 🐳 Docker Support
* ☁️ Cloud Deployment

---

# 📸 Screenshots

Add application screenshots here to showcase the project.

Recommended screenshots:

* Login Page       <img src="project ss/screen_shot/login.PNG" width="600"/>
* Admin Dashboard
* Product Management
* Category Management
* Supplier Management
* Inventory / Stock Management

Example:

```markdown
![Admin Dashboard](screenshots/dashboard.png)
```

---

# 🎯 Project Highlights

* Developed a complete web-based inventory management solution.
* Implemented database-driven CRUD operations.
* Created an admin dashboard for centralized management.
* Integrated PHP backend with MySQL database.
* Implemented authentication and session management.
* Designed a responsive and user-friendly interface.

---

# 👨‍💻 Author

## Aman Ansari

**Software Engineer | Python Developer | Full-Stack Developer**

📍 Ahmedabad, Gujarat, India

### Connect With Me

* **GitHub:** https://github.com/YOUR_USERNAME
* **LinkedIn:** https://linkedin.com/in/YOUR_USERNAME
* **Portfolio:** https://ansariamanvfx5.netlify.app/

---

# 📄 License

This project is created for **educational and portfolio purposes**.

---

⭐ **If you find this project useful, please consider giving the repository a star.**
