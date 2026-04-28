<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $emailSubject }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f2f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            font-size: 15px;
            color: #1a1a2e;
            padding: 40px 16px;
        }

        .wrapper {
            max-width: 620px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #0d0d2b 0%, #1a1a4e 100%);
            border-radius: 12px 12px 0 0;
            padding: 36px 40px;
            text-align: center;
            border-bottom: 3px solid #4d4dff;
        }

        .header-logo {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: #ffffff;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .header-logo span { color: #6666ff; }

        .header-tagline {
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .body-section {
            background: #ffffff;
            padding: 36px 40px;
        }

        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 20px;
        }

        .message-content {
            font-size: 15px;
            color: #374151;
            line-height: 1.85;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .divider {
            border: none;
            border-top: 1px solid #e5e7f0;
            margin: 28px 0;
        }

        .signature {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.7;
        }

        .signature strong {
            color: #111827;
            display: block;
            font-size: 15px;
        }

        .footer {
            background: #0d0d2b;
            border-radius: 0 0 12px 12px;
            padding: 24px 40px;
            text-align: center;
        }

        .footer .footer-brand {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .footer .footer-brand span { color: #6666ff; }

        .footer p {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
        }

        .footer a {
            color: #6666ff;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .body-section, .header, .footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div class="header-logo">HEXA<span>FUME</span></div>
        <div class="header-tagline">Think Big &middot; IT Services &amp; Digital Solutions</div>
    </div>

    <div class="body-section">
        <p class="greeting">Hello {{ $senderName }},</p>
        <div class="message-content">{{ $emailBody }}</div>

        <hr class="divider" />

        <div class="signature">
            <strong>Hexafume Team</strong>
            DHA 1, Islamabad, Pakistan<br>
            <a href="mailto:support@hexafume.com" style="color:#4d4dff;text-decoration:none;">support@hexafume.com</a>
            &bull;
            <a href="tel:+923150884024" style="color:#4d4dff;text-decoration:none;">+92 315 088 4024</a>
        </div>
    </div>

    <div class="footer">
        <div class="footer-brand">HEXA<span>FUME</span></div>
        <p>
            DHA 1, Islamabad, Pakistan &bull;
            <a href="mailto:support@hexafume.com">support@hexafume.com</a> &bull;
            <a href="tel:+923150884024">+92 315 088 4024</a>
        </p>
        <p style="margin-top:10px;">
            &copy; {{ date('Y') }} Hexafume. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>
