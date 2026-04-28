<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Inquiry: {{ $service }}</title>
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

        /* ─── Header ─── */
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

        .header-logo span {
            color: #6666ff;
        }

        .header-tagline {
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ─── Alert Banner ─── */
        .alert-banner {
            background: linear-gradient(135deg, #4d4dff 0%, #6b21a8 100%);
            padding: 18px 40px;
            text-align: center;
        }

        .alert-banner p {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        .alert-banner span {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            border-radius: 100px;
            padding: 2px 12px;
            font-size: 12px;
            margin-left: 8px;
            letter-spacing: 0.06em;
            vertical-align: middle;
        }

        /* ─── Body ─── */
        .body {
            background: #ffffff;
            padding: 36px 40px;
        }

        .intro {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 28px;
            padding-bottom: 28px;
            border-bottom: 1px solid #f0f0f5;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #9ca3af;
            margin-bottom: 16px;
        }

        /* ─── Detail Grid ─── */
        .details {
            background: #f8f9ff;
            border: 1px solid #e5e7f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .detail-row {
            display: flex;
            align-items: stretch;
            border-bottom: 1px solid #e5e7f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 140px;
            min-width: 140px;
            background: #f0f1ff;
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #4d4dff;
            display: flex;
            align-items: center;
        }

        .detail-label .icon {
            margin-right: 7px;
            font-size: 14px;
        }

        .detail-value {
            padding: 13px 18px;
            font-size: 14px;
            color: #111827;
            display: flex;
            align-items: center;
            word-break: break-word;
            flex: 1;
        }

        /* ─── Service Badge ─── */
        .service-badge {
            display: inline-block;
            background: linear-gradient(135deg, rgba(77,77,255,0.12), rgba(107,33,168,0.12));
            border: 1px solid rgba(77,77,255,0.3);
            color: #4d4dff;
            border-radius: 100px;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        /* ─── Message Box ─── */
        .message-box {
            background: #f8f9ff;
            border: 1px solid #e5e7f0;
            border-left: 4px solid #4d4dff;
            border-radius: 0 10px 10px 0;
            padding: 20px 22px;
            margin-bottom: 28px;
        }

        .message-box p {
            font-size: 14px;
            color: #374151;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        /* ─── Action Button ─── */
        .cta-wrap {
            text-align: center;
            margin-bottom: 28px;
        }

        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #4d4dff, #6b21a8);
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ─── Meta Note ─── */
        .meta-note {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }

        .meta-note strong {
            color: #78350f;
        }

        /* ─── Footer ─── */
        .footer {
            background: #0d0d2b;
            border-radius: 0 0 12px 12px;
            padding: 24px 40px;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
        }

        .footer a {
            color: #6666ff;
            text-decoration: none;
        }

        .footer .footer-brand {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .footer .footer-brand span {
            color: #6666ff;
        }

        /* ─── Responsive (email clients) ─── */
        @media only screen and (max-width: 600px) {
            .body, .header, .alert-banner, .footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .detail-label {
                width: 110px;
                min-width: 110px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-logo">HEXA<span>FUME</span></div>
        <div class="header-tagline">Think Big &middot; IT Services &amp; Digital Solutions</div>
    </div>

    {{-- ── Alert Banner ── --}}
    <div class="alert-banner">
        <p>
            &#128276; New Contact Inquiry Received
            <span>ACTION REQUIRED</span>
        </p>
    </div>

    {{-- ── Body ── --}}
    <div class="body">

        <p class="intro">
            A new inquiry has been submitted through the Hexafume website contact form.
            Please review the details below and respond to the prospective client within 24&nbsp;hours.
        </p>

        {{-- ── Contact Details ── --}}
        <p class="section-title">&#128100; Contact Details</p>
        <div class="details">
            <div class="detail-row">
                <div class="detail-label"><span class="icon">&#128100;</span> Name</div>
                <div class="detail-value">{{ $senderName }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><span class="icon">&#9993;</span> Email</div>
                <div class="detail-value">
                    <a href="mailto:{{ $senderEmail }}" style="color:#4d4dff;text-decoration:none;font-weight:600;">
                        {{ $senderEmail }}
                    </a>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><span class="icon">&#128222;</span> Phone</div>
                <div class="detail-value">
                    @if($senderPhone)
                        <a href="tel:{{ $senderPhone }}" style="color:#4d4dff;text-decoration:none;font-weight:600;">
                            {{ $senderPhone }}
                        </a>
                    @else
                        <span style="color:#9ca3af;font-style:italic;">Not provided</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><span class="icon">&#128196;</span> Service</div>
                <div class="detail-value">
                    <span class="service-badge">{{ $service }}</span>
                </div>
            </div>
        </div>

        {{-- ── Message ── --}}
        <p class="section-title">&#128172; Their Message</p>
        <div class="message-box">
            <p>{{ $userMessage }}</p>
        </div>

        {{-- ── CTA ── --}}
        <div class="cta-wrap">
            <a href="mailto:{{ $senderEmail }}?subject=Re: Your Inquiry About {{ rawurlencode($service) }}&body=Hi {{ rawurlencode($senderName) }},%0A%0AThank you for reaching out to Hexafume!%0A%0A" class="cta-btn">
                &#9993;&nbsp; Reply to {{ $senderName }}
            </a>
        </div>

        {{-- ── Meta Note ── --}}
        <div class="meta-note">
            <strong>&#9888; Reminder:</strong>
            This inquiry was submitted via the website contact form and has been logged in the system.
            Please reply directly to <strong>{{ $senderEmail }}</strong> to continue the conversation.
        </div>

    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-brand">HEXA<span>FUME</span></div>
        <p>
            DHA 1, Islamabad, Pakistan &bull;
            <a href="mailto:support@hexafume.com">support@hexafume.com</a> &bull;
            <a href="tel:+923150884024">+92 315 088 4024</a>
        </p>
        <p style="margin-top:10px;">
            &copy; {{ date('Y') }} Hexafume. This is an automated notification &mdash; do not reply to this email.
        </p>
    </div>

</div>
</body>
</html>
```

Now let me create that file properly:
