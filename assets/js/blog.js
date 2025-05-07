 // Like button functionality
 document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function () {
        let countSpan = this.querySelector('.like-count');
        let count = parseInt(countSpan.innerText);
        countSpan.innerText = count + 1;
    });
});