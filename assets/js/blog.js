document.querySelectorAll('.like-btn').forEach(button => {
    const countSpan = button.querySelector('.like-count');
    const blogId = button.getAttribute('data-id');

    button.addEventListener('click', function () {
        fetch('blog.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=like_blog&blog_id=${blogId}`
        })
        .then(response => response.text())
        .then(updatedCount => {
            countSpan.innerText = updatedCount;
        })
        .catch(error => {
            console.error("Like failed:", error);
        });
    });
});
