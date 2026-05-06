<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = 'Request a Demo | SchoolPulse - The Modern School OS';
$page_description = 'See SchoolPulse in action. Request a personalized demo and discover how our school management system can transform your institution.';
$page_css = ['assets/css/demo.css'];

include 'includes/header.php';
?>

<main id="demo-page-wrap">

<!-- ── Hero ─────────────────────────────────────────────────────────── -->
<section class="demo-hero-section">
  <div class="demo-hero-inner">
    <span class="demo-hero-badge">Experience the Future</span>
    <h1 class="demo-hero-title">See SchoolPulse in Action</h1>
    <p class="demo-hero-subtitle">Discover how our intelligent OS transforms administrative chaos into streamlined academic excellence. Tailored for Indian schools, built for the global future.</p>
    <div class="demo-hero-avatars">
      <div class="demo-avatar-stack">
        <div class="demo-avatar demo-avatar--blue">R</div>
        <div class="demo-avatar demo-avatar--green">P</div>
        <div class="demo-avatar demo-avatar--amber">A</div>
      </div>
      <span class="demo-hero-trust-text">Trusted by 500+ Indian Institutions</span>
    </div>
  </div>
</section>

<!-- ── Form + Intro ──────────────────────────────────────────────────── -->
<section class="demo-form-section">
  <div class="demo-form-section-inner">

    <!-- Left: intro -->
    <div class="demo-intro-col">
      <h2>Request Your Free Demo</h2>
      <p class="demo-intro-lead">Our experts will guide you through a personalized walkthrough of the SchoolPulse ecosystem. See how you can save up to ₹25,000 per month in operational leaks.</p>

      <ul class="demo-checklist">
        <li>
          <span class="material-symbols-outlined check-icon">check_circle</span>
          <div>
            <div class="check-title">Live Feature Walkthrough</div>
            <div class="check-desc">See real-time dashboards and fee management modules.</div>
          </div>
        </li>
        <li>
          <span class="material-symbols-outlined check-icon">check_circle</span>
          <div>
            <div class="check-title">Custom Fee Structure Setup</div>
            <div class="check-desc">Learn how to automate complex Indian fee structures.</div>
          </div>
        </li>
        <li>
          <span class="material-symbols-outlined check-icon">check_circle</span>
          <div>
            <div class="check-title">Migration Strategy</div>
            <div class="check-desc">We'll show you how we move your data from Excel in 48 hours.</div>
          </div>
        </li>
      </ul>

      <div class="demo-testimonial">
        <div class="demo-testimonial-body">
          <span class="material-symbols-outlined stars-icon">stars</span>
          <p>"SchoolPulse helped our ICSE school automate 90% of fee collection. The demo was eye-opening!"</p>
        </div>
        <div class="demo-testimonial-author">— Dr. Rajesh K., Director, Global Scholars School</div>
      </div>
    </div>

    <!-- Right: form card -->
    <div>
      <div class="demo-form-card">
        <div class="demo-form-card-header">
          <h3>Tell Us About Your School</h3>
          <p>Fill out the details below and we'll be in touch within 2 business hours.</p>
        </div>

        <div id="form-success" class="demo-alert demo-alert--success" role="alert">
          <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">check_circle</span>
          Demo scheduled! Our team will contact you within 2 hours.
        </div>
        <div id="form-error" class="demo-alert demo-alert--error" role="alert">
          <span class="material-symbols-outlined">error</span>
          <span id="form-error-msg">Something went wrong. Please try again.</span>
        </div>

        <form id="demo-form" class="demo-form" method="POST" novalidate>
          <div class="demo-form-grid">
            <div class="demo-field">
              <label for="school_name">School Name<span class="req">*</span></label>
              <input id="school_name" name="school_name" type="text" required
                class="demo-input" placeholder="e.g. St. Xavier's International"/>
              <span class="demo-field-error">This field is required</span>
            </div>
            <div class="demo-field">
              <label for="school_type">School Type</label>
              <select id="school_type" name="school_type" class="demo-select">
                <option value="">Select type</option>
                <option>CBSE Board</option>
                <option>ICSE / ISC</option>
                <option>State Board</option>
                <option>IB / IGCSE</option>
                <option>Pre-School</option>
                <option>Coaching Institute</option>
              </select>
            </div>
            <div class="demo-field">
              <label for="contact_person">Your Name<span class="req">*</span></label>
              <input id="contact_person" name="contact_person" type="text" required
                class="demo-input" placeholder="Full Name"/>
              <span class="demo-field-error">This field is required</span>
            </div>
            <div class="demo-field">
              <label for="designation">Your Role</label>
              <select id="designation" name="designation" class="demo-select">
                <option value="">Select role</option>
                <option>Principal</option>
                <option>Administrator</option>
                <option>Chairman / Director</option>
                <option>Accountant</option>
                <option>IT Head</option>
                <option>Vice Principal</option>
              </select>
            </div>
            <div class="demo-field">
              <label for="email">Email Address<span class="req">*</span></label>
              <input id="email" name="email" type="email" required
                class="demo-input" placeholder="work@schoolname.com"/>
              <span class="demo-field-error">Enter a valid email address</span>
            </div>
            <div class="demo-field">
              <label for="phone">Phone Number<span class="req">*</span></label>
              <input id="phone" name="phone" type="tel" required
                class="demo-input" placeholder="+91 00000 00000"/>
              <span class="demo-field-error">Enter a valid phone number</span>
            </div>
            <div class="demo-field">
              <label for="city">City</label>
              <input id="city" name="city" type="text"
                class="demo-input" placeholder="e.g. Pune"/>
            </div>
            <div class="demo-field">
              <label for="student_count">Number of Students</label>
              <select id="student_count" name="student_count" class="demo-select">
                <option value="">Select range</option>
                <option value="500">Under 500</option>
                <option value="1500">500 – 1500</option>
                <option value="3000">1500 – 3000</option>
                <option value="3001">Above 3000</option>
              </select>
            </div>
          </div>

          <!-- Areas of interest -->
          <div class="demo-field">
            <label>Areas of Interest</label>
            <div class="demo-checkbox-grid">
              <?php
              $interests = ['Fee Management','Attendance','Exams / LMS','Transportation','Staff Payroll','ERP Switch'];
              foreach ($interests as $item):
              ?>
              <label class="demo-checkbox-label">
                <input type="checkbox" name="interested_features[]"
                  value="<?php echo htmlspecialchars($item); ?>"/>
                <?php echo htmlspecialchars($item); ?>
              </label>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Message -->
          <div class="demo-field">
            <label for="message">Specific Requirements</label>
            <textarea id="message" name="message" class="demo-textarea" rows="3"
              placeholder="Tell us more about your current challenges…"></textarea>
          </div>

          <button id="demo-submit-btn" type="submit" class="demo-submit-btn">
            Schedule My Demo
            <span class="material-symbols-outlined btn-icon">arrow_forward</span>
          </button>
          <p class="demo-form-note">By submitting, you agree to our Terms and Privacy Policy.</p>
        </form>
      </div>
    </div>

  </div>
</section>

<!-- ── What Happens Next ─────────────────────────────────────────────── -->
<section class="demo-steps-section">
  <div class="demo-steps-section-inner">
    <h2 class="demo-section-title">What Happens Next?</h2>
    <div class="demo-steps-track">
      <div class="demo-steps-grid">
        <?php
        $steps = [
          ['1', 'Quick Response',    'Our school success manager calls you within 2 hours to understand your specific board requirements.'],
          ['2', 'Personalized Demo', 'A 45-minute live walkthrough of modules that matter most to your institution\'s workflow.'],
          ['3', 'Custom Proposal',   'Get a tailored implementation roadmap and a quote designed for your school\'s budget.'],
        ];
        foreach ($steps as [$n, $title, $desc]):
        ?>
        <div class="demo-step">
          <div class="demo-step-number"><?php echo $n; ?></div>
          <h4><?php echo $title; ?></h4>
          <p><?php echo $desc; ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ── Why Attend ────────────────────────────────────────────────────── -->
<section class="demo-benefits-section">
  <div class="demo-benefits-section-inner">
    <div class="demo-section-header">
      <h2>Why Attend the Demo?</h2>
      <p>It's more than just a software tour. It's a consultation on school efficiency.</p>
    </div>
    <div class="demo-bento-grid">
      <?php
      $cards = [
        ['visibility',    '--blue',   'See It in Action',        'Experience the real UI, mobile app, and the ultra-fast fee processing module in real-time.'],
        ['person_pin',    '--amber',  'Personalized Experience', 'We configure the demo environment to match your school\'s specific board and fee types.'],
        ['forum',         '--green',  'Ask Questions',           'Get immediate answers about security, offline access, and teacher adoption directly from experts.'],
        ['analytics',     '--purple', 'ROI Analysis',            'We provide a custom report on how much time and ₹ your school can save over 12 months.'],
        ['map',           '--red',    'Implementation Roadmap',  'A clear, step-by-step plan for your school\'s digital transformation journey.'],
        ['verified_user', '--slate',  'No Commitment',           'The demo is completely free. We focus on value first, so you can decide with confidence.'],
      ];
      foreach ($cards as [$icon, $variant, $title, $desc]):
      ?>
      <div class="demo-bento-card">
        <div class="demo-bento-icon demo-bento-icon<?php echo $variant; ?>">
          <span class="material-symbols-outlined"><?php echo $icon; ?></span>
        </div>
        <h4><?php echo $title; ?></h4>
        <p><?php echo $desc; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Trust Bar ─────────────────────────────────────────────────────── -->
<section class="demo-trust-section">
  <div class="demo-trust-section-inner">
    <?php
    $stats = [['500+','Schools Onboarded'],['98%','Satisfaction Rate'],['24/7','Local Support'],['30 Days','Free Trial Period']];
    foreach ($stats as [$num, $label]):
    ?>
    <div class="demo-trust-stat">
      <span class="demo-trust-stat-number"><?php echo $num; ?></span>
      <span class="demo-trust-stat-label"><?php echo $label; ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</section>

</main>

<script>
(function () {
  const form      = document.getElementById('demo-form');
  const btn       = document.getElementById('demo-submit-btn');
  const successEl = document.getElementById('form-success');
  const errorEl   = document.getElementById('form-error');
  const errorMsg  = document.getElementById('form-error-msg');

  // ── Inline validation ──────────────────────────────────────
  const validators = {
    school_name:    v => v.trim() !== '',
    contact_person: v => v.trim() !== '',
    email:          v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
    phone:          v => /^[\+]?[\d\s\-\(\)]{10,}$/.test(v),
  };

  function validateField(input) {
    const name  = input.name;
    const field = input.closest('.demo-field');
    if (!field || !validators[name]) return true;
    const ok = validators[name](input.value);
    field.classList.toggle('has-error', !ok);
    return ok;
  }

  form.querySelectorAll('.demo-input').forEach(input => {
    input.addEventListener('blur', () => validateField(input));
    input.addEventListener('input', () => {
      if (input.closest('.demo-field').classList.contains('has-error')) {
        validateField(input);
      }
    });
  });

  // ── Submit ─────────────────────────────────────────────────
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Run all validators
    let valid = true;
    form.querySelectorAll('.demo-input[required]').forEach(input => {
      if (!validateField(input)) valid = false;
    });
    if (!valid) return;

    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined" style="animation:spin .8s linear infinite">progress_activity</span> Scheduling…';
    successEl.classList.remove('visible');
    errorEl.classList.remove('visible');

    const fd = new FormData(form);
    const checked = [...form.querySelectorAll('input[name="interested_features[]"]:checked')].map(c => c.value);
    fd.delete('interested_features[]');
    fd.append('interested_features', checked.join(', '));

    try {
      const res  = await fetch('api/submit-demo.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        successEl.classList.add('visible');
        form.reset();
        form.querySelectorAll('.demo-field').forEach(f => f.classList.remove('has-error'));
      } else {
        throw new Error(data.message || 'Something went wrong');
      }
    } catch (err) {
      errorMsg.textContent = err.message || 'Please try again later.';
      errorEl.classList.add('visible');
    } finally {
      btn.disabled = false;
      btn.innerHTML = 'Schedule My Demo <span class="material-symbols-outlined btn-icon">arrow_forward</span>';
    }
  });
})();
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<?php include 'includes/footer.php'; ?>