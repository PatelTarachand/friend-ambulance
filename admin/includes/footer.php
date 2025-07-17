                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggle?.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
        
        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (!alert.classList.contains('alert-permanent')) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
        
        // Confirm delete actions
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
        
        // Image preview functionality
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                    document.getElementById(previewId).style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        
                        field.addEventListener('input', function() {
                            this.classList.remove('is-invalid');
                        });
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
            });
        });
        
        // File upload validation
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (5MB limit)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Only JPEG, PNG, and GIF files are allowed');
                        this.value = '';
                        return;
                    }
                }
            });
        });
        
        // Sortable functionality for tables
        function initSortable() {
            const tables = document.querySelectorAll('.sortable-table');
            tables.forEach(table => {
                const tbody = table.querySelector('tbody');
                if (tbody) {
                    // Add drag handles
                    tbody.querySelectorAll('tr').forEach(row => {
                        const firstCell = row.querySelector('td');
                        if (firstCell) {
                            firstCell.innerHTML = '<i class="fas fa-grip-vertical text-muted me-2"></i>' + firstCell.innerHTML;
                            row.style.cursor = 'move';
                        }
                    });
                }
            });
        }
        
        // Initialize sortable on page load
        document.addEventListener('DOMContentLoaded', initSortable);
        
        // AJAX helper function
        function ajaxRequest(url, data, callback) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(callback)
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
        
        // Status toggle functionality
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const table = this.dataset.table;
                const status = this.checked ? 1 : 0;
                
                ajaxRequest('ajax/toggle-status.php', {
                    id: id,
                    table: table,
                    status: status
                }, function(response) {
                    if (!response.success) {
                        alert('Failed to update status');
                        toggle.checked = !toggle.checked;
                    }
                });
            });
        });
        
        // Auto-save functionality for forms
        document.querySelectorAll('.auto-save').forEach(form => {
            let timeout;
            form.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData
                    });
                }, 2000);
            });
        });
    </script>
</body>
</html>
