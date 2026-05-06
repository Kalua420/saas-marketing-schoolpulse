<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get site settings from database
$site_name = get_setting($pdo, 'site_name', 'SchoolPulse');
$contact_email = get_setting($pdo, 'contact_email', 'hello@schoolpulse.in');
$legal_email = get_setting($pdo, 'legal_email', 'legal@schoolpulse.in');
$contact_phone = get_setting($pdo, 'contact_phone', '+91 98765 43210');
$address = get_setting($pdo, 'address', 'India');

$page_title       = 'Terms of Service | ' . $site_name;
$page_description = 'Read the ' . $site_name . ' Terms of Service. Understand your rights and responsibilities when using our school management platform.';
$page_css         = ['assets/css/legal.css'];

require_once 'includes/header.php';
?>

<main id="legal-page-wrap">

<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="legal-hero">
  <div class="legal-hero-inner">
    <h1>Terms of Service</h1>
    <p class="legal-hero-sub">Last updated: January 1, 2024 &nbsp;·&nbsp; Please read these terms carefully before using <?php echo htmlspecialchars($site_name); ?>.</p>
  </div>
</section>

<!-- ── Canvas ────────────────────────────────────────────────── -->
<div class="legal-canvas-wrap">
  <div class="legal-canvas">

    <!-- 1 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">1</span>
        <h2>Acceptance of Terms</h2>
      </div>
      <p>By accessing or using the <?php echo htmlspecialchars($site_name); ?> platform ("Service"), provided by <?php echo htmlspecialchars($site_name); ?>, you agree to be bound by these Terms of Service. If you are entering into this agreement on behalf of a school, educational institution, or other legal entity, you represent that you have the authority to bind such entity to these terms.</p>
      <p>If you do not agree with any of these terms, you are prohibited from using our services.</p>
    </div>

    <!-- 2 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">2</span>
        <h2>Description of Service</h2>
      </div>
      <p><?php echo htmlspecialchars($site_name); ?> provides a comprehensive cloud-based enterprise resource planning (ERP) and student information system designed to optimize administrative efficiency, academic tracking, and communication within educational institutions. The Service includes:</p>
      <ul>
        <li>Student information management</li>
        <li>Academic and administrative tools</li>
        <li>Communication platforms</li>
        <li>Financial management features</li>
        <li>Reporting and analytics</li>
      </ul>
      <p>We reserve the right to modify, suspend, or discontinue any part of our service at any time with reasonable notice.</p>
    </div>

    <!-- 3 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">3</span>
        <h2>User Accounts and Registration</h2>
      </div>
      <div class="legal-subsection">
        <h3>3.1 Account Creation</h3>
        <p>To access certain features of the Service, you must register for an account. You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate and complete. You are responsible for:</p>
        <ul>
          <li>Maintaining the confidentiality of your account credentials</li>
          <li>All activities that occur under your account</li>
          <li>Notifying us immediately of any unauthorized use</li>
        </ul>

        <h3>3.2 Account Responsibility</h3>
        <p>Institutions are responsible for managing sub-accounts for staff, students, and parents. You are responsible for safeguarding your credentials and for all activities that occur under your account.</p>

        <h3>3.3 Authorized Users</h3>
        <p>You may grant access to authorized users within your organization. You remain responsible for all actions taken by these users.</p>
      </div>
    </div>

    <!-- 4 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">4</span>
        <h2>Acceptable Use Policy</h2>
      </div>
      <p>You agree not to use our services to:</p>
      <ul>
        <li>Violate any applicable laws or regulations</li>
        <li>Infringe on intellectual property rights</li>
        <li>Upload malicious software or harmful content</li>
        <li>Decompile, reverse engineer, or attempt to extract the source code of the software</li>
        <li>Attempt to gain unauthorized access to our systems or circumvent any security measures</li>
        <li>Interfere with or disrupt our services</li>
        <li>Use the service for any unlawful or prohibited purpose</li>
      </ul>
    </div>

    <!-- 5 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">5</span>
        <h2>Data Privacy and Security</h2>
      </div>
      <p>Your use of the Service is also governed by our <a href="privacy.php">Privacy Policy</a>. We implement industry-standard security measures to protect institutional and student data. You acknowledge that data is hosted on secure cloud infrastructure located in India.</p>
      <div class="legal-subsection">
        <h3>5.1 Your Data</h3>
        <p>You retain ownership of all data you input into our system. We act as a data processor and will:</p>
        <ul>
          <li>Process your data only as instructed by you</li>
          <li>Implement appropriate security measures</li>
          <li>Not use your data for our own purposes</li>
          <li>Return or delete your data upon termination</li>
        </ul>

        <h3>5.2 Data Protection</h3>
        <p>We comply with applicable data protection laws and maintain appropriate technical and organizational measures to protect your data.</p>
      </div>
    </div>

    <!-- 6 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">6</span>
        <h2>Subscription and Payment</h2>
      </div>
      <div class="legal-subsection">
        <h3>6.1 Subscription Fees</h3>
        <p>Access to <?php echo htmlspecialchars($site_name); ?> is provided on a subscription basis. You agree to pay all applicable fees as described in your chosen plan.</p>

        <h3>6.2 Billing</h3>
        <ul>
          <li>Fees are billed in advance on a monthly or annual basis</li>
          <li>All fees are non-refundable unless otherwise specified in a signed service level agreement</li>
          <li>We may change our pricing with 30 days' notice</li>
          <li>Failure to pay subscription fees may result in suspension of access to institutional data</li>
        </ul>

        <h3>6.3 Free Trial</h3>
        <p>We may offer free trials. At the end of the trial period, you will be charged unless you cancel before the trial expires.</p>
      </div>
    </div>

    <!-- 7 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">7</span>
        <h2>Intellectual Property</h2>
      </div>
      <div class="legal-subsection">
        <h3>7.1 Our Rights</h3>
        <p><?php echo htmlspecialchars($site_name); ?> and all related trademarks, logos, and intellectual property are owned by us. You may not use our intellectual property without written permission.</p>

        <h3>7.2 Your Rights</h3>
        <p>You retain all rights to your content and data. By using our service, you grant us a limited license to process and display your content as necessary to provide our services.</p>
      </div>
    </div>

    <!-- 8 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">8</span>
        <h2>Service Availability</h2>
      </div>
      <div class="legal-subsection">
        <h3>8.1 Uptime</h3>
        <p>We strive to maintain 99.9% uptime but cannot guarantee uninterrupted service. We may perform maintenance that temporarily affects availability.</p>

        <h3>8.2 Support</h3>
        <p>Support is provided according to your subscription plan. We aim to respond to support requests within 24 hours during business days.</p>
      </div>
    </div>

    <!-- 9 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">9</span>
        <h2>Limitation of Liability</h2>
      </div>
      <p>To the maximum extent permitted by law:</p>
      <ul>
        <li>Our total liability shall not exceed the amount paid by you in the 12 months preceding the claim</li>
        <li>We are not liable for indirect, incidental, or consequential damages</li>
        <li>We do not warrant that our service will be error-free or uninterrupted</li>
      </ul>
    </div>

    <!-- 10 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">10</span>
        <h2>Indemnification</h2>
      </div>
      <p>You agree to indemnify and hold us harmless from any claims, damages, or expenses arising from:</p>
      <ul>
        <li>Your use of our services</li>
        <li>Your violation of these terms</li>
        <li>Your violation of any third-party rights</li>
      </ul>
    </div>

    <!-- 11 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">11</span>
        <h2>Termination</h2>
      </div>
      <div class="legal-subsection">
        <h3>11.1 By You</h3>
        <p>You may terminate your account at any time by contacting us or using the cancellation feature in your account settings.</p>

        <h3>11.2 By Us</h3>
        <p>We may terminate your account if you violate these terms, fail to pay applicable fees, or engage in prohibited activities.</p>

        <h3>11.3 Effect of Termination</h3>
        <p>Upon termination, your access will cease and we will delete your data within 30 days unless legally required to retain it.</p>
      </div>
    </div>

    <!-- 12 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">12</span>
        <h2>Changes to Terms</h2>
      </div>
      <p>We may update these terms from time to time. We will notify you of material changes by posting updated terms on our website, sending email notifications, and displaying notices in our application. Continued use of our services after changes constitutes acceptance of the new terms.</p>
    </div>

    <!-- 13 -->
    <div class="legal-section">
      <div class="legal-section-title">
        <span class="legal-section-num">13</span>
        <h2>Governing Law</h2>
      </div>
      <p>These terms shall be governed by and construed in accordance with the laws of India. Any disputes arising from these terms shall be subject to the exclusive jurisdiction of the courts in Gurugram, Haryana.</p>
    </div>

    <!-- Contact card -->
    <div class="legal-contact-card">
      <div class="legal-contact-icon">
        <span class="material-symbols-outlined">gavel</span>
      </div>
      <div>
        <h4>Legal Contact &amp; Jurisdiction</h4>
        <p>For questions about these terms or to reach our legal team, use the contact details below.</p>
        <div class="legal-contact-details">
          <span><strong><?php echo htmlspecialchars($site_name); ?></strong></span>
          <span><?php echo nl2br(htmlspecialchars($address)); ?></span>
          <span><?php echo htmlspecialchars($contact_phone); ?></span>
          <a href="mailto:<?php echo htmlspecialchars($legal_email); ?>" class="legal-email"><?php echo htmlspecialchars($legal_email); ?></a>
        </div>
      </div>
    </div>

  </div><!-- /.legal-canvas -->
</div><!-- /.legal-canvas-wrap -->

<!-- ── Anchor image ───────────────────────────────────────────── -->
<div class="legal-anchor-section">
  <div class="legal-anchor-card">
    <div class="legal-anchor-placeholder">
      <div class="legal-anchor-overlay" style="position:static;background:none;padding:0;">
        <div>
          <h3 style="font-family:'Poppins',sans-serif;font-size:28px;font-weight:700;color:#fff;margin:0 0 8px;">Built on Trust</h3>
          <p style="font-size:15px;color:#cbd5e1;margin:0;max-width:480px;">Empowering over 500+ institutions across India with secure, transparent, and efficient management systems.</p>
        </div>
      </div>
    </div>
  </div>
</div>

</main>

<?php require_once 'includes/footer.php'; ?>
