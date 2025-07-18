<?php
include 'includes/header.php';

// Get gallery and slider images from database
try {
    require_once 'admin/includes/database.php';

    $db = new GalleryDB();
    $sliderDb = new SliderDB();

    // Get active gallery images
    $galleryImages = $db->getActive();

    // Get active slider images for hero section
    $sliderImages = $sliderDb->getActive();

    // For compatibility, create featured images (first 6 items)
    $featuredImages = array_slice($galleryImages, 0, 6);

    // Group images by category (for now, all in one category)
    $imagesByCategory = ['ambulances' => $galleryImages];

    $hasCustomGallery = !empty($galleryImages);
    $hasSliderImages = !empty($sliderImages);
    $totalImages = count($galleryImages);

} catch (Exception $e) {
    // Fallback to empty arrays if database fails
    $galleryImages = [];
    $sliderImages = [];
    $featuredImages = [];
    $imagesByCategory = [];
    $hasCustomGallery = false;
    $hasSliderImages = false;
    $totalImages = 0;

    // Log error for debugging
    error_log("Gallery database error: " . $e->getMessage());
}

// Add structured data for better SEO
$galleryStructuredData = [
    "@context" => "https://schema.org",
    "@type" => "ImageGallery",
    "name" => "Friends Ambulance Service Gallery",
    "description" => "Gallery showcasing our ambulance fleet, medical equipment, professional team, and facilities",
    "url" => SITE_URL . "/gallery",
    "publisher" => [
        "@type" => "Organization",
        "name" => SITE_NAME,
        "url" => SITE_URL
    ],
    "about" => [
        "@type" => "MedicalBusiness",
        "name" => SITE_NAME,
        "description" => "Professional ambulance and medical transportation services"
    ]
];
?>

<!-- Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($galleryStructuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- Hero Slider Styles -->
<style>
.hero-slider .carousel-item {
    transition: transform 1s ease-in-out;
}

.hero-slider .carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.hero-slider .carousel-fade .carousel-item.active {
    opacity: 1;
}

.hero-bg {
    transition: transform 8s ease-out;
}

.hero-slider .carousel-item.active .hero-bg {
    transform: scale(1.05);
}

.stat-highlight {
    background: rgba(255,255,255,0.1);
    padding: 15px 20px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    text-align: center;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
    opacity: 0.8;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 1;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
}
</style>

<!-- Main Content -->
<main id="main-content" role="main">

<?php if ($hasSliderImages): ?>
<!-- Dynamic Hero Slider -->
<section class="hero-slider position-relative" role="banner" aria-labelledby="gallery-main-heading">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <?php foreach ($sliderImages as $index => $slide): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $index; ?>"
                        <?php echo $index === 0 ? 'class="active" aria-current="true"' : ''; ?>
                        aria-label="Slide <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($sliderImages as $index => $slide): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="hero-slide position-relative" style="height: 70vh; min-height: 500px;">
                        <!-- Background Image -->
                        <div class="hero-bg position-absolute w-100 h-100"
                             style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo htmlspecialchars($slide['image']); ?>') center/cover no-repeat;">
                        </div>

                        <!-- Content Overlay -->
                        <div class="hero-content position-absolute top-50 start-50 translate-middle text-center text-white w-100">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <?php if ($index === 0): ?>
                                            <div class="header-badge mb-3">
                                                <span class="badge bg-primary fs-6 px-3 py-2">
                                                    <i class="fas fa-images me-2"></i>GALLERY
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <h1 id="gallery-main-heading" class="display-4 fw-bold mb-3">
                                            <?php echo htmlspecialchars($slide['title']); ?>
                                        </h1>

                                        <?php if ($slide['subtitle']): ?>
                                            <p class="lead mb-4">
                                                <?php echo htmlspecialchars($slide['subtitle']); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($slide['button_text'] && $slide['button_link']): ?>
                                            <a href="<?php echo htmlspecialchars($slide['button_link']); ?>"
                                               class="btn btn-primary btn-lg me-3">
                                                <?php echo htmlspecialchars($slide['button_text']); ?>
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($index === 0): ?>
                                            <div class="header-stats mt-4">
                                                <div class="row g-3 justify-content-center">
                                                    <div class="col-auto">
                                                        <div class="stat-highlight text-white">
                                                            <span class="fw-bold fs-4"><?php echo $totalImages; ?>+</span>
                                                            <span>Images</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat-highlight text-white">
                                                            <span class="fw-bold fs-4">HD</span>
                                                            <span>Quality</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat-highlight text-white">
                                                            <span class="fw-bold fs-4"><?php echo count($sliderImages); ?></span>
                                                            <span>Slides</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<?php else: ?>
<!-- Fallback Static Header -->
<section class="premium-gallery-header bg-gradient-warning text-dark py-5 position-relative overflow-hidden"
         role="banner"
         aria-labelledby="gallery-main-heading">
    <div class="gallery-background-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="header-content">
                    <div class="header-badge mb-3">
                        <span class="badge bg-dark fs-6 px-3 py-2" role="status">
                            <i class="fas fa-images me-2" aria-hidden="true"></i>GALLERY
                        </span>
                    </div>
                    <h1 id="gallery-main-heading" class="display-5 fw-bold mb-3">
                        Our Ambulance Fleet & Facilities
                    </h1>
                    <p class="lead">Take a look at our modern ambulances, advanced equipment, and professional team</p>
                    <div class="header-stats mt-4">
                        <div class="row g-3">
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4"><?php echo $totalImages; ?>+</span>
                                    <span class="text-dark">Images</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-highlight">
                                    <span class="fw-bold fs-4">HD</span>
                                    <span class="text-dark">Quality</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <div class="header-visual">
                    <div class="gallery-icon-showcase" role="img" aria-label="Gallery showcase">
                        <i class="fas fa-images display-1" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Gallery Search -->
<section class="gallery-search-section py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-3">
                    <h2 class="h5 fw-bold text-primary mb-2">Search Gallery</h2>
                    <p class="text-muted small">Find images by title or description</p>
                </div>
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           id="gallerySearch"
                           placeholder="Search images by title, description..."
                           aria-label="Search gallery images">
                    <button class="btn btn-outline-primary" type="button" id="searchButton">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Gallery Grid -->
<section class="premium-gallery-grid py-5 bg-white"
         role="region"
         aria-labelledby="gallery-grid-heading">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 id="gallery-grid-heading" class="fw-bold text-primary display-6">Our Visual Gallery</h2>
            <p class="lead text-muted">Explore our comprehensive collection of ambulances, equipment, and facilities</p>
        </div>
        <div class="row g-4" id="galleryContainer" role="grid" aria-label="Image gallery">
            <?php if ($hasCustomGallery): ?>
                <!-- Dynamic Gallery Images from Database -->
                <?php $imageIndex = 0; foreach ($galleryImages as $image): $imageIndex++; ?>
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="<?php echo ($imageIndex % 6) * 100; ?>"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="image-<?php echo $imageIndex; ?>">
                        <div class="gallery-image-container">
                            <div class="gallery-image" style="height: 280px; overflow: hidden;">
                                <?php
                                $imageSrc = $image['image'];
                                $imageExists = file_exists($imageSrc);
                                ?>

                                <?php if ($imageExists): ?>
                                    <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                                         alt="<?php echo htmlspecialchars($image['name']); ?>"
                                         class="w-100 h-100"
                                         style="object-fit: cover;"
                                         loading="lazy"
                                         onerror="this.src='assets/images/placeholder-gallery.jpg'">
                                <?php else: ?>
                                    <!-- Fallback placeholder -->
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <i class="fas fa-image text-muted fs-1 mb-2"></i>
                                            <p class="text-muted small">Image not found</p>
                                            <small class="text-muted"><?php echo htmlspecialchars($imageSrc); ?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <button class="btn btn-light btn-sm image-zoom"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-image="<?php echo htmlspecialchars($imageSrc); ?>"
                                                data-title="<?php echo htmlspecialchars($image['name']); ?>"
                                                data-description="<?php echo htmlspecialchars($image['name']); ?>"
                                                aria-label="View larger image">
                                            <i class="fas fa-expand" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3 d-none">
                            <h6 id="image-<?php echo $imageIndex; ?>" class="fw-bold text-primary mb-2">
                                <?php echo htmlspecialchars($image['name']); ?>
                            </h6>
                            <div class="gallery-meta mt-2">
                                <span class="badge bg-primary text-white">
                                    <i class="fas fa-image me-1"></i>
                                    Gallery
                                </span>
                                <span class="badge bg-success text-white ms-1">
                                    <i class="fas fa-check me-1"></i>Active
                                </span>
                            </div>
                            <div class="gallery-date mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo date('M j, Y', strtotime($image['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Enhanced Default Gallery Items -->
                <!-- Ambulance Images -->
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="100"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="bls-ambulance">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-ambulance text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">BLS Ambulance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Oxygen Support</span>
                                        <span class="feature-badge">First Aid Kit</span>
                                        <span class="feature-badge">Trained Paramedic</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="bls-ambulance" class="fw-bold text-primary mb-2">Basic Life Support Ambulance</h6>
                            <p class="text-muted small mb-2">Equipped with essential medical equipment for stable patient transport and basic emergency care</p>
                            <div class="gallery-meta">
                                <span class="badge bg-primary">Ambulances</span>
                                <span class="badge bg-success">24x7 Available</span>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="500"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="maintenance-facility">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-tools text-dark" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Maintenance</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">Well-equipped</span>
                                        <span class="feature-badge">Regular Service</span>
                                        <span class="feature-badge">Quality Care</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="maintenance-facility" class="fw-bold text-warning mb-2">Maintenance Facility</h6>
                            <p class="text-muted small mb-2">Well-equipped maintenance facility for ambulance upkeep and regular servicing</p>
                            <div class="gallery-meta">
                                <span class="badge bg-dark">Facilities</span>
                                <span class="badge bg-warning text-dark">Maintenance</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 gallery-item"
                     data-aos="fade-up"
                     data-aos-delay="600"
                     role="gridcell">
                    <div class="premium-gallery-card h-100"
                         role="article"
                         aria-labelledby="control-room">
                        <div class="gallery-image-container">
                            <div class="gallery-image bg-gradient-light d-flex align-items-center justify-content-center" style="height: 280px;">
                                <div class="text-center icon-showcase">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-phone text-white" style="font-size: 3rem;" aria-hidden="true"></i>
                                    </div>
                                    <p class="mt-3 text-muted fw-semibold">Control Room</p>
                                </div>
                            </div>
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <div class="service-features">
                                        <span class="feature-badge">24x7 Active</span>
                                        <span class="feature-badge">Quick Dispatch</span>
                                        <span class="feature-badge">GPS Tracking</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-info p-3">
                            <h6 id="control-room" class="fw-bold text-danger mb-2">24x7 Control Room</h6>
                            <p class="text-muted small mb-2">Round-the-clock control room for emergency dispatch and ambulance coordination</p>
                            <div class="gallery-meta">
                                <span class="badge bg-dark">Facilities</span>
                                <span class="badge bg-danger">Emergency</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
            <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn" style="display: none;">
                <i class="fas fa-plus me-2" aria-hidden="true"></i>Load More Images
            </button>
        </div>
    </div>
</section>

<!-- Enhanced Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="image-container">
                            <img src="" alt="" class="w-100" id="modalImage" style="max-height: 70vh; object-fit: contain;">
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

</main>

<!-- Gallery JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Search Functionality
    const galleryItems = document.querySelectorAll('.gallery-item');
    const galleryContainer = document.getElementById('galleryContainer');
    const searchInput = document.getElementById('gallerySearch');
    const searchButton = document.getElementById('searchButton');
    const clearSearchButton = document.getElementById('clearSearch');

    let isSearchMode = false;

    // Search functionality
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        clearSearchButton.addEventListener('click', clearSearch);
    }

    function performSearch() {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            alert('Please enter at least 2 characters to search');
            return;
        }

        isSearchMode = true;
        searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        clearSearchButton.style.display = 'inline-block';

        // Simple client-side search for now
        const searchResults = [];
        galleryItems.forEach(item => {
            const title = item.querySelector('h6').textContent.toLowerCase();
            const description = item.querySelector('p') ? item.querySelector('p').textContent.toLowerCase() : '';

            if (title.includes(query.toLowerCase()) || description.includes(query.toLowerCase())) {
                searchResults.push(item);
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.5s ease-in-out';
            } else {
                item.style.display = 'none';
            }
        });

        searchButton.innerHTML = '<i class="fas fa-search"></i>';

        // Show results count
        const resultsCount = searchResults.length;
        showSearchResults(resultsCount, query);
    }

    function clearSearch() {
        isSearchMode = false;
        searchInput.value = '';
        clearSearchButton.style.display = 'none';

        // Show all gallery items
        galleryItems.forEach(item => {
            item.style.display = 'block';
            item.style.animation = 'fadeIn 0.5s ease-in-out';
        });

        // Hide search results message
        const searchMessage = document.getElementById('searchResultsMessage');
        if (searchMessage) {
            searchMessage.remove();
        }
    }

    function showSearchResults(count, query) {
        // Remove existing message
        const existingMessage = document.getElementById('searchResultsMessage');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create new message
        const message = document.createElement('div');
        message.id = 'searchResultsMessage';
        message.className = 'alert alert-info text-center mt-3';
        message.innerHTML = `
            <i class="fas fa-search me-2"></i>
            Found <strong>${count}</strong> result${count !== 1 ? 's' : ''} for "<strong>${query}</strong>"
            <button type="button" class="btn-close ms-2" onclick="document.getElementById('clearSearch').click()"></button>
        `;

        galleryContainer.parentNode.insertBefore(message, galleryContainer);
    }

    // Enhanced Image Modal Functionality
    const imageZoomButtons = document.querySelectorAll('.image-zoom');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');
    const modalImageTitle = document.getElementById('modalImageTitle');
    const modalDescriptionText = document.getElementById('modalDescriptionText');
    const modalCategoryBadge = document.getElementById('modalCategoryBadge');
    const modalImageDescription = document.getElementById('modalImageDescription');

    let currentImageSrc = '';

    imageZoomButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            const imageTitle = this.getAttribute('data-title');
            const imageDescription = this.getAttribute('data-description');
            const categoryElement = this.closest('.gallery-item').querySelector('.gallery-meta .badge');

            currentImageSrc = imageSrc;

            // Update modal content
            modalImage.src = imageSrc;
            modalImage.alt = imageTitle;
            modalTitle.textContent = imageTitle;
            modalImageTitle.textContent = imageTitle;

            // Update description
            if (imageDescription && imageDescription.trim() !== '') {
                modalDescriptionText.textContent = imageDescription;
                modalImageDescription.style.display = 'block';
            } else {
                modalImageDescription.style.display = 'none';
            }

            // Update category badge
            if (categoryElement) {
                modalCategoryBadge.innerHTML = categoryElement.outerHTML;
            }
        });
    });

    // Download image function
    window.downloadImage = function() {
        if (currentImageSrc) {
            const link = document.createElement('a');
            link.href = currentImageSrc;
            link.download = currentImageSrc.split('/').pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    };

    // Share image function
    window.shareImage = function() {
        if (navigator.share && currentImageSrc) {
            navigator.share({
                title: modalImageTitle.textContent,
                text: modalDescriptionText.textContent,
                url: window.location.origin + '/' + currentImageSrc
            }).catch(console.error);
        } else {
            // Fallback: copy to clipboard
            const url = window.location.origin + '/' + currentImageSrc;
            navigator.clipboard.writeText(url).then(() => {
                alert('Image URL copied to clipboard!');
            }).catch(() => {
                alert('Image URL: ' + url);
            });
        }
    };

    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;

        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        updateCounter();
    };

    // Intersection Observer for counters
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
});

// CSS Animation Keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

<?php include 'includes/footer.php'; ?>
