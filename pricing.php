<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title       = 'Pricing - SchoolPulse';
$page_description = 'Simple, transparent pricing for every school. Start free, scale as you grow.';
$page_css         = ['assets/css/pricing.css'];

require_once 'includes/header.php';
?>

<main>

<section class="p-hero">
  <div class="container">
    <div class="p-hero-inner">
      <h1>Simple, Transparent Pricing</h1>
      <p>Modern institutional management doesn't have to be complex. Choose the plan that scales with your growth.</p>
      <div class="billing-toggle">
        <span>Monthly</span>
        <label class="toggle-track">
          <input type="checkbox" id="billingToggle">
          <span class="toggle-thumb"></span>
        </label>
        <span>Annual <span class="save-badge">Save 20%</span></span>
      </div>
    </div>
  </div>
</section>

<section class="plans-section">
  <div class="plans-grid-wrap">
    <div class="plans-grid">

      <div class="plan-card">
        <div class="plan-name">Starter</div>
        <div class="plan-tagline">Ideal for small private academies and learning centers.</div>
        <div class="plan-price-row">
          <span class="plan-currency">₹</span>
          <span class="plan-amount" data-monthly="2,999" data-annual="2,399">2,999</span>
          <span class="plan-period">/mo</span>
        </div>
        <ul class="plan-feature-list">
          <li><i class="fas fa-check-circle fi-check"></i>Up to 200 Students</li>
          <li><i class="fas fa-check-circle fi-check"></i>Basic Attendance Tracking</li>
          <li><i class="fas fa-check-circle fi-check"></i>Student Information System</li>
          <li><i class="fas fa-check-circle fi-check"></i>Automated Report Cards</li>
        </ul>
        <a href="demo.php" class="btn-plan-border">Start Free Trial</a>
      </div>

      <div class="plan-card featured">
        <span class="plan-popular-badge">Most Popular</span>
        <div class="plan-name">Professional</div>
        <div class="plan-tagline">Perfect for growing schools with full administrative needs.</div>
        <div class="plan-price-row">
          <span class="plan-currency">₹</span>
          <span class="plan-amount" data-monthly="5,999" data-annual="4,799">5,999</span>
          <span class="plan-period">/mo</span>
        </div>
        <ul class="plan-feature-list">
          <li><i class="fas fa-check-circle fi-check"></i><strong>Everything in Starter +</strong></li>
          <li><i class="fas fa-check-circle fi-check"></i>Up to 1,000 Students</li>
          <li><i class="fas fa-check-circle fi-check"></i>Online Fee Collection</li>
          <li><i class="fas fa-check-circle fi-check"></i>SMS &amp; Email Notifications</li>
          <li><i class="fas fa-check-circle fi-check"></i>Staff Payroll Management</li>
        </ul>
        <a href="demo.php" class="btn-plan-solid">Start Free Trial</a>
      </div>

      <div class="plan-card">
        <div class="plan-name">Enterprise</div>
        <div class="plan-tagline">Scalable solution for school groups and large institutions.</div>
        <div class="plan-price-row">
          <span class="plan-currency">₹</span>
          <span class="plan-amount" data-monthly="12,999" data-annual="10,399">12,999</span>
          <span class="plan-period">/mo</span>
        </div>
        <ul class="plan-feature-list">
          <li><i class="fas fa-check-circle fi-check"></i><strong>Everything in Professional +</strong></li>
          <li><i class="fas fa-check-circle fi-check"></i>Unlimited Students</li>
          <li><i class="fas fa-check-circle fi-check"></i>Biometric Integration</li>
          <li><i class="fas fa-check-circle fi-check"></i>API Access for Customization</li>
          <li><i class="fas fa-check-circle fi-check"></i>Dedicated Account Manager</li>
        </ul>
        <a href="demo.php" class="btn-plan-border">Start Free Trial</a>
      </div>

    </div>
  </div>
</section>

<section class="compare-section">
  <div class="container">
    <div class="section-center">
      <h2>Compare Our Capabilities</h2>
      <p>Every feature you need to run a high-performing school.</p>
    </div>
    <div class="compare-outer">
      <table class="compare-table">
        <thead>
          <tr>
            <th style="text-align:left;">Features</th>
            <th>Starter</th>
            <th>Professional</th>
            <th>Enterprise</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Student Info System (SIS)</td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
          <tr>
            <td>Attendance Management</td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
          <tr>
            <td>Fee Collection &amp; Ledger</td>
            <td><i class="fas fa-minus icon-no"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
          <tr>
            <td>Library Management</td>
            <td><i class="fas fa-minus icon-no"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
          <tr>
            <td>Biometric Support</td>
            <td><i class="fas fa-minus icon-no"></i></td>
            <td><i class="fas fa-minus icon-no"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
          <tr>
            <td>LMS &amp; E-Learning</td>
            <td><i class="fas fa-minus icon-no"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
            <td><i class="fas fa-check icon-yes"></i></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="faq-section">
  <div class="container">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-wrap">
      <div class="faq-item open">
        <button class="faq-btn" onclick="toggleFaq(this)">
          <span class="faq-btn-text">How long is the free trial?</span>
          <span class="faq-icon-wrap"><i class="fas fa-chevron-down"></i></span>
        </button>
        <div class="faq-body"><p>All our plans come with a 14-day fully-featured free trial. No credit card is required to start exploring the platform.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-btn" onclick="toggleFaq(this)">
          <span class="faq-btn-text">Can we upgrade or downgrade later?</span>
          <span class="faq-icon-wrap"><i class="fas fa-chevron-down"></i></span>
        </button>
        <div class="faq-body"><p>Yes — you can change your plan at any time. Upgrades take effect immediately; downgrades apply at the next billing cycle.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-btn" onclick="toggleFaq(this)">
          <span class="faq-btn-text">Do you offer any on-premise installation?</span>
          <span class="faq-icon-wrap"><i class="fas fa-chevron-down"></i></span>
        </button>
        <div class="faq-body"><p>SchoolPulse is cloud-based for maximum uptime and security. For large government projects we offer private cloud deployments on the Enterprise plan.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-btn" onclick="toggleFaq(this)">
          <span class="faq-btn-text">Is our school data secured?</span>
          <span class="faq-icon-wrap"><i class="fas fa-chevron-down"></i></span>
        </button>
        <div class="faq-body"><p>All data is encrypted with AES-256 in transit and at rest, hosted on Tier-4 data centres with a 99.9% uptime SLA.</p></div>
      </div>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container">
    <div class="cta-card">
      <div class="cta-inner">
        <h2>Ready to pulse with excellence?</h2>
        <p>Join 500+ institutions transforming their operations with SchoolPulse.</p>
        <div class="cta-btns">
          <a href="demo.php"    class="btn-cta-amber">Get Started Free</a>
          <a href="contact.php" class="btn-cta-white-border">Schedule a Demo</a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

<script>
function toggleFaq(btn) {
  const item = btn.closest('.faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
document.getElementById('billingToggle').addEventListener('change', function () {
  const annual = this.checked;
  document.querySelectorAll('.plan-amount').forEach(el => {
    el.textContent = annual ? el.dataset.annual : el.dataset.monthly;
  });
});
</script>

<?php require_once 'includes/footer.php'; ?>
