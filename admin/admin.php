<?php include('../includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .section-admin{
            display: flex;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #343a40;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .nav-links {
            flex-grow: 1;
            margin-left: 0px;
        }
        .nav-links i{
            margin-right: 10px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }
        .logout i{
            margin-right: 20px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .iconAdmin i{
            font-size: 60px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border: 3px solid white;
            border-radius: 50%;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
 <div class="section-admin">
    <div class="sidebar">
        <div class="adminHeader text-center py-3">
            <div class="iconAdmin"><i class="fa-solid fa-user "></i></div>
            <h4 class="text-white text-center">Welcome, Admin</h4>
        </div>
        <div class="nav-links">
            <a href="#" class="nav-item" data-target="dashboard"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
            <a href="#" class="nav-item" data-target="manage-rooms"> <i class="fa-solid fa-person-shelter"></i>Manage Rooms</a>
            <a href="#" class="nav-item" data-target="manage-bookings"><i class="fa-solid fa-book"></i>Manage Bookings</a>
            <a href="#" class="nav-item" data-target="manage-users"> <i class="fa-solid fa-user"></i>Manage Users</a>
            <a href="#" class="nav-item" data-target="manage-blog"><i class="fa-solid fa-gear"></i>Blog Post Manage</a>
        </div>
        <div class="logout">
            <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i>Logout </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content">
        <div id="dashboard" class="content-section active">
            <h2 class="mb-4">Dashboard</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text fs-4">150</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Bookings</h5>
                            <p class="card-text fs-4">85</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Available Rooms</h5>
                            <p class="card-text fs-4">40</p>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="mt-5">
                <h4>Recent Activity</h4>
                <ul class="list-group">
                    <li class="list-group-item">User John booked Room A101.</li>
                    <li class="list-group-item">Admin updated room prices.</li>
                    <li class="list-group-item">New user Sarah registered.</li>
                </ul>
            </div>
        </div>
        
        <div id="manage-rooms" class="content-section">
            <h2>Manage Rooms</h2>
            <p>Here you can add, edit, or delete rooms.</p>
        </div>

        <div id="manage-bookings" class="content-section">
            <h2>Manage Bookings</h2>
            <p>Here you can manage bookings.</p>
        </div>

        <div id="manage-users" class="content-section">
            <h2>Manage Users</h2>
            <p>Here you can manage registered users.</p>
        </div>

        <div id="manage-blog" class="content-section">
            <h2 class="mb-4">Manage Blog Posts</h2>

            <?php

            // Delete blog post
            if (isset($_GET['delete'])) {
                $delete_id = intval($_GET['delete']);
                $conn->query("DELETE FROM blogs WHERE blog_id = $delete_id");
                echo "<script>alert('Blog post deleted successfully.');</script>";
            }
        
            // Fetch blog posts
            $result = $conn->query("SELECT * FROM blogs");
        
            if ($result->num_rows > 0): ?>
                <div class="row g-4">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($row['image'])): ?>
                                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Blog Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 100))) . '...'; ?></p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><?php echo date("F j, Y", strtotime($row['publish_date'])); ?></small>
                                    <a href="?delete=<?php echo $row['blog_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No blog posts found.</p>
            <?php endif;
        
            $conn->close();
            ?>
        </div>
        
    </div>
    
 </div>

<script>
    $(document).ready(function(){
        $(".nav-item").click(function(){
            $(".content-section").removeClass("active");
            let target = $(this).data("target");
            $("#" + target).addClass("active");
        });
    });
</script>

</body>
</html>
