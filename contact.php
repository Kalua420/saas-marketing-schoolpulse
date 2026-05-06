<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title       = 'Contact Us - SchoolPulse';
$page_description = 'Get in touch with the SchoolPulse team. We\'re here to help you transform your school management.';
$page_css         = ['assets/css/contact.css'];

require_once 'includes/header.php';
?>

<main>

<header class="c-hero">
  <div class="container">
    <div class="c-hero-inner">
      <span class="c-hero-badge">Connect with our team</span>
      <h1>Get in Touch</h1>
      <p>Transforming institution administration starts with a conversation. Our experts are standing by to help you navigate the SchoolPulse ecosystem.</p>
    </div>
  </div>
</header>

<section class="c-contact-section">
  <div class="c-contact-wrap">
    <div class="c-contact-grid">

      <div class="c-form-card">
        <h2>Send us a Message</h2>
        <form id="contactForm">
          <div class="c-form-grid">
            <div class="c-form-group">
              <label for="firstName">First Name</label>
              <input type="text" id="firstName" name="firstName" placeholder="Arjun" required>
            </div>
            <div class="c-form-group">
              <label for="lastName">Last Name</label>
              <input type="text" id="lastName" name="lastName" placeholder="Sharma" required>
            </div>
            <div class="c-form-group">
              <label for="email">Work Email</label>
              <input type="email" id="email" name="email" placeholder="principal@school.edu.in" required>
            </div>
            <div class="c-form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="+91 00000 00000">
            </div>
            <div class="c-form-group full">
              <label for="schoolName">School Name</label>
              <input type="text" id="schoolName" name="schoolName" placeholder="Central Academy Senior Secondary School" required>
            </div>
            <div class="c-form-group full">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="5" placeholder="Tell us about your institution's goals..." required></textarea>
            </div>
            <div class="full">
              <button type="submit" class="c-submit-btn" id="submitBtn">
                <span class="btn-text">Send Inquiry <i class="fas fa-paper-plane" style="font-size:.85rem;"></i></span>
                <span class="btn-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Sending…</span>
              </button>
              <div id="contactFormMessage" class="c-form-msg"></div>
            </div>
          </div>
        </form>
      </div>

      <div class="c-info-col">
        <div class="c-info-card">
          <div class="c-info-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <h4>Corporate HQ</h4>
            <p>Tech Hub, 4th Floor, Sector 62,<br>Gurgaon, Haryana 122001, India</p>
          </div>
        </div>
        <div class="c-contact-pair">
          <div class="c-contact-pair-item">
            <div class="c-info-icon blue"><i class="fas fa-phone"></i></div>
            <div>
              <div class="c-pair-label">Call Us</div>
              <div class="c-pair-value">+91 123 456 7890</div>
            </div>
          </div>
          <div class="c-contact-pair-item">
            <div class="c-info-icon amber"><i class="fas fa-envelope"></i></div>
            <div>
              <div class="c-pair-label">Email Us</div>
              <div class="c-pair-value">hello@schoolpulse.in</div>
            </div>
          </div>
        </div>
        <div class="c-support-card">
          <h3>Dedicated Support</h3>
          <p>Existing customer? Access our 24/7 technical helpdesk for immediate assistance.</p>
          <a href="contact.php" class="c-support-link">Help Center <i class="fas fa-external-link-alt" style="font-size:.75rem;"></i></a>
          <div class="c-support-bg-icon"><i class="fas fa-headset"></i></div>
        </div>
        <div class="c-social-row">
          <span>Follow us</span>
          <div class="c-social-links">
            <a href="#" aria-label="Website"><i class="fas fa-globe"></i></a>
            <a href="#" aria-label="Forum"><i class="fas fa-comments"></i></a>
            <a href="#" aria-label="Share"><i class="fas fa-share-alt"></i></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="c-faq-section">
  <div class="container">
    <div class="section-header">
      <h2>Quick Answers</h2>
      <p>Common inquiries to help you get started faster.</p>
    </div>
    <div class="c-faq-grid">
      <div class="c-faq-card">
        <i class="fas fa-bolt c-faq-card-icon blue"></i>
        <h3>Fast Deployment</h3>
        <p>Standard rollout in <strong>72 hours</strong> with full migration support from our onboarding team.</p>
      </div>
      <div class="c-faq-card">
        <i class="fas fa-shield-alt c-faq-card-icon green"></i>
        <h3>Secure Data</h3>
        <p>AES-256 encryption &amp; multi-region cloud hosting with <strong>99.9% uptime</strong> SLA.</p>
      </div>
      <div class="c-faq-card">
        <i class="fas fa-mobile-alt c-faq-card-icon amber"></i>
        <h3>Mobile First</h3>
        <p>Native iOS/Android apps for admins, teachers, and parents included in all plans.</p>
      </div>
      <div class="c-faq-card">
        <i class="fas fa-rupee-sign c-faq-card-icon dark"></i>
        <h3>Scalable Pricing</h3>
        <p>Pay per student. No hidden costs or mandatory long-term contracts required.</p>
      </div>
    </div>
  </div>
</section>

<section class="c-map-section">
  <div class="container">
    <div class="c-map-wrap">
      <div class="c-map-ping">
        <div class="c-map-ping-ring"></div>
        <div class="c-map-ping-dot"></div>
      </div>
      <div class="c-map-overlay">
        <div class="c-map-card">
          <div class="c-map-icon"><i class="fas fa-building"></i></div>
          <h2>Visit Our Office</h2>
          <p>Schedule a personal demo at our headquarters in Gurgaon's Tech District.</p>
          <a href="https://maps.google.com/?q=Sector+62+Gurgaon+Haryana" target="_blank" rel="noopener" class="c-map-btn">
            <i class="fas fa-directions"></i> Get Directions
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

<script>
document.getElementById('contactForm').addEventListener('submit', async function (e) {
  e.preventDefault();
  const form    = this;
  const btn     = document.getElementById('submitBtn');
  const btnText = btn.querySelector('.btn-text');
  const btnLoad = btn.querySelector('.btn-loading');
  const msgDiv  = document.getElementById('contactFormMessage');
  btnText.style.display = 'none';
  btnLoad.style.display = 'inline-flex';
  btn.disabled = true;
  try {
    const res    = await fetch('api/submit-contact.php', { method: 'POST', body: new FormData(form) });
    const result = await res.json();
    if (result.success) {
      msgDiv.className   = 'c-form-msg success';
      msgDiv.textContent = "Thank you! We'll get back to you within 24 hours.";
      form.reset();
    } else { throw new Error(result.message || 'Something went wrong'); }
  } catch (err) {
    msgDiv.className   = 'c-form-msg error';
    msgDiv.textContent = 'Sorry, there was an error. Please try again or email us directly.';
  }
  btnText.style.display = 'inline';
  btnLoad.style.display = 'none';
  btn.disabled = false;
  msgDiv.style.display  = 'block';
  msgDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
});
</script>

<?php require_once 'includes/footer.php'; ?>
