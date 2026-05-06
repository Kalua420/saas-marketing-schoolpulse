<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

require_login();

// ── Dashboard stats ──────────────────────────────────────────────
$stats = [];

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM demo_requests");
$stats['total_demos'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) AS new FROM demo_requests WHERE status = 'new'");
$stats['new_demos'] = $stmt->fetch()['new'];

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM clients");
$stats['total_clients'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) AS active FROM clients WHERE status = 'active'");
$stats['active_clients'] = $stmt->fetch()['active'];

// Active rate
$active_rate = $stats['total_clients'] > 0
    ? round(($stats['active_clients'] / $stats['total_clients']) * 100, 1)
    : 0;

// ── Recent demo requests ─────────────────────────────────────────
$stmt = $pdo->query("
    SELECT id, school_name, contact_person, email, student_count, status, created_at
    FROM demo_requests
    ORDER BY created_at DESC
    LIMIT 5
");
$recent_demos = $stmt->fetchAll();

// ── Recent contact submissions ───────────────────────────────────
$stmt = $pdo->query("
    SELECT first_name, last_name, email, school_name, message, status, submitted_at
    FROM contact_submissions
    ORDER BY submitted_at DESC
    LIMIT 3
");
$recent_contacts = $stmt->fetchAll();

// ── Badge helper ─────────────────────────────────────────────────
function status_badge_class(string $status): string {
    $map = [
        'new'            => 'bg-error-container/50 text-on-error-container',
        'pending'        => 'bg-error-container/50 text-on-error-container',
        'contacted'      => 'bg-surface-variant text-surface-tint',
        'demo_scheduled' => 'bg-surface-variant text-surface-tint',
        'converted'      => 'bg-emerald-100 text-emerald-800',
        'completed'      => 'bg-emerald-100 text-emerald-800',
        'rejected'       => 'bg-red-100 text-red-800',
        'unread'         => 'bg-error-container/50 text-on-error-container',
        'read'           => 'bg-surface-variant text-surface-tint',
        'replied'        => 'bg-emerald-100 text-emerald-800',
    ];
    return $map[$status] ?? 'bg-surface-variant text-surface-tint';
}

function status_label(string $status): string {
    $map = [
        'new'            => 'Urgent',
        'pending'        => 'Urgent',
        'contacted'      => 'Processing',
        'demo_scheduled' => 'Processing',
        'converted'      => 'Completed',
        'completed'      => 'Completed',
        'rejected'       => 'Rejected',
        'unread'         => 'Urgent',
        'read'           => 'Processing',
        'replied'        => 'Completed',
    ];
    return $map[$status] ?? ucfirst($status);
}

$page_title = 'SchoolPulse Admin - Executive Dashboard';
$page_header = 'Admin Dashboard';

require_once 'includes/executive-header.php';
?>

<!-- KPI Header -->
<section>
<h2 class="font-h2 text-h2 text-on-surface mb-md animate-fade-in">Executive Summary</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">

<!-- KPI Card 1 -->
<div class="stat-card animate-fade-in-up stagger-1 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Total Requests</span>
<div class="stat-icon bg-blue-50">
<span class="material-symbols-outlined text-blue-600">assignment</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($stats['total_demos']); ?></div>
<div class="text-sm text-gray-600">All time submissions</div>
</div>

<!-- KPI Card 2 -->
<div class="stat-card animate-fade-in-up stagger-2 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">New Requests</span>
<div class="stat-icon bg-purple-50">
<span class="material-symbols-outlined text-purple-600">event_available</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($stats['new_demos']); ?></div>
<div class="text-sm text-gray-600">Requires attention</div>
</div>

<!-- KPI Card 3 -->
<div class="stat-card animate-fade-in-up stagger-3 bg-white">
<div class="flex items-center justify-between">
<div>
<span class="stat-label block mb-4">Active Rate</span>
<div class="stat-value text-gray-900"><?php echo $active_rate; ?>%</div>
</div>
<div class="relative w-16 h-16">
<svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
<path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e0e7ff" stroke-dasharray="100, 100" stroke-width="3"></path>
<path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#4f46e5" stroke-dasharray="<?php echo $active_rate; ?>, 100" stroke-width="3" class="progress-fill"></path>
</svg>
</div>
</div>
</div>

<!-- KPI Card 4 -->
<div class="stat-card animate-fade-in-up stagger-4 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Total Clients</span>
<div class="stat-icon bg-green-50">
<span class="material-symbols-outlined text-green-600">groups</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($stats['total_clients']); ?></div>
<div class="text-sm text-gray-600"><?php echo number_format($stats['active_clients']); ?> active</div>
</div>

</div>
</section>

<!-- Main Grid Section -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">

<!-- Left Column (Wide) -->
<div class="lg:col-span-2 card-modern animate-scale-in bg-white">
<div class="flex justify-between items-center mb-6">
<h3 class="font-h3 text-h3 text-gray-900">Recent Demo Requests</h3>
<a href="leads.php" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">View All</a>
</div>
<div class="overflow-x-auto">
<table class="table-modern">
<thead>
<tr class="border-b-2 border-gray-200">
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">School Name</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Students</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
<th class="py-3 px-4"></th>
</tr>
</thead>
<tbody class="text-sm text-gray-700">
<?php if (empty($recent_demos)): ?>
<tr>
<td colspan="5" class="py-8 text-center text-gray-500">No demo requests yet</td>
</tr>
<?php else: ?>
<?php foreach ($recent_demos as $demo): ?>
<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
<td class="py-4 px-4 font-semibold text-gray-900"><?php echo htmlspecialchars($demo['school_name']); ?></td>
<td class="py-4 px-4 text-gray-700"><?php echo htmlspecialchars($demo['contact_person']); ?></td>
<td class="py-4 px-4 text-gray-700"><?php echo htmlspecialchars($demo['student_count'] ?? '—'); ?></td>
<td class="py-4 px-4">
<span class="badge-modern <?php echo status_badge_class($demo['status']); ?>">
<?php echo status_label($demo['status']); ?>
</span>
</td>
<td class="py-4 px-4 text-right">
<a href="lead-detail.php?id=<?php echo $demo['id']; ?>" class="btn-modern px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold inline-block hover:bg-blue-700">
Quick View
</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>
</div>

<!-- Right Column (Narrow) -->
<div class="card-modern animate-scale-in flex flex-col bg-white">
<h3 class="font-h3 text-h3 text-gray-900 mb-6">Recent Messages</h3>
<div class="flex-1 space-y-4">
<?php if (empty($recent_contacts)): ?>
<div class="empty-state">
<span class="material-symbols-outlined empty-state-icon text-gray-300">mail</span>
<p class="text-gray-500">No messages yet</p>
</div>
<?php else: ?>
<?php foreach ($recent_contacts as $contact): ?>
<div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all hover:shadow-md hover:scale-[1.02]">
<div class="flex items-start justify-between mb-2">
<span class="font-semibold text-gray-900"><?php echo htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']); ?></span>
<span class="text-xs text-gray-500"><?php echo date('M j', strtotime($contact['submitted_at'])); ?></span>
</div>
<p class="text-sm text-gray-600 line-clamp-2 mb-2">
<?php echo htmlspecialchars(mb_substr($contact['message'], 0, 80)); ?><?php echo mb_strlen($contact['message']) > 80 ? '...' : ''; ?>
</p>
<span class="badge-modern <?php echo status_badge_class($contact['status']); ?>">
<?php echo status_label($contact['status']); ?>
</span>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<a href="contacts.php" class="mt-4 text-center text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors btn-modern py-2 rounded-lg">
View All Messages
</a>
</div>

</section>

<?php require_once 'includes/executive-footer.php'; ?>
