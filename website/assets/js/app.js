document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.site-nav');
    const loader = document.querySelector('.loading-screen');
    const themeToggle = document.getElementById('themeToggle');
    const backToTop = document.getElementById('backToTop');

    setTimeout(() => loader?.classList.add('is-hidden'), 350);

    const savedTheme = localStorage.getItem('fitpro-theme');
    if(savedTheme === 'dark'){
        document.body.classList.add('dark-mode');
    }

    themeToggle?.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('fitpro-theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        const icon = themeToggle.querySelector('i');
        if(icon){
            icon.className = document.body.classList.contains('dark-mode') ? 'fa fa-sun' : 'fa fa-moon';
        }
    });

    const onScroll = () => {
        nav?.classList.toggle('scrolled', window.scrollY > 40);
        backToTop?.classList.toggle('show', window.scrollY > 500);
    };

    window.addEventListener('scroll', onScroll);
    onScroll();

    backToTop?.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if(entry.isIntersecting){
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {threshold:.12});

    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if(!entry.isIntersecting){
                return;
            }

            const el = entry.target;
            const target = Number(el.dataset.count || 0);
            const duration = 1100;
            const start = performance.now();

            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                el.textContent = Math.floor(target * progress).toLocaleString();
                if(progress < 1){
                    requestAnimationFrame(tick);
                }
            };

            requestAnimationFrame(tick);
            counterObserver.unobserve(el);
        });
    }, {threshold:.45});

    document.querySelectorAll('[data-count]').forEach((el) => counterObserver.observe(el));

    document.querySelectorAll('[data-filter]').forEach((button) => {
        button.addEventListener('click', () => {
            const group = button.closest('[data-filter-group]') || document;
            const filter = button.dataset.filter;
            group.querySelectorAll('[data-filter]').forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll('[data-category]').forEach((item) => {
                item.style.display = filter === 'all' || item.dataset.category === filter ? '' : 'none';
            });
        });
    });

    const classSearch = document.getElementById('classSearch');
    const classLevel = document.getElementById('classLevel');
    const filterClasses = () => {
        const search = (classSearch?.value || '').toLowerCase();
        const level = classLevel?.value || 'all';
        document.querySelectorAll('[data-class-card]').forEach((card) => {
            const matchesSearch = card.textContent.toLowerCase().includes(search);
            const matchesLevel = level === 'all' || card.dataset.level === level;
            card.style.display = matchesSearch && matchesLevel ? '' : 'none';
        });
    };

    classSearch?.addEventListener('input', filterClasses);
    classLevel?.addEventListener('change', filterClasses);

    const bmiForm = document.getElementById('bmiForm');
    bmiForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        const weight = Number(document.getElementById('bmiWeight')?.value || 0);
        const heightCm = Number(document.getElementById('bmiHeight')?.value || 0);
        const result = document.getElementById('bmiResult');
        if(!weight || !heightCm || !result){
            return;
        }

        const bmi = weight / Math.pow(heightCm / 100, 2);
        let label = 'Healthy range';
        if(bmi < 18.5){
            label = 'Below healthy range';
        }else if(bmi >= 25 && bmi < 30){
            label = 'Above healthy range';
        }else if(bmi >= 30){
            label = 'High range';
        }

        result.innerHTML = `<strong>${bmi.toFixed(1)}</strong><span>${label}</span>`;
    });

    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = '<button type="button" aria-label="Close gallery"><i class="fa fa-xmark"></i></button><img alt="FitPro gallery preview">';
    document.body.appendChild(lightbox);

    const lightboxImg = lightbox.querySelector('img');
    lightbox.querySelector('button')?.addEventListener('click', () => lightbox.classList.remove('show'));
    lightbox.addEventListener('click', (event) => {
        if(event.target === lightbox){
            lightbox.classList.remove('show');
        }
    });

    document.querySelectorAll('[data-lightbox]').forEach((item) => {
        item.addEventListener('click', () => {
            if(lightboxImg){
                lightboxImg.src = item.dataset.lightbox;
            }
            lightbox.classList.add('show');
        });
    });
});
