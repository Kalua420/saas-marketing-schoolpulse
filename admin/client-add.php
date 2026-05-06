<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$page_title = 'Add Client - SchoolPulse Admin';

// Handle form submission
if ($_POST) {
    $errors = [];

    // Required fields that exist in the live schema
    $required = ['school_name', 'plan'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }

    // Validate email if provided
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }

    // Check duplicate email
    if (!empty($_POST['email'])) {
        $chk = $pdo->prepare("SELECT id FROM clients WHERE email = ?");
        $chk->execute([$_POST['email']]);
        if ($chk->fetch()) {
            $errors[] = 'A client with this email already exists';
        }
    }

    if (empty($errors)) {
        try {
            $school_name  = sanitizeInput($_POST['school_name']);
            $contact_name = sanitizeInput($_POST['contact_name'] ?? '');
            $email        = sanitizeInput($_POST['email'] ?? '');
            $phone        = sanitizeInput($_POST['phone'] ?? '');
            $city         = sanitizeInput($_POST['city'] ?? '');
            $state        = sanitizeInput($_POST['state'] ?? '');
            $plan         = sanitizeInput($_POST['plan']);
            $status       = sanitizeInput($_POST['status'] ?? 'trial');
            $onboarded_at = !empty($_POST['onboarded_at']) ? sanitizeInput($_POST['onboarded_at']) : null;
            $renewal_date = !empty($_POST['renewal_date']) ? sanitizeInput($_POST['renewal_date']) : null;
            $logo_url     = sanitizeInput($_POST['logo_url'] ?? '');
            $notes        = sanitizeInput($_POST['notes'] ?? '');

            $stmt = $pdo->prepare("
                INSERT INTO clients
                    (school_name, contact_name, email, phone, city, state,
                     plan, status, onboarded_at, renewal_date, logo_url, notes,
                     created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

            if ($stmt->execute([
                $school_name, $contact_name, $email, $phone, $city, $state,
                $plan, $status, $onboarded_at, $renewal_date,
                $logo_url ?: null, $notes
            ])) {
                $success_message = "Client added successfully!";
                header("refresh:2;url=clients.php");
            } else {
                $error_message = "Failed to add client. Please try again.";
            }
        } catch (Exception $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}

$page_header = 'Add New Client';

require_once 'includes/executive-header.php';
?>
    <div class="admin-header">
        <div class="header-left">
            <a href="clients.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Clients
            </a>
            <h1>Add New Client</h1>
        </div>
    </div>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            <p><small>Redirecting to clients list...</small></p>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="client-form">
        <div class="form-sections">

            <!-- School Information -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="fas fa-school"></i> School Information</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="school_name">School Name *</label>
                            <input type="text" id="school_name" name="school_name"
                                   value="<?php echo htmlspecialchars($_POST['school_name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="logo_url">Logo URL</label>
                            <input type="url" id="logo_url" name="logo_url"
                                   value="<?php echo htmlspecialchars($_POST['logo_url'] ?? ''); ?>"
                                   placeholder="https://example.com/logo.png">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city"
                                   value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state"
                                   value="<?php echo htmlspecialchars($_POST['state'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="fas fa-user"></i> Contact Information</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_name">Contact Name</label>
                            <input type="text" id="contact_name" name="contact_name"
                                   value="<?php echo htmlspecialchars($_POST['contact_name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Details -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="fas fa-credit-card"></i> Subscription Details</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="plan">Plan *</label>
                            <select id="plan" name="plan" required>
                                <option value="">Select Plan</option>
                                <option value="starter"    <?php echo ($_POST['plan'] ?? '') === 'starter'    ? 'selected' : ''; ?>>Starter</option>
                                <option value="growth"     <?php echo ($_POST['plan'] ?? '') === 'growth'     ? 'selected' : ''; ?>>Growth</option>
                                <option value="enterprise" <?php echo ($_POST['plan'] ?? '') === 'enterprise' ? 'selected' : ''; ?>>Enterprise</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="trial"    <?php echo ($_POST['status'] ?? 'trial') === 'trial'    ? 'selected' : ''; ?>>Trial</option>
                                <option value="active"   <?php echo ($_POST['status'] ?? '') === 'active'   ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($_POST['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                <option value="churned"  <?php echo ($_POST['status'] ?? '') === 'churned'  ? 'selected' : ''; ?>>Churned</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="onboarded_at">Onboarded Date</label>
                            <input type="date" id="onboarded_at" name="onboarded_at"
                                   value="<?php echo htmlspecialchars($_POST['onboarded_at'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="renewal_date">Renewal Date</label>
                            <input type="date" id="renewal_date" name="renewal_date"
                                   value="<?php echo htmlspecialchars($_POST['renewal_date'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-section">
                <div class="section-header">
                    <h2><i class="fas fa-sticky-note"></i> Notes</h2>
                </div>
                <div class="section-content">
                    <div class="form-group">
                        <label for="notes">Internal Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  placeholder="Add any internal notes about this client..."><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Add Client
            </button>
            <a href="clients.php" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>

<style>
.client-form { max-width: 900px; }

.form-sections { display: flex; flex-direction: column; gap: 2rem; }

.form-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.section-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.section-header h2 { margin: 0; font-size: 1.25rem; color: var(--navy-color); }
.section-header i  { margin-right: 0.5rem; color: var(--primary-color); }

.section-content { padding: 2rem; }

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-row:last-child { margin-bottom: 0; }

.form-group { display: flex; flex-direction: column; }

.form-group label {
    font-weight: 600;
    color: var(--navy-color);
    margin-bottom: 0.5rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245,158,11,0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
    .form-actions { flex-direction: column; }
}
</style>

<?php require_once 'includes/executive-footer.php'; ?>
