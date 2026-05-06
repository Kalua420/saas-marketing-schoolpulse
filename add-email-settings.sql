-- Add new email settings to site_settings table
-- Run this SQL in phpMyAdmin or MySQL command line

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `updated_at`) 
VALUES 
    ('legal_email', 'legal@schoolpulse.in', NOW()),
    ('privacy_email', 'privacy@schoolpulse.in', NOW()),
    ('support_email', 'support@schoolpulse.in', NOW())
ON DUPLICATE KEY UPDATE 
    `setting_value` = VALUES(`setting_value`),
    `updated_at` = NOW();
