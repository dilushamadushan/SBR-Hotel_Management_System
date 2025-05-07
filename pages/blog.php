<?php include('../includes/config.php'); ?>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $title = $_POST['blogTitle'];
        $content = $_POST['blogContent'];
        $publish_date = date("Y-m-d");

        $image_name = $_FILES['blogImage']['name'];
        $tmp  = explode(".",$image_name);
        $newfilename = round(microtime(true)).'.'.end($tmp);
        $uploadPath = '../upload/'.$newfilename;
        move_uploaded_file($_FILES['blogImage']['tmp_name'],$uploadPath); 

        $sqlBlog = "INSERT INTO blogs(title,content,image,publish_date) VALUE ('$title','$content','$uploadPath','$publish_date')"; 
        $data = mysqli_query($conn,$sqlBlog);
        if($data){
           // echo "Success";
        }else{
            echo "haaa";
        }
    }
?>
<?php include('../includes/header.php'); ?>

<link rel="stylesheet" href="../assets/css/blog.css">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>BLOG</h1>
                <div class="page-path">
                    <p><span>Home ></span> Blog</p>
                </div>
            </div>
        </div>
    </div>

    <div class="sec">
        <div class="blogPost">
            <div class="row blog-post-row">
            <?php    
                $sql = "SELECT * FROM blogs ORDER BY publish_date DESC";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { 
                    $modalId = "blogModal" . $row['blog_id'];
            ?>        
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="img">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                <p class="card-text"><?php echo substr($row['content'], 0, 100) . '...'; ?></p>
                <p class="text-muted">Published on: <?php echo $row['publish_date']; ?></p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">Read More</button>
                <button class="btn btn-outline-danger like-btn" data-id="<?php echo $row['blog_id']; ?>">❤️ <span class="like-count">0</span></button>
            </div>
        </div>
    </div>

    <!-- Modal for each blog post -->
    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?php echo $modalId; ?>Label"><?php echo $row['title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?php echo $row['image']; ?>" class="img-fluid mb-3" alt="img">
                    <p><?php echo $row['content']; ?></p>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
            </div>
        </div>
           <!-- Blog Submission Form -->
           <div class="card p-4 mb-4">
            <h3 class="mb-3">Share Your Experience</h3>
            <form action="blog.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Blog Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="blogTitle" required>
                </div>
                <div class="mb-3">
                    <label for="blogContent" class="form-label">Blog Content</label>
                    <textarea class="form-control" id="blogContent" name="blogContent" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="blogImage" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="blogImage" name="blogImage" accept="image/*" required>
                </div>
                <input type="hidden" name="publishDate">
                <button type="submit" class="btn btn-primary">Submit Blog</button>
            </form>
            </div>
  
    </div>
    <script src="../assets/js/blog.js"></script>
<?php include('../includes/footer.php'); ?>
</body>
</html>
