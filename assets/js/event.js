function showModal(title, content) {
    document.getElementById("modalTitle").innerText = title;
    document.getElementById("modalBody").innerHTML = content;
    document.getElementById("customModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("customModal").style.display = "none";
}

function showEventDetails(title, description, location, event_date, start_time, duration, event_type, price) {
    // Fallback values for undefined data
    title = title || "Not available";
    description = description || "Not available";
    location = location || "Not available";
    event_date = event_date || "Not available";
    start_time = start_time || "Not available";
    duration = duration || "Not available";
    event_type = event_type || "Not available";
    price = price || "Not available";
    
    // Create CSS styles
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        .event-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        
        .event-modal-content {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 500px;
            position: relative;
            padding: 25px;
            animation: scaleIn 0.3s ease;
        }
        
        .event-close-button {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #555;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
            padding: 0;
            width: 30px;
            height: 30px;
            text-align: center;
        }
        
        .event-close-button:hover {
            color: #000;
        }
        
        .event-title {
            margin: 0 0 10px 0;
            color: #222;
            font-size: 26px;
            font-weight: 600;
            line-height: 1.2;
        }
        
        .event-description {
            margin: 0 0 25px 0;
            color: #555;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .event-details-grid {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .event-detail-label {
            font-weight: 600;
            color: #444;
            font-size: 15px;
        }
        
        .event-detail-value {
            color: #333;
            font-size: 15px;
        }
        
        .event-price {
            font-weight: 600;
            color: #2c7be5;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    `;
    
    // Create modal container
    const modalContainer = document.createElement('div');
    modalContainer.className = 'event-modal-overlay';
    
    // Create the modal content
    const modalContent = document.createElement('div');
    modalContent.className = 'event-modal-content';
    
    // Create close button
    const closeButton = document.createElement('button');
    closeButton.className = 'event-close-button';
    closeButton.textContent = '×';
    closeButton.onclick = function() {
        document.body.removeChild(modalContainer);
        document.head.removeChild(styleElement);
    };
    
    // Create event title
    const titleElement = document.createElement('h2');
    titleElement.className = 'event-title';
    titleElement.textContent = title;
    
    // Create description
    const descElement = document.createElement('p');
    descElement.className = 'event-description';
    descElement.textContent = description;
    
    // Create details container
    const detailsContainer = document.createElement('div');
    detailsContainer.className = 'event-details-grid';
    
    // Helper function to add detail row
    function addDetailRow(label, value, isPrice = false) {
        const labelElement = document.createElement('div');
        labelElement.className = 'event-detail-label';
        labelElement.textContent = label + ':';
        
        const valueElement = document.createElement('div');
        valueElement.className = isPrice ? 'event-detail-value event-price' : 'event-detail-value';
        valueElement.textContent = value;
        
        detailsContainer.appendChild(labelElement);
        detailsContainer.appendChild(valueElement);
    }
    
    // Format price with dollar sign if it's a number
    const formattedPrice = price !== 'Not available' ? '$' + price : price;
    
    // Add all details
    addDetailRow('Location', location);
    addDetailRow('Date', event_date);
    addDetailRow('Start Time', start_time);
    addDetailRow('Duration', duration + ' Hours');
    addDetailRow('Type', event_type);
    addDetailRow('Price', formattedPrice, true);
    
    // Assemble modal
    modalContent.appendChild(closeButton);
    modalContent.appendChild(titleElement);
    modalContent.appendChild(descElement);
    modalContent.appendChild(detailsContainer);
    modalContainer.appendChild(modalContent);
    
    // Add style element to head
    document.head.appendChild(styleElement);
    
    // Add modal to body
    document.body.appendChild(modalContainer);
    
    // Add click event to close when clicking outside the modal
    modalContainer.addEventListener('click', function(event) {
        if (event.target === modalContainer) {
            document.body.removeChild(modalContainer);
            document.head.removeChild(styleElement);
        }
    });
}

// Example usage:
// showEventDetails("Tech Conference", "A big tech event for networking.", "New York", "2025-05-12", "10:00:00", "5", "Paid", "100.00");


function showRegisterForm(title) {
    // Add custom styles to make the form and modal smaller
    const smallerFormStyles = `
        <style>
            /* Make the modal container smaller */
            .modal-content {
                width: 35% !important;  /* Smaller width for the modal */
                padding: 15px !important;
            }
            
            /* Make the form smaller */
            #customModal .form {
                max-width: 350px !important;  /* Smaller max-width */
                padding: 1rem !important;  /* Smaller padding */
                gap: 1rem !important;  /* Smaller gap between elements */
            }
            
            /* Make form inputs smaller */
            #customModal .form .input {
                padding: 0.5rem !important;
                margin-bottom: 0.75rem !important;
                font-size: 0.9rem !important;
            }
            
            /* Make form buttons smaller */
            #customModal .form .login-button,
            #customModal .form .clear-button {
                padding: 0.5rem !important;
                font-size: 0.9rem !important;
            }
            
            /* Make event title container smaller */
            .event-title-container {
                padding: 10px !important;
                margin: 10px 0 !important;
            }
            
            /* Make event label smaller */
            .event-label {
                font-size: 12px !important;
                margin-bottom: 3px !important;
            }
            
            /* Make event name smaller */
            .event-name {
                font-size: 20px !important;
                margin: 3px 0 !important;
            }
        </style>
    `;

    showModal("Register for Event", 
        smallerFormStyles +
        `<form action="event.php" method="POST" class="form" id="registerForm">
            <!-- Keep the rest of your form code the same -->
            <input type="hidden" name="title" value="${title}" />
            
            <div id="eventTitle" class="event-title-container">
                <span class="event-label">EVENT:</span>
                <h2 class="event-name">${title}</h2>
            </div>

            <input required class="input" type="text" name="fullName" id="fullName" placeholder="Full Name" />
            <input required class="input" type="tel" name="phone" id="phone" placeholder="Phone Number" pattern="[0-9]{10}" title="Enter a 10-digit phone number" />
            <input required class="input" type="number" name="room" id="room" placeholder="Room Number" />
            <input required class="input" type="email" name="email" id="email" placeholder="E-mail" />
            <input required class="input" type="number" name="participants" id="participants" placeholder="Number of Participants" min="1" max="10" />
            <input class="login-button" type="submit" value="Register">
            <input class="clear-button" type="reset" value="Clear">
        </form>`);

    // The event listener part stays the same
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateForm()) {
            submitFormData();
        }
    });
}

function validateForm() {
    const fullName = document.getElementById('fullName').value;  // Assuming your full name field has the ID 'fullName'
    const phone = document.getElementById('phone').value;
    const room = document.getElementById('room').value;
    const email = document.getElementById('email').value;
    const participants = document.getElementById('participants').value;

    // Check if full name is valid (letters, spaces, hyphens, apostrophes only, and at least 2 characters)
    if (!/^[A-Za-z\s'-]+$/.test(fullName) || fullName.trim().length < 2) {
        alert("Please enter a valid full name (letters, spaces, hyphens, and apostrophes only).");
        return false;
    }

    // Check if phone number is exactly 10 digits and only numeric
    if (!/^\d{10}$/.test(phone)) {
        alert("Please enter a valid 10-digit phone number.");
        return false;
    }

    // Check if room number is provided
    if (room.trim() === "") {
        alert("Room number cannot be empty.");
        return false;
    }

   

    // Check if email is valid
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Check if participants are between 1 and 10
    if (participants < 1 || participants > 10) {
        alert("Number of participants must be between 1 and 10.");
        return false;
    }

    return true; // If all checks passed
}


function submitFormData() {
    // Create a FormData object to send form data to PHP
    const formData = new FormData(document.getElementById('registerForm'));

    // Create the AJAX request to submit the form
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'event.php', true); // PHP file that will process the form

    xhr.onload = function () {
        if (xhr.status === 200) {
            // If success, show success alert
            alert('✅ Registration Successful! Please check your email 🤗');
        } else {
            // If error, show error alert
            alert('Registration failed. Please try again.');
            console.error('Error response:', xhr.responseText);  // Log the error response
            return;
        }
    };

    xhr.onerror = function () {
        // Handle network errors
        alert('Network error, please try again later.');
        console.error('Network error');
    };

    xhr.send(formData); // Send the form data to the server
}

function setFilter(type) {
    let events = document.querySelectorAll('.event-item');
    
    events.forEach(event => {
        let eventType = event.getAttribute('data-type');
        
        if (type === "Free") {
            if (eventType === "free") {
                event.style.visibility = "visible";
                event.style.opacity = "1";
            } else {
                event.style.visibility = "hidden";
                event.style.opacity = "0";
            }
        } else if (type === "Paid") {
            if (eventType === "paid") {
                event.style.visibility = "visible";
                event.style.opacity = "1";
            } else {
                event.style.visibility = "hidden";
                event.style.opacity = "0";
            }
        } else {
            event.style.visibility = "visible";
            event.style.opacity = "1";
        }
    });
}






