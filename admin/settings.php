<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$page_title = 'Settings - SchoolPulse Admin';
$page_header = 'Settings';

$success_message = '';
$error_message   = '';

// ── Helper: upsert a setting ──────────────────────────────────────────────────
function save_setting(PDO $pdo, string $key, string $value): void {
    $stmt = $pdo->prepare("
        INSERT INTO site_settings (setting_key, setting_value, updated_at)
        VALUES (?, ?, NOW())
        ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()
    ");
    $stmt->execute([$key, $value]);
}

// ── Handle: Site Settings ─────────────────────────────────────────────────────
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'save_site_settings') {
    try {
        $fields = [
            'site_name', 'site_tagline', 'contact_email',
            'contact_phone', 'whatsapp_number', 'address', 'meta_description',
        ];
        foreach ($fields as $key) {
            save_setting($pdo, $key, sanitizeInput($_POST[$key] ?? ''));
        }
        $success_message = "Site settings saved successfully.";
    } catch (Exception $e) {
        $error_message = "Failed to save settings: " . $e->getMessage();
    }
}

// ── Handle: Change Password ───────────────────────────────────────────────────
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $current  = $_POST['current_password']  ?? '';
    $new_pw   = $_POST['new_password']      ?? '';
    $confirm  = $_POST['confirm_password']  ?? '';

    if (!$current || !$new_pw || !$confirm) {
        $error_message = "All password fields are required.";
    } elseif ($new_pw !== $confirm) {
        $error_message = "New password and confirmation do not match.";
    } elseif (strlen($new_pw) < 8) {
        $error_message = "New password must be at least 8 characters.";
    } else {
        $stmt = $pdo->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($current, $admin['password_hash'])) {
            $error_message = "Current password is incorrect.";
        } else {
            $hash = password_hash($new_pw, PASSWORD_DEFAULT);
            $upd  = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
            if ($upd->execute([$hash, $_SESSION['admin_id']])) {
                $success_message = "Password changed successfully.";
            } else {
                $error_message = "Failed to update password.";
            }
        }
    }
}

// ── Load current settings ─────────────────────────────────────────────────────
$settings_keys = [
    'site_name', 'site_tagline', 'contact_email',
    'contact_phone', 'whatsapp_number', 'address', 'meta_description',
];
$settings = [];
foreach ($settings_keys as $key) {
    $settings[$key] = get_setting($pdo, $key);
}

require_once 'includes/executive-header.php';
?>

<!-- Page Header -->
<section>
<div class="flex justify-between items-center mb-md">
<div>
<h2 class="font-h2 text-h2 text-on-surface">Settings</h2>
<p class="text-body-sm text-on-surface-variant mt-2">Manage site configuration and your account</p>
</div>
</div>
</section>

<!-- Alerts -->
<?php if ($success_message): ?>
<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-[10px] flex items-center gap-3 mb-gutter">
<span class="material-symbols-outlined">check_circle</span>
<span class="font-ui-medium"><?php echo htmlspecialchars($success_message); ?></span>
</div>
<?php endif; ?>

<?php if ($error_message): ?>
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-[10px] flex items-center gap-3 mb-gutter">
<span class="material-symbols-outlined">error</span>
<span class="font-ui-medium"><?php echo htmlspecialchars($error_message); ?></span>
</div>
<?php endif; ?>

<!-- Settings Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">

<!-- Left Column (2/3) -->
<div class="lg:col-span-2 space-y-gutter">

<!-- Site Settings Card -->
<section class="bg-surface-container-lowest rounded-[18px] shadow-[0_2px_8px_rgba(26,39,68,0.08)] overflow-hidden">
<div class="p-md border-b border-outline-variant/50 bg-surface-container-low">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-[12px] bg-blue-100 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-blue-600 text-2xl">language</span>
</div>
<div>
<h3 class="font-h3 text-h3 text-primary-container">Site Settings</h3>
<p class="text-sm text-on-surface-variant">Public-facing information shown on the website</p>
</div>
</div>
</div>

<form method="POST" class="p-md">
<input type="hidden" name="action" value="save_site_settings">

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
<div>
<label for="site_name" class="block text-sm font-ui-medium text-on-surface mb-2">Site Name</label>
<input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" placeholder="SchoolPulse" class="w-full px-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
<div>
<label for="site_tagline" class="block text-sm font-ui-medium text-on-surface mb-2">Tagline</label>
<input type="text" id="site_tagline" name="site_tagline" value="<?php echo htmlspecialchars($settings['site_tagline']); ?>" placeholder="The Complete School Management System" class="w-full px-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
<div>
<label for="contact_email" class="block text-sm font-ui-medium text-on-surface mb-2">Contact Email</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">mail</span>
<input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email']); ?>" placeholder="hello@schoolpulse.in" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>
<div>
<label for="contact_phone" class="block text-sm font-ui-medium text-on-surface mb-2">Contact Phone</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">call</span>
<input type="text" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($settings['contact_phone']); ?>" placeholder="+91 98765 43210" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
<div>
<label for="whatsapp_number" class="block text-sm font-ui-medium text-on-surface mb-2">
WhatsApp Number
<span class="text-xs text-on-surface-variant font-normal">(digits only, with country code)</span>
</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">chat</span>
<input type="text" id="whatsapp_number" name="whatsapp_number" value="<?php echo htmlspecialchars($settings['whatsapp_number']); ?>" placeholder="919876543210" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>
<div>
<label for="address" class="block text-sm font-ui-medium text-on-surface mb-2">Address</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">location_on</span>
<input type="text" id="address" name="address" value="<?php echo htmlspecialchars($settings['address']); ?>" placeholder="India" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>
</div>

<div class="mb-4">
<label for="meta_description" class="block text-sm font-ui-medium text-on-surface mb-2 flex items-center justify-between">
<span>Meta Description</span>
<span class="text-xs text-on-surface-variant font-normal" id="meta-count"><?php echo strlen($settings['meta_description']); ?>/160</span>
</label>
<textarea id="meta_description" name="meta_description" rows="3" maxlength="160" placeholder="Brief description for search engines..." oninput="document.getElementById('meta-count').textContent=this.value.length+'/160'" class="w-full px-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm resize-none"><?php echo htmlspecialchars($settings['meta_description']); ?></textarea>
<p class="text-xs text-on-surface-variant mt-1">Shown in Google search results. Keep under 160 characters.</p>
</div>

<div class="pt-4 border-t border-outline-variant/50">
<button type="submit" class="px-6 py-2 bg-primary-container text-on-primary rounded-[10px] font-ui-medium hover:scale-102 transition-transform flex items-center gap-2">
<span class="material-symbols-outlined text-[20px]">save</span>
Save Site Settings
</button>
</div>
</form>
</section>

</div>

<!-- Right Column (1/3) -->
<div class="space-y-gutter">

<!-- Account Info Card -->
<section class="bg-surface-container-lowest rounded-[18px] shadow-[0_2px_8px_rgba(26,39,68,0.08)] overflow-hidden">
<div class="p-md border-b border-outline-variant/50 bg-surface-container-low">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-[12px] bg-purple-100 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-purple-600 text-2xl">account_circle</span>
</div>
<div>
<h3 class="font-h3 text-h3 text-primary-container">Account</h3>
<p class="text-sm text-on-surface-variant">Your admin profile</p>
</div>
</div>
</div>

<div class="p-md">
<div class="flex items-center gap-4">
<div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-container to-secondary flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
<?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?>
</div>
<div>
<div class="font-ui-medium text-primary-container text-lg"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></div>
<div class="text-sm text-on-surface-variant"><?php echo ucfirst($_SESSION['admin_role']); ?></div>
</div>
</div>
</div>
</section>

<!-- Change Password Card -->
<section class="bg-surface-container-lowest rounded-[18px] shadow-[0_2px_8px_rgba(26,39,68,0.08)] overflow-hidden">
<div class="p-md border-b border-outline-variant/50 bg-surface-container-low">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-[12px] bg-amber-100 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-amber-600 text-2xl">lock</span>
</div>
<div>
<h3 class="font-h3 text-h3 text-primary-container">Change Password</h3>
<p class="text-sm text-on-surface-variant">Update your credentials</p>
</div>
</div>
</div>

<form method="POST" class="p-md" id="passwordForm">
<input type="hidden" name="action" value="change_password">

<div class="mb-4">
<label for="current_password" class="block text-sm font-ui-medium text-on-surface mb-2">Current Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">lock</span>
<input type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="••••••••" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
</div>

<div class="mb-4">
<label for="new_password" class="block text-sm font-ui-medium text-on-surface mb-2">New Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">key</span>
<input type="password" id="new_password" name="new_password" autocomplete="new-password" placeholder="Min. 8 characters" oninput="checkPasswordStrength(this.value)" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
<div id="strengthBar" class="hidden mt-2 flex items-center gap-2">
<div class="flex-1 h-1 bg-surface-variant rounded-full overflow-hidden">
<div id="strengthFill" class="h-full transition-all duration-300"></div>
</div>
<span id="strengthLabel" class="text-xs font-semibold"></span>
</div>
</div>

<div class="mb-4">
<label for="confirm_password" class="block text-sm font-ui-medium text-on-surface mb-2">Confirm New Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">key</span>
<input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" placeholder="Repeat new password" oninput="checkMatch()" class="w-full pl-10 pr-4 py-2 rounded-[10px] border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none text-sm"/>
</div>
<p id="matchHint" class="text-xs font-semibold mt-1"></p>
</div>

<div class="pt-4 border-t border-outline-variant/50">
<button type="submit" class="w-full px-6 py-2 bg-primary-container text-on-primary rounded-[10px] font-ui-medium hover:scale-102 transition-transform flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-[20px]">shield</span>
Update Password
</button>
</div>
</form>
</section>

<!-- Danger Zone Card -->
<section class="bg-red-50 rounded-[18px] shadow-[0_2px_8px_rgba(26,39,68,0.08)] overflow-hidden border border-red-200">
<div class="p-md border-b border-red-200 bg-red-100">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-[12px] bg-red-200 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-red-600 text-2xl">warning</span>
</div>
<div>
<h3 class="font-h3 text-h3 text-red-900">Session</h3>
<p class="text-sm text-red-700">Sign out of the admin panel</p>
</div>
</div>
</div>

<div class="p-md">
<a href="logout.php" class="w-full px-6 py-2 bg-red-600 text-white rounded-[10px] font-ui-medium hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-[20px]">logout</span>
Sign Out
</a>
</div>
</section>

</div>

</div>

<script>
// Password strength meter
function checkPasswordStrength(val) {
    const bar = document.getElementById('strengthBar');
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');

    if (!val) {
        bar.classList.add('hidden');
        return;
    }
    bar.classList.remove('hidden');

    let score = 0;
    if (val.length >= 8) score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '20%', color: '#ef4444', text: 'Weak' },
        { pct: '40%', color: '#f97316', text: 'Fair' },
        { pct: '60%', color: '#eab308', text: 'Good' },
        { pct: '80%', color: '#22c55e', text: 'Strong' },
        { pct: '100%', color: '#16a34a', text: 'Very strong' },
    ];
    const lvl = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent = lvl.text;
    label.style.color = lvl.color;
}

// Password match hint
function checkMatch() {
    const pw = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;
    const hint = document.getElementById('matchHint');

    if (!confirm) {
        hint.textContent = '';
        return;
    }

    if (pw === confirm) {
        hint.textContent = '✓ Passwords match';
        hint.style.color = '#16a34a';
    } else {
        hint.textContent = '✗ Passwords do not match';
        hint.style.color = '#ef4444';
    }
}

// Prevent submit if passwords don't match
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const pw = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;
    if (pw && confirm && pw !== confirm) {
        e.preventDefault();
        document.getElementById('matchHint').textContent = '✗ Passwords do not match';
        document.getElementById('matchHint').style.color = '#ef4444';
        document.getElementById('confirm_password').focus();
    }
});
</script>

<?php require_once 'includes/executive-footer.php'; ?>
