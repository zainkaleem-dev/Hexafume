<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email — {{ $email->subject }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            padding: 40px 20px;
            color: #111827;
        }

        .page-wrapper {
            max-width: 720px;
            margin: 0 auto;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .top-bar h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
        }

        .top-bar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-back {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-compose {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Alert */
        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
        }

        .alert-success::before { content: '✔'; font-weight: bold; color: #059669; }

        /* Card */
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 28px 32px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .card-header-left h1 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.4;
            word-break: break-word;
        }

        .card-header-left p {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            margin-top: 5px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .status-sent {
            background: #d1fae5;
            color: #065f46;
        }

        .status-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Meta info */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-bottom: 1.5px solid #e5e7eb;
        }

        .meta-item {
            padding: 18px 32px;
            border-bottom: 1px solid #f3f4f6;
        }

        .meta-item:nth-child(odd) {
            border-right: 1px solid #f3f4f6;
        }

        .meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 15px;
            color: #1f2937;
            font-weight: 500;
            word-break: break-all;
        }

        .meta-value .email-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ede9fe;
            color: #5b21b6;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Body section */
        .body-section {
            padding: 28px 32px;
        }

        .body-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        .body-content {
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px 26px;
            font-size: 15px;
            color: #374151;
            line-height: 1.8;
            white-space: pre-line;
            word-break: break-word;
            min-height: 120px;
        }

        /* Footer */
        .card-footer {
            background: #f9fafb;
            border-top: 1.5px solid #e5e7eb;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-footer .timestamp {
            font-size: 12px;
            color: #9ca3af;
        }

        .card-footer .timestamp span {
            font-weight: 600;
            color: #6b7280;
        }

        /* Delete form */
        .delete-form {
            display: inline;
        }

        /* Responsive */
        @media (max-width: 560px) {
            .meta-grid {
                grid-template-columns: 1fr;
            }

            .meta-item:nth-child(odd) {
                border-right: none;
            }

            .card-header,
            .body-section,
            .card-footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .meta-item {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    {{-- Top Bar --}}
    <div class="top-bar">
        <h2>&#9993; Email Detail</h2>
        <div class="top-bar-actions">
            <a href="{{ route('email.index') }}" class="btn btn-back">&#8592; Back to Inbox</a>
            <a href="{{ route('email.compose') }}" class="btn btn-compose">+ Compose</a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Main Card --}}
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <div class="card-header-left">
                <h1>{{ $email->subject }}</h1>
                <p>Sent {{ $email->created_at->diffForHumans() }}</p>
            </div>
            <span class="status-badge {{ $email->status === 'sent' ? 'status-sent' : 'status-failed' }}">
                @if ($email->status === 'sent')
                    &#10003; Sent
                @else
                    &#10007; Failed
                @endif
            </span>
        </div>

        {{-- Meta Grid --}}
        <div class="meta-grid">
            <div class="meta-item">
                <div class="meta-label">&#128100; Recipient Name</div>
                <div class="meta-value">{{ $email->recipient_name }}</div>
            </div>

            <div class="meta-item">
                <div class="meta-label">&#128231; Recipient Email</div>
                <div class="meta-value">
                    <span class="email-chip">&#64; {{ $email->recipient_email }}</span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">&#128197; Sent At</div>
                <div class="meta-value">{{ $email->created_at->format('F j, Y') }}</div>
            </div>

            <div class="meta-item">
                <div class="meta-label">&#128336; Time</div>
                <div class="meta-value">{{ $email->created_at->format('g:i A') }}</div>
            </div>
        </div>

        {{-- Message Body --}}
        <div class="body-section">
            <div class="body-label">&#128172; Message Body</div>
            <div class="body-content">{{ $email->body }}</div>
        </div>

        {{-- Card Footer --}}
        <div class="card-footer">
            <p class="timestamp">
                Record created: <span>{{ $email->created_at->format('d M Y, g:i A') }}</span>
            </p>

            <form
                action="{{ route('email.destroy', $email->id) }}"
                method="POST"
                class="delete-form"
                onsubmit="return confirm('Are you sure you want to delete this email record?')"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">&#128465; Delete Record</button>
            </form>
        </div>

    </div>

</div>

</body>
</html>
