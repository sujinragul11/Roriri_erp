<?php
// Shared SMTP mail helper for client credential notifications.
// Usage: require_once __DIR__ . '/sendMail.php'; then sendClientMail($to, $subject, $bodyHtml);

require_once dirname(__DIR__, 2) . '/PHPMailer/src/Exception.php';
require_once dirname(__DIR__, 2) . '/PHPMailer/src/PHPMailer.php';
require_once dirname(__DIR__, 2) . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendClientMail($to, $subject, $bodyHtml) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = '92.205.4.188';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@roririsoft.com';
        $mail->Password = 'Admin@Roririsoft.com';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->setFrom('admin@roririsoft.com', 'Roriri Software Solutions Pvt. Ltd.');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyHtml;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function clientCredentialEmailBody($clientName, $username, $password, $loginUrl) {
    return '<div style="font-family:Arial,sans-serif;max-width:560px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
                <div style="background:#1e2a4a;color:#fff;padding:16px 24px;font-size:18px;font-weight:600;">Roriri Software Solutions Pvt. Ltd.</div>
                <div style="padding:24px;">
                    <p>Dear ' . htmlspecialchars($clientName) . ',</p>
                    <p>Your client portal login credentials are below:</p>
                    <table style="border-collapse:collapse;width:100%;">
                        <tr><td style="padding:8px;border:1px solid #ddd;background:#f7f7f7;"><strong>Login URL</strong></td><td style="padding:8px;border:1px solid #ddd;"><a href="' . htmlspecialchars($loginUrl) . '">' . htmlspecialchars($loginUrl) . '</a></td></tr>
                        <tr><td style="padding:8px;border:1px solid #ddd;background:#f7f7f7;"><strong>Username</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($username) . '</td></tr>
                        <tr><td style="padding:8px;border:1px solid #ddd;background:#f7f7f7;"><strong>Password</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($password) . '</td></tr>
                    </table>
                    <p style="margin-top:16px;">Please use these credentials to access your dashboard. If these were updated, the previous password no longer works.</p>
                    <p>Thank you,<br>Roriri Software Solutions Team</p>
                </div>
            </div>';
}
