<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Already logged in → go straight to dashboard
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = sanitize($_POST['email']    ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                login_admin($admin);
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (Exception $e) {
            $error = 'Login failed. Please try again.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login — SchoolPulse</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --navy:        #0f172a;
      --navy-mid:    #1e293b;
      --blue:        #0058be;
      --amber:       #f59e0b;
      --amber-dark:  #d97706;
      --error:       #ef4444;
      --surface:     #f8fafc;
      --border:      #e2e8f0;
      --text:        #0f172a;
      --text-muted:  #475569;
      --text-faint:  #94a3b8;
      --white:       #ffffff;
      --radius:      14px;
      --transition:  0.2s cubic-bezier(0.4,0,0.2,1);
    }

    html, body {
      height: 100%;
      font-family: 'Inter', sans-serif;
      background: var(--navy);
      color: var(--text);
    }

    /* ── Background ─────────────────────────────────────────── */
    .login-bg {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      position: relative;
      overflow: hidden;
    }

    .login-bg::before,
    .login-bg::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
      opacity: 0.12;
      filter: blur(90px);
    }
    .login-bg::before {
      width: 500px; height: 500px;
      background: #3b82f6;
      top: -15%; right: -10%;
    }
    .login-bg::after {
      width: 400px; height: 400px;
      background: var(--amber);
      bottom: -15%; left: -8%;
    }

    /* ── Card ───────────────────────────────────────────────── */
    .login-card {
      width: 100%;
      max-width: 420px;
      background: var(--white);
      border-radius: 28px;
      padding: 48px 44px;
      box-shadow: 0 32px 64px rgba(0,0,0,.35), 0 2px 8px rgba(0,0,0,.15);
      position: relative;
      z-index: 1;
      animation: card-rise 0.45s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes card-rise {
      from { opacity: 0; transform: translateY(28px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0)    scale(1);    }
    }

    /* ── Brand ──────────────────────────────────────────────── */
    .login-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
    }

    .login-brand-icon {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, var(--navy-mid), var(--navy));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--amber);
      font-size: 18px;
      flex-shrink: 0;
    }

    .login-brand-name {
      font-family: 'Poppins', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.02em;
    }

    .login-brand-badge {
      margin-left: auto;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--text-faint);
      background: #f1f5f9;
      padding: 4px 10px;
      border-radius: 9999px;
    }

    /* ── Heading ────────────────────────────────────────────── */
    .login-heading {
      font-family: 'Poppins', sans-serif;
      font-size: 24px;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.02em;
      margin-bottom: 6px;
    }

    .login-sub {
      font-size: 14px;
      color: var(--text-muted);
      margin-bottom: 28px;
    }

    /* ── Error ──────────────────────────────────────────────── */
    .login-error {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(239,68,68,.07);
      border: 1px solid rgba(239,68,68,.2);
      color: #dc2626;
      font-size: 13px;
      font-weight: 500;
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .login-error i { font-size: 15px; flex-shrink: 0; }

    /* ── Form ───────────────────────────────────────────────── */
    .login-form { display: flex; flex-direction: column; gap: 18px; }

    .form-field { display: flex; flex-direction: column; gap: 6px; }

    .form-field label {
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .05em;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-faint);
      font-size: 14px;
      pointer-events: none;
    }

    .input-wrap input {
      width: 100%;
      padding: 12px 14px 12px 40px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      background: #f8fafc;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: var(--text);
      transition: border-color var(--transition), background var(--transition), box-shadow var(--transition);
    }

    .input-wrap input::placeholder { color: var(--text-faint); }

    .input-wrap input:focus {
      outline: none;
      border-color: var(--blue);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(0,88,190,.08);
    }

    /* password toggle */
    .input-wrap .toggle-pw {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-faint);
      font-size: 14px;
      padding: 0;
      pointer-events: all;
      transition: color var(--transition);
    }
    .input-wrap .toggle-pw:hover { color: var(--text-muted); }

    /* ── Submit ─────────────────────────────────────────────── */
    .login-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: var(--radius);
      background: linear-gradient(135deg, var(--amber), var(--amber-dark));
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(245,158,11,.35);
      transition: transform var(--transition), box-shadow var(--transition), opacity var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 4px;
    }

    .login-btn:hover {
      transform: scale(1.015);
      box-shadow: 0 6px 20px rgba(245,158,11,.45);
    }

    .login-btn:active { transform: scale(0.98); }

    .login-btn:disabled {
      opacity: 0.65;
      cursor: not-allowed;
      transform: none;
    }

    /* ── Footer ─────────────────────────────────────────────── */
    .login-footer {
      margin-top: 28px;
      text-align: center;
    }

    .login-footer a {
      font-size: 13px;
      color: var(--text-faint);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color var(--transition);
    }

    .login-footer a:hover { color: var(--text-muted); }

    /* ── Accessibility ──────────────────────────────────────── */
    .login-btn:focus-visible,
    .input-wrap input:focus-visible {
      outline: 3px solid var(--blue);
      outline-offset: 2px;
    }

    @media (max-width: 480px) {
      .login-card { padding: 36px 24px; }
    }
  </style>
</head>
<body>

<div class="login-bg">
  <div class="login-card">

    <!-- Brand -->
    <div class="login-brand">
      <div class="login-brand-icon">
        <i class="fas fa-school"></i>
      </div>
      <span class="login-brand-name">SchoolPulse</span>
      <span class="login-brand-badge">Admin</span>
    </div>

    <!-- Heading -->
    <h1 class="login-heading">Welcome back</h1>
    <p class="login-sub">Sign in to your admin dashboard</p>

    <!-- Error -->
    <?php if ($error): ?>
    <div class="login-error">
      <i class="fas fa-circle-exclamation"></i>
      <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form class="login-form" method="POST" id="loginForm">
      <div class="form-field">
        <label for="email">Email Address</label>
        <div class="input-wrap">
          <i class="fas fa-envelope"></i>
          <input
            type="email"
            id="email"
            name="email"
            required
            autocomplete="email"
            placeholder="admin@schoolpulse.in"
            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
          />
        </div>
      </div>

      <div class="form-field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock"></i>
          <input
            type="password"
            id="password"
            name="password"
            required
            autocomplete="current-password"
            placeholder="Enter your password"
          />
          <button type="button" class="toggle-pw" aria-label="Toggle password visibility" onclick="togglePassword()">
            <i class="fas fa-eye" id="pwIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="login-btn" id="loginBtn">
        <i class="fas fa-arrow-right-to-bracket"></i>
        Sign In
      </button>
    </form>

    <!-- Footer -->
    <div class="login-footer">
      <a href="../index.php">
        <i class="fas fa-arrow-left"></i>
        Back to website
      </a>
    </div>

  </div>
</div>

<script>
function togglePassword() {
  const input  = document.getElementById('password');
  const icon   = document.getElementById('pwIcon');
  const isText = input.type === 'text';
  input.type   = isText ? 'password' : 'text';
  icon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
}

document.getElementById('loginForm').addEventListener('submit', function() {
  const btn = document.getElementById('loginBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in…';
});
</script>

</body>
</html>
