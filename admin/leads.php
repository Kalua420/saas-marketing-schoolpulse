<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$page_title = 'Demo Requests — SchoolPulse Admin';
$page_header = 'Demo Requests';

// ── Status update ────────────────────────────────────────────────
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $lead_id = (int)$_POST['lead_id'];
    $status  = sanitizeInput($_POST['status']);
    $stmt    = $pdo->prepare("UPDATE demo_requests SET status = ?, updated_at = NOW() WHERE id = ?");
    if ($stmt->execute([$status, $lead_id])) {
        $success_message = "Lead status updated successfully.";
    } else {
        $error_message = "Failed to update lead status.";
    }
}

// ── Filters ──────────────────────────────────────────────────────
$status_filter = $_GET['status'] ?? '';
$date_filter   = $_GET['date']   ?? '';
$search        = $_GET['search'] ?? '';

$where = [];
$params = [];

if ($status_filter) {
    $where[]  = "status = ?";
    $params[] = $status_filter;
}

if ($date_filter) {
    match ($date_filter) {
        'today' => $where[] = "DATE(created_at) = CURDATE()",
        'week'  => $where[] = "created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)",
        'month' => $where[] = "created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)",
        default => null,
    };
}

if ($search) {
    $where[]  = "(school_name LIKE ? OR contact_person LIKE ? OR email LIKE ?)";
    $sp       = "%$search%";
    $params   = array_merge($params, [$sp, $sp, $sp]);
}

$where_clause = $where ? "WHERE " . implode(" AND ", $where) : "";

// ── Pagination ───────────────────────────────────────────────────
$page     = max(1, (int)($_GET['page'] ?? 1));
$per_page = 20;
$offset   = ($page - 1) * $per_page;

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM demo_requests $where_clause");
$count_stmt->execute($params);
$total_leads = (int)$count_stmt->fetchColumn();
$total_pages = max(1, (int)ceil($total_leads / $per_page));

$stmt = $pdo->prepare("SELECT * FROM demo_requests $where_clause ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$leads = $stmt->fetchAll();

// ── Status counts ────────────────────────────────────────────────
$status_counts = [];
foreach ($pdo->query("SELECT status, COUNT(*) AS cnt FROM demo_requests GROUP BY status") as $row) {
    $status_counts[$row['status']] = $row['cnt'];
}

// ── Badge helper ─────────────────────────────────────────────────
function lead_badge(string $status): string {
    $map = [
        'new'            => 'bg-red-100 text-red-800 border border-red-200',
        'contacted'      => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'demo_scheduled' => 'bg-purple-100 text-purple-800 border border-purple-200',
        'converted'      => 'bg-green-100 text-green-800 border border-green-200',
        'rejected'       => 'bg-gray-100 text-gray-800 border border-gray-200',
    ];
    $labels = [
        'new'            => 'Urgent',
        'contacted'      => 'Contacted',
        'demo_scheduled' => 'Scheduled',
        'converted'      => 'Converted',
        'rejected'       => 'Rejected',
    ];
    $class = $map[$status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
    $label = $labels[$status] ?? ucfirst($status);
    return '<span class="badge-modern ' . $class . ' px-3 py-1.5 rounded-full text-xs font-bold inline-flex items-center gap-1">' . htmlspecialchars($label) . '</span>';
}

require_once 'includes/executive-header.php';
?>

<!-- Page Header -->
<section class="animate-fade-in">
<div class="flex justify-between items-center mb-md">
<div>
<h2 class="font-h2 text-h2 text-gray-900">Demo Requests</h2>
<p class="text-sm text-gray-600 mt-2"><?php echo number_format($total_leads); ?> total request<?php echo $total_leads !== 1 ? 's' : ''; ?></p>
</div>
<div class="flex gap-3">
<button onclick="window.print()" class="btn-modern px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2 shadow-sm">
<span class="material-symbols-outlined text-[20px]">print</span>Export
</button>
</div>
</div>
</section>

<!-- Alerts -->
<?php if (isset($success_message)): ?>
<div class="animate-fade-in bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3 mb-gutter shadow-sm">
<span class="material-symbols-outlined text-green-600">check_circle</span>
<span class="font-semibold"><?php echo htmlspecialchars($success_message); ?></span>
</div>
<?php endif; ?>

<!-- Stats Grid -->
<section class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-lg">
<div class="stat-card animate-fade-in-up stagger-1 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">New Leads</span>
<div class="stat-icon bg-red-50">
<span class="material-symbols-outlined text-red-600">inbox</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['new'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Requires attention</div>
</div>

<div class="stat-card animate-fade-in-up stagger-2 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Contacted</span>
<div class="stat-icon bg-blue-50">
<span class="material-symbols-outlined text-blue-600">phone</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['contacted'] ?? 0); ?></div>
<div class="text-sm text-gray-600">In progress</div>
</div>

<div class="stat-card animate-fade-in-up stagger-3 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Scheduled</span>
<div class="stat-icon bg-purple-50">
<span class="material-symbols-outlined text-purple-600">calendar_month</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['demo_scheduled'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Upcoming demos</div>
</div>

<div class="stat-card animate-fade-in-up stagger-4 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Converted</span>
<div class="stat-icon bg-green-50">
<span class="material-symbols-outlined text-green-600">handshake</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['converted'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Success rate</div>
</div>
</section>

<!-- Filters -->
<section class="card-modern animate-scale-in bg-white mb-gutter">
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div>
<label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
<input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="School, contact..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all"/>
</div>
</div>

<div>
<label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
<select id="status" name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all">
<option value="">All Statuses</option>
<?php foreach (['new' => 'New', 'contacted' => 'Contacted', 'demo_scheduled' => 'Demo Scheduled', 'converted' => 'Converted', 'rejected' => 'Rejected'] as $val => $lbl): ?>
<option value="<?php echo $val; ?>" <?php echo $status_filter === $val ? 'selected' : ''; ?>><?php echo $lbl; ?></option>
<?php endforeach; ?>
</select>
</div>

<div>
<label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date Range</label>
<select id="date" name="date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all">
<option value="">All Time</option>
<option value="today" <?php echo $date_filter === 'today' ? 'selected' : ''; ?>>Today</option>
<option value="week" <?php echo $date_filter === 'week' ? 'selected' : ''; ?>>Last 7 Days</option>
<option value="month" <?php echo $date_filter === 'month' ? 'selected' : ''; ?>>Last 30 Days</option>
</select>
</div>

<div class="flex items-end gap-2">
<button type="submit" class="btn-modern flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-sm">
Filter
</button>
<a href="leads.php" class="btn-modern px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
Clear
</a>
</div>
</form>
</section>

<!-- Leads Table -->
<section class="card-modern animate-scale-in bg-white overflow-hidden">
<div class="overflow-x-auto">
<table class="table-modern">
<thead>
<tr class="border-b-2 border-gray-200">
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">School</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Students</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
<th class="py-3 px-4"></th>
</tr>
</thead>
<tbody class="text-sm text-gray-700">
<?php if (empty($leads)): ?>
<tr>
<td colspan="6" class="py-12 text-center">
<div class="empty-state">
<span class="material-symbols-outlined empty-state-icon text-gray-300">inbox</span>
<h3 class="text-lg font-bold text-gray-900 mb-2">No demo requests found</h3>
<p class="text-sm text-gray-600"><?php echo $where_clause ? 'Try adjusting your filters.' : 'Requests will appear here once submitted.'; ?></p>
</div>
</td>
</tr>
<?php else: ?>
<?php foreach ($leads as $lead): ?>
<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
<td class="py-4 px-4">
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($lead['school_name']); ?></div>
<?php if (!empty($lead['city'])): ?>
<div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-[14px]">location_on</span>
<?php echo htmlspecialchars($lead['city']); ?>
</div>
<?php endif; ?>
</td>
<td class="py-4 px-4">
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($lead['contact_person']); ?></div>
<div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-[14px]">mail</span>
<?php echo htmlspecialchars($lead['email']); ?>
</div>
</td>
<td class="py-4 px-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-gray-400 text-[18px]">group</span>
<span class="font-semibold"><?php echo htmlspecialchars($lead['student_count'] ?? '—'); ?></span>
</div>
</td>
<td class="py-4 px-4"><?php echo lead_badge($lead['status']); ?></td>
<td class="py-4 px-4">
<div class="text-gray-900"><?php echo date('M j, Y', strtotime($lead['created_at'])); ?></div>
<div class="text-xs text-gray-500"><?php echo date('g:i A', strtotime($lead['created_at'])); ?></div>
</td>
<td class="py-4 px-4 text-right">
<a href="lead-detail.php?id=<?php echo $lead['id']; ?>" class="btn-modern px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold inline-block hover:bg-blue-700 shadow-sm">
View
</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<div class="p-4 border-t border-gray-200 flex items-center justify-between bg-gray-50">
<span class="text-sm text-gray-600">
Showing <span class="font-semibold text-gray-900"><?php echo number_format($offset + 1); ?>–<?php echo number_format(min($offset + $per_page, $total_leads)); ?></span> of <span class="font-semibold text-gray-900"><?php echo number_format($total_leads); ?></span>
</span>
<div class="flex items-center gap-2">
<?php if ($page > 1): ?>
<a href="?page=<?php echo $page - 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" class="btn-modern px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-1">
<span class="material-symbols-outlined text-[18px]">chevron_left</span>
Previous
</a>
<?php endif; ?>

<span class="px-4 py-2 text-sm font-semibold text-gray-700">Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

<?php if ($page < $total_pages): ?>
<a href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>" class="btn-modern px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-1">
Next
<span class="material-symbols-outlined text-[18px]">chevron_right</span>
</a>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</section>

<?php require_once 'includes/executive-footer.php'; ?>
