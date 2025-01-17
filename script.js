document.addEventListener('DOMContentLoaded', () => {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = {
        'index.php': 'nav-home',
        'nelayan.php': 'nav-nelayan',
        'tangkapan.php': 'nav-tangkapan',
        'penjualan.php': 'nav-penjualan',
        'laporan.php': 'nav-laporan'
        
    };
    

    if (navLinks[currentPage]) {
        document.getElementById(navLinks[currentPage]).classList.add('active');
    }

    // Example of dynamic content update
    const welcomeMessage = document.querySelector('h2');
    const currentHour = new Date().getHours();
    if (currentHour < 12) {
        welcomeMessage.textContent = "Selamat Pagi di Sistem Koperasi";
    } else if (currentHour < 18) {
        welcomeMessage.textContent = "Selamat Siang di Sistem Koperasi";
    } else {
        welcomeMessage.textContent = "Selamat Malam di Sistem Koperasi";
    }
});