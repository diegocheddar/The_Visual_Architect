<?php
// aarchitect project inquiry handler.
// Replace these values before launch.
$recipient = "johnny@thevisualarchitect.io";
$siteUrl = "https://thevisualarchitect.io";
$instagramUrl = "https://www.instagram.com/";
$behanceUrl = "https://www.behance.net/";
$linkedinUrl = "https://www.linkedin.com/";
$pinterestUrl = "https://www.pinterest.com/";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.html");
    exit;
}

function clean($value) {
    return trim(str_replace(["\r", "\n"], " ", (string)$value));
}

function buildClientEmail($safeName, $safeProject, $safeMessage, $siteUrl, $instagramUrl, $behanceUrl, $linkedinUrl, $pinterestUrl, $logoCid, $heroCid) {
    return '<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"></head>'
        . '<body style="margin:0;padding:0;background:#f2f1ed;color:#171717;font-family:Arial,Helvetica,sans-serif;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;background:#f2f1ed;"><tr><td align="center" style="padding:32px 14px;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:680px;background:#fbfaf7;">'
        . '<tr><td style="padding:30px 34px 24px;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"><tr>'
        . '<td valign="middle" style="width:54px;"><a href="' . $siteUrl . '/home.html" style="display:inline-block;text-decoration:none;"><img src="cid:' . $logoCid . '" width="42" height="42" alt="aarchitect" style="display:block;width:42px;height:42px;border:0;"></a></td>'
        . '<td align="right" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:9px;line-height:1.4;letter-spacing:2px;text-transform:uppercase;color:#5d5d59;">Design &nbsp;·&nbsp; Development &nbsp;·&nbsp; Digital Experiences</td>'
        . '</tr></table></td></tr>'
        . '<tr><td style="padding:0 34px;"><img src="cid:' . $heroCid . '" width="612" alt="aarchitect project inquiry" style="display:block;width:100%;height:auto;border:0;"></td></tr>'
        . '<tr><td style="padding:28px 44px 14px;">'
        . '<div style="font-family:Georgia,Times New Roman,serif;font-size:43px;line-height:0.98;font-weight:400;letter-spacing:-1.7px;color:#111;margin:0 0 22px;">Thank you for<br>reaching out.</div>'
        . '<div style="font-size:15px;line-height:1.55;color:#222;margin-bottom:8px;">Hi ' . $safeName . ',</div>'
        . '<div style="font-size:15px;line-height:1.55;color:#222;max-width:510px;">We’ve received your project inquiry. Thank you for considering aarchitect for your project.<br>We’ll review the details you provided and get back to you shortly.</div>'
        . '</td></tr>'
        . '<tr><td style="padding:0 44px;"><div style="border-top:1px solid #d5d4cf;height:1px;line-height:1px;">&nbsp;</div></td></tr>'
        . '<tr><td style="padding:18px 44px 16px;">'
        . '<div style="font-size:10px;line-height:1.4;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;">Project type</div>'
        . '<div style="font-size:14px;line-height:1.55;margin-bottom:20px;">' . $safeProject . '</div>'
        . '<div style="font-size:10px;line-height:1.4;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;">Your message</div>'
        . '<div style="font-family:Georgia,Times New Roman,serif;font-size:15px;line-height:1.5;color:#30302d;">' . $safeMessage . '</div>'
        . '</td></tr>'
        . '<tr><td style="padding:0 44px;"><div style="border-top:1px solid #d5d4cf;height:1px;line-height:1px;">&nbsp;</div></td></tr>'
        . '<tr><td style="padding:18px 44px 34px;">'
        . '<div style="font-family:Georgia,Times New Roman,serif;font-size:15px;line-height:1.5;color:#4a4945;margin-bottom:18px;">In the meantime, feel free to explore more of our work or follow along.</div>'
        . '<table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr><td bgcolor="#111111" style="background:#111111;"><a href="' . $siteUrl . '/home.html" style="display:inline-block;padding:13px 42px;font-size:9px;line-height:1;letter-spacing:2.4px;text-decoration:none;color:#ffffff;text-transform:uppercase;">View our work</a></td></tr></table>'
        . '</td></tr>'
        . '<tr><td style="padding:0 44px 30px;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"><tr>'
        . '<td valign="bottom"><a href="' . $siteUrl . '/home.html" style="display:inline-block;text-decoration:none;margin-bottom:7px;"><img src="cid:' . $logoCid . '" width="25" height="25" alt="aarchitect" style="display:block;width:25px;height:25px;border:0;"></a><div style="font-family:Georgia,Times New Roman,serif;font-size:10px;line-height:1.4;color:#55534e;">Design · Development · Digital Experiences</div></td>'
        . '<td align="right" valign="bottom"><table role="presentation" cellspacing="0" cellpadding="0" border="0" align="right"><tr>'
        . '<td style="padding-left:7px;"><a href="' . $instagramUrl . '" aria-label="Instagram" style="display:block;width:28px;height:28px;line-height:28px;text-align:center;border:1px solid #969692;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:10px;color:#777;text-decoration:none;">ig</a></td>'
        . '<td style="padding-left:7px;"><a href="' . $behanceUrl . '" aria-label="Behance" style="display:block;width:28px;height:28px;line-height:28px;text-align:center;border:1px solid #969692;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:10px;color:#777;text-decoration:none;">be</a></td>'
        . '<td style="padding-left:7px;"><a href="' . $linkedinUrl . '" aria-label="LinkedIn" style="display:block;width:28px;height:28px;line-height:28px;text-align:center;border:1px solid #969692;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:10px;color:#777;text-decoration:none;">in</a></td>'
        . '<td style="padding-left:7px;"><a href="' . $pinterestUrl . '" aria-label="Pinterest" style="display:block;width:28px;height:28px;line-height:28px;text-align:center;border:1px solid #969692;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:10px;color:#777;text-decoration:none;">p</a></td>'
        . '</tr></table></td>'
        . '</tr></table></td></tr>'
        . '</table></td></tr></table></body></html>';
}

$name    = clean($_POST["name"] ?? "");
$emailRaw = trim($_POST["email"] ?? "");
$email   = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);
$company = clean($_POST["company"] ?? "");
$project = clean($_POST["project"] ?? "");
$budget  = clean($_POST["budget"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || !$email || $message === "") {
    http_response_code(422);
    $sent = false;
    $title = "Please complete the required fields";
    $copy = "Name, email, and project details are required. Please return to the form and try again.";
} else {
    $serverName = $_SERVER["SERVER_NAME"] ?? "localhost";
    $mailDomain = preg_replace('/:\\d+$/', '', $serverName);
    $mailDomain = preg_replace('/[^a-zA-Z0-9.-]/', '', $mailDomain);
    if ($mailDomain === '') $mailDomain = 'localhost';
    $fromAddress = "no-reply@" . $mailDomain;

    // 1) Send the inquiry to the studio.
    $subject = "New project inquiry from " . $name;
    $body = "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Company / Brand: {$company}\n";
    $body .= "Project type: {$project}\n";
    $body .= "Budget: {$budget}\n\n";
    $body .= "Tell us about your project:\n{$message}\n";

    $studioHeaders = [
        "MIME-Version: 1.0",
        "From: The Visual Architect <{$fromAddress}>",
        "Reply-To: {$email}",
        "Content-Type: text/plain; charset=UTF-8"
    ];
    $studioSent = mail($recipient, $subject, $body, implode("\r\n", $studioHeaders));

    // 2) Send the client the same branded design shown on email-preview.html.
    $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $safeProject = htmlspecialchars($project !== '' ? $project : 'Project inquiry', ENT_QUOTES, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    $clientSubject = "Thank you for your inquiry — The Visual Architect";
    $heroCid = 'aarchitect-hero';
    $logoCid = 'aarchitect-logo';
    $heroPath = __DIR__ . '/assets/contact.jpg';
    $logoPath = __DIR__ . '/assets/brand-logo-email.png';

    $clientHtml = buildClientEmail(
        $safeName,
        $safeProject,
        $safeMessage,
        $siteUrl,
        $instagramUrl,
        $behanceUrl,
        $linkedinUrl,
        $pinterestUrl,
        $logoCid,
        $heroCid
    );

    $boundary = '=_aarchitect_' . md5(uniqid((string)mt_rand(), true));
    $clientHeaders = [
        "MIME-Version: 1.0",
        "From: The Visual Architect <{$fromAddress}>",
        "Reply-To: {$recipient}",
        "Content-Type: multipart/related; boundary=\"{$boundary}\""
    ];

    $clientBody = "--{$boundary}\r\n";
    $clientBody .= "Content-Type: text/html; charset=UTF-8\r\n";
    $clientBody .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $clientBody .= $clientHtml . "\r\n";

    if (is_readable($heroPath)) {
        $heroData = chunk_split(base64_encode(file_get_contents($heroPath)));
        $clientBody .= "--{$boundary}\r\n";
        $clientBody .= "Content-Type: image/jpeg; name=\"aarchitect-hero.jpg\"\r\n";
        $clientBody .= "Content-Transfer-Encoding: base64\r\n";
        $clientBody .= "Content-ID: <{$heroCid}>\r\n";
        $clientBody .= "Content-Disposition: inline; filename=\"aarchitect-hero.jpg\"\r\n\r\n";
        $clientBody .= $heroData . "\r\n";
    }

    if (is_readable($logoPath)) {
        $logoData = chunk_split(base64_encode(file_get_contents($logoPath)));
        $clientBody .= "--{$boundary}\r\n";
        $clientBody .= "Content-Type: image/png; name=\"aarchitect-logo.png\"\r\n";
        $clientBody .= "Content-Transfer-Encoding: base64\r\n";
        $clientBody .= "Content-ID: <{$logoCid}>\r\n";
        $clientBody .= "Content-Disposition: inline; filename=\"aarchitect-logo.png\"\r\n\r\n";
        $clientBody .= $logoData . "\r\n";
    }
    $clientBody .= "--{$boundary}--\r\n";

    // Only confirm receipt after the studio copy has been accepted by the mail server.
    // This prevents a client from receiving a false confirmation if the inquiry itself failed.
    $clientSent = false;
    if ($studioSent) {
        $clientSent = mail($email, $clientSubject, $clientBody, implode("\r\n", $clientHeaders));
        if (!$clientSent) {
            error_log('aarchitect: client confirmation email failed for ' . $email);
        }
    }

    $sent = $studioSent;
    if ($sent) {
        header("Location: response.html");
        exit;
    }

    http_response_code(500);
    $title = "Message not sent";
    $copy = "The server could not send your inquiry. Please email us directly or try again later.";
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<link rel="stylesheet" href="styles.css">
<style>
.form-result{min-height:70vh;display:flex;align-items:center;justify-content:center;padding:120px 24px 60px;text-align:center}.form-result-inner{max-width:520px}.form-result h1{font:inherit;font-size:18px;font-weight:400;margin:0 0 18px}.form-result p{margin:0 0 26px;line-height:1.55}.form-result a{color:inherit;text-decoration:none;border-bottom:1px solid currentColor;padding-bottom:2px}
</style>
</head>
<body class="fade-page inquiry-page">
<header class="site-header">
  <a class="brand" href="index.html">The Visual Architect</a>
  <a class="close" href="contact.html" aria-label="Close">×</a>
</header>
<main class="form-result">
  <div class="form-result-inner">
    <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><?php echo htmlspecialchars($copy, ENT_QUOTES, 'UTF-8'); ?></p>
    <a href="contact.html"><?php echo $sent ? "Back to contact" : "Return to form"; ?></a>
  </div>
</main>
</body>
</html>
