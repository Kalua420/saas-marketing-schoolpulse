<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title       = 'SchoolPulse - Complete School Management System';
$page_description = 'Transform your school management with SchoolPulse. Streamline admissions, attendance, fees, and communication in one powerful platform designed for Indian schools.';
$page_css         = ['assets/css/homepage.css'];

require_once 'includes/header.php';
?>

<main>

<!-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ -->
<section class="hero">
    <div class="container">

        <div class="hero-content">
            <h1>Transform Your School<br>with <span class="highlight">SchoolPulse</span></h1>
            <p>The all-in-one school ERP built for modern Indian schools. Effortlessly streamline admissions, fees, and academics to drive grade-level growth.</p>

            <div class="hero-buttons">
                <a href="demo.php"     class="btn-hero-primary">Request Free Demo</a>
                <a href="features.php" class="btn-hero-secondary">Explore Features</a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="hero-stat-number">500+</span>
                    <span class="hero-stat-label">Schools</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">1,00,000+</span>
                    <span class="hero-stat-label">Students</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">99.9%</span>
                    <span class="hero-stat-label">Uptime</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">4.9</span>
                    <span class="hero-stat-label">Avg Rating</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-dashboard">
                <div class="dashboard-topbar">
                    <span class="dashboard-topbar-title">SchoolPulse Dashboard</span>
                    <span class="dashboard-topbar-badge">● Live</span>
                </div>
                <div class="dashboard-stats-row">
                    <div class="dash-stat">
                        <span class="dash-stat-val">1,247</span>
                        <span class="dash-stat-lbl">Students</span>
                    </div>
                    <div class="dash-stat">
                        <span class="dash-stat-val">94.2%</span>
                        <span class="dash-stat-lbl">Attendance</span>
                    </div>
                    <div class="dash-stat">
                        <span class="dash-stat-val">₹2.4L</span>
                        <span class="dash-stat-lbl">Fees Today</span>
                    </div>
                </div>
                <div class="dashboard-chart-area">
                    <div class="chart-label">Monthly Fee Collection</div>
                    <div class="chart-bars">
                        <div class="chart-bar" style="height:40%"></div>
                        <div class="chart-bar" style="height:55%"></div>
                        <div class="chart-bar" style="height:45%"></div>
                        <div class="chart-bar" style="height:70%"></div>
                        <div class="chart-bar" style="height:60%"></div>
                        <div class="chart-bar active" style="height:85%"></div>
                        <div class="chart-bar" style="height:75%"></div>
                        <div class="chart-bar" style="height:90%"></div>
                        <div class="chart-bar" style="height:65%"></div>
                        <div class="chart-bar" style="height:80%"></div>
                        <div class="chart-bar" style="height:72%"></div>
                        <div class="chart-bar active" style="height:95%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="features-section" id="features">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Integrated School Ecosystem</h2>
            <p class="section-subtitle">One platform covering every corner of your institution, designed to orchestrate efficiency and accelerate growth.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-user-graduate"></i></div>
                <h3>SIS (Student Information)</h3>
                <p>Complete student profiles, academic history, attendance records, and admission-to-graduation tracking.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Staff Management</h3>
                <p>Manage teacher profiles, performance appraisals, and daily attendance for your entire faculty and support staff.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-rupee-sign"></i></div>
                <h3>Financial Management</h3>
                <p>Automated fee collection, online payment gateways, digital receipts, and real-time financial audits with GST-compliant reporting.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Mobile Apps</h3>
                <p>Native iOS and Android apps for parents, teachers, and admins. Direct chat between teachers and parents with app notifications.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                <h3>Attendance System</h3>
                <p>Biometric integration and mobile-based attendance for students and staff with automated 'Absent' alerts to parents.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-comments"></i></div>
                <h3>Communication Hub</h3>
                <p>Centralised notification centre for circulars, notices, parent-teacher chats, and parent-to-school messaging.</p>
            </div>
        </div>
    </div>
</section>

<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Simple Three-Step Deployment</h2>
            <p class="section-subtitle">Go from sign-up to fully operational in under a week — no IT team required.</p>
        </div>
        <div class="process-grid">
            <div class="process-step">
                <div class="process-number">1</div>
                <h3>Quick Setup</h3>
                <p>Define your school structure, classes, and session parameters in our guided onboarding wizard with zero-code configuration.</p>
            </div>
            <div class="process-step">
                <div class="process-number">2</div>
                <h3>Data Migration</h3>
                <p>Securely import your existing student records, staff data, and historic fee history using our intelligent migration tools.</p>
            </div>
            <div class="process-step">
                <div class="process-number">3</div>
                <h3>Go Live</h3>
                <p>Launch to your staff and parents with our onboarding training. We provide 24/7 support for the first 30 days at no extra cost.</p>
            </div>
        </div>
    </div>
</section>

<section class="testimonials-section" id="testimonials">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Trusted by Educational Leaders</h2>
            <p class="section-subtitle">Hundreds of principals and administrators across India rely on SchoolPulse every day.</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <span class="quote-mark">"</span>
                <p class="testimonial-content">SchoolPulse has completely transformed how we manage our school. The fee collection system alone has saved us countless hours and improved our cash flow significantly.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">PS</div>
                    <div class="author-info">
                        <h4>Mrs. Priya Sharma</h4>
                        <p>Principal, Delhi Public School, Mumbai</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card featured">
                <span class="quote-mark">"</span>
                <p class="testimonial-content">The transparency of fee collection and the real-time dashboard is designed to perfection. Our parents trust us more because of the instant payment receipts and attendance alerts.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">RK</div>
                    <div class="author-info">
                        <h4>Mr. Rajesh Kumar</h4>
                        <p>Director, Bright Future Academy, Bangalore</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <span class="quote-mark">"</span>
                <p class="testimonial-content">Our admin team used to spend 3 hours daily on manual reports. SchoolPulse reduced that to 15 minutes. The support team is exceptional — always available.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">AP</div>
                    <div class="author-info">
                        <h4>Dr. Anjali Patel</h4>
                        <p>Administrator, Green Valley School, Pune</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing-teaser" id="pricing">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Transparent Institutional Pricing</h2>
            <p class="section-subtitle">Scale as you grow. All plans include free onboarding and 30-day support.</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="plan-name">Starter</div>
                <div class="plan-price"><sup>₹</sup>2,999</div>
                <div class="plan-period">/ month</div>
                <ul class="plan-features">
                    <li>Up to 300 Students</li>
                    <li>SIS &amp; Attendance</li>
                    <li>Fee Collection</li>
                    <li>Mobile App Access</li>
                    <li>Email Support</li>
                </ul>
                <a href="demo.php" class="btn-plan-outline">Start Starter</a>
            </div>
            <div class="pricing-card featured">
                <span class="plan-badge">Best Popular</span>
                <div class="plan-name">Professional</div>
                <div class="plan-price"><sup>₹</sup>5,999</div>
                <div class="plan-period">/ month</div>
                <ul class="plan-features">
                    <li>Up to 1,000 Students</li>
                    <li>All Starter Features</li>
                    <li>Staff Management</li>
                    <li>Timetable &amp; Exams</li>
                    <li>Priority Support</li>
                </ul>
                <a href="demo.php" class="btn-plan-primary">Start Professional</a>
            </div>
            <div class="pricing-card">
                <div class="plan-name">Enterprise</div>
                <div class="plan-price">Custom</div>
                <div class="plan-period">pricing</div>
                <ul class="plan-features">
                    <li>Unlimited Students</li>
                    <li>Custom Integrations</li>
                    <li>Multi-branch Support</li>
                    <li>Unlimited Storage</li>
                    <li>On-premise Options</li>
                </ul>
                <a href="contact.php" class="btn-plan-outline">Contact Sales</a>
            </div>
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="pricing.php" style="font-size:0.875rem;color:#64748b;text-decoration:none;border-bottom:1px solid #e5e7eb;padding-bottom:2px;">
                View full pricing details →
            </a>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-card-inner">
                <h2>Ready to Transform Your School?</h2>
                <p>Join 500+ progressive institutions using SchoolPulse to digitise their legacy systems and empower their teams.</p>
                <div class="cta-buttons">
                    <a href="demo.php"    class="btn-cta-primary">Get a Free Demo</a>
                    <a href="contact.php" class="btn-cta-secondary">Talk to Sales</a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php require_once 'includes/footer.php'; ?>
