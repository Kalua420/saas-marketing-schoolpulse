<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$page_title = 'Contact Submissions — SchoolPulse Admin';

// ── Status update ────────────────────────────────────────────────
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $contact_id = (int)$_POST['contact_id'];
    $status     = sanitizeInput($_POST['status']);
    $stmt       = $pdo->prepare("UPDATE contact_submissions SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $contact_id])) {
        $success_message = "Contact status updated.";
    } else {
        $error_message = "Failed to update contact status.";
    }
}

// ── Bulk actions ─────────────────────────────────────────────────
if ($_POST && isset($_POST['bulk_action'], $_POST['selected_contacts'])) {
    $bulk_action       = $_POST['bulk_action'];
    $selected_contacts = $_POST['selected_contacts'];
    $new_status = match($bulk_action) {
        'mark_responded' => 'read',
        'mark_resolved'  => 'replied',
        default          => null,
    };
    if ($new_status) {
        $stmt = $pdo->prepare("UPDATE contact_submissions SET status = ? WHERE id = ?");
        foreach ($selected_contacts as $cid) {
            $stmt->execute([$new_status, (int)$cid]);
        }
        $success_message = count($selected_contacts) . " contact(s) updated.";
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
    $where[]  = "(name LIKE ? OR email LIKE ? OR subject LIKE ?)";
    $sp       = "%$search%";
    $params   = array_merge($params, [$sp, $sp, $sp]);
}

$where_clause = $where ? "WHERE " . implode(" AND ", $where) : "";

// ── Pagination ───────────────────────────────────────────────────
$page     = max(1, (int)($_GET['page'] ?? 1));
$per_page = 20;
$offset   = ($page - 1) * $per_page;

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_submissions $where_clause");
$count_stmt->execute($params);
$total_contacts = (int)$count_stmt->fetchColumn();
$total_pages    = max(1, (int)ceil($total_contacts / $per_page));

$stmt = $pdo->prepare("SELECT * FROM contact_submissions $where_clause ORDER BY submitted_at DESC LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$contacts = $stmt->fetchAll();

// ── Status counts ────────────────────────────────────────────────
$status_counts = [];
foreach ($pdo->query("SELECT status, COUNT(*) AS cnt FROM contact_submissions GROUP BY status") as $row) {
    $status_counts[$row['status']] = $row['cnt'];
}

// ── Badge helper ─────────────────────────────────────────────────
function contact_status_badge(string $status): string {
    $map = [
        'new'     => 'bg-red-100 text-red-800 border border-red-200',
        'read'    => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'replied' => 'bg-green-100 text-green-800 border border-green-200',
    ];
    $labels = [
        'new'     => 'Urgent',
        'read'    => 'Processing',
        'replied' => 'Completed',
    ];
    $class = $map[$status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
    $label = $labels[$status] ?? ucfirst($status);
    return '<span class="badge-modern ' . $class . ' px-3 py-1.5 rounded-full text-xs font-bold inline-flex items-center gap-1">' . htmlspecialchars($label) . '</span>';
}

$page_header = 'Contact Messages';

require_once 'includes/executive-header.php';
?>

<!-- Page Header -->
<section class="animate-fade-in">
<div class="flex justify-between items-center mb-md">
<div>
<h2 class="font-h2 text-h2 text-gray-900">Contact Messages</h2>
<p class="text-sm text-gray-600 mt-2"><?php echo number_format($total_contacts); ?> total message<?php echo $total_contacts !== 1 ? 's' : ''; ?></p>
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

<?php if (isset($error_message)): ?>
<div class="animate-fade-in bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3 mb-gutter shadow-sm">
<span class="material-symbols-outlined text-red-600">error</span>
<span class="font-semibold"><?php echo htmlspecialchars($error_message); ?></span>
</div>
<?php endif; ?>

<!-- Stats Grid -->
<section class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-lg">
<div class="stat-card animate-fade-in-up stagger-1 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">New Messages</span>
<div class="stat-icon bg-red-50">
<span class="material-symbols-outlined text-red-600">mail</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['new'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Requires attention</div>
</div>

<div class="stat-card animate-fade-in-up stagger-2 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Read</span>
<div class="stat-icon bg-yellow-50">
<span class="material-symbols-outlined text-yellow-600">drafts</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['read'] ?? 0); ?></div>
<div class="text-sm text-gray-600">In progress</div>
</div>

<div class="stat-card animate-fade-in-up stagger-3 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Replied</span>
<div class="stat-icon bg-green-50">
<span class="material-symbols-outlined text-green-600">mark_email_read</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['replied'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Completed</div>
</div>

<div class="stat-card animate-fade-in-up stagger-4 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Total</span>
<div class="stat-icon bg-blue-50">
<span class="material-symbols-outlined text-blue-600">inbox</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format(array_sum($status_counts)); ?></div>
<div class="text-sm text-gray-600">All messages</div>
</div>
</section>

<!-- Filters -->
<section class="card-modern animate-scale-in bg-white mb-gutter">
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div>
<label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
<input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Name, email, subject..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all"/>
</div>
</div>

<div>
<label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
<select id="status" name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all">
<option value="">All Statuses</option>
<option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
<option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
<option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Replied</option>
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
<a href="contacts.php" class="btn-modern px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
Clear
</a>
</div>
</form>
</section>

<!-- Bulk Actions Bar -->
<form method="POST" id="contactsForm">
<div class="bg-gray-50 rounded-lg p-3 mb-4 flex items-center gap-3 border border-gray-200">
<select name="bulk_action" id="bulkAction" class="px-4 py-2 rounded-lg border border-gray-300 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none">
<option value="">Bulk Actions</option>
<option value="mark_responded">Mark as Read</option>
<option value="mark_resolved">Mark as Replied</option>
</select>
<button type="submit" class="btn-modern px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm" onclick="return confirmBulk()">
Apply
</button>
<span class="text-sm font-semibold text-gray-600" id="selectedCount"></span>
</div>

<!-- Contacts Table -->
<section class="card-modern animate-scale-in bg-white overflow-hidden">
<div class="overflow-x-auto">
<table class="table-modern">
<thead>
<tr class="border-b-2 border-gray-200">
<th class="py-3 px-4 w-12">
<input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="selectAll">
</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">School</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Message</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
<th class="py-3 px-4"></th>
</tr>
</thead>
<tbody class="text-sm text-gray-700">
<?php if (empty($contacts)): ?>
<tr>
<td colspan="7" class="py-12 text-center">
<div class="empty-state">
<span class="material-symbols-outlined empty-state-icon text-gray-300">mail</span>
<h3 class="text-lg font-bold text-gray-900 mb-2">No contact messages found</h3>
<p class="text-sm text-gray-600"><?php echo $where_clause ? 'Try adjusting your filters.' : 'Messages will appear here once submitted.'; ?></p>
</div>
</td>
</tr>
<?php else: ?>
<?php foreach ($contacts as $contact): ?>
<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors <?php echo $contact['status'] === 'new' ? 'bg-red-50/30' : ''; ?>">
<td class="py-4 px-4">
<input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 contact-checkbox" name="selected_contacts[]" value="<?php echo $contact['id']; ?>">
</td>
<td class="py-4 px-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
<?php 
$full_name = trim($contact['first_name'] . ' ' . $contact['last_name']);
$names = explode(' ', $full_name);
echo strtoupper(substr($names[0], 0, 1));
if (isset($names[1])) echo strtoupper(substr($names[1], 0, 1));
?>
</div>
<div>
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($full_name); ?></div>
<div class="text-xs text-gray-500 flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">mail</span>
<?php echo htmlspecialchars($contact['email']); ?>
</div>
<?php if (!empty($contact['phone'])): ?>
<div class="text-xs text-gray-500 flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">call</span>
<?php echo htmlspecialchars($contact['phone']); ?>
</div>
<?php endif; ?>
</div>
</div>
</td>
<td class="py-4 px-4">
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($contact['school_name'] ?: '—'); ?></div>
</td>
<td class="py-4 px-4 max-w-xs">
<div class="text-sm text-gray-600 line-clamp-2">
<?php echo htmlspecialchars(mb_substr($contact['message'], 0, 100)); ?><?php if (mb_strlen($contact['message']) > 100): ?>...<?php endif; ?>
</div>
</td>
<td class="py-4 px-4"><?php echo contact_status_badge($contact['status']); ?></td>
<td class="py-4 px-4">
<div class="text-gray-900"><?php echo date('M j, Y', strtotime($contact['submitted_at'])); ?></div>
<div class="text-xs text-gray-500"><?php echo date('g:i A', strtotime($contact['submitted_at'])); ?></div>
</td>
<td class="py-4 px-4">
<div class="flex items-center gap-2">
<a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors" title="Reply via email">
<span class="material-symbols-outlined text-[18px]">reply</span>
</a>
<div class="relative">
<button type="button" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors dropdown-toggle" data-contact-id="<?php echo $contact['id']; ?>">
<span class="material-symbols-outlined text-[18px]">more_vert</span>
</button>
<div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
<form method="POST" class="p-2">
<input type="hidden" name="action" value="update_status">
<input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
<button type="submit" name="status" value="read" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 text-gray-700">
<span class="material-symbols-outlined text-[18px]">drafts</span>
Mark Read
</button>
<button type="submit" name="status" value="replied" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 text-gray-700">
<span class="material-symbols-outlined text-[18px]">mark_email_read</span>
Mark Replied
</button>
</form>
</div>
</div>
</div>
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
Showing <span class="font-semibold text-gray-900"><?php echo number_format($offset + 1); ?>–<?php echo number_format(min($offset + $per_page, $total_contacts)); ?></span> of <span class="font-semibold text-gray-900"><?php echo number_format($total_contacts); ?></span>
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
</form>

<script>
// Select all checkbox
const selectAll = document.getElementById('selectAll');
const countEl = document.getElementById('selectedCount');

function updateCount() {
  const n = document.querySelectorAll('.contact-checkbox:checked').length;
  countEl.textContent = n > 0 ? n + ' selected' : '';
}

selectAll.addEventListener('change', function () {
  document.querySelectorAll('.contact-checkbox').forEach(cb => cb.checked = this.checked);
  updateCount();
});

document.querySelectorAll('.contact-checkbox').forEach(cb => {
  cb.addEventListener('change', () => {
    selectAll.checked = document.querySelectorAll('.contact-checkbox:not(:checked)').length === 0;
    updateCount();
  });
});

// Bulk confirm
function confirmBulk() {
  const action = document.getElementById('bulkAction').value;
  const selected = document.querySelectorAll('.contact-checkbox:checked');
  if (!action) { alert('Please select a bulk action.'); return false; }
  if (!selected.length) { alert('Please select at least one contact.'); return false; }
  return confirm('Apply this action to ' + selected.length + ' contact(s)?');
}

// Dropdown menus
document.addEventListener('click', function (e) {
  const toggle = e.target.closest('.dropdown-toggle');
  
  // Close all dropdowns
  document.querySelectorAll('.dropdown-menu').forEach(m => {
    if (!toggle || m !== toggle.nextElementSibling) {
      m.classList.add('hidden');
    }
  });
  
  // Toggle clicked dropdown
  if (toggle) {
    e.stopPropagation();
    const menu = toggle.nextElementSibling;
    menu.classList.toggle('hidden');
  }
});
</script>

<?php require_once 'includes/executive-footer.php'; ?>
