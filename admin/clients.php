<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$page_title = 'Clients - SchoolPulse Admin';
$page_header = 'Clients';

// Handle client deletion
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'delete_client') {
    $client_id = (int)$_POST['client_id'];
    $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
    if ($stmt->execute([$client_id])) {
        $success_message = "Client deleted successfully!";
    } else {
        $error_message = "Failed to delete client.";
    }
}

// Handle status updates
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $client_id = (int)$_POST['client_id'];
    $status = sanitizeInput($_POST['status']);
    $stmt = $pdo->prepare("UPDATE clients SET status = ?, updated_at = NOW() WHERE id = ?");
    if ($stmt->execute([$status, $client_id])) {
        $success_message = "Client status updated successfully!";
    } else {
        $error_message = "Failed to update client status.";
    }
}

// Filters
$status_filter = $_GET['status'] ?? '';
$plan_filter   = $_GET['plan']   ?? '';
$search        = $_GET['search'] ?? '';

$where_conditions = [];
$params = [];

if ($status_filter) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
}

if ($plan_filter) {
    $where_conditions[] = "plan = ?";
    $params[] = $plan_filter;
}

if ($search) {
    $where_conditions[] = "(school_name LIKE ? OR contact_name LIKE ? OR email LIKE ?)";
    $sp = "%$search%";
    $params[] = $sp; $params[] = $sp; $params[] = $sp;
}

$where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Pagination
$page     = max(1, (int)($_GET['page'] ?? 1));
$per_page = 20;
$offset   = ($page - 1) * $per_page;

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM clients $where_clause");
$count_stmt->execute($params);
$total_clients = (int)$count_stmt->fetchColumn();
$total_pages   = max(1, (int)ceil($total_clients / $per_page));

$stmt = $pdo->prepare("SELECT * FROM clients $where_clause ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$clients = $stmt->fetchAll();

// Status counts
$status_counts = [];
$sc = $pdo->query("SELECT status, COUNT(*) as count FROM clients GROUP BY status");
while ($row = $sc->fetch()) { $status_counts[$row['status']] = $row['count']; }

// Plan distribution (active clients)
$plan_counts = [];
$pc = $pdo->query("SELECT plan, COUNT(*) as count FROM clients WHERE status = 'active' GROUP BY plan");
while ($row = $pc->fetch()) { $plan_counts[$row['plan']] = $row['count']; }

// Status badge helper
function client_status_badge(string $status): string {
    $map = [
        'active'   => 'bg-green-100 text-green-800 border border-green-200',
        'trial'    => 'bg-blue-100 text-blue-800 border border-blue-200',
        'inactive' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        'churned'  => 'bg-red-100 text-red-800 border border-red-200',
    ];
    $class = $map[$status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
    return '<span class="badge-modern ' . $class . ' px-3 py-1.5 rounded-full text-xs font-bold inline-flex items-center gap-1">' . htmlspecialchars(ucfirst($status)) . '</span>';
}

require_once 'includes/executive-header.php';
?>

<!-- Page Header -->
<section class="animate-fade-in">
<div class="flex justify-between items-center mb-md">
<div>
<h2 class="font-h2 text-h2 text-gray-900">Clients</h2>
<p class="text-sm text-gray-600 mt-2"><?php echo number_format($total_clients); ?> total client<?php echo $total_clients !== 1 ? 's' : ''; ?></p>
</div>
<div class="flex gap-3">
<a href="client-add.php" class="btn-modern px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2 shadow-sm">
<span class="material-symbols-outlined text-[20px]">add</span>Add Client
</a>
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
<span class="stat-label">Active</span>
<div class="stat-icon bg-green-50">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['active'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Paying clients</div>
</div>

<div class="stat-card animate-fade-in-up stagger-2 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Trial</span>
<div class="stat-icon bg-blue-50">
<span class="material-symbols-outlined text-blue-600">schedule</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['trial'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Evaluation period</div>
</div>

<div class="stat-card animate-fade-in-up stagger-3 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Inactive</span>
<div class="stat-icon bg-yellow-50">
<span class="material-symbols-outlined text-yellow-600">pause_circle</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['inactive'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Paused accounts</div>
</div>

<div class="stat-card animate-fade-in-up stagger-4 bg-white">
<div class="flex justify-between items-start mb-4">
<span class="stat-label">Churned</span>
<div class="stat-icon bg-red-50">
<span class="material-symbols-outlined text-red-600">cancel</span>
</div>
</div>
<div class="stat-value text-gray-900"><?php echo number_format($status_counts['churned'] ?? 0); ?></div>
<div class="text-sm text-gray-600">Lost clients</div>
</div>
</section>

<!-- Plan Distribution -->
<?php if (!empty($plan_counts)): ?>
<section class="card-modern animate-scale-in bg-white mb-gutter">
<h3 class="text-lg font-bold text-gray-900 mb-4">Active Clients by Plan</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<?php foreach ($plan_counts as $plan => $count): ?>
<div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-l-4 border-<?php echo $plan === 'starter' ? 'blue' : ($plan === 'growth' ? 'purple' : 'green'); ?>-500 hover:bg-gray-100 transition-colors">
<div>
<div class="font-semibold text-gray-900"><?php echo ucfirst($plan); ?></div>
<div class="text-sm text-gray-600"><?php echo $count; ?> client<?php echo $count !== 1 ? 's' : ''; ?></div>
</div>
<span class="material-symbols-outlined text-3xl text-<?php echo $plan === 'starter' ? 'blue' : ($plan === 'growth' ? 'purple' : 'green'); ?>-500">workspace_premium</span>
</div>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<!-- Filters -->
<section class="card-modern animate-scale-in bg-white mb-gutter">
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div>
<label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
<input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="School, contact, email..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all"/>
</div>
</div>

<div>
<label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
<select id="status" name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all">
<option value="">All Statuses</option>
<option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
<option value="trial" <?php echo $status_filter === 'trial' ? 'selected' : ''; ?>>Trial</option>
<option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
<option value="churned" <?php echo $status_filter === 'churned' ? 'selected' : ''; ?>>Churned</option>
</select>
</div>

<div>
<label for="plan" class="block text-sm font-semibold text-gray-700 mb-2">Plan</label>
<select id="plan" name="plan" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm transition-all">
<option value="">All Plans</option>
<option value="starter" <?php echo $plan_filter === 'starter' ? 'selected' : ''; ?>>Starter</option>
<option value="growth" <?php echo $plan_filter === 'growth' ? 'selected' : ''; ?>>Growth</option>
<option value="enterprise" <?php echo $plan_filter === 'enterprise' ? 'selected' : ''; ?>>Enterprise</option>
</select>
</div>

<div class="flex items-end gap-2">
<button type="submit" class="btn-modern flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-sm">
Filter
</button>
<a href="clients.php" class="btn-modern px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
Clear
</a>
</div>
</form>
</section>

<!-- Clients Table -->
<section class="card-modern animate-scale-in bg-white overflow-hidden">
<div class="overflow-x-auto">
<table class="table-modern">
<thead>
<tr class="border-b-2 border-gray-200">
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">School</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Plan</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Location</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
<th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Onboarded</th>
<th class="py-3 px-4"></th>
</tr>
</thead>
<tbody class="text-sm text-gray-700">
<?php if (empty($clients)): ?>
<tr>
<td colspan="7" class="py-12 text-center">
<div class="empty-state">
<span class="material-symbols-outlined empty-state-icon text-gray-300">business</span>
<h3 class="text-lg font-bold text-gray-900 mb-2">No clients found</h3>
<p class="text-sm text-gray-600 mb-4"><?php echo $where_clause ? 'Try adjusting your filters.' : 'Add your first client to get started.'; ?></p>
<a href="client-add.php" class="btn-modern inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-sm">
<span class="material-symbols-outlined">add</span>Add Client
</a>
</div>
</td>
</tr>
<?php else: ?>
<?php foreach ($clients as $client): ?>
<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
<td class="py-4 px-4">
<div class="flex items-center gap-3">
<?php if ($client['logo_url']): ?>
<img src="<?php echo htmlspecialchars($client['logo_url']); ?>" alt="" class="w-10 h-10 rounded-lg object-contain bg-white border border-gray-200">
<?php else: ?>
<div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
<?php echo strtoupper(substr($client['school_name'], 0, 2)); ?>
</div>
<?php endif; ?>
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($client['school_name']); ?></div>
</div>
</td>
<td class="py-4 px-4">
<?php if ($client['contact_name']): ?>
<div class="font-semibold text-gray-900"><?php echo htmlspecialchars($client['contact_name']); ?></div>
<?php endif; ?>
<?php if ($client['email']): ?>
<div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-[14px]">mail</span>
<?php echo htmlspecialchars($client['email']); ?>
</div>
<?php endif; ?>
<?php if ($client['phone']): ?>
<div class="text-xs text-gray-500 flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">call</span>
<?php echo htmlspecialchars($client['phone']); ?>
</div>
<?php endif; ?>
</td>
<td class="py-4 px-4">
<span class="badge-modern px-3 py-1.5 rounded-full text-xs font-bold inline-flex items-center gap-1 <?php 
echo $client['plan'] === 'starter' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
    ($client['plan'] === 'growth' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-green-100 text-green-800 border border-green-200'); 
?>">
<?php echo ucfirst($client['plan']); ?>
</span>
</td>
<td class="py-4 px-4">
<div class="text-gray-700">
<?php
$loc = array_filter([$client['city'], $client['state']]);
echo htmlspecialchars(implode(', ', $loc) ?: '—');
?>
</div>
</td>
<td class="py-4 px-4"><?php echo client_status_badge($client['status']); ?></td>
<td class="py-4 px-4">
<?php if ($client['onboarded_at']): ?>
<div class="text-gray-900"><?php echo date('M j, Y', strtotime($client['onboarded_at'])); ?></div>
<?php if ($client['renewal_date']): ?>
<div class="text-xs text-gray-500">Renews: <?php echo date('M j, Y', strtotime($client['renewal_date'])); ?></div>
<?php endif; ?>
<?php else: ?>
<span class="text-gray-500">—</span>
<?php endif; ?>
</td>
<td class="py-4 px-4">
<div class="flex items-center gap-2">
<a href="client-edit.php?id=<?php echo $client['id']; ?>" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors" title="Edit">
<span class="material-symbols-outlined text-[18px]">edit</span>
</a>
<div class="relative">
<button type="button" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors dropdown-toggle" data-client-id="<?php echo $client['id']; ?>">
<span class="material-symbols-outlined text-[18px]">more_vert</span>
</button>
<div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
<form method="POST" class="p-2">
<input type="hidden" name="action" value="update_status">
<input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
<?php if ($client['status'] !== 'active'): ?>
<button type="submit" name="status" value="active" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 text-gray-700">
<span class="material-symbols-outlined text-[18px]">check_circle</span>
Activate
</button>
<?php endif; ?>
<?php if ($client['status'] !== 'inactive'): ?>
<button type="submit" name="status" value="inactive" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 text-gray-700">
<span class="material-symbols-outlined text-[18px]">pause_circle</span>
Mark Inactive
</button>
<?php endif; ?>
<?php if ($client['status'] !== 'churned'): ?>
<button type="submit" name="status" value="churned" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 text-gray-700">
<span class="material-symbols-outlined text-[18px]">cancel</span>
Mark Churned
</button>
<?php endif; ?>
<div class="h-px bg-gray-200 my-2"></div>
<button type="button" onclick="deleteClient(<?php echo $client['id']; ?>)" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg flex items-center gap-2">
<span class="material-symbols-outlined text-[18px]">delete</span>
Delete
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
Showing <span class="font-semibold text-gray-900"><?php echo number_format($offset + 1); ?>–<?php echo number_format(min($offset + $per_page, $total_clients)); ?></span> of <span class="font-semibold text-gray-900"><?php echo number_format($total_clients); ?></span>
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

<script>
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

// Delete client confirmation
function deleteClient(clientId) {
  if (confirm('Are you sure you want to delete this client? This action cannot be undone.')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
      <input type="hidden" name="action" value="delete_client">
      <input type="hidden" name="client_id" value="${clientId}">
    `;
    document.body.appendChild(form);
    form.submit();
  }
}
</script>

<?php require_once 'includes/executive-footer.php'; ?>
