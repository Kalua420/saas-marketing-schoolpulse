<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$lead_id = (int)($_GET['id'] ?? 0);

if (!$lead_id) {
    header('Location: leads.php');
    exit;
}

// Get lead details — live columns: id, school_name, contact_person, email, phone,
// city, designation, student_count, message, status, notes, created_at, updated_at
$stmt = $pdo->prepare("SELECT * FROM demo_requests WHERE id = ?");
$stmt->execute([$lead_id]);
$lead = $stmt->fetch();

if (!$lead) {
    header('Location: leads.php');
    exit;
}

$page_title = 'Lead Details - ' . $lead['school_name'] . ' - SchoolPulse Admin';
$page_header = 'Lead Details';

// Handle status + notes update
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $status = sanitizeInput($_POST['status']);
    $notes  = sanitizeInput($_POST['notes'] ?? '');

    $stmt = $pdo->prepare("UPDATE demo_requests SET status = ?, notes = ?, updated_at = NOW() WHERE id = ?");
    if ($stmt->execute([$status, $notes, $lead_id])) {
        $success_message = "Lead updated successfully!";
        // Refresh
        $stmt = $pdo->prepare("SELECT * FROM demo_requests WHERE id = ?");
        $stmt->execute([$lead_id]);
        $lead = $stmt->fetch();
    } else {
        $error_message = "Failed to update lead.";
    }
}

require_once 'includes/executive-header.php';
?>
    <div class="admin-header">
        <div class="header-left">
            <a href="leads.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
            <h1><?php echo htmlspecialchars($lead['school_name']); ?></h1>
        </div>
        <div class="admin-actions">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="lead-detail-grid">
        <!-- School / Contact Information -->
        <div class="detail-card">
            <div class="card-header">
                <h2><i class="fas fa-school"></i> School Information</h2>
                <?php echo getStatusBadge($lead['status']); ?>
            </div>
            <div class="card-content">
                <div class="info-grid">
                    <div class="info-item">
                        <label>School Name</label>
                        <value><?php echo htmlspecialchars($lead['school_name']); ?></value>
                    </div>
                    <div class="info-item">
                        <label>City</label>
                        <value><?php echo htmlspecialchars($lead['city'] ?: '—'); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Student Count</label>
                        <value><?php echo htmlspecialchars($lead['student_count'] ?: '—'); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Submitted</label>
                        <value><?php echo date('M j, Y g:i A', strtotime($lead['created_at'])); ?></value>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Person -->
        <div class="detail-card">
            <div class="card-header">
                <h2><i class="fas fa-user"></i> Contact Person</h2>
            </div>
            <div class="card-content">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Name</label>
                        <value><?php echo htmlspecialchars($lead['contact_person']); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Designation</label>
                        <value><?php echo htmlspecialchars($lead['designation'] ?: '—'); ?></value>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <value>
                            <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>">
                                <?php echo htmlspecialchars($lead['email']); ?>
                            </a>
                        </value>
                    </div>
                    <div class="info-item">
                        <label>Phone</label>
                        <value>
                            <?php if ($lead['phone']): ?>
                                <a href="tel:<?php echo htmlspecialchars($lead['phone']); ?>">
                                    <?php echo htmlspecialchars($lead['phone']); ?>
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </value>
                    </div>
                </div>

                <div class="contact-actions">
                    <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                    <?php if ($lead['phone']): ?>
                        <a href="tel:<?php echo htmlspecialchars($lead['phone']); ?>" class="btn btn-secondary">
                            <i class="fas fa-phone"></i> Call
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Message -->
        <?php if ($lead['message']): ?>
        <div class="detail-card full-width">
            <div class="card-header">
                <h2><i class="fas fa-comment"></i> Message</h2>
            </div>
            <div class="card-content">
                <div class="message-content">
                    <?php echo nl2br(htmlspecialchars($lead['message'])); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Status & Notes -->
        <div class="detail-card">
            <div class="card-header">
                <h2><i class="fas fa-edit"></i> Update Status &amp; Notes</h2>
            </div>
            <div class="card-content">
                <form method="POST" class="status-form">
                    <input type="hidden" name="action" value="update_status">

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="new"            <?php echo $lead['status'] === 'new'            ? 'selected' : ''; ?>>New</option>
                            <option value="contacted"      <?php echo $lead['status'] === 'contacted'      ? 'selected' : ''; ?>>Contacted</option>
                            <option value="demo_scheduled" <?php echo $lead['status'] === 'demo_scheduled' ? 'selected' : ''; ?>>Demo Scheduled</option>
                            <option value="converted"      <?php echo $lead['status'] === 'converted'      ? 'selected' : ''; ?>>Converted</option>
                            <option value="rejected"       <?php echo $lead['status'] === 'rejected'       ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Internal Notes</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Add your notes about this lead..."><?php echo htmlspecialchars($lead['notes'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Lead
                    </button>
                </form>
            </div>
        </div>

        <!-- Timeline -->
        <div class="detail-card">
            <div class="card-header">
                <h2><i class="fas fa-history"></i> Timeline</h2>
            </div>
            <div class="card-content">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-blue"></div>
                        <div class="timeline-content">
                            <h4>Lead Submitted</h4>
                            <p>Demo request submitted through website</p>
                            <time><?php echo date('M j, Y g:i A', strtotime($lead['created_at'])); ?></time>
                        </div>
                    </div>

                    <?php if ($lead['updated_at'] && $lead['updated_at'] !== $lead['created_at']): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-orange"></div>
                            <div class="timeline-content">
                                <h4>Status Updated</h4>
                                <p>Lead status: <?php echo getStatusBadge($lead['status']); ?></p>
                                <time><?php echo date('M j, Y g:i A', strtotime($lead['updated_at'])); ?></time>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<style>
.lead-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.detail-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.detail-card.full-width {
    grid-column: 1 / -1;
}

.card-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h2 {
    margin: 0;
    font-size: 1.25rem;
    color: var(--navy-color);
}

.card-header i { margin-right: 0.5rem; color: var(--primary-color); }

.card-content { padding: 1.5rem; }

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.info-item { display: flex; flex-direction: column; }

.info-item label {
    font-weight: 600;
    color: #666;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.info-item value { color: var(--navy-color); font-weight: 500; }

.contact-actions { margin-top: 1.5rem; display: flex; gap: 1rem; }

.message-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
    line-height: 1.6;
}

.form-group { margin-bottom: 1.25rem; display: flex; flex-direction: column; }

.form-group label {
    font-weight: 600;
    color: var(--navy-color);
    margin-bottom: 0.5rem;
}

.form-group select,
.form-group textarea {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
}

.timeline { position: relative; }

.timeline:before {
    content: '';
    position: absolute;
    left: 20px; top: 0; bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 60px;
    margin-bottom: 2rem;
}

.timeline-marker {
    position: absolute;
    left: 12px; top: 0;
    width: 16px; height: 16px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-marker.bg-blue   { background: #007bff; }
.timeline-marker.bg-orange { background: #fd7e14; }
.timeline-marker.bg-green  { background: #28a745; }

.timeline-content h4 { margin: 0 0 0.5rem; color: var(--navy-color); }
.timeline-content p  { margin: 0 0 0.5rem; color: #666; }
.timeline-content time { font-size: 0.875rem; color: #999; }

@media (max-width: 768px) {
    .lead-detail-grid { grid-template-columns: 1fr; }
    .info-grid { grid-template-columns: 1fr; }
    .contact-actions { flex-direction: column; }
}
</style>

<?php require_once 'includes/executive-footer.php'; ?>
