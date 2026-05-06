<?php
function sanitize(string $input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Alias used across admin pages
function sanitizeInput(string $input): string {
    return sanitize($input);
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function send_notification_email(string $to, string $subject, string $body): bool {
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: SchoolPulse <noreply@schoolpulse.in>\r\n";
    return @mail($to, $subject, $body, $headers);  // @ suppresses warnings
}

function time_ago(string $datetime): string {
    $time = time() - strtotime($datetime);
    if ($time < 60)     return 'just now';
    if ($time < 3600)   return floor($time/60).' min ago';
    if ($time < 86400)  return floor($time/3600).' hrs ago';
    return floor($time/86400).' days ago';
}

function get_setting(PDO $pdo, string $key, string $default = ''): string {
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['setting_value'] : $default;
}

function status_badge(string $status): string {
    $map = [
        'new'            => ['label' => 'New',            'color' => '#f59e0b'],
        'contacted'      => ['label' => 'Contacted',      'color' => '#3b5bdb'],
        'qualified'      => ['label' => 'Qualified',      'color' => '#0891b2'],
        'demo_scheduled' => ['label' => 'Demo Scheduled', 'color' => '#8b5cf6'],
        'demo_completed' => ['label' => 'Demo Completed', 'color' => '#6366f1'],
        'converted'      => ['label' => 'Converted',      'color' => '#059669'],
        'rejected'       => ['label' => 'Rejected',       'color' => '#dc2626'],
        'active'         => ['label' => 'Active',         'color' => '#059669'],
        'trial'          => ['label' => 'Trial',          'color' => '#f59e0b'],
        'suspended'      => ['label' => 'Suspended',      'color' => '#ea580c'],
        'cancelled'      => ['label' => 'Cancelled',      'color' => '#dc2626'],
        'responded'      => ['label' => 'Responded',      'color' => '#0891b2'],
        'resolved'       => ['label' => 'Resolved',       'color' => '#059669'],
        'inactive'       => ['label' => 'Inactive',       'color' => '#64748b'],
        'churned'        => ['label' => 'Churned',        'color' => '#dc2626'],
        'draft'          => ['label' => 'Draft',          'color' => '#64748b'],
        'published'      => ['label' => 'Published',      'color' => '#059669'],
    ];
    $s = $map[$status] ?? ['label' => ucfirst($status), 'color' => '#64748b'];
    return "<span class='badge' style='background:{$s['color']}20;color:{$s['color']};border:1px solid {$s['color']}40'>{$s['label']}</span>";
}

// Alias used across admin pages
function getStatusBadge(string $status): string {
    return status_badge($status);
}