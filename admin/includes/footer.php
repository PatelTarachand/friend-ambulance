                    </div> <!-- End Content Container -->
                </div> <!-- End Main Content -->
            </div> <!-- End Main Content Column -->
        </div> <!-- End Row -->
    </div> <!-- End Container Fluid -->

    <?php
    // Include and render notifications
    if (file_exists('includes/notifications.php')) {
        require_once 'includes/notifications.php';
        echo renderAdminNotifications();
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"></script>
    
    <!-- Enhanced Admin JavaScript -->
    <script>
        // Modern Admin Panel Enhancements
        class AdminPanel {
            constructor() {
                this.init();
            }

            init() {
                this.setupAlerts();
                this.setupConfirmations();
                this.setupFormValidation();
                this.setupAnimations();
                this.setupTooltips();
                this.setupMobileMenu();
                this.setupLoadingStates();
            }

            // Enhanced alert system with animations
            setupAlerts() {
                document.addEventListener('DOMContentLoaded', () => {
                    const alerts = document.querySelectorAll('.alert-dismissible');
                    alerts.forEach((alert, index) => {
                        // Animate in
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-20px)';

                        setTimeout(() => {
                            alert.style.transition = 'all 0.3s ease';
                            alert.style.opacity = '1';
                            alert.style.transform = 'translateY(0)';
                        }, index * 100);

                        // Auto-dismiss with progress bar
                        this.createProgressBar(alert);

                        setTimeout(() => {
                            this.dismissAlert(alert);
                        }, 5000);
                    });
                });
            }

            createProgressBar(alert) {
                const progressBar = document.createElement('div');
                progressBar.style.cssText = `
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    height: 3px;
                    background: currentColor;
                    opacity: 0.3;
                    width: 100%;
                    animation: shrink 5s linear;
                `;

                const style = document.createElement('style');
                style.textContent = `
                    @keyframes shrink {
                        from { width: 100%; }
                        to { width: 0%; }
                    }
                `;
                document.head.appendChild(style);

                alert.style.position = 'relative';
                alert.appendChild(progressBar);
            }

            dismissAlert(alert) {
                alert.style.transition = 'all 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';

                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }

            // Enhanced confirmation dialogs
            setupConfirmations() {
                document.addEventListener('click', (e) => {
                    const element = e.target.closest('[data-confirm]');
                    if (element) {
                        e.preventDefault();
                        const message = element.getAttribute('data-confirm') || 'Are you sure?';
                        const title = element.getAttribute('data-title') || 'Confirm Action';

                        this.showConfirmModal(title, message, () => {
                            if (element.tagName === 'A') {
                                window.location.href = element.href;
                            } else if (element.tagName === 'BUTTON' || element.type === 'submit') {
                                element.closest('form')?.submit();
                            }
                        });
                    }
                });
            }

            showConfirmModal(title, message, callback) {
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                            <div class="modal-header" style="background: var(--primary-gradient); color: white; border: none;">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 30px;">
                                <p style="margin: 0; font-size: 1.1rem;">${message}</p>
                            </div>
                            <div class="modal-footer" style="border: none; padding: 20px 30px;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary confirm-btn">Confirm</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);
                const bsModal = new bootstrap.Modal(modal);

                modal.querySelector('.confirm-btn').addEventListener('click', () => {
                    callback();
                    bsModal.hide();
                });

                modal.addEventListener('hidden.bs.modal', () => {
                    document.body.removeChild(modal);
                });

                bsModal.show();
            }

            // Enhanced form validation
            setupFormValidation() {
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    if (form.hasAttribute('data-validate')) {
                        if (!this.validateForm(form)) {
                            e.preventDefault();
                        }
                    }
                });

                // Real-time validation
                document.addEventListener('blur', (e) => {
                    if (e.target.hasAttribute('required')) {
                        this.validateField(e.target);
                    }
                }, true);
            }

            validateForm(form) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!this.validateField(field)) {
                        isValid = false;
                    }
                });

                return isValid;
            }

            validateField(field) {
                const isValid = field.value.trim() !== '';

                field.classList.toggle('is-invalid', !isValid);
                field.classList.toggle('is-valid', isValid);

                // Add shake animation for invalid fields
                if (!isValid) {
                    field.style.animation = 'shake 0.5s';
                    setTimeout(() => field.style.animation = '', 500);
                }

                return isValid;
            }

            // Smooth animations and interactions
            setupAnimations() {
                // Add CSS for animations
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes shake {
                        0%, 100% { transform: translateX(0); }
                        25% { transform: translateX(-5px); }
                        75% { transform: translateX(5px); }
                    }

                    .fade-in {
                        animation: fadeIn 0.5s ease-in;
                    }

                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(20px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                `;
                document.head.appendChild(style);

                // Animate cards on scroll
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('fade-in');
                        }
                    });
                });

                document.querySelectorAll('.card, .stat-card').forEach(card => {
                    observer.observe(card);
                });
            }

            // Setup tooltips
            setupTooltips() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            }

            // Mobile menu toggle
            setupMobileMenu() {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'btn btn-primary d-md-none position-fixed';
                toggleBtn.style.cssText = 'top: 20px; left: 20px; z-index: 1001; border-radius: 50%; width: 50px; height: 50px;';
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';

                toggleBtn.addEventListener('click', () => {
                    document.querySelector('.sidebar').classList.toggle('show');
                });

                document.body.appendChild(toggleBtn);
            }

            // Loading states for buttons
            setupLoadingStates() {
                document.addEventListener('click', (e) => {
                    const btn = e.target.closest('button[type="submit"], .btn-loading');
                    if (btn && !btn.disabled) {
                        this.setLoadingState(btn);
                    }
                });
            }

            setLoadingState(btn) {
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="loading-spinner me-2"></span>Processing...';

                // Reset after 3 seconds (adjust as needed)
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }, 3000);
            }
        }

        // Initialize admin panel enhancements
        new AdminPanel();

        // Legacy functions for backward compatibility
        function validateForm(formId) {
            const form = document.getElementById(formId);
            return form ? new AdminPanel().validateForm(form) : true;
        }

        function enableAutoSave(formId, interval = 30000) {
            const form = document.getElementById(formId);
            if (!form) return;

            setInterval(() => {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                localStorage.setItem('draft_' + formId, JSON.stringify(data));
            }, interval);
        }

        function loadDraft(formId) {
            const draft = localStorage.getItem('draft_' + formId);
            if (!draft) return;

            const data = JSON.parse(draft);
            const form = document.getElementById(formId);
            if (!form) return;

            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field && field.type !== 'file') {
                    field.value = data[key];
                }
            });
        }

        function clearDraft(formId) {
            localStorage.removeItem('draft_' + formId);
        }
    </script>
</body>
</html>
