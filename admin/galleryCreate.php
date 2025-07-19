<?php
// Gallery Create Form
include 'includes/header.php';
?>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-content-inner">

                    <!-- Page Header -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <h2>
                                <i class="fas fa-plus me-2 text-primary"></i>
                                Add New Gallery Image
                            </h2>
                            <p class="text-muted">Upload and add a new image to the gallery</p>
                        </div>
                        <div class="col-lg-4 text-end">
                            <a href="gallery.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Gallery
                            </a>
                        </div>
                    </div>

                    <!-- Create Form -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-image me-2"></i>Gallery Image Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="gallerySave.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">
                                                        <i class="fas fa-tag me-1"></i>Image Name *
                                                    </label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           placeholder="Enter descriptive name for the image" required>
                                                    <div class="form-text">
                                                        This will be used as the image title and alt text.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-toggle-on me-1"></i>Status
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                                                        <label class="form-check-label" for="status">
                                                            Active (Visible on website)
                                                        </label>
                                                    </div>
                                                    <div class="form-text">
                                                        Toggle to make the image visible or hidden on the website.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">
                                                        <i class="fas fa-upload me-1"></i>Select Image *
                                                    </label>
                                                    <input type="file" class="form-control" id="image" name="image"
                                                           accept="image/jpeg,image/jpg,image/png,image/gif" required>
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Supported formats: JPG, PNG, GIF | Max size: 5MB
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <input type="submit" class="btn btn-primary btn-lg me-3" value="Save Gallery Image" name="submit" />
                                                    
                                                    
                                                <a href="gallery.php" class="btn btn-secondary btn-lg">
                                                    <i class="fas fa-times me-2"></i>Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
