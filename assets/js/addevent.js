// Function to toggle price field visibility based on event type selection
function togglePriceField() {
    const eventType = document.getElementById('event_type');
    const priceGroup = document.getElementById('price-group');
    
    if (eventType && priceGroup) {
        if (eventType.value === 'Paid') {
            priceGroup.style.display = 'block';
            document.getElementById('price').setAttribute('required', 'required');
        } else {
            priceGroup.style.display = 'none';
            document.getElementById('price').removeAttribute('required');
            // Reset price value for free events
            if (eventType.value === 'Free') {
                document.getElementById('price').value = '0';
            }
        }
    }
}

// Confirmation before deleting an event
document.addEventListener('DOMContentLoaded', function() {
    // Run the toggle function on page load to ensure correct initial state
    togglePriceField();
    
    // Add event image validation
    const imageInput = document.getElementById('event_image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileSize = this.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 5) {
                    alert('File size exceeds 5MB. Please select a smaller image.');
                    this.value = '';
                }
            }
        });
    }
    
    // Confirmation for delete form
    const deleteForm = document.querySelector('form[action*="mode=delete"]');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const eventName = document.getElementById('event_name_to_delete').value;
            if (!confirm(`Are you sure you want to delete the event "${eventName}"? This action cannot be undone.`)) {
                e.preventDefault();
                return false;
            }
        });
    }
});