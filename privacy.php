<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get site settings from database
$site_name = get_setting($pdo, 'site_name', 'SchoolPulse');
$contact_email = get_setting($pdo, 'contact_email', 'hello@schoolpulse.in');
$contact_phone = get_setting($pdo, 'contact_phone', '+91 98765 43210');
$address = get_setting($pdo, 'address', 'India');

$page_title       = 'Privacy Policy | ' . $site_name;
$page_description = 'Read the ' . $site_name . ' Privacy Policy. Learn how we collect, use, and protect your data and student information.';
$page_css         = ['assets/css/legal.css'];

require_once 'includes/header.php';
?>

<main id="legal-page-wrap">

<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="legal-hero">
  <div class="legal-hero-inner">
    <h1>Privacy Policy</h1>
    <p class="legal-hero-sub">Last updated: January 1, 2024 &nbsp;·&nbsp; Your privacy is important to us.</p>
  </div>
</section>

<!-- ── Canvas ────────────────────────────────────────────────── -->
<div class="legal-canvas-wrap">
  <div class="legal-canvas">

    <!-- 1 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">1</span>
        <h2>Information We Collect</h2>
      </div>
      <div class="legal-subsection">
        <h3>1.1 Information You Provide</h3>
        <p>We collect information you provide directly to us, including:</p>
        <ul>
          <li>Account registration information (name, email, phone number)</li>
          <li>School and institutional details</li>
          <li>Student and staff information entered into the system</li>
          <li>Communication preferences and settings</li>
          <li>Support requests and correspondence</li>
        </ul>

        <h3>1.2 Information We Collect Automatically</h3>
        <p>When you use our services, we automatically collect:</p>
        <ul>
          <li>Usage data and analytics</li>
          <li>Device information and IP addresses</li>
          <li>Browser type and operating system</li>
          <li>Log files and system activity</li>
        </ul>
      </div>
    </div>

    <!-- 2 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">2</span>
        <h2>How We Use Your Information</h2>
      </div>
      <p>We use the information we collect to:</p>
      <ul>
        <li>Provide and maintain our school management services</li>
        <li>Process transactions and manage accounts</li>
        <li>Send important notifications and updates</li>
        <li>Provide customer support and technical assistance</li>
        <li>Improve our services and develop new features</li>
        <li>Ensure security and prevent fraud</li>
        <li>Comply with legal obligations</li>
      </ul>
    </div>

    <!-- 3 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">3</span>
        <h2>Information Sharing and Disclosure</h2>
      </div>
      <div class="legal-subsection">
        <h3>3.1 We Do Not Sell Your Data</h3>
        <p>We do not sell, rent, or trade your personal information to third parties for marketing purposes.</p>

        <h3>3.2 Limited Sharing</h3>
        <p>We may share your information only in the following circumstances:</p>
        <ul>
          <li><strong>With your consent:</strong> When you explicitly authorize us to share information</li>
          <li><strong>Service providers:</strong> With trusted third-party vendors who help us operate our services</li>
          <li><strong>Legal requirements:</strong> When required by law or to protect our rights</li>
          <li><strong>Business transfers:</strong> In connection with mergers or acquisitions</li>
        </ul>
      </div>
    </div>

    <!-- 4 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">4</span>
        <h2>Data Security</h2>
      </div>
      <p>We implement comprehensive security measures to protect your information:</p>
      <ul>
        <li><strong>Encryption:</strong> All data is encrypted in transit and at rest</li>
        <li><strong>Access controls:</strong> Strict role-based access to your data</li>
        <li><strong>Regular audits:</strong> Ongoing security assessments and monitoring</li>
        <li><strong>Secure infrastructure:</strong> Data stored in secure, certified data centers in India</li>
        <li><strong>Backup and recovery:</strong> Regular backups with secure recovery procedures</li>
      </ul>
    </div>

    <!-- 5 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">5</span>
        <h2>Data Retention</h2>
      </div>
      <p>We retain your information for as long as necessary to:</p>
      <ul>
        <li>Provide our services to you</li>
        <li>Comply with legal obligations</li>
        <li>Resolve disputes and enforce agreements</li>
      </ul>
      <p>When you cancel your account, we will delete your data within 30 days, except where retention is required by law.</p>
    </div>

    <!-- 6 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">6</span>
        <h2>Your Rights and Choices</h2>
      </div>
      <p>You have the following rights regarding your personal information:</p>
      <ul>
        <li><strong>Access:</strong> Request a copy of your personal data</li>
        <li><strong>Correction:</strong> Update or correct inaccurate information</li>
        <li><strong>Deletion:</strong> Request deletion of your personal data</li>
        <li><strong>Portability:</strong> Export your data in a standard format</li>
        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
      </ul>
      <p>To exercise these rights, contact us at <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>"><?php echo htmlspecialchars($contact_email); ?></a></p>
    </div>

    <!-- 7 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">7</span>
        <h2>Children's Privacy</h2>
      </div>
      <p>Our services are designed for educational institutions and may contain information about students under 18. We:</p>
      <ul>
        <li>Only collect student information as directed by schools</li>
        <li>Do not use student data for advertising or marketing</li>
        <li>Provide parents with access to their child's information</li>
        <li>Allow parents to request correction or deletion of their child's data</li>
      </ul>
    </div>

    <!-- 8 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">8</span>
        <h2>International Data Transfers</h2>
      </div>
      <p>Your data is primarily stored and processed in India. If we transfer data internationally, we ensure appropriate safeguards are in place to protect your information in compliance with applicable data protection laws.</p>
    </div>

    <!-- 9 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">9</span>
        <h2>Cookies and Tracking</h2>
      </div>
      <p>We use cookies and similar technologies to:</p>
      <ul>
        <li>Remember your preferences and settings</li>
        <li>Analyze usage patterns and improve our services</li>
        <li>Provide security features</li>
      </ul>
      <p>You can control cookie settings through your browser preferences.</p>
    </div>

    <!-- 10 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">10</span>
        <h2>Updates to This Policy</h2>
      </div>
      <p>We may update this privacy policy from time to time. We will notify you of any material changes by posting the updated policy on our website, sending email notifications to registered users, and displaying prominent notices in our application.</p>
    </div>

    <!-- 11 — Contact -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">11</span>
        <h2>Contact Us</h2>
      </div>
      <p>If you have questions about this privacy policy or our data practices, please reach out to our privacy team.</p>
    </div>

    <!-- Contact card -->
    <div class="legal-contact-card">
      <div class="legal-contact-icon">
        <span class="material-symbols-outlined">shield_person</span>
      </div>
      <div>
        <h4>Privacy Team</h4>
        <p>Our dedicated privacy team is available to answer any questions about how we handle your data.</p>
        <div class="legal-contact-details">
          <span><strong><?php echo htmlspecialchars($site_name); ?></strong></span>
          <span><?php echo nl2br(htmlspecialchars($address)); ?></span>
          <span><?php echo htmlspecialchars($contact_phone); ?></span>
          <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>" class="legal-email"><?php echo htmlspecialchars($contact_email); ?></a>
        </div>
      </div>
    </div>

  </div><!-- /.legal-canvas -->
</div><!-- /.legal-canvas-wrap -->

<!-- ── Anchor image ───────────────────────────────────────────── -->
<div class="legal-anchor-section">
  <div class="legal-anchor-card">
    <div class="legal-anchor-placeholder">
      <div style="padding:40px 48px;">
        <h3 style="font-family:'Poppins',sans-serif;font-size:28px;font-weight:700;color:#fff;margin:0 0 8px;">Your Data, Protected</h3>
        <p style="font-size:15px;color:#cbd5e1;margin:0;max-width:480px;">We are committed to the highest standards of data security and privacy for every institution and student on our platform.</p>
      </div>
    </div>
  </div>
</div>

</main>

<?php require_once 'includes/footer.php'; ?>
