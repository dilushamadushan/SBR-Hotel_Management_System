function openBookingPopup(roomName) {
    document.getElementById("roomNameDisplay").innerText = roomName;
    document.getElementById('bookingModal').style.display = "block"; 
    document.getElementById('bookingForm').reset();
}
function closeBookingPopup() {
    document.getElementById('bookingModal').style.display = "none"; 
    document.getElementById("bookingForm").reset();
    document.getElementById("bookingConfirmation").style.display = "none";
}

function openOfferPopup() {
    document.getElementById("formPopup").classList.add("active");
  }
  
//   document.getElementById("bookingForm").addEventListener("submit", function (e) {
//     e.preventDefault();
//     alert("🎉 Booking submitted successfully!");
//     document.getElementById("bookingForm").reset();
//     document.getElementById("formPopup").classList.remove("active");
//   });

  function closePopup() {
    document.getElementById('formPopup').style.display = "none"; 
    document.getElementById("bookingForm").reset();
    document.getElementById("formPopup").style.display = "none";
}

$(document).ready(function(){
    $("#searchBox").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".room-item").filter(function() {
            $(this).toggle($(this).attr("data-name").toLowerCase().includes(value) || 
                           $(this).attr("data-features").toLowerCase().includes(value));
        });
    });
});

function openBookingPopup(roomType) {
    document.getElementById("bookingModal").style.display = "block";
    document.getElementById("roomNameDisplay").innerText = roomType;
    document.querySelector("input[name='room_type']").value = roomType;
}

    

    










