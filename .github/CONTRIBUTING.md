## 🤝 Contributing

Hi there! 👋 We're thrilled that you'd like to contribute to the **Secret Berry Resort** project. Your help is essential in making this system better for everyone.

> [!IMPORTANT]  
> **Please follow the guidelines below before submitting a Pull Request (PR):**
>
> - 🔀 Always create a new branch for your changes.
> - 🚫 **Do NOT** submit PRs directly to the `main` branch.
> - ✅ Submit all PRs to the `develop` branch only.
> - 🔤 Use only **lowercase letters and hyphens** for file names and branch names. Avoid spaces, numbers, or special characters.


## 📂 Folder Structure

```plaintext
📁 SECRET-BERRY-RESORT-PROJECT/
├── .github/          # Contribution guidelines and settings
├── admin/            # Admin-side functionality
├── assets/           # Images, CSS, JavaScript files
├── function/         # PHP helper functions
├── includes/         # Common includes (headers, footers, DB connection)
├── pages/            # User-facing pages (blogs, rooms, about, etc.)
├── upload/           # Image and file uploads
├── index.php         # Main homepage file
└── README.md         # Project documentation
```
    
## 🎨 Theme Colors:

- Use the following color palette consistently across all new components:
    - primary-color: #e82574;
    - primary-color-dark: #bc1c5c;
    - text-dark: #0c0a09;
    - text-light: #78716c;
  
## 📝 Additional Notes:

- ✅ Bootstrap CSS/JS, LineIcons CDN, and Font Awesome CDN are already included in header.php and footer.php.

- ⚠️ Do NOT re-add these links manually.

- 🧩 Use consistent structure and naming across new files.

- 📌 Stick to the provided templates for new feature/pages.

## Basic Template

Use this boilerplate for all new PHP pages:

### PHP

```php
<?php include('../includes/config.php'); ?>

<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../assets/css/ADD YOUR STYLE SHEET NAME">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>YOUR PAGE NAME</h1>
                <div class="page-path">
                    <p><span>Home ></span> YOUR PAGE NAME</p>
                </div>
            </div>
        </div>
    </div>

    <div class="sec">
            <!--YOUR CODE GOSE HERE-->
    </div>

<script src="../assets/js/ADD YOUR JS NAME"></script>

<?php include('../includes/footer.php'); ?>

```

### CSS

```css
.sec{
    margin-top: 20px;
    margin-left: 8%;
    margin-right: 8%;
    margin-bottom: 20px;
}
body {
    overflow-x: hidden;
}

.section__container {
    margin: auto;
    margin-bottom: 1rem;
    line-height: 3rem;
    height: 400px;
    text-align: center;
}
.header-container{
    height: 400px;
    background-image: url("../media/index/header.jpg");
    background-position: center ; 
    background-size: cover;
    background-repeat: no-repeat;
}
.container-text{
    color: rgb(255, 254, 254);
    padding-top: 150px;
}
.container-text h1{
    font-weight: bold;
}
.container-text span{
    color: var(--text-light);
}
```