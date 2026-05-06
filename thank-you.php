<?php
require_once 'includes/functions.php';

$type = $_GET['type'] ?? 'demo';

// Page meta varies by type
$page_titles = [
  'demo'    => 'Demo Request Received | SchoolPulse',
  'contact' => 'Message Sent | SchoolPulse',
];
$page_title       = $page_titles[$type] ?? 'Thank You | SchoolPulse';
$page_description = 'Thank you for reaching out to SchoolPulse. Our team will be in touch shortly.';
$page_css         = ['assets/css/thank-you.css'];

include 'includes/header.php';
?>

<main id="ty-page-wrap">

  <!-- ── Confirmation card ──────────────────────────────────── -->
  <div class="ty-card">

    <div class="ty-icon-wrap">
      <span class="material-symbols-outlined">check_circle</span>
    </div>

    <?php if ($type === 'demo'): ?>

      <h1>Demo Request Received!</h1>
      <p class="ty-lead">Thank you for your interest in SchoolPulse. We've received your demo request and our team will contact you within 24 hours to schedule a personalized demonstration.</p>

      <div class="ty-steps">
        <div class="ty-steps-title">
          <span class="material-symbols-outlined">timeline</span>
          What happens next?
        </div>
        <ul class="ty-steps-list">
          <li>
            <span class="material-symbols-outlined">call</span>
            Our team will call you within 24 hours
          </li>
          <li>
            <span class="material-symbols-outlined">calendar_month</span>
            We'll schedule a demo at your convenience
          </li>
          <li>
            <span class="material-symbols-outlined">school</span>
            You'll see SchoolPulse customized for your school
          </li>
          <li>
            <span class="material-symbols-outlined">quiz</span>
            Get answers to all your questions from our experts
          </li>
        </ul>
      </div>

    <?php elseif ($type === 'contact'): ?>

      <h1>Message Sent!</h1>
      <p class="ty-lead">Thank you for contacting us. We've received your message and will get back to you within 1–2 business days.</p>

      <div class="ty-steps">
        <div class="ty-steps-title">
          <span class="material-symbols-outlined">timeline</span>
          What happens next?
        </div>
        <ul class="ty-steps-list">
          <li>
            <span class="material-symbols-outlined">mark_email_read</span>
            You'll receive a confirmation email shortly
          </li>
          <li>
            <span class="material-symbols-outlined">support_agent</span>
            Our support team will review your message
          </li>
          <li>
            <span class="material-symbols-outlined">reply</span>
            We'll respond within 1–2 business days
          </li>
        </ul>
      </div>

    <?php else: ?>

      <h1>Thank You!</h1>
      <p class="ty-lead">Your submission has been received successfully. We'll be in touch soon.</p>

    <?php endif; ?>

    <div class="ty-actions">
      <a href="index.php" class="ty-btn-primary">
        <span class="material-symbols-outlined" style="font-size:18px;">home</span>
        Back to Home
      </a>
      <a href="features.php" class="ty-btn-secondary">
        <span class="material-symbols-outlined" style="font-size:18px;">featured_play_list</span>
        Explore Features
      </a>
    </div>

  </div>

  <!-- ── Discovery section ──────────────────────────────────── -->
  <div class="ty-discover">
    <div class="ty-discover-header">
      <h2>While you wait, explore more</h2>
      <div class="ty-discover-divider"></div>
    </div>

    <div class="ty-discover-grid">

      <div class="ty-disc-card">
        <div class="ty-disc-icon ty-disc-icon--blue">
          <span class="material-symbols-outlined">featured_play_list</span>
        </div>
        <h4>Features</h4>
        <p>Discover all the powerful features that make SchoolPulse the complete solution for institutional management.</p>
        <a href="features.php" class="ty-disc-link">
          Learn more
          <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>

      <div class="ty-disc-card">
        <div class="ty-disc-icon ty-disc-icon--amber">
          <span class="material-symbols-outlined">payments</span>
        </div>
        <h4>Pricing</h4>
        <p>See our transparent pricing plans designed for schools of all sizes, from local academies to large institutions.</p>
        <a href="pricing.php" class="ty-disc-link">
          View plans
          <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>

      <div class="ty-disc-card">
        <div class="ty-disc-icon ty-disc-icon--green">
          <span class="material-symbols-outlined">school</span>
        </div>
        <h4>Explore More</h4>
        <p>Discover how SchoolPulse can transform your institution's administrative operations and efficiency.</p>
        <a href="features.php" class="ty-disc-link">
          View features
          <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>

    </div>
  </div>

</main>

<?php include 'includes/footer.php'; ?>
