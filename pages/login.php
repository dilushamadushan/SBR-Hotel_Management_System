<?php include "../includes/header.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <form method="POST" action="../function/loginFunction.php">

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
                                
                                <div id="loginMessage" class="mt-3"></div>

                            </form>
                            <p class="text-center mt-3">Don't have an account? <a href="#" id="showRegister">Register here</a></p>
                        </div>
                        
                        <!-- Registration Form (Initially Hidden) -->
                        <!-- <div id="registerForm" style="display: none;">
                            <h3 class="text-center">Register</h3>
                            <form method="POST" action="../function/registerForm.php" enctype="multipart/form-data">
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
                        </div> -->

                        <div id="registerForm" style="display: none;">
    <h3 class="text-center">Register</h3>
    <form id="registerFormForm" method="POST" enctype="multipart/form-data">
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
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        <div class="text-center mt-3">
            <a href="#" class="btn btn-light w-100">
                <i class="fab fa-google"></i> Sign up with Google
            </a>
        </div>
    </form>
    <p class="text-center mt-3">Already have an account? <a href="#" id="showLogin">Login here</a></p>

    <!-- Place to show messages -->
    <div id="registerMessage" class="mt-3"></div>
</div>




                    </div>
                </div>
            </div>
        </div>
    </div>

    
<script>
$(document).ready(function() {

  // --- Register Form Submission with AJAX ---
  $('#registerFormForm').on('submit', function(e) {
    e.preventDefault();

    const email = $('input[name="registerEmail"]').val().trim();
    const password = $('input[name="registerPassword"]').val();
    const mobile = $('input[name="registerMobile"]').val().trim();

    if (!validateEmail(email)) {
      alert("Please enter a valid email address.");
      return;
    }

    if (password.length < 6) {
      alert("Password must be at least 6 characters long.");
      return;
    }

    if (!validateMobile(mobile)) {
      alert("Please enter a valid mobile number.");
      return;
    }

    let formData = new FormData(this);

    $.ajax({
      url: '../function/registerForm.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        console.log("Register AJAX success response:", response); // Debug
        if (response.success) {
          $('#registerMessage').html('<div class="alert alert-success">' + response.message + '</div>');
          $('#registerFormForm')[0].reset();
        } else {
          $('#registerMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
        }
      },
      error: function(xhr, status, error) {
        console.error("Register AJAX error:", { status, error, response: xhr.responseText }); // Debug
        $('#registerMessage').html(
          `<div class="alert alert-danger">
            Registration request failed.<br>
            Status: ${status}<br>
            Error: ${error}<br>
            Response: ${xhr.responseText}
          </div>`
        );
      }
    });
  });

  // --- Login Form Submission with AJAX ---
  $('#loginForm form').on('submit', function(e) {
    e.preventDefault();

    const email = $('input[name="loginEmail"]').val().trim();
    const password = $('input[name="loginPassword"]').val();

    if (!validateEmail(email)) {
      alert("Please enter a valid email address.");
      return;
    }

    if (password.length < 6) {
      alert("Password must be at least 6 characters long.");
      return;
    }

    $.ajax({
      url: '../function/loginFunction.php',
      type: 'POST',
      data: { loginEmail: email, loginPassword: password, login: true },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#loginMessage').html('<div class="alert alert-success">' + response.message + '</div>');
          setTimeout(() => {
            if(response.role == 'admin') {
              window.location.href = '../admin/admin.php';
            } else {
              window.location.href = 'proflie.php';
            }
          }, 1500);
        } else {
          $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
        }
      },
      error: function(xhr, status, error) {
        console.error("Login AJAX error:", { status, error, response: xhr.responseText }); // Debug
        $('#loginMessage').html(
          `<div class="alert alert-danger">
            Login request failed.<br>
            Status: ${status}<br>
            Error: ${error}<br>
            Response: ${xhr.responseText}
          </div>`
        );
      }
    });
  });

  // --- Toggle login/register forms ---
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

  // --- Utility validation functions ---
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  function validateMobile(mobile) {
    const re = /^[0-9]{10}$/; // Adjust if needed
    return re.test(mobile);
  }

});
</script>


<?php include "../includes/footer.php" ?>