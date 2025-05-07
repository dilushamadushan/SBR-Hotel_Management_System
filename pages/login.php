<?php include "../includes/header.php" ?>
<link rel="stylesheet" href="../assets/css/login.css">
    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>Hello ! Welcome Back.</h1>
                <div class="page-path">
                    <p><span>Home ></span> Sign Up</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sec">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card p-4 shadow">
                        <!-- Login Form -->
                        <div id="loginForm">
                            <h3 class="text-center">Login</h3>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="loginEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="loginPassword" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                                <div class="text-center mt-3">
                                    <a href="#" class="btn btn-light w-100">
                                        <i class="fab fa-google"></i> Sign in with Google
                                    </a>
                                </div>
                            </form>
                            <p class="text-center mt-3">Don't have an account? <a href="#" id="showRegister">Register here</a></p>
                        </div>
                        
                        <!-- Registration Form (Initially Hidden) -->
                        <div id="registerForm" style="display: none;">
                            <h3 class="text-center">Register</h3>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="registerName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="registerEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerMobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="registerMobile" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="registerAddress" required>
                                </div>
                                <div class="mb-3">
                                    <label for="userImg" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="user_image" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="registerPassword" required>
                                </div>
                                <button type="submit" name="register" class="btn btn-primary  w-100">Register</button>
                                <div class="text-center mt-3">
                                    <a href="#" class="btn btn-light w-100">
                                        <i class="fab fa-google"></i> Sign up with Google
                                    </a>
                                </div>
                            </form>
                            <p class="text-center mt-3">Already have an account? <a href="#" id="showLogin">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#showRegister').click(function(e) {
                e.preventDefault();
                $('#loginForm').hide();
                $('#registerForm').show();
            });
            
            $('#showLogin').click(function(e) {
                e.preventDefault();
                $('#registerForm').hide();
                $('#loginForm').show();
            });
        });
    </script>
<?php include "../includes/footer.php" ?>