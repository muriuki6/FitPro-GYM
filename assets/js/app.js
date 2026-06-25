/* ==========================================
   FITPRO GYM MANAGEMENT SYSTEM
   MAIN APPLICATION SCRIPT
========================================== */

/* Sidebar Toggle */

function toggleSidebar() {

    const sidebar = document.querySelector('.sidebar');

    if (!sidebar) return;

    sidebar.classList.toggle('sidebar-hidden');
}

/* Dark Mode Toggle */

const themeToggle =
document.getElementById('themeToggle');

if (themeToggle) {

    themeToggle.addEventListener('click', () => {

        document.body.classList.toggle('dark-mode');

        localStorage.setItem(
            'theme',
            document.body.classList.contains('dark-mode')
            ? 'dark'
            : 'light'
        );

    });

}

/* Restore Theme */

window.addEventListener('load', () => {

    const theme =
    localStorage.getItem('theme');

    if (theme === 'dark') {

        document.body.classList.add('dark-mode');

    }

});

/* Attendance - Mark Absent */

const absentBtn =
document.getElementById('absentBtn');

if (absentBtn) {

    absentBtn.addEventListener('click', function () {

        const member =
        document.getElementById('member_id').value;

        if (!member) {

            showToast(
                'Please select a member',
                'warning'
            );

            return;
        }

        fetch('../api/mark_absent.php', {

            method: 'POST',

            headers: {
                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body: 'member_id=' + member

        })

        .then(response => response.text())

        .then(data => {

            showToast(data, 'success');

            setTimeout(() => {

                location.reload();

            }, 1000);

        })

        .catch(error => {

            console.error(error);

            showToast(
                'Operation failed',
                'danger'
            );

        });

    });

}

/* Payment Search */

const searchBtn =
document.getElementById('searchBtn');

if (searchBtn) {

    searchBtn.addEventListener('click', searchTable);

}

const searchInput =
document.getElementById('searchPayment');

if (searchInput) {

    searchInput.addEventListener('keyup', function (e) {

        if (e.key === 'Enter') {

            searchTable();

        }

    });

}

function searchTable() {

    const input =
    document.getElementById('searchPayment');

    const table =
    document.getElementById('paymentTable');

    if (!input || !table) return;

    const filter =
    input.value.toLowerCase();

    const rows =
    table.querySelectorAll('tbody tr');

    rows.forEach(row => {

        row.style.display =
        row.innerText.toLowerCase()
        .includes(filter)
        ? ''
        : 'none';

    });

}

/* Animated Counters */

document.querySelectorAll('.counter')
.forEach(counter => {

    const target =
    parseInt(counter.innerText);

    let current = 0;

    const update = () => {

        const increment =
        target / 50;

        if (current < target) {

            current += increment;

            counter.innerText =
            Math.ceil(current);

            requestAnimationFrame(update);

        } else {

            counter.innerText = target;

        }

    };

    update();

});

/* Image Preview */

const imageInput =
document.getElementById('photo');

if (imageInput) {

    imageInput.addEventListener(
        'change',
        function () {

            const preview =
            document.getElementById('preview');

            if (
                this.files &&
                this.files[0] &&
                preview
            ) {

                preview.src =
                URL.createObjectURL(
                    this.files[0]
                );

            }

        }
    );

}

/* Toast Notification System */

function showToast(
message,
type = 'success'
) {

    const toast =
    document.createElement('div');

    toast.className =
    `alert alert-${type} position-fixed`;

    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '9999';

    toast.innerHTML = message;

    document.body.appendChild(toast);

    setTimeout(() => {

        toast.remove();

    }, 3000);

}

/* Real Time Clock */

const liveClock =
document.getElementById('liveClock');

if (liveClock) {

    setInterval(() => {

        const now =
        new Date();

        liveClock.innerHTML =
        now.toLocaleString();

    }, 1000);

}

/* Loading Buttons */

document.querySelectorAll(
'form'
).forEach(form => {

    form.addEventListener(
        'submit',
        function () {

            const btn =
            this.querySelector(
                'button[type="submit"]'
            );

            if (btn) {

                btn.disabled = true;

                btn.innerHTML =
                '<span class="spinner-border spinner-border-sm"></span> Processing...';

            }

        }
    );

});

console.log(
'FitPro Gym Management System Loaded Successfully'
);