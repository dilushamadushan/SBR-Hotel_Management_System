# 🌴 Secret Berry Resort - Hotel Management System

## 📖 Project Overview

**Secret Berry Resort** is an Online Hotel Management System developed as part of an academic project. It provides a browser-based platform for hotel guests and administrators to interact digitally. The system supports booking rooms, managing accounts, and accessing hotel services seamlessly.


## 🚀 Key Features

- 🛏️ **Room Booking System** – Browse available rooms and make bookings.
- 👤 **User Authentication** – Register, log in, and manage user profiles.
- 📋 **Booking History** – View and manage previous and upcoming reservations.
- 🛠️ **Admin Panel** – Add/edit/delete rooms, manage bookings, and user accounts.
- 📸 **Media Upload** – Add images for rooms and hotel services.
- 📩 **Contact Form** – Users can send messages to hotel management.
- 🧾 **Informational Pages** – Restaurant, spa, facilities, and more.


## 🧱 Tech Stack

| Layer       | Technology         |
|-------------|--------------------|
| Frontend    | HTML, CSS, JavaScript |
| Styling     | Bootstrap Framework |
| Backend     | PHP                 |
| Database    | MySQL              |


## 💻 Installation & Setup

Follow these steps to set up the project:

### 1. Clone the Repository

```bash
git clone https://github.com/dilushamadushan/SBR-Hotel_Management_System.git
cd SBR-Hotel_Management_System
```

### 2. Install Composer Dependencies

Make sure you have [Composer](https://getcomposer.org/) installed.

#### Install Main Dependencies

```bash
composer install
```

Once Composer is installed, go to your project directory and require `vlucas/phpdotenv` to manage environment variables:

```bash
cd path/to/your-project
composer require vlucas/phpdotenv
```

### 3. Create and Configure `.env` File

Create a `.env` file in the project root with the following content:

```
DB_HOST = localhost
DB_USERNAME = root
DB_PASSWORD = your_db_password
DB_NAME = database name

MAILE_HOST = smtp.gmail.com
MAILE_SMTPAUTH = true
MAILE_UERNAME = your_email@gmail.com
MAILE_PASSWORD = your_email_password
MAILE_SMTPSECURE = tls
MAILE_PORT = 587
```

Replace the above values with your actual database and mail server credentials.

### 4. Configure PHP Mail Server

Make sure your PHP installation is configured to send emails. This usually involves:

- Setting the `mail` settings in your `php.ini` file (for example, `SMTP`, `smtp_port`, `sendmail_path`, etc.).
- Using SMTP or another mail service and adding the appropriate configuration to your `.env` file as shown above.

### 5. Set File Permissions

Depending on your web server and operating system, you may need to set permissions on some directories (e.g., for storage or cache).


## Contributing

> [!IMPORTANT]  
> All group members must read [CONTRIBUTION GUIDE](.github/CONTRIBUTING.md)

Don't forget to hit the :star: if you like this repo.
