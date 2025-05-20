<?php include('includes/config.php'); ?>

<link rel="stylesheet" href="assets/css/index.css">

<?php include "includes/header.php" ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ensure $conn is defined and connected

    $checkInDate = $_POST["check-date"];
    $checkOutDate = $_POST["check-out-date"];
    $roomType = $_POST["room-type"];

    $roomAvailable = true;

    $query = mysqli_query($conn, "SELECT * FROM booking_details");

    while ($res = mysqli_fetch_assoc($query)) {
        if (
            $checkInDate < $res['check_out_date'] &&
            $checkOutDate > $res['check_in_date'] &&
            $res['room_type'] == $roomType
        ) {
            // Conflict found
            $roomAvailable = false;
            break;
        }
    }

    if ($roomAvailable) {
        echo "<script>
            alert('Room is available!');
        </script>";
    } else {
        echo "<script>
            if (confirm('Room not available! Do you want to try different dates or room type?')) {
                window.location.href = window.location.href;
            }
        </script>";
    }
}
?>


<section class="home_slider">
        <img src="assets/media/index/img1.jpg" alt="Slide 1" class="slider_img active">
        <img src="assets/media/index/img2.jpg" alt="Slide 2" class="slider_img">
        <img src="assets/media/index/img3.jpg" alt="Slide 3" class="slider_img">
        <img src="assets/media/index/img4.jpg" alt="Slide 4" class="slider_img">
        <img src="assets/media/index/img5.jpg" alt="Slide 5" class="slider_img">

        <div class="banner_content active">
            <h2>Welcome to Our Hotel</h2>
            <p>Experience luxury like never before.</p>
            <a href="pages/room-catalogue.php" class="more_btn">Book Room</a>
        </div>

        <div class="banner_content">
            <h2>Breathtaking Views</h2>
            <p>Experience the best view.</p>
            <a href="pages/room-catalogue.php" class="more_btn">Book Room</a>
        </div>

        <div class="banner_content">
            <h2>Luxury Redefined</h2>
            <p>A place where elegance meets comfort.</p>
            <a href="pages/room-catalogue.php" class="more_btn">Book Room</a>
        </div>

        <div class="banner_content">
            <h2>Comfortable & Affordable</h2>
            <p>Your perfect getaway awaits.</p>
            <a href="pages/room-catalogue.php" class="more_btn">Book Room</a>
        </div>

        <div class="banner_content">
            <h2>Delicious Dining</h2>
            <p>Enjoy world-class cuisines.</p>
            <a href="pages/room-catalogue.php" class="more_btn">Book Room</a>
        </div>

        <div class="menu_bg">
            <img src="assets/media/index/img1.jpg" alt="Slide 1" class="bg_btn active" data-index="0">
            <img src="assets/media/index/img2.jpg" alt="Slide 2" class="bg_btn" data-index="1">
            <img src="assets/media/index/img3.jpg" alt="Slide 3" class="bg_btn" data-index="2">
            <img src="assets/media/index/img4.jpg" alt="Slide 4" class="bg_btn" data-index="3">
            <img src="assets/media/index/img5.jpg" alt="Slide 5" class="bg_btn" data-index="4">
        </div>
</section>

<div class="sec">
    <section class="formBook bg-light" >
            <div class="container mt-5">
                <div class="booking-form  p-3 rounded">
                    <form action="" method="post">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="check-date" class="form-label">CHECK-IN DATE</label>
                                <input type="date" id="check-date" name="check-date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="check-out-date" class="form-label">CHECK-OUT DATE</label>
                                <input type="date" id="check-out-date" name="check-out-date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="room-type" class="form-label">ROOM TYPE</label>
                                <select name="room-type" id="room-type" class="form-select" required>
                                    <option value="Luxury Suite">Luxury Suite</option>
                                    <option value="Deluxe Room">Deluxe Room</option>
                                    <option value="Standard Room">Standard Room</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="children" class="form-label">CHILDERN</label>
                                <select name="children" id="children" class="form-select" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="2">3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="adults" class="form-label">ADULTS</label>
                                <select name="adults" id="adults" class="form-select" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-grid book-btn">
                                <button type="submit" class="btn btn-primary">Check Available</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>

    <section class="py-5 welcome">
            <div class="container">
              <div class="row align-items-center ">
                <div class="col-md-12 col-lg-7 ml-auto order-lg-2 position-relative mb-5" data-aos="fade-up">
                  <figure class="img-absolute">
                    <img src="assets/media/index/food-1.jpg" alt="Image" class="img-fluid">
                  </figure>
                  <img src="assets/media/index/imgR.jpg" alt="Image" class="img-fluid rounded">
                </div>
                <div class="col-md-12 col-lg-4 order-lg-1 welcomeCon" data-aos="fade-up">
                  <h1 class="heading fw-bold">Welcome!</h1>
                    <p class="mb-4">Nestled in the heart of Nuwara Eliya, Sri Lanka, Secret Berry Resort offers a serene escape surrounded by lush greenery and breathtaking landscapes. 
                      Discover the perfect blend of luxury and tranquility, where every moment is a secret to cherish.</p>
                  <p><a href="#" class="btn btn-primary text-white py-2 mr-3" data-bs-toggle="modal" data-bs-target="#aboutHotelModal">Learn More</a></p>
              </div>
            </div>            
    </section>

    <div class="modal fade" id="aboutHotelModal" tabindex="-1" aria-labelledby="aboutHotelModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-4">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold w-100 text-center" id="aboutHotelModalLabel">Welcome to Secret Berry Resort</h5>
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center px-4">
            <p class="mb-4"><strong>Secret Berry Resort</strong> is a peaceful hideaway in the cool hills of <strong>Nuwara Eliya</strong>, Sri Lanka. Designed for those who seek comfort, nature, and luxury, our resort is the perfect blend of modern elegance and natural beauty.</p>

            <h6 class="fw-bold mt-3">🌿 What Makes Us Special</h6>
            <ul class="list-unstyled mb-4">
              <li>✔️ Located in the heart of Nuwara Eliya with stunning mountain views</li>
              <li>✔️ Luxurious rooms and suites including the elegant <strong>Luxury Suite</strong></li>
              <li>✔️ On-site fine dining restaurant offering local and international cuisine</li>
              <li>✔️ Organic garden and fresh farm-to-table ingredients</li>
              <li>✔️ Spa, wellness center, and yoga deck for complete relaxation</li>
              <li>✔️ Guided tours, nature trails, and tea estate visits</li>
              <li>✔️ Friendly, multilingual staff and 24/7 front desk support</li>
            </ul>

            <h6 class="fw-bold">🏡 Our Rooms</h6>
            <p class="mb-4">From cozy Deluxe Rooms to the exquisite Luxury Suite, every room is designed to provide comfort, privacy, and a direct connection to nature. All rooms include high-speed Wi-Fi, room service, premium toiletries, and beautiful views.</p>

            <h6 class="fw-bold">📍 Location</h6>
            <p class="mb-4">We are just minutes away from Gregory Lake, Victoria Park, and the city's bustling market — yet hidden enough to offer complete peace and quiet.</p>

            <h6 class="fw-bold">🌟 Guest Promise</h6>
            <p class="mb-4">We’re committed to making your stay unforgettable — whether you're here for a honeymoon, family vacation, or just a break from city life.</p>

          </div>
          <div class="modal-footer justify-content-center border-0 pt-0">
            <a href="pages/room-catalogue.php" class="btn btn-primary px-4">Explore Our Rooms</a>
            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <section class="services-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center mb-4">
                        <div class="section-title ">
                            <span class="text-uppercase text-secondary">What We Do</span>
                            <h1 class="fw-bold">Discover Our Services</h1>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-square-parking fa-4x"></i>
                            <h4 class="mt-3">Travel Plan</h4>
                            <p>Plan your perfect trip with ease and enjoy seamless travel experiences.</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php#travel" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-utensils fa-4x"></i>
                            <h4 class="mt-3">Catering Service</h4>
                            <p>Delicious meals tailored to your taste, served with perfection.</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php#Catering" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-bed-pulse fa-4x"></i>
                            <h4 class="mt-3">Babysitting</h4>
                            <p>Trustworthy and caring babysitting services for your little ones.</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php#Babysitting" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-clock fa-4x"></i>
                            <h4 class="mt-3">Hire Driver</h4>
                            <p>Reliable and professional drivers for your safe and comfortable ride.</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php#Hire" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-martini-glass-citrus fa-4x"></i>
                            <h4 class="mt-3">Bar & Drink</h4>
                            <p>Enjoy premium drinks and cocktails in a vibrant atmosphere.</p>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                      <a href="pages/service.php#Bar" class="text-decoration-none text-dark">
                        <div class="service-item p-4 text-center">
                            <i class="fa-solid fa-spa fa-4x"></i>
                            <h4 class="mt-3">Spa & Wellness</h4>
                            <p>Relax and rejuvenate with our premium spa and wellness treatments.</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
    </section>

    <section class="section-Room">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center mb-4">
                            <div class="section-title ">
                                <span class="text-uppercase text-secondary">OUR LIVING ROOM</span>
                                <h1 class="fw-bold">Explore Our Rooms</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 room-card">
                      <div class="card card-explore">
                      <div class="card-explore__img">
                        <img class="card-img" src="assets/media/index/explore1.jpg" alt="">
                      </div>
                      <div class="card-body">
                        <h3 class="card-explore__price">$250.00 <sub>/ Per Night</sub></h3>
                        <h4 class="card-explore__title"><a href="#">Luxury Suite</a></h4>
                        <p>Experience the pinnacle of luxury with our spacious and elegantly designed suites.</p>
                        <a class="card-explore__link" href="pages/room-catalogue.php">Book Now <i class="fa-solid fa-arrow-right"></i></a>
                      </div>
                      </div>
                    </div>
                
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 room-card">
                      <div class="card card-explore">
                      <div class="card-explore__img">
                        <img class="card-img" src="assets/media/index/explore2.jpg" alt="">
                      </div>
                      <div class="card-body">
                        <h3 class="card-explore__price">$180.00 <sub>/ Per Night</sub></h3>
                        <h4 class="card-explore__title"><a href="#">Deluxe Room</a></h4>
                        <p>Relax in style with our deluxe rooms, offering comfort and modern amenities.</p>
                        <a class="card-explore__link" href="pages/room-catalogue.php">Book Now <i class="fa-solid fa-arrow-right"></i></a>
                      </div>
                      </div>
                    </div>
                
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 room-card">
                      <div class="card card-explore">
                      <div class="card-explore__img">
                        <img class="card-img" src="assets/media/index/explore3.jpg" alt="">
                      </div>
                      <div class="card-body">
                        <h3 class="card-explore__price">$120.00 <sub>/ Per Night</sub></h3>
                        <h4 class="card-explore__title"><a href="#">Standard Room</a></h4>
                        <p>Enjoy a cozy and affordable stay in our well-equipped standard rooms.</p>
                        <a class="card-explore__link" href="pages/room-catalogue.php">Book Now <i class="fa-solid fa-arrow-right"></i></a>
                      </div>
                      </div>
                    </div>
                  </div>
            </div>
    </section>

    <section class="container text-center my-5 secAbout" id="about">
                <div class="row align-items-center">
                  <div class="col-lg-6">
                    <img src="assets/media/index/about.jpg" alt="about" class="img-fluid rounded">
                  </div>
                  <div class="col-lg-6 aboutCon">
                    <h6 class="text-uppercase text-secondary ">About Us</h6>
                    <h1 class="fw-semibold">The Best Holidays Start Here!</h1>
                    <p class="text-muted">
                      With a focus on quality accommodations, personalized experiences, and seamless booking,
                      our platform is dedicated to ensuring that every traveler embarks on their dream holiday with confidence and excitement.
                    </p>
                    <a href="pages/about-us.php" class="btn btn-primary">Read More</a>
                  </div>
                </div>
    </section>

    <section class="container py-5 secCount">
                <div class="row text-center justify-content-center">
                  <div class="col-md-4 ">
                    <div class="p-4 shadow rounded countValue">
                      <h4 class="text-black">25+</h4>
                      <p>Properties Available</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="p-4 shadow rounded countValue">
                      <h4 class="text-black">350+</h4>
                      <p>Bookings Completed</p>
                    </div>
                  </div>
                  <div class="col-md-4 ">
                    <div class="p-4 shadow rounded countValue">
                      <h4 class="text-black">600+</h4>
                      <p>Happy Customers</p>
                    </div>
                  </div>
                </div>
    </section>

<!-- Bootstrap Ad Popup Modal -->
<div class="modal fade" id="adModal" tabindex="-1" aria-labelledby="adModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
    <div class="modal-content position-relative" style="height: 500px; overflow: hidden;">
      
      <!-- Close Button at Top-Left -->
      <button type="button" class="btn-close position-absolute top-0 start-0 m-2 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
      
      <!-- Ad Content -->
      <div class="modal-body p-0" id="adContent" style="transition: opacity 1s;">
        <!-- Dynamic ad content will be inserted here -->
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="adModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content" id="adContent" style="transition: opacity 0.5s;"></div>
  </div>
</div>

</div>    

<script src="assets/js/index.js"></script>

<?php include "includes/footer.php" ?>