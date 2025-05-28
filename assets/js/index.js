document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.querySelectorAll('.bg_btn');
    const slider = document.querySelectorAll('.slider_img');
    const banner = document.querySelectorAll('.banner_content');
    let currentIndex = 0;

    function sliderC(index) {
        menuBtn.forEach(btn => btn.classList.remove('active'));
        slider.forEach(img => img.classList.remove('active'));
        banner.forEach(content => content.classList.remove('active'));

        menuBtn[index].classList.add('active');
        slider[index].classList.add('active');
        banner[index].classList.add('active');
    }

    menuBtn.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            sliderC(index);
            currentIndex = index;
        });
    });

    // Auto-slide functionality
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slider.length;
        sliderC(currentIndex);
    }, 5000);
});

const ads = [
  {
    bg: 'url(assets/media/index/ads1.jpg)',
    html: `
      <div class="h-100 w-100 d-flex flex-column justify-content-center align-items-center text-white text-center px-4" style="background-color: rgba(0,0,0,0.55);">
        <div class="mb-3">
          <i class="bi bi-stars fs-1 text-warning"></i>
          <h2 class="mt-2">SBR Grand Gala Night</h2>
        </div>
        <p>🎉 Join us on <strong>June 15</strong> for a night of luxury, live music, and fine dining at the Oceanview Hall.</p>
        <p><i class="bi bi-clock"></i> <strong>7:00 PM</strong> &nbsp; | &nbsp; <i class="bi bi-geo-alt"></i> <strong>Oceanview Hall</strong></p>
        <a href="events.php" class="btn btn-outline-light mt-3 px-4">Reserve Your Seat</a>
      </div>
    `
  },
  {
    bg: 'url(assets/media/index/spa.avif)',
    html: `
      <div class="h-100 w-100 d-flex flex-column justify-content-center align-items-center text-white text-center px-4" style="background-color: rgba(0,0,0,0.55);">
        <div class="mb-3">
          <i class="bi bi-journal-richtext fs-1 text-info"></i>
          <h2 class="mt-2">New Blog: Spa Weekend Tips</h2>
        </div>
        <p>🧘‍♀️ Discover our latest wellness article on how to reset your body and mind with spa therapy at SBR Hotel.</p>
        <p><i class="bi bi-calendar3"></i> <strong>May 18</strong> &nbsp; | &nbsp; <i class="bi bi-tags"></i> <strong>Health & Wellness</strong></p>
        <a href="pages/blog.php#77" class="btn btn-outline-info mt-3 px-4">Read More</a>
      </div>
    `
  },
  {
    bg: 'url(assets/media/index/DE2.webp)',
    html: `
      <div class="h-100 w-100 d-flex flex-column justify-content-center align-items-center text-white text-center px-4" style="background-color: rgba(0,0,0,0.55);">
        <div class="mb-3">
          <i class="bi bi-truck-front-fill fs-1 text-warning"></i>
          <h2 class="mt-2">Free Airport Pickup</h2>
        </div>
        <p>🚐 Book any premium room and get a free luxury airport pickup — stress-free travel starts with SBR!</p>
        <p><i class="bi bi-clock-history"></i> <strong>24/7 Available</strong> &nbsp; | &nbsp; <i class="bi bi-check2-circle"></i> <strong>Booking Required</strong></p>
        <a href="services.php" class="btn btn-outline-warning mt-3 px-4">Learn More</a>
      </div>
    `
  },
  {
    bg: 'url(assets/media/index/sunSet.jpg)',
    html: `
      <div class="h-100 w-100 d-flex flex-column justify-content-center align-items-center text-white text-center px-4" style="background-color: rgba(0,0,0,0.55);">
        <div class="mb-3">
          <i class="bi bi-sunset-fill fs-1 text-success"></i>
          <h2 class="mt-2">Summer Sunset Package</h2>
        </div>
        <p>🌅 2-night stay, romantic candlelight dinner & sunset cruise — available for Deluxe & Executive rooms only.</p>
        <p><i class="bi bi-calendar-range"></i> <strong>Valid: June–August</strong></p>
        <a href="offers.php" class="btn btn-outline-success mt-3 px-4">Book Now</a>
      </div>
    `
  }
];

let currentAd = 0;

function showNextAd() {
  const adContent = document.getElementById("adContent");
  adContent.style.opacity = 0;

  setTimeout(() => {
    const ad = ads[currentAd];
    adContent.innerHTML = ad.html;
    adContent.style.backgroundImage = ad.bg;
    adContent.style.backgroundSize = "cover";
    adContent.style.backgroundPosition = "center";
    adContent.style.opacity = 1;

    currentAd = (currentAd + 1) % ads.length;
  }, 500);
}

setTimeout(() => {
  const adModal = new bootstrap.Modal(document.getElementById('adModal'));
  adModal.show();

  showNextAd();
  setInterval(showNextAd, 7000);
}, 5000); // 5 minutes