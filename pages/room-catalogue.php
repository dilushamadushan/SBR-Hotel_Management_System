<?php
session_start();
$booking_success = false;
if (isset($_SESSION['booking_success']) && $_SESSION['booking_success'] === true) {
    $booking_success = true;
    unset($_SESSION['booking_success']);
}
?>

<?php include('../includes/config.php'); ?>


<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../assets/css/room_catalogue.css">

    <div class="header-container">
        <div class="section__container" id="home">
            <div class="container-text">
                <h1>Room Catalogue</h1>
                <div class="page-path">
                    <p><span>Home ></span> Room Catalogue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="sec">
            <div class="searchBox">
                <input type="text" id="searchBox" class="form-control" placeholder="Search by room type or feature...">
            </div>     
            <div class="room-container">
                <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Available Top Level Couples Rooms</h2>
                <div class="room-list">
                    <!-- Luxury Suite -->
                    <div class="col-md-4 room-item" data-name="luxury Suite" data-features="wifi fireplace jacuzzi garden" data-category="luxury">
                        <div class="room-card">
                            <div id="luxurySuiteCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../assets/media/room_catalogue/luxury/1.jpg" class="d-block w-100" alt="Room Image 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/luxury/2.jpg" class="d-block w-100" alt="Room Image 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/luxury/3.jpg" class="d-block w-100" alt="Room Image 3">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/luxury/4.jpg" class="d-block w-100" alt="Room Image 4">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Deluxe/5.jpeg" class="d-block w-100" alt="Room Image 5">
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#luxurySuiteCarousel" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#luxurySuiteCarousel" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                            <br>
                            <h2>Luxury Suite</h2>
                            <p>Spacious suite with Gregory Lake view and a private balcony.</p>
                            <span class="price">$200 / Night</span><br>
                            <button class="btn-details btn-danger" data-bs-toggle="modal" data-bs-target="#luxurySuiteModal">View Details</button>
                            <button class="book-now" onclick="openBookingPopup('Luxury Suite')">Book Now</button>
                        </div>

                        <div class="modal fade" id="luxurySuiteModal" tabindex="-1" aria-labelledby="luxurySuiteLabel" aria-hidden="true" data-bs-backdrop="false">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="luxurySuiteLabel">Luxury Suite</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <img src="../assets/media/room_catalogue/image 1.png" class="img-fluid mb-3 rounded" alt="Luxury Suite">
                                <ul class="list-unstyled mb-3">
                                  <li><strong>View:</strong> Gregory Lake & Private Balcony</li>
                                  <li><strong>Amenities:</strong><i class="bi bi-wifi"></i> Free WiFi | <i class="bi bi-fire"></i> Fireplace | <i class="bi bi-droplet"></i> Private Jacuzzi | <i class="bi bi-tree"></i> Garden View</li>
                                  <li><strong>Special:</strong> 20% Discount, Complimentary Breakfast</li>
                                </ul>
                                <p>Indulge in a world of elegance and tranquility at Secret Berry Resort. Enjoy cozy fire-lit evenings, scenic hikes, and boat rides on Gregory Lake. Each suite is designed for absolute relaxation, with a soothing ambiance and luxury features.</p>
                                <div class="alert alert-success">
                                  <strong>Offer:</strong> Original Price: <del>$250</del> | <strong>Now: $200</strong> (20% off)
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="bookingModal" class="booking-modal">
                            <div class="modal-content-booking">
                                <span class="close-btn" onclick="closeBookingPopup()">&times;</span>
                                <h2>Booking: <span id="roomNameDisplay"></span></h2>
                                <form id="bookingForm" method="POST" action="book_room_conn.php">
                                    <input type="hidden" name="room_type" value="Luxury Suite Room">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                                    <label for="checkin">Check-in Date</label>
                                    <input type="date" id="checkin" name="checkin" required>
                                    <label for="checkout">Check-out Date</label>
                                    <input type="date" id="checkout" name="checkout" required>
                                    <div class="row g-2 mt-3">
                                      <div class="col-md-6">
                                        <label for="adultCount" class="form-label">Adults</label>
                                        <input type="number" class="form-control" name="adults" id="adultCount" min="0" value="0" required>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="childrenCount" class="form-label">Children</label>
                                        <input type="number" class="form-control" name="children" id="childrenCount" min="0" value="0" required>
                                      </div>
                                    </div>
                                    <hr class="my-3">
                                    <h6 class="text-primary">💳 Payment Details</h6>                            
                                    <div class="mb-3">
                                      <label for="cardNumber" class="form-label">Card Number</label>
                                      <input type="text" class="form-control" id="cardNumber" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-md-6 mb-3">
                                        <label for="expiryDate" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiryDate" name="expiry_date" placeholder="MM/YY" required>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="password" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                                      </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                      <label for="cardHolder" class="form-label">Card Holder Name</label>
                                      <input type="text" class="form-control" id="cardHolder" name="card_holder" required>
                                    </div>
                                    <label for="requests">Special Requests</label>
                                    <textarea id="requests" name="requests" name="requests" placeholder="Any special instructions..."></textarea><br>
                                     <button type="submit" class="btn btn-success">Submit Booking</button>
                                </form>

                                <?php if ($booking_success): ?>
                                      <script>
                                          alert("✅ Booking Successful! Your room is reserved.");
                                      </script>
                                <?php endif; ?>

                                   
                                <div id="bookingConfirmation" class="alert alert-success mt-3" style="display: none;">
                                  ✅ Thank you! Your booking has been submitted.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Deluxe Room -->
                    <div class="col-md-4 room-item" data-name="Deluxe Room" data-features="wifi heating coffee" data-category="deluxe">
                        <div class="room-card">
                            <div id="deluxeRoomCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../assets/media/room_catalogue/Deluxe/1.jpg" class="d-block w-100" alt="Room Image 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Deluxe/2.jpeg" class="d-block w-100" alt="Room Image 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Deluxe/3.jpeg" class="d-block w-100" alt="Room Image 3">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Deluxe/4.jpeg" class="d-block w-100" alt="Room Image 4">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Deluxe/5.jpeg" class="d-block w-100" alt="Room Image 5">
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#deluxeRoomCarousel" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#deluxeRoomCarousel" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                            <br>
                            <h2>Deluxe Room</h2>
                            <p>Cozy and elegant room with lake views and a private balcony.</p>
                            <div class="card-body">
                                <p></p>
                            </div>
                            <span class="price">$180 / Night</span><br>
                            <button class="btn-details btn-danger" data-bs-toggle="modal" data-bs-target="#deluxeRoomModal">View Details</button>
                            <button class="book-now" onclick="openBookingPopup('Deluxe Room')">Book Now</button>
                        </div>

                        <div class="modal fade" id="deluxeRoomModal" tabindex="-1" aria-labelledby="deluxeRoomLabel" aria-hidden="true" data-bs-backdrop="false">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deluxeRoomLabel">Deluxe Room</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <img src="../assets/media/room_catalogue/Deluxe/1.jpg" class="img-fluid mb-3 rounded" alt="Deluxe Room">
                                <ul class="list-unstyled mb-3">
                                  <li><strong>View:</strong> Gregory Lake & Private Balcony</li>
                                  <li><strong>Amenities:</strong>
                                    <i class="bi bi-wifi"></i> Free WiFi | <i class="bi bi-fire"></i> Fireplace | <i class="bi bi-droplet"></i> Private Jacuzzi | <i class="bi bi-tree"></i> Garden View
                                  </li>
                                  <li><strong>Special:</strong> 10% Discount, Complimentary Breakfast</li>
                                </ul>
                                <p>Relax in cozy comfort with scenic lake views and warm interiors. The Deluxe Room is designed for couples or solo travelers looking for an affordable yet classy stay at Secret Berry Hotel.</p>
                                <div class="alert alert-success">
                                  <strong>Offer:</strong> Original Price: <del>$200</del> | <strong>Now: $180</strong> (10% off)
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <!-- Standard Room -->
                    <div class="col-md-4 room-item" data-name="Standard Room" data-features="wifi parking breakfast" data-category="standard">
                        <div class="room-card">
                            <div id="standardRoomCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../assets/media/room_catalogue/Standard/1.jpg" class="d-block w-100" alt="Room Image 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Standard/2.jpg" class="d-block w-100" alt="Room Image 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Standard/3.jpg" class="d-block w-100" alt="Room Image 3">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Standard/4.jpg" class="d-block w-100" alt="Room Image 4">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="../assets/media/room_catalogue/Standard/5.jpg" class="d-block w-100" alt="Room Image 5">
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#standardRoomCarousel" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#standardRoomCarousel" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                            <h2>Standard Room</h2>
                            <p>Cozy room with modern amenities.</p>
                            <span class="price">$120 / Night</span><br>
                            <button class="btn-details btn-danger" data-bs-toggle="modal" data-bs-target="#standardRoomModal">View Details</button>
                            <button class="book-now" onclick="openBookingPopup('Standard Room')">Book Now</button>
                            

                        </div>

                        <div class="modal fade" id="standardRoomModal" tabindex="-1" aria-labelledby="standardRoomLabel" aria-hidden="true" data-bs-backdrop="false">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                  <div class="modal-header bg-danger text-white">
                                      <h5 class="modal-title" id="standardRoomLabel">Standard Room</h5>
                                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <img src="../assets/media/room_catalogue/Standard/1.jpg" class="img-fluid mb-3 rounded" alt="Standard Room">
                                      <ul class="list-unstyled mb-3">
                                          <li><strong>View:</strong> Mountain and Garden</li>
                                          <li><strong>Amenities:</strong>
                                            <i class="bi bi-wifi"></i> Free WiFi | <i class="bi bi-p-circle"></i> Free Parking | <i class="bi bi-egg-fried"></i> Breakfast
                                          </li>
                                          <li><strong>Special:</strong> Best for solo or budget travelers</li>
                                      </ul>
                                      <p>A practical and relaxing space with all essentials for your getaway. Perfect for those who want to enjoy Nuwara Eliya's beauty without overspending. Start your day with a hot local breakfast and enjoy quiet evenings in comfort.</p>
                                      <div class="alert alert-success">
                                          <strong>Offer:</strong> Only <strong>$120</strong> per night
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
          
            

            <div class="second-sub-text">
              <p><u><b>About this property</b></u></p>
              <p><b>Comfortable Accommodations:</b>Palazzo Lake Gregory in Nuwara Eliya offers comfortable rooms with private bathrooms, 
                  tea and coffee makers, and free toiletries. Each room includes a shower and complimentary WiFi throughout the property</p>
              <p><b>Dining Experience:</b>Our family-friendly restaurant offers a diverse selection of cuisines, including Chinese, British, 
                  Indian, Italian, and local specialties. Guests can enjoy a delightful breakfast with continental, American, buffet, and full 
                  English options. Be sure to try our exclusive dishes featuring our secret berry product, a unique ingredient that adds a delicious 
                  twist to our signature desserts and beverages.</p>
              <p><b>Leisure Facilities:</b>The hotel features a garden, terrace, and free on-site parking. Additional amenities include a child-friendly 
                  buffet, electric vehicle charging station, and bicycle parking.</p>
              <p><b>Location and Attractions:</b>Located 1.9 mi from Gregory Lake and 4.3 mi from Hakgala Botanical Garden, the property is 30 mi from 
                  Castlereigh Reservoir Seaplane Base. Guests appreciate the scenic views and attentive staff.</p>

              <p>Couples in particular like the location – they rated it 8.9 for a two-person trip.</p>           
              
              <div class="icon-list">
                  <p><b>Most popular facilities</b></p>
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
                  <i class="bi bi-wifi"></i> Free WiFi  &nbsp;
                  <i class="bi bi-p-circle"></i> Free Parking  &nbsp;
                  <i class="bi bi-shop"></i> Restaurant  &nbsp;
                  <i class="bi bi-ban"></i> Non-Smoking Rooms  &nbsp;
                  <i class="bi bi-cone-striped"></i> Room Service  &nbsp;
                  <i class="bi bi-thermometer-half"></i> Heating<br>
                  <i class="bi bi-fire"></i> BBQ Facilities  &nbsp;
                  <i class="bi bi-tree"></i> Garden  &nbsp; 
                  <i class="bi bi-cup-hot"></i> Tea/Coffee Maker in All Rooms  &nbsp;
                  <i class="bi bi-egg-fried"></i> Breakfast
              </div>
            </div>

            <div class="container my-5">
              <div class="container">
                <div class="highlighted-header">
                  <h4>Choose Rooms by Occupancy</h4>
                </div>
              </div>
              <div class="text-center">
                <select id="occupancySelect" class="form-select w-50 mx-auto mb-4">
                  <option selected disabled>🔽 Select Room Type</option>
                  <option value="solo">🧍 Solo Traveler</option>
                  <option value="small_family">👨‍👩‍👧 Small Family</option>
                  <option value="large_family">👨‍👩‍👧‍👦 Large Family</option>
                  <option value="single">🛏️ Single Bed</option>
                  <option value="double">🛏️ Double Bed</option>
                  <option value="queen">👸 Queen Bed</option>
                  <option value="king">🤴 King Bed</option>
                </select>
              </div>
            </div>
            
            <div class="container">
              <div class="row" id="roomCards">
            </div>
          
          
          <script>
            const roomTemplates = {
              solo: `
                <div class="col-lg-4 col-md-6 my-3">
                  <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="../assets/media/room_catalogue/room/5.jpg" class="card-img-top" alt="Solo Room">
                    <div class="card-body">
                      <h5>Solo Room</h5>
                      <h6 class="mb-4">$80 per night</h6>
                      <div class="features mb-4">
                        <h6 class="mb-1">Features</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Room</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Bathroom</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Sofa</span>
                      </div>
                      <div class="facilities mb-4">
                        <h6 class="mb-1">Facilities</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">WiFi</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">Room Heater</span>
                      </div>
                      <div class="d-flex justify-content-evenly mb-2">
                        <a href="#" class="btn btn-primary" onclick="openBookingPopup('Solo Room')">Book Now</a>
                        <a href="#" class="btn btn-light btn-outline-primary" onclick="openRoomDetails('solo')">More details</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 my-3">
                  <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="../assets/media/room_catalogue/room/4.jpg" class="card-img-top" alt="Solo Room">
                    <div class="card-body">
                      <h5>Solo Room</h5>
                      <h6 class="mb-4">$80 per night</h6>
                      <div class="features mb-4">
                        <h6 class="mb-1">Features</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Room</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Bathroom</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Sofa</span>
                      </div>
                      <div class="facilities mb-4">
                        <h6 class="mb-1">Facilities</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">WiFi</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">Room Heater</span>
                      </div>
                      <div class="d-flex justify-content-evenly mb-2">
                        <a href="#" class="btn btn-primary" onclick="openBookingPopup('Solo Room')">Book Now</a>
                        <a href="#" class="btn btn-light btn-outline-primary" onclick="openRoomDetails('solo')">More details</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 my-3">
                  <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="../assets/media/room_catalogue/room/3.jpg" class="card-img-top" alt="Solo Room">
                    <div class="card-body">
                      <h5>Solo Room</h5>
                      <h6 class="mb-4">$80 per night</h6>
                      <div class="features mb-4">
                        <h6 class="mb-1">Features</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Room</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Bathroom</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">1 Sofa</span>
                      </div>
                      <div class="facilities mb-4">
                        <h6 class="mb-1">Facilities</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">WiFi</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">Room Heater</span>
                      </div>
                      <div class="d-flex justify-content-evenly mb-2">
                        <a href="#" class="btn btn-primary" onclick="openBookingPopup('Solo Room')">Book Now</a>
                        <a href="#" class="btn btn-light btn-outline-primary" onclick="openRoomDetails('solo')">More details</a>
                      </div>
                    </div>
                  </div>
                </div>
              `,
              
              small_family: `
                 <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/6.webp" class="card-img-top" alt="Small Family Room">
                        <div class="card-body">
                          <h5>Family Room</h5>
                          <h6 class="mb-4">$180 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">2 Bedrooms</span>
                            <span class="badge bg-light text-dark">2 Bathrooms</span>
                            <span class="badge bg-light text-dark">1 Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Wi-Fi</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">Mini Kitchen</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Family Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('small_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/19.jpg" class="card-img-top" alt="Small Family Room" style= "max-height: 210px;"">
                        <div class="card-body">
                          <h5>Family Room</h5>
                          <h6 class="mb-4">$180 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">2 Bedrooms</span>
                            <span class="badge bg-light text-dark">2 Bathrooms</span>
                            <span class="badge bg-light text-dark">1 Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Wi-Fi</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">Mini Kitchen</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Family Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('small_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/18.jpg" class="card-img-top" alt="Small Family Room" style= "max-height: 210px;">
                        <div class="card-body">
                          <h5>Family Room</h5>
                          <h6 class="mb-4">$180 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">2 Bedrooms</span>
                            <span class="badge bg-light text-dark">2 Bathrooms</span>
                            <span class="badge bg-light text-dark">1 Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Wi-Fi</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">Mini Kitchen</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                              <i class="bi bi-star text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Family Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('small_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    `
                    ,
                
                large_family: `
                    <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/4.jpg" class="card-img-top" alt="Large Family Room">
                        <div class="card-body">
                          <h5>Large Family Suite</h5>
                          <h6 class="mb-4">$250 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">3 Bedrooms</span>
                            <span class="badge bg-light text-dark">3 Bathrooms</span>
                            <span class="badge bg-light text-dark">Dining + Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Kitchen</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">AC</span>
                            <span class="badge bg-light text-dark">Room Heater</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Large Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('large_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/15.jpg" class="card-img-top" alt="Large Family Room" style= "max-height: 230px;">
                        <div class="card-body">
                          <h5>Large Family Suite</h5>
                          <h6 class="mb-4">$250 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">3 Bedrooms</span>
                            <span class="badge bg-light text-dark">3 Bathrooms</span>
                            <span class="badge bg-light text-dark">Dining + Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Kitchen</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">AC</span>
                            <span class="badge bg-light text-dark">Room Heater</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Large Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('large_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-3">
                      <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="../assets/media/room_catalogue/room/16.jpg" class="card-img-top" alt="Large Family Room" style= "max-height: 230px;">
                        <div class="card-body">
                          <h5>Large Family Suite</h5>
                          <h6 class="mb-4">$250 per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                            <span class="badge bg-light text-dark">3 Bedrooms</span>
                            <span class="badge bg-light text-dark">3 Bathrooms</span>
                            <span class="badge bg-light text-dark">Dining + Living Room</span>
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge bg-light text-dark">Kitchen</span>
                            <span class="badge bg-light text-dark">TV</span>
                            <span class="badge bg-light text-dark">AC</span>
                            <span class="badge bg-light text-dark">Room Heater</span>
                          </div>
                          <div class="rating mb-4">
                            <h6 class="mb-1">Rating</h6>
                            <span class="badge bg-light">
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                              <i class="bi bi-star-fill text-warning"></i>
                            </span>
                          </div>
                          <div class="d-flex justify-content-evenly mb-2">
                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('Large Room')">Book Now</a>
                            <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('large_family')">More details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    `,
                    single: `
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/7.webp" class="card-img-top" alt="Single Bed Room">
                            <div class="card-body">
                              <h5>Single Bed Room</h5>
                              <h6 class="mb-4">$60 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Single Bed</span>
                                <span class="badge bg-light text-dark">Free Wifi</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">TV</span>
                                <span class="badge bg-light text-dark">Room Heater</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('single Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('single')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/18.jpg" class="card-img-top" alt="Single Bed Room" style= "max-height: 190px;">
                            <div class="card-body">
                              <h5>Single Bed Room</h5>
                              <h6 class="mb-4">$60 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Single Bed</span>
                                <span class="badge bg-light text-dark">Free Wifi</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">TV</span>
                                <span class="badge bg-light text-dark">Room Heater</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('single Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('single')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/12.jpg" class="card-img-top" alt="Single Bed Room" style= "max-height: 190px;">
                            <div class="card-body">
                              <h5>Single Bed Room</h5>
                              <h6 class="mb-4">$60 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Single Bed</span>
                                <span class="badge bg-light text-dark">Free Wifi</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">TV</span>
                                <span class="badge bg-light text-dark">Room Heater</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('single Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('single')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        `,
                    
                      double: `
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/10.jpg" class="card-img-top" alt="Double Bed Room" style= "max-height: 240px;">
                            <div class="card-body">
                              <h5>Double Bed Room</h5>
                              <h6 class="mb-4">$90 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Double Bed</span>
                                <span class="badge bg-light text-dark">Balcony</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">AC</span>
                                <span class="badge bg-light text-dark">Mini Fridge</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('double Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('double')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/20.jpg" class="card-img-top" alt="Double Bed Room" style= "max-height: 240px;">
                            <div class="card-body">
                              <h5>Double Bed Room</h5>
                              <h6 class="mb-4">$90 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Double Bed</span>
                                <span class="badge bg-light text-dark">Balcony</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">AC</span>
                                <span class="badge bg-light text-dark">Mini Fridge</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('double Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('double')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/11.jpg" class="card-img-top" alt="Double Bed Room" style= "max-height: 240px;">
                            <div class="card-body">
                              <h5>Double Bed Room</h5>
                              <h6 class="mb-4">$90 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Double Bed</span>
                                <span class="badge bg-light text-dark">Balcony</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">AC</span>
                                <span class="badge bg-light text-dark">Mini Fridge</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('double Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('double')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        `,
                    
                      queen: `
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/13.jpg" class="card-img-top" alt="Queen Bed Room" >
                            <div class="card-body">
                              <h5>Queen Bed Room</h5>
                              <h6 class="mb-4">$110 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Queen Bed</span>
                                <span class="badge bg-light text-dark">Mountain View</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">Jacuzzi</span>
                                <span class="badge bg-light text-dark">Mini Bar</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('queen Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('queen')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/22.jpg" class="card-img-top" alt="Queen Bed Room" style= "max-height: 200px;>
                            <div class="card-body">
                              <br>
                              <h5>Queen Bed Room</h5>
                              <h6 class="mb-4">$110 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 Queen Bed</span>
                                <span class="badge bg-light text-dark">Mountain View</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">Jacuzzi</span>
                                <span class="badge bg-light text-dark">Mini Bar</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('queen Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('queen')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        `,
                    
                      king: `
                        <div class="col-lg-4 col-md-6 my-3">
                          <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="../assets/media/room_catalogue/room/9.jpg" class="card-img-top" alt="King Bed Room">
                            <div class="card-body">
                              <h5>King Bed Room</h5>
                              <h6 class="mb-4">$130 per night</h6>
                              <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge bg-light text-dark">1 King Bed</span>
                                <span class="badge bg-light text-dark">Fireplace</span>
                              </div>
                              <div class="facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                <span class="badge bg-light text-dark">Smart TV</span>
                                <span class="badge bg-light text-dark">Sound System</span>
                              </div>
                              <div class="d-flex justify-content-evenly mb-2">
                                <a href="#" class="btn btn-primary" onclick="openBookingPopup('King Room')">Book Now</a>
                                <a href="#" class="btn btn-outline-primary" onclick="openRoomDetails('king')">More details</a>
                              </div>
                            </div>
                          </div>
                        </div>`
            };
          
            document.getElementById("occupancySelect").addEventListener("change", function () {
              const selected = this.value;
              const roomCards = document.getElementById("roomCards");
              roomCards.innerHTML = roomTemplates[selected] || "";
            });
          </script>


            <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel" aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="roomDetailsModalLabel">Room Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <script>
                        const roomDetails = {
                              solo: `
                                <h5>Solo Room</h5>
                                <p><strong>Price:</strong> $80 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 Room</li>
                                  <li>1 Bathroom</li>
                                  <li>1 Sofa</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>WiFi</li>
                                  <li>Room Heater</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              couple: `
                                <h5>Couple Suite</h5>
                                <p><strong>Price:</strong> $150 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 Large Bed</li>
                                  <li>1 Bathroom</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>WiFi</li>
                                  <li>Television</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              small_family: `
                                <h5>Family Room</h5>
                                <p><strong>Price:</strong> $180 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>2 Bedrooms</li>
                                  <li>2 Bathrooms</li>
                                  <li>1 Living Room</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>Wi-Fi</li>
                                  <li>TV</li>
                                  <li>Mini Kitchen</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              large_family: `
                                <h5>Large Family Suite</h5>
                                <p><strong>Price:</strong> $250 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>3 Bedrooms</li>
                                  <li>3 Bathrooms</li>
                                  <li>Dining + Living Room</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>Kitchen</li>
                                  <li>TV</li>
                                  <li>AC</li>
                                  <li>Room Heater</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                </div>
                              `,
                              single: `
                                <h5>Single Bed Room</h5>
                                <p><strong>Price:</strong> $60 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 Single Bed</li>
                                  <li>Free Wifi</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>TV</li>
                                  <li>Room Heater</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              double: `
                                <h5>Double Bed Room</h5>
                                <p><strong>Price:</strong> $90 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 Double Bed</li>
                                  <li>Balcony</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>AC</li>
                                  <li>Mini Fridge</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              queen: `
                                <h5>Queen Bed Room</h5>
                                <p><strong>Price:</strong> $110 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 Queen Bed</li>
                                  <li>Sea View</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>Jacuzzi</li>
                                  <li>Mini Bar</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                  <i class="bi bi-star text-warning"></i>
                                </div>
                              `,
                              king: `
                                <h5>King Bed Room</h5>
                                <p><strong>Price:</strong> $130 per night</p>
                                <h6>Features</h6>
                                <ul>
                                  <li>1 King Bed</li>
                                  <li>Fireplace</li>
                                </ul>
                                <h6>Facilities</h6>
                                <ul>
                                  <li>Smart TV</li>
                                  <li>Sound System</li>
                                </ul>
                                <p><strong>Rating:</strong></p>
                                <div class="rating">
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                  <i class="bi bi-star-fill text-warning"></i>
                                </div>
                              `,
                            };

                      </script>
                      <div id="roomDetailsContent">
                         <script>
                            function openRoomDetails(roomType) {
                              const roomContent = roomDetails[roomType];
                              const roomDetailsContent = document.getElementById('roomDetailsContent');
                              roomDetailsContent.innerHTML = roomContent;
                              const myModal = new bootstrap.Modal(document.getElementById('roomDetailsModal'));
                              myModal.show();
                            }
                         </script>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="openBookingPopup()">Book Now</button>
                    </div>
                  </div>
                </div>
              </div>


            <div class="container my-5">
              <div class="row align-items-center g-4">
                <!-- 📍 Left: Descriptive Text Section -->
                <div class="col-lg-7 col-md-12">
                  <div class="p-4 rounded-4 bg-white shadow-lg">
                    <h4 class="fw-bold text-primary mb-3">Discover the Beauty of Nuwara Eliya</h4>
                    <p class="text-muted">Wake up to the crisp mountain air, misty landscapes, and the soothing aroma of fresh Ceylon tea as you escape to the breathtaking 
                      beauty of Nuwara Eliya, the "Little England" of Sri Lanka. Nestled amidst rolling tea plantations and serene lakes, Secret Berry 
                      Resort offers a perfect blend of luxury, comfort, and nature’s tranquility.</p>
            
                    <p class="text-muted">Indulge in cozy fire-lit evenings, scenic hikes through lush green hills, 
                      and boat rides on the tranquil Gregory Lake. Enjoy a warm cup of world-famous 
                      Nuwara Eliya tea as you unwind in our elegant suites, designed for absolute relaxation. 
                      Whether you're exploring the Horton Plains, taking in the vibrant blooms of Hakgala Gardens, 
                      or enjoying a horseback ride through town, every moment here is a journey into timeless beauty.</p>
            
                    <p class="text-muted">Our exclusive seasonal offers let you experience this highland paradise like never before! Book 
                      your stay now and immerse yourself in the charm, elegance, and refreshing climate of Nuwara Eliya. 
                      Your mountain escape awaits! ⛰️🍃</p>
                  </div>
                </div>
            
                <!-- 💎 Right: Special Offer Card -->
                <div class="col-lg-1 col-md-12">
                  <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
                    <div class="card-body text-center">
                      <h5 class="card-title text-danger fw-bold mb-3">🎁 Get Special Offers!</h5>
                      <div class="bg-warning-subtle text-dark rounded-3 py-2 px-3 mb-3 animate__animated animate__pulse">
                        <strong>Earn 180 BerryPoints</strong> with this booking!
                      </div>
                      <p class="text-muted mb-1">💼 <b>Luxury Suite Special</b></p>
                      <p class="text-success fw-medium mb-3">10% OFF | Free Breakfast | Jacuzzi Access</p>
                      <button id="seeMoreButton" class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#offerModal">
                        See More Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            


                <!-- 💥 Offer Popup Modal -->
                <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true" data-bs-backdrop="false">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0 rounded-4">
                      <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title" id="offerModalLabel">🎁 Luxury Suite Offer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        <h4 class="text-success">✨ Earn 180 BerryPoints!</h4>
                        <p>Book our <strong>Luxury Suite</strong> now and enjoy:</p>
                        <ul class="list-unstyled">
                          <li>🌟 10% OFF your stay</li>
                          <li>🧁 Complimentary breakfast for 2</li>
                          <li>🍓 Strawberry welcome basket</li>
                          <li>🔥 Jacuzzi & fireplace access</li>
                        </ul>
                        <p class="text-muted"><strong>Offer valid until:</strong> <span class="text-danger">June 15, 2025</span></p>
                        <button class="btn btn-primary" onclick="openOfferPopup(); bootstrap.Modal.getInstance(document.getElementById('offerModal')).hide();">
                          Book Now & Claim Offer
                        </button>                          
                      </div>
                    </div>
                  </div>
                </div>

                <div id="formPopup">
                  <div class="side-popup-content">
                    <span class="close-btn" onclick="closePopup()">&times;</span>
                    <h3>Book Luxury Suite</h3>
                    <p><strong>Original Price:</strong> $200</p>
                    <p><strong>Discount:</strong> 10%</p>
                    <p><strong>New Price:</strong> <span style="color: green; font-weight: bold;">$180</span></p>
                    <div class="alert alert-success p-2 rounded-3">
                      <strong>🎁 Special Offer Applied!</strong><br>
                      ✔️ 10% Discount<br>
                      ✔️ Earn 180 BerryPoints<br>
                      ✔️ Free Breakfast<br>
                      ✔️ Jacuzzi & Fireplace Access
                    </div>
                
                    <form id="bookingForm" method="POST" action="book_room_conn.php">
                      <input type="hidden" name="room_type" value="Luxury Suite Room">
                      <label for="name">Full Name</label>
                      <input type="text" id="name" name="name" required placeholder="Enter your name">
                      
                      <label for="email">Email Address</label>
                      <input type="email" id="email" name="email" required placeholder="Enter your email">

                      <label for="phone">Phone Number</label>
                      <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                      
                      <label for="checkin">Check-in Date</label>
                      <input type="date" id="checkin" name="checkin" required>
                      
                      <label for="checkout">Check-out Date</label>
                      <input type="date" id="checkout" name="checkout" required>

                      <div class="row g-2 mt-3">
                        <div class="col-md-6">
                          <label for="adultCount" class="form-label">Adults</label>
                          <input type="number" class="form-control" id="adultCount" min="0" value="0" required>
                        </div>
                        <div class="col-md-6">
                          <label for="childrenCount" class="form-label">Children</label>
                          <input type="number" class="form-control" id="childrenCount" min="0" value="0" required>
                        </div>
                      </div>

                      <hr class="my-3">
                        <h6 class="text-primary">💳 Payment Details
                        <hr class="my-3">
                          <h6 class="text-primary">💰 Booking Summary</h6>
                          <p><strong>Price per night:</strong> $<span id="pricePerNight">180</span></p>
                            <div class="mb-3">
                              <label for="totalPrice" class="form-label">Total Price</label>
                              <input type="text" class="form-control" id="totalPrice" value="$180" readonly>
                            </div>
                                                          
                        <div class="mb-3">
                          <label for="cardNumber" class="form-label">Card Number</label>
                          <input type="text" class="form-control" id="cardNumber" placeholder="XXXX XXXX XXXX XXXX" required>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="password" class="form-control" id="cvv" placeholder="123" required>
                          </div>
                        </div>
                        
                        <div class="mb-3">
                          <label for="cardHolder" class="form-label">Card Holder Name</label>
                          <input type="text" class="form-control" id="cardHolder" required>
                        </div>

                      <label for="requests">Special Requests</label>
                      <textarea id="requests" name="requests" placeholder="Any special instructions..."></textarea><br>
                      
                      <button type="submit" class="btn btn-success">Submit Booking</button>
                    </form>
                  </div>
                </div>



                <div class="alert alert-info">
                  <strong>First-Time Guests Special! 🎁</strong> We love meeting new guests! Enjoy a special offer just for you when you visit for the first time.
                  <br>
                  <div class="offer-section">
                    <span class="badge bg-danger">10% OFF</span>
                    <p class="text-muted mb-1">Limited time offer - Book before <strong>June 15</strong>!</p>
                    <div id="countdown" style="font-weight: bold; color: #79020e; font-size: 50px;padding-left: 100px;"></div>
                </div>
              </div>

              <script>
                window.onload = function () {
                  const endDate = new Date("2025-06-15T23:59:59").getTime();
                  const countdownEl = document.getElementById("countdown");
                
                  const x = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = endDate - now;
                
                    if (distance < 0) {
                      countdownEl.innerHTML = "Offer expired";
                      clearInterval(x);
                      return;
                    }
                
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                    countdownEl.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
                  }, 1000);
                };
                </script>
                
                
                

              
                    
                <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Normal Standard Rooms</h2>

                <div class="room-container-base">
                    <div class="room-sub-container">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/1.jpeg" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/2.jpg" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/3.jpg" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/4.jpg" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/5.jpg" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="new-card border-0 shadow" style="max-width: 350px; margin: auto;">
                                    <img src="../assets/media/room_catalogue/room/6.webp" class="card-img-top" alt="room image 1">
                                    <div class="card-body">
                                        <h5>Simple Room </h5>
                                        <h6 class="mb-4">$100 per night</h6>
                                        <div class="features mb-4">
                                            <h6 class="mb-1">Features</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                2 Rooms
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Bathroom
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                1 Balcony
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                3 sofa
                                            </span>
                                        </div>
                                        <div class="facilities mb-4">
                                            <h6 class="mb-1">Facilities</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Wifi
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Television
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                AC
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                Room heater
                                            </span>
                                        </div>
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            <a href="#" class="btn btn-primary" onclick="openBookingPopup('simple room')">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 text-center mb-5">
                                <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>

<script src="../assets/js/room_catalogue.js"></script>

<?php include('../includes/footer.php'); ?>
