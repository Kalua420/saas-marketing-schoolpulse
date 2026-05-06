<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'SchoolPulse - Complete School Management System'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? htmlspecialchars($page_description) : 'Transform your school management with SchoolPulse. Streamline admissions, attendance, fees, and communication in one powerful platform.'; ?>">
    <meta name="keywords" content="school management system, student management, fee management, attendance system, school software, education technology, India">
    <meta name="author" content="SchoolPulse">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo isset($page_title) ? htmlspecialchars($page_title) : 'SchoolPulse - Complete School Management System'; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? htmlspecialchars($page_description) : 'Transform your school management with SchoolPulse'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://schoolpulse.in">

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏫</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Shared styles: navbar + footer -->
    <link rel="stylesheet" href="assets/css/shared.css">

    <!-- Page-specific stylesheet (set $page_css before including this file) -->
    <?php if (!empty($page_css)): ?>
        <?php foreach ((array)$page_css as $css): ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($css); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<nav class="navbar" id="navbar" style="
  position: fixed; top: 0; width: 100%; z-index: 9999;
  background: rgba(255,255,255,0.97);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid #e2e8f0;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  font-family: 'Inter', sans-serif;
">
  <div style="max-width:1280px; margin:0 auto; padding:0 32px; display:flex; align-items:center; justify-content:space-between; height:68px;">

    <!-- Brand -->
    <a href="index.php" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
      <div style="width:36px;height:36px;background:linear-gradient(135deg,#1e293b,#0f172a);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-school" style="color:#fcd34d;font-size:16px;"></i>
      </div>
      <span style="font-family:'Poppins',sans-serif;font-weight:700;font-size:20px;color:#0f172a;letter-spacing:-0.02em;">SchoolPulse</span>
    </a>

    <!-- Desktop nav -->
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <ul id="nav-links" style="display:flex;align-items:center;gap:4px;list-style:none;margin:0;padding:0;">
      <?php
      // Primary nav — only top-level destination pages
      $nav_items = [
        ['index.php',    'Home'],
        ['features.php', 'Features'],
        ['pricing.php',  'Pricing'],
        ['contact.php',  'Contact'],
        ['demo.php',     'Get Demo'],
      ];

      // Pages that are active-detected but not shown as nav links
      $active_map = [];
      $effective_current = $active_map[$current] ?? $current;

      foreach ($nav_items as [$href, $label]):
        $active = $effective_current === $href;
      ?>
      <li>
        <a href="<?php echo $href; ?>" style="
          display:block; padding:8px 14px; border-radius:8px;
          font-size:15px; font-weight:600; text-decoration:none;
          color: <?php echo $active ? '#0058be' : '#475569'; ?>;
          background: <?php echo $active ? '#eff6ff' : 'transparent'; ?>;
          transition: color .2s, background .2s;
        "
        onmouseover="if(!<?php echo $active ? 'true' : 'false'; ?>){this.style.color='#0058be';this.style.background='#f8fafc';}"
        onmouseout="if(!<?php echo $active ? 'true' : 'false'; ?>){this.style.color='#475569';this.style.background='transparent';}">
          <?php echo $label; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>

    <!-- Actions -->
    <div style="display:flex;align-items:center;gap:10px;">
      <a href="admin/login.php" style="
        padding:8px 16px; border-radius:8px; font-size:15px; font-weight:600;
        color:#475569; text-decoration:none; transition:color .2s;
      "
      onmouseover="this.style.color='#0f172a';"
      onmouseout="this.style.color='#475569';">
        Login
      </a>
      <a href="demo.php" style="
        padding:9px 20px; border-radius:10px; font-size:15px; font-weight:600;
        background:linear-gradient(135deg,#f59e0b,#d97706);
        color:#fff; text-decoration:none;
        box-shadow:0 4px 14px rgba(245,158,11,.35);
        transition:transform .15s, box-shadow .15s;
        display:flex; align-items:center; gap:6px;
      "
      onmouseover="this.style.transform='scale(1.03)';this.style.boxShadow='0 6px 20px rgba(245,158,11,.45)';"
      onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 14px rgba(245,158,11,.35)';">
        Get a Demo
      </a>
      <!-- Mobile hamburger -->
      <button id="mobile-menu-btn" aria-label="Toggle menu" style="
        display:none; flex-direction:column; gap:5px; background:none;
        border:none; cursor:pointer; padding:6px;
      ">
        <span style="display:block;width:22px;height:2px;background:#475569;border-radius:2px;transition:.3s;"></span>
        <span style="display:block;width:22px;height:2px;background:#475569;border-radius:2px;transition:.3s;"></span>
        <span style="display:block;width:22px;height:2px;background:#475569;border-radius:2px;transition:.3s;"></span>
      </button>
    </div>

  </div>

  <!-- Mobile drawer -->
  <div id="mobile-drawer" style="
    display:none; flex-direction:column; gap:4px;
    padding:12px 24px 20px; border-top:1px solid #f1f5f9;
    background:rgba(255,255,255,0.98);
  ">
    <?php foreach ($nav_items as [$href, $label]): ?>
    <a href="<?php echo $href; ?>" style="
      padding:10px 14px; border-radius:8px; font-size:15px; font-weight:600;
      color:<?php echo ($effective_current === $href) ? '#0058be' : '#475569'; ?>;
      background:<?php echo ($effective_current === $href) ? '#eff6ff' : 'transparent'; ?>;
      text-decoration:none;
    "><?php echo $label; ?></a>
    <?php endforeach; ?>
    <a href="admin/login.php" style="padding:10px 14px;border-radius:8px;font-size:15px;font-weight:600;color:#475569;text-decoration:none;">Login</a>
  </div>
</nav>

<!-- Push content below fixed nav -->
<div style="height:68px;"></div>

<script>
(function(){
  var btn    = document.getElementById('mobile-menu-btn');
  var drawer = document.getElementById('mobile-drawer');

  // Show hamburger on mobile
  function checkWidth(){
    var isMobile = window.innerWidth < 768;
    btn.style.display    = isMobile ? 'flex' : 'none';
    document.getElementById('nav-links').style.display = isMobile ? 'none' : 'flex';
  }
  checkWidth();
  window.addEventListener('resize', checkWidth);

  btn.addEventListener('click', function(){
    var open = drawer.style.display === 'flex';
    drawer.style.display = open ? 'none' : 'flex';
  });
})();
</script>
