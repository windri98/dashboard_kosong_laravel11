// dropdown pada navbar
document.addEventListener('DOMContentLoaded', function() {
    const profile = document.querySelector('.profile');
    const dropdownContent = profile.querySelector('.dropdown-content-navbar');

    profile.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent event bubbling
        dropdownContent.classList.toggle('show');
    });

    document.addEventListener('click', function() {
        dropdownContent.classList.remove('show');
    });
});

//
document.addEventListener('DOMContentLoaded', function() {
// Toggle sidebar
const toggleSidebarBtn = document.querySelector('.toggle-sidebar');
const container = document.querySelector('.container');
const overlay = document.querySelector('.overlay');
const sidebar = document.querySelector('.sidebar');

if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        } else {
            container.classList.toggle('sidebar-collapsed');
        }
    });
}

if (overlay) {
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
}

// Fungsi untuk menutup semua dropdown kecuali yang sedang aktif
const closeAllDropdowns = (exceptDropdown = null) => {
    const allDropdowns = document.querySelectorAll('.dropdown');
    allDropdowns.forEach(dropdown => {
        if (dropdown !== exceptDropdown) {
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            const dropdownIcon = dropdown.querySelector('.dropdown-icon');

            dropdown.classList.remove('active');
            if (dropdownIcon) {
                dropdownIcon.classList.remove('rotate');
            }
            if (dropdownContent) {
                dropdownContent.style.maxHeight = null;
            }
        }
    });
};

// Fungsi dropdown menu di sidebar
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const dropdownHeader = dropdown.querySelector('.dropdown-header');
    const dropdownContent = dropdown.querySelector('.dropdown-content');
    const dropdownIcon = dropdown.querySelector('.dropdown-icon');

    if (dropdownHeader) {
        dropdownHeader.addEventListener('click', function(e) {
            e.stopPropagation(); // Hindari event bubbling

            // Jika dropdown ini sedang aktif, tutup saja
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
                if (dropdownIcon) {
                    dropdownIcon.classList.remove('rotate');
                }
                if (dropdownContent) {
                    dropdownContent.style.maxHeight = null;
                }
            } else {
                // Tutup semua dropdown lain dulu
                closeAllDropdowns(dropdown);

                // Buka dropdown ini
                dropdown.classList.add('active');
                if (dropdownIcon) {
                    dropdownIcon.classList.add('rotate');
                }
                if (dropdownContent) {
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                }
            }
        });
    }
});

// Handle klik pada menu item untuk mengaktifkan item yang diklik
const menuItems = document.querySelectorAll('.menu-item:not(.dropdown)');

menuItems.forEach(item => {
    item.addEventListener('click', function() {
        // Tutup semua dropdown
        closeAllDropdowns();

        // Hapus class active dari semua menu item
        menuItems.forEach(menuItem => {
            menuItem.classList.remove('active');
        });

        // Tambahkan class active ke item yang diklik
        this.classList.add('active');
    });
});

// Handle klik pada sub-menu item
const subMenuItems = document.querySelectorAll('.sub-menu-item');

subMenuItems.forEach(item => {
    item.addEventListener('click', function(e) {
        // Hindari event bubbling ke parent
        e.stopPropagation();

        // Tutup dropdown lainnya (tidak termasuk parent dari sub-menu ini)
        const parentDropdown = this.closest('.dropdown');

        // Hapus class active dari semua sub-menu item
        subMenuItems.forEach(subItem => {
            subItem.classList.remove('active');
        });

        // Tambahkan class active ke sub-menu yang diklik
        this.classList.add('active');
    });
});

// Tutup dropdown jika klik di luar sidebar
document.addEventListener('click', function(e) {
    if (!e.target.closest('.sidebar')) {
        closeAllDropdowns();
    }
});

// Handle notifikasi klik
const notificationBtn = document.querySelector('.notification');

if (notificationBtn) {
    notificationBtn.addEventListener('click', function() {
        alert('Notifikasi: Anda memiliki 3 pemberitahuan baru');
    });
}

// Setup Chart.js jika elemen canvas ada
if (document.getElementById('monthlyActivityChart')) {
    const activityChartCtx = document.getElementById('monthlyActivityChart').getContext('2d');
    const activityChart = new Chart(activityChartCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Aktivitas 2025',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 70, 75, 80],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Sembunyikan placeholder saat grafik dimuat
    document.querySelector('.chart-placeholder').style.display = 'none';
}

if (document.getElementById('userDistributionChart')) {
    const userChartCtx = document.getElementById('userDistributionChart').getContext('2d');
    const userChart = new Chart(userChartCtx, {
        type: 'pie',
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'],
            datasets: [{
                label: 'Distribusi Pengguna',
                data: [45, 40, 15],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Sembunyikan placeholder kedua saat grafik dimuat
    document.querySelectorAll('.chart-placeholder')[1].style.display = 'none';
}

// Responsive behavior
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
        container.classList.remove('sidebar-collapsed');
        if (sidebar.classList.contains('show')) {
            overlay.classList.add('show');
        }
    } else {
        overlay.classList.remove('show');
    }
});
});
