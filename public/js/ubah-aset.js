document.addEventListener('DOMContentLoaded', () => {
    const statusWrapper = document.querySelector('#statusWrapper');
    const lockMessage = document.querySelector('#msg-lock');

    if (statusWrapper && lockMessage) {
        statusWrapper.addEventListener('click', () => {
            lockMessage.style.display = 'block';
            lockMessage.style.transform = 'translateX(5px)';
            setTimeout(() => lockMessage.style.transform = 'translateX(-5px)', 50);
            setTimeout(() => lockMessage.style.transform = 'translateX(0)', 100);
            setTimeout(() => {
                lockMessage.style.display = 'none';
            }, 3000);
        });
    }
});
