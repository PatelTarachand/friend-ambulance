<?php
// Contact Form Submissions Management
require_once 'includes/database.php';

// Handle actions
if ($_POST) {
    $contactDB = new ContactFormDB();
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'mark_read':
                if (isset($_POST['id'])) {
                    $contactDB->markAsRead($_POST['id']);
                    $success_message = "Submission marked as read.";
                }
                break;
                
            case 'mark_replied':
                if (isset($_POST['id'])) {
                    $contactDB->markAsReplied($_POST['id']);
                    $success_message = "Submission marked as replied.";
                }
                break;
                
            case 'archive':
                if (isset($_POST['id'])) {
                    $contactDB->archiveSubmission($_POST['id']);
                    $success_message = "Submission archived.";
                }
                break;
                
            case 'delete':
                if (isset($_POST['id'])) {
                    $contactDB->deleteSubmission($_POST['id']);
                    $success_message = "Submission deleted.";
                }
                break;
        }
    }
}

// Get filter and pagination parameters
$status_filter = $_GET['status'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Initialize database and get data
$contactDB = new ContactFormDB();
$submissions = $contactDB->getAllSubmissions($status_filter ?: null, $per_page, $offset);
$stats = $contactDB->getSubmissionStats();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-12">
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Total Submissions</div>
                            <div class="h3 mb-0 fw-bold"><?php echo $stats['total']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon warning me-3">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">New Messages</div>
                            <div class="h3 mb-0 fw-bold"><?php echo $stats['new_count']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3">
                            <i class="fas fa-reply"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Replied</div>
                            <div class="h3 mb-0 fw-bold"><?php echo $stats['replied_count']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon danger me-3">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Today</div>
                            <div class="h3 mb-0 fw-bold"><?php echo $stats['today_count']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters and Actions -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-inbox me-2"></i>Contact Form Submissions
                    </h5>
                    <div class="d-flex gap-2">
                        <!-- Status Filter -->
                        <select class="form-select form-select-sm" onchange="filterByStatus(this.value)">
                            <option value="">All Status</option>
                            <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                            <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                            <option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                            <option value="archived" <?php echo $status_filter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                
                <?php if (empty($submissions)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No submissions found</h5>
                        <p class="text-muted">
                            <?php if ($status_filter): ?>
                                No submissions with status "<?php echo ucfirst($status_filter); ?>" found.
                            <?php else: ?>
                                No contact form submissions yet.
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submissions as $submission): ?>
                                    <tr class="<?php echo $submission['status'] === 'new' ? 'table-warning' : ''; ?>">
                                        <td>
                                            <small class="text-muted">
                                                <?php echo date('M j, Y', strtotime($submission['submitted_at'])); ?><br>
                                                <?php echo date('g:i A', strtotime($submission['submitted_at'])); ?>
                                            </small>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($submission['name']); ?></strong>
                                            <?php if ($submission['phone']): ?>
                                                <br><small class="text-muted">
                                                    <i class="fas fa-phone fa-xs"></i> 
                                                    <?php echo htmlspecialchars($submission['phone']); ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>" 
                                               class="text-decoration-none">
                                                <?php echo htmlspecialchars($submission['email']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($submission['subject']): ?>
                                                <span class="badge bg-info">
                                                    <?php echo htmlspecialchars($submission['subject']); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">No subject</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $submission['status'] === 'new' ? 'warning' : 
                                                    ($submission['status'] === 'read' ? 'info' : 
                                                    ($submission['status'] === 'replied' ? 'success' : 'secondary')); 
                                            ?>">
                                                <?php echo ucfirst($submission['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary btn-sm" 
                                                        onclick="viewSubmission(<?php echo $submission['id']; ?>)"
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <?php if ($submission['status'] === 'new'): ?>
                                                    <form method="post" class="d-inline">
                                                        <input type="hidden" name="action" value="mark_read">
                                                        <input type="hidden" name="id" value="<?php echo $submission['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-info btn-sm" title="Mark as Read">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <?php if ($submission['status'] !== 'replied'): ?>
                                                    <form method="post" class="d-inline">
                                                        <input type="hidden" name="action" value="mark_replied">
                                                        <input type="hidden" name="id" value="<?php echo $submission['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-success btn-sm" title="Mark as Replied">
                                                            <i class="fas fa-reply"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $submission['id']; ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this submission?')"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Submission Details Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submission Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="submissionDetails">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const url = new URL(window.location);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}

function viewSubmission(id) {
    fetch(`get-submission.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('submissionDetails').innerHTML = data.html;
                new bootstrap.Modal(document.getElementById('submissionModal')).show();
            } else {
                alert('Error loading submission details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading submission details');
        });
}
</script>

<?php include 'includes/footer.php'; ?>
