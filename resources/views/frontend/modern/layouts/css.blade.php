<style>
/* Custom Styles */
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
    --success-color: #198754;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --info-color: #0dcaf0;
}

/* Top Bar */
.top-bar {
    font-size: 0.875rem;
}

.top-bar a {
    transition: color 0.3s ease;
}

.top-bar a:hover {
    color: var(--warning-color) !important;
}

/* Navigation */
.navbar-brand {
    font-size: 1.5rem;
}

.nav-link {
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: var(--primary-color) !important;
}

/* Hero Section */
.hero-section {
    position: relative;
}

.carousel-item img {
    height: 65vh;
    object-fit: cover;
}

.carousel-caption {
    background: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    padding: 2rem;
    bottom: 3rem;
}

.carousel-caption h1 {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

.carousel-caption p {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
}


.sidebar-box {
    height: 65vh;

}

.sidebar-box .card-body {
    height: 60vh;
    overflow-x: hidden !important;
    overflow-y: auto !important;
}

/* Notice Ticker */
.notice-ticker {
    height: 45px;
    overflow: hidden;
    display: flex;
    align-items: center;
    background: linear-gradient(45deg, var(--warning-color), var(--warning-color));
    border-bottom: 3px solid var(--danger-color);
}

.ticker-label {
    flex-shrink: 0;
}

.ticker-content {
    display: inline-block;
    white-space: nowrap;
    animation: marquee 20s linear infinite;
    padding-left: 50px;
    /* space after label */
    font-weight: 500;
}

.ticker-content span {
    margin-right: 2rem;
    /* spacing between items */
}

@keyframes marquee {
    0% {
        transform: translateX(20%);
    }

    100% {
        transform: translateX(-100%);
    }
}


/* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--primary-color);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -1.75rem;
    top: 0.5rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--primary-color);
}

/* Section Styling */
.section-block {
    margin-bottom: 3rem;
    padding: 2rem 0;
}

.section-header {
    margin-bottom: 2rem;
    text-align: center;
}

.section-title {
    position: relative;
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 1rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--primary-color);
    border-radius: 2px;
}

/* Statistics Section */
.stat-card {
    padding: 2rem 1rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    background: var(--light-color);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.stat-icon i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.counter {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0.5rem 0;
}

.stat-label {
    font-weight: 500;
    color: var(--secondary-color);
    margin: 0;
}

/* Teacher Cards */
/* Teacher Cards - Enhanced */
.teacher-card {
    padding: 1.5rem;
    background: linear-gradient(145deg, #ffffff, #f9f9f9);
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.teacher-card img {
    border: 3px solid #f1f1f1;
    transition: border-color 0.3s ease;
}

.teacher-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.teacher-card:hover img {
    border-color: var(--primary-color);
    /* Bootstrap primary color */
}


.grid-gallery {
    display: grid;
    grid-template-columns: 2fr 1fr;
    /* Left bigger */
    grid-template-rows: repeat(2, 200px);
    /* Two rows */
    gap: 1rem;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    cursor: pointer;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-overlay i {
    color: white;
    font-size: 2rem;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

/* Make tall image span 2 rows */
.gallery-item.tall {
    grid-row: span 2;
}

/* Responsive */
@media (max-width: 768px) {
    .grid-gallery {
        grid-template-columns: 1fr;
        grid-template-rows: auto;
    }

    .gallery-item.tall {
        grid-row: auto;
    }
}


/* Cards */
.card {
    border: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.card-header {
    font-weight: 600;
}


/* List Groups */
.list-group-item {
    border: none;
    transition: background-color 0.3s ease, padding-left 0.3s ease;
}

.list-group-item:hover {
    background-color: rgba(0, 123, 255, 0.1);
    padding-left: 1.5rem;
}

/* Sidebar */
.sidebar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Accordion */
.accordion-button {
    font-weight: 500;
}

.accordion-button:not(.collapsed) {
    background-color: rgba(13, 110, 253, 0.1);
    color: var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .carousel-item img {
        height: 300px;
    }

    .carousel-caption {
        bottom: 1rem;
        padding: 1rem;
    }

    .carousel-caption h1 {
        font-size: 1.5rem;
    }

    .ticker-content {
        font-size: 0.875rem;
    }

    .section-block {
        padding: 1rem 0;
    }

    .stat-card {
        margin-bottom: 1rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease;
}

/* Custom Button Styles */
.btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Custom Modal */
.modal-content {
    border: none;
    border-radius: 10px;
}

#lightboxImage {
    border-radius: 10px;
}

footer h5, footer h6 {
    font-weight: 600;
    color: #fff;
}

footer p, footer a {
    font-size: 14px;
}

footer a {
    text-decoration: none;
    transition: color 0.3s ease;
}

footer a:hover {
    color: #fff !important;
}

footer .social-links a {
    color: #fff;
    transition: transform 0.3s ease, color 0.3s ease;
}

footer .social-links a:hover {
    transform: translateY(-3px);
    color: #0d6efd;
}

</style>