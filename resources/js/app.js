import '../css/app.css';

document.addEventListener('alpine:init', () => {
    window.addEventListener('cookie-consent-accepted', () => {
        localStorage.setItem('cookie_consent', 'accepted');
        document.getElementById('cookie-consent')?.remove();
    });

    window.addEventListener('cookie-consent-declined', () => {
        localStorage.setItem('cookie_consent', 'declined');
        document.getElementById('cookie-consent')?.remove();
    });
});
