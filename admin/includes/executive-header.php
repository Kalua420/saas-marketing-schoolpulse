<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" name="viewport"/>
<title><?php echo htmlspecialchars($page_title ?? 'SchoolPulse Admin'); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Newsreader:wght@400&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="../assets/css/admin-animations.css" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
darkMode: "class",
theme: {
extend: {
"colors": {
"on-surface-variant": "#45464d",
"on-primary": "#ffffff",
"primary-fixed-dim": "#b9c6eb",
"on-tertiary-container": "#a88a5a",
"on-primary-fixed-variant": "#3a4665",
"outline": "#75777e",
"tertiary-fixed-dim": "#e3c28d",
"on-background": "#0c1c2e",
"on-error-container": "#93000a",
"on-primary-container": "#828eb1",
"on-secondary": "#ffffff",
"primary-fixed": "#d9e2ff",
"primary-container": "#1a2744",
"surface-tint": "#515e7e",
"surface-container": "#e5eeff",
"secondary-fixed": "#dde1ff",
"inverse-on-surface": "#eaf1ff",
"on-tertiary-fixed-variant": "#5a431a",
"on-error": "#ffffff",
"on-tertiary-fixed": "#271900",
"on-surface": "#0c1c2e",
"tertiary": "#1d1100",
"surface-container-highest": "#d4e4fc",
"surface-container-high": "#dbe9ff",
"on-secondary-container": "#fffbff",
"on-secondary-fixed-variant": "#0736ba",
"secondary-fixed-dim": "#b8c3ff",
"error-container": "#ffdad6",
"surface-bright": "#f8f9ff",
"tertiary-fixed": "#ffdeab",
"primary": "#04122e",
"surface-variant": "#d4e4fc",
"surface-container-low": "#eff4ff",
"on-secondary-fixed": "#001355",
"inverse-primary": "#b9c6eb",
"on-primary-fixed": "#0d1b37",
"inverse-surface": "#223144",
"on-tertiary": "#ffffff",
"error": "#ba1a1a",
"secondary-container": "#4b69ea",
"background": "#f8f9ff",
"surface-container-lowest": "#ffffff",
"tertiary-container": "#372400",
"secondary": "#2d4fcf",
"surface": "#f8f9ff",
"outline-variant": "#c5c6ce",
"surface-dim": "#ccdbf3"
},
"borderRadius": {
"DEFAULT": "0.25rem",
"lg": "0.5rem",
"xl": "0.75rem",
"full": "9999px"
},
"spacing": {
"xs": "4px",
"sm": "12px",
"md": "16px",
"gutter": "20px",
"lg": "32px",
"xl": "48px",
"margin": "24px",
"base": "8px"
},
"fontFamily": {
"label-caps": ["Plus Jakarta Sans"],
"ui-medium": ["Plus Jakarta Sans"],
"h3": ["Plus Jakarta Sans"],
"body-sm": ["Newsreader"],
"body-main": ["Newsreader"],
"h2": ["Plus Jakarta Sans"],
"h1": ["Plus Jakarta Sans"]
},
"fontSize": {
"label-caps": ["12px", { "lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700" }],
"ui-medium": ["16px", { "lineHeight": "1.5", "fontWeight": "600" }],
"h3": ["24px", { "lineHeight": "1.4", "fontWeight": "700" }],
"body-sm": ["15px", { "lineHeight": "1.5", "fontWeight": "400" }],
"body-main": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
"h2": ["32px", { "lineHeight": "1.3", "fontWeight": "700" }],
"h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800" }]
}
}
}
}
</script>
<style>
.material-symbols-outlined {
font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

/* Ensure no gaps at any zoom level */
html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

body {
  display: flex;
  min-height: 100vh;
}

/* Sidebar responsive sizing */
aside.fixed {
  position: fixed;
  left: 0;
  top: 0;
  height: 100vh;
  width: 256px;
  transition: width 0.3s ease;
  flex-shrink: 0;
}

/* Main content area fills remaining space */
main {
  margin-left: 256px;
  width: calc(100% - 256px);
  transition: margin-left 0.3s ease, width 0.3s ease;
  display: flex;
  flex-direction: column;
  min-width: 0;
}

/* Content area should fill all available space */
main > div {
  width: 100%;
  max-width: none !important;
}

/* Grid and flex items should be responsive */
.grid {
  width: 100%;
}

/* Ensure cards and sections fill width */
section {
  width: 100%;
  max-width: none !important;
}

/* Responsive breakpoints */
@media (max-width: 1280px) {
  aside.fixed {
    width: 220px;
  }
  main {
    margin-left: 220px;
    width: calc(100% - 220px);
  }
}

@media (max-width: 1024px) {
  aside.fixed {
    width: 200px;
  }
  main {
    margin-left: 200px;
    width: calc(100% - 200px);
  }
  aside.fixed h2 {
    font-size: 1rem;
  }
  aside.fixed .db-sidebar__sub {
    font-size: 0.7rem;
  }
}

@media (max-width: 768px) {
  aside.fixed {
    width: 72px;
  }
  aside.fixed .db-sidebar__sub,
  aside.fixed nav a span:not(.material-symbols-outlined),
  aside.fixed .db-sidebar__cta a span:not(.material-symbols-outlined) {
    display: none;
  }
  aside.fixed nav a {
    justify-content: center;
    padding-left: 0;
    padding-right: 0;
  }
  main {
    margin-left: 72px;
    width: calc(100% - 72px);
  }
}

/* Zoom level adjustments */
@media (min-width: 1920px) {
  aside.fixed {
    width: 280px;
  }
  main {
    margin-left: 280px;
    width: calc(100% - 280px);
  }
}

/* Prevent horizontal scroll */
body, html {
  overflow-x: hidden;
}

/* Ensure content area fills properly */
.flex-1 {
  flex: 1 1 0%;
  min-width: 0;
  width: 100%;
}

/* Make sure all child elements respect parent width */
* {
  box-sizing: border-box;
}

/* Force content to fill width */
main > div > div {
  width: 100% !important;
  max-width: none !important;
}

/* Ensure all sections and containers are full width */
.space-y-4, .space-y-6, .space-y-8,
.space-y-lg, .space-y-md, .space-y-gutter {
  width: 100%;
}
</style>
</head>
<body class="bg-background text-on-background font-body-main antialiased flex h-screen overflow-hidden">

<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-screen w-64 z-50 bg-[#0f1a2e] text-white font-['Plus_Jakarta_Sans'] text-sm tracking-wide border-r border-white/5 shadow-[4px_0_24px_rgba(15,26,46,0.15)] flex flex-col py-6">
<div class="px-6 mb-8 flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-white/10 p-2 flex items-center justify-center">
<span class="text-2xl font-bold text-amber-500">SP</span>
</div>
<div>
<h2 class="text-lg font-bold text-white leading-tight">SchoolPulse</h2>
<span class="text-white/60 text-xs">Admin Portal</span>
</div>
</div>

<nav class="flex-1 overflow-y-auto px-4 space-y-2">
<?php
$current_page = basename($_SERVER['PHP_SELF']);
$nav_items = [
    ['href' => 'dashboard.php', 'icon' => 'dashboard', 'label' => 'Dashboard', 'fill' => true],
    ['href' => 'leads.php', 'icon' => 'assignment', 'label' => 'Demo Requests'],
    ['href' => 'contacts.php', 'icon' => 'mail', 'label' => 'Contact Messages'],
    ['href' => 'clients.php', 'icon' => 'groups', 'label' => 'Clients'],
    ['href' => 'profile.php', 'icon' => 'account_circle', 'label' => 'My Profile'],
    ['href' => 'settings.php', 'icon' => 'settings', 'label' => 'Settings'],
];

foreach ($nav_items as $item):
    $is_active = $current_page === $item['href'];
    $active_class = $is_active ? 'border-l-4 border-amber-500 bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5';
    $icon_fill = ($is_active && isset($item['fill'])) ? "style=\"font-variation-settings: 'FILL' 1;\"" : '';
?>
<a class="<?php echo $active_class; ?> py-3 px-6 flex items-center gap-3 transition-colors rounded-r-lg hover:translate-x-1 duration-200" href="<?php echo $item['href']; ?>">
<span class="material-symbols-outlined" <?php echo $icon_fill; ?>><?php echo $item['icon']; ?></span><?php echo $item['label']; ?>
</a>
<?php endforeach; ?>
</nav>

<div class="px-6 mt-auto space-y-4">
<a href="leads.php" class="block w-full bg-gradient-to-r from-on-tertiary-container to-amber-600 text-white font-ui-medium py-3 rounded-[10px] hover:scale-105 transition-transform shadow-lg shadow-amber-900/20 active:opacity-80 text-center">
View All Requests
</a>
<div class="space-y-1">
<a class="text-slate-400 hover:text-white py-2 px-4 flex items-center gap-3 transition-colors rounded-lg text-sm" href="../" target="_blank">
<span class="material-symbols-outlined text-[20px]">open_in_new</span>View Site
</a>
<a class="text-slate-400 hover:text-white py-2 px-4 flex items-center gap-3 transition-colors rounded-lg text-sm" href="logout.php">
<span class="material-symbols-outlined text-[20px]">logout</span>Sign Out
</a>
</div>
</div>
</aside>

<!-- Main Content Area -->
<main class="flex-1 ml-64 flex flex-col h-screen overflow-hidden w-auto">
<!-- TopAppBar -->
<header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 w-full border-b border-slate-200 shadow-[0_2px_8px_rgba(26,39,68,0.06)] flex justify-between items-center px-4 md:px-8 h-16">
<div class="flex items-center gap-4 md:gap-6 flex-1 min-w-0">
<h1 class="text-lg md:text-xl font-extrabold tracking-tight text-[#1a2744] font-['Plus_Jakarta_Sans'] truncate"><?php echo $page_header ?? 'Admin Dashboard'; ?></h1>
<div class="relative w-48 md:w-64 hidden md:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
<input class="w-full bg-surface-container-low border border-outline-variant rounded-full py-1.5 pl-10 pr-4 text-sm font-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/20 transition-all" placeholder="Search..." type="text"/>
</div>
</div>
<div class="flex items-center gap-1 md:gap-2 flex-shrink-0">
<button class="p-2 text-slate-500 hover:bg-slate-50 transition-all duration-200 rounded-full focus:ring-2 focus:ring-[#1a2744]/20 active:scale-95">
<span class="material-symbols-outlined text-[20px] md:text-[24px]">notifications</span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-50 transition-all duration-200 rounded-full focus:ring-2 focus:ring-[#1a2744]/20 active:scale-95">
<span class="material-symbols-outlined text-[20px] md:text-[24px]">settings</span>
</button>
<a href="profile.php" class="ml-2 md:ml-4 h-8 w-8 rounded-full bg-gradient-to-br from-secondary to-primary-container overflow-hidden border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-sm flex-shrink-0 hover:scale-110 transition-transform">
<?php
// Get current user's profile picture
$stmt_user = $pdo->prepare("SELECT profile_picture FROM admin_users WHERE id = ?");
$stmt_user->execute([$_SESSION['admin_id']]);
$current_user = $stmt_user->fetch();

if ($current_user && $current_user['profile_picture']):
?>
    <img src="../<?php echo htmlspecialchars($current_user['profile_picture']); ?>" alt="Profile" class="w-full h-full object-cover">
<?php else: ?>
    <?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?>
<?php endif; ?>
</a>
</div>
</header>

<!-- Scrollable Canvas -->
<div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 bg-surface">
<div class="w-full space-y-4 md:space-y-6 lg:space-y-8">
