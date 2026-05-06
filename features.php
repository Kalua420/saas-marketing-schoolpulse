<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title       = 'Powerful Features - SchoolPulse';
$page_description = 'Discover comprehensive school management features designed for modern Indian schools. Student lifecycle, finance, communication, and more — all in one platform.';
$page_css         = ['assets/css/features.css'];

require_once 'includes/header.php';
?>

<main>

<section class="features-hero">
    <div class="container">
        <span class="hero-badge">Next-Gen Education ERP</span>
        <h1>Powerful Features for<br><span class="highlight">Modern Schools</span></h1>
        <p>Streamline administration, empower teachers, and engage parents with a unified platform designed for the Indian academic landscape.</p>
        <div class="hero-buttons">
            <a href="demo.php"  class="btn-hero-primary">Request Free Demo</a>
            <a href="#modules"  class="btn-hero-secondary">Explore Modules</a>
        </div>
    </div>
</section>

<section class="modules-section" id="modules">
    <div class="container">
        <div class="section-header">
            <h2>Comprehensive Management Suites</h2>
            <p>Modular components that work together seamlessly or as standalone solutions.</p>
        </div>
        <div class="modules-grid">
            <div class="module-card">
                <div class="module-icon-wrap icon-amber"><i class="fas fa-user-graduate"></i></div>
                <h3>Student Information System</h3>
                <p>Centralized database for student profiles, document management, and historical academic records with 360° visibility.</p>
            </div>
            <div class="module-card">
                <div class="module-icon-wrap icon-blue"><i class="fas fa-book-open"></i></div>
                <h3>Academic Management</h3>
                <p>Automated timetables, lesson planning, and examination modules supporting CBSE, ICSE, and State Board formats.</p>
            </div>
            <div class="module-card">
                <div class="module-icon-wrap icon-green"><i class="fas fa-rupee-sign"></i></div>
                <h3>Fee &amp; Finance (₹)</h3>
                <p>Integrated payment gateways for online fee collection, automated invoice generation, and real-time expense tracking.</p>
            </div>
            <div class="module-card">
                <div class="module-icon-wrap icon-purple"><i class="fas fa-comments"></i></div>
                <h3>Communication Hub</h3>
                <p>Multi-channel alerts via SMS, Email, and App notifications. Direct chat between teachers and parents in local languages.</p>
            </div>
            <div class="module-card">
                <div class="module-icon-wrap icon-rose"><i class="fas fa-book"></i></div>
                <h3>Library Management</h3>
                <p>Digital cataloging, barcode scanning, and automated overdue reminders to keep your library running efficiently.</p>
            </div>
            <div class="module-card">
                <div class="module-icon-wrap icon-teal"><i class="fas fa-fingerprint"></i></div>
                <h3>Attendance Tracking</h3>
                <p>Biometric integration and mobile-based attendance for staff and students with instant 'Absent' alerts to parents.</p>
            </div>
        </div>
    </div>
</section>

<section class="feature-showcase-section" id="academic">
    <div class="container">
        <div class="showcase-row">
            <div class="showcase-content">
                <span class="showcase-label">Student-Centric Design</span>
                <h2>Unified Student Lifecycle Management</h2>
                <div class="highlight-cards">
                    <div class="highlight-card">
                        <h4>360° Academic History</h4>
                        <p>Access every grade, remark, and health record from admission to graduation.</p>
                    </div>
                    <div class="highlight-card">
                        <h4>Digital Portfolio</h4>
                        <p>Automated generation of Transfer Certificates and Character Reports.</p>
                    </div>
                    <div class="highlight-card">
                        <h4>Behavioral Insights</h4>
                        <p>AI-driven predictive analytics for identifying students needing academic support.</p>
                    </div>
                </div>
            </div>
            <div class="showcase-visual">
                <div class="mockup-browser">
                    <div class="mockup-browser-bar">
                        <div class="browser-dots"><span></span><span></span><span></span></div>
                        <div class="browser-url">schoolpulse.admin/students/18293</div>
                    </div>
                    <div class="mockup-browser-body">
                        <div class="student-card">
                            <div class="student-card-header">
                                <div class="student-avatar">RS</div>
                                <div>
                                    <div class="student-name">Rahul Sharma</div>
                                    <div class="student-meta">Roll No: 24 | Class 10-A</div>
                                    <div class="student-badges">
                                        <span class="badge-active">Active</span>
                                        <span class="badge-hosteler">Hosteler</span>
                                    </div>
                                </div>
                            </div>
                            <div class="student-stats">
                                <div class="student-stat">
                                    <div class="student-stat-label">Attendance</div>
                                    <div class="student-stat-value green">95.2%</div>
                                </div>
                                <div class="student-stat">
                                    <div class="student-stat-label">Last Grade</div>
                                    <div class="student-stat-value blue">A+</div>
                                </div>
                                <div class="student-stat">
                                    <div class="student-stat-label">Fee Status</div>
                                    <div class="student-stat-value amber">Paid</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="feature-showcase-section alt-bg" id="communication">
    <div class="container">
        <div class="showcase-row reverse">
            <div class="showcase-visual">
                <div class="mockup-phone-wrap">
                    <div class="mockup-phone">
                        <div class="mockup-phone-notch"></div>
                        <div class="mockup-phone-screen">
                            <div class="chat-screen">
                                <div class="chat-topbar">
                                    <span class="chat-back">‹</span>
                                    <div class="chat-avatar-sm">MK</div>
                                    <div class="chat-contact-info">
                                        <div class="chat-contact-name">Mrs. Kapoor (Teacher)</div>
                                        <div class="chat-contact-status">Online</div>
                                    </div>
                                </div>
                                <div class="chat-messages-area">
                                    <div class="chat-bubble received">Namaste! Rahul has performed exceptionally well in the Hindi elocution contest today.</div>
                                    <div class="chat-bubble sent">धन्यवाद मैडम! यह सुनकर बहुत खुशी हुई! (Thank you Madam! Very happy to hear this.)</div>
                                    <div class="chat-bubble received">He is a bright student. I have shared the results on the portal.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <span class="showcase-label">Bilingual Engagement</span>
                <h2>Seamless Communication with Multi-Language Support</h2>
                <p>Bridge the gap between home and school with a platform that speaks your language. Support for Hindi, English, and 8+ regional languages ensures no parent is left behind.</p>
                <ul class="feature-check-list">
                    <li>Automated Broadcasts for Parent Meetings</li>
                    <li>Real-time Messaging for Urgent Alerts</li>
                    <li>In-app Digital Notice Board with Multimedia</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="security-section">
    <div class="container">
        <div class="section-header">
            <h2>Enterprise-Grade Security</h2>
            <p>Your data integrity and privacy are our top priorities.</p>
        </div>
        <div class="security-grid">
            <div class="security-card">
                <div class="security-icon-wrap"><i class="fas fa-shield-alt"></i></div>
                <h4>Data Security</h4>
                <p>256-bit SSL encryption for all data in transit and at rest.</p>
            </div>
            <div class="security-card">
                <div class="security-icon-wrap"><i class="fas fa-user-lock"></i></div>
                <h4>Role-Based Access</h4>
                <p>Granular permissions for Admins, Teachers, and Parents.</p>
            </div>
            <div class="security-card">
                <div class="security-icon-wrap"><i class="fas fa-cloud-upload-alt"></i></div>
                <h4>Auto Backups</h4>
                <p>Real-time daily backups on redundant cloud servers.</p>
            </div>
            <div class="security-card">
                <div class="security-icon-wrap"><i class="fas fa-plug"></i></div>
                <h4>API Integration</h4>
                <p>Seamlessly connect with Biometrics and Tally.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-card-inner">
                <h2>Ready to Transform Your School?</h2>
                <p>Join 500+ schools already using SchoolPulse to achieve 1,00,000+ happy parents and efficient admin operations.</p>
                <div class="cta-buttons">
                    <a href="demo.php"    class="btn-cta-primary">Request Free Demo</a>
                    <a href="pricing.php" class="btn-cta-secondary">View Pricing</a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php require_once 'includes/footer.php'; ?>
