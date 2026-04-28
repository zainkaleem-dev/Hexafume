<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sent Emails</title>
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
            padding: 32px 16px;
            color: #111827;
        }

        .page-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Top bar */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .top-bar h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar h1 .icon {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 10px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .btn-compose {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-compose:hover {
            opacity: 0.90;
            transform: translateY(-1px);
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            padding: 13px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
        }

        .alert-success::before {
            content: '✔';
            font-weight: 700;
            color: #059669;
            flex-shrink: 0;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .alert-error::before {
            content: '✕';
            font-weight: 700;
            color: #dc2626;
            flex-shrink: 0;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 130px;
            background: white;
            border-radius: 10px;
            padding: 16px 20px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-card .stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9ca3af;
        }

        .stat-card .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: #1f2937;
            line-height: 1;
        }

        .stat-card.sent .stat-value  { color: #059669; }
        .stat-card.failed .stat-value { color: #dc2626; }
        .stat-card.total .stat-value  { color: #4f46e5; }

        /* Table card */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1.5px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-header span {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .card-header .count {
            background: #ede9fe;
            color: #6d28d9;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Empty state */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
            color: #9ca3af;
        }

        .empty-state .empty-icon {
            font-size: 48px;
            margin-bottom: 14px;
            opacity: 0.4;
        }

        .empty-state p {
            font-size: 15px;
            margin-bottom: 18px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        thead th {
            padding: 12px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #6b7280;
            border-bottom: 1.5px solid #f3f4f6;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody td {
            padding: 14px 20px;
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }

        .recipient-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .recipient-name {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        .recipient-email {
            font-size: 12px;
            color: #6b7280;
        }

        .subject-cell {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
            color: #1f2937;
        }

        /* Status badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-sent {
            background: #ecfdf5;
            color: #065f46;
        }

        .badge-sent::before {
            background: #10b981;
        }

        .badge-failed {
            background: #fef2f2;
            color: #991b1b;
        }

        .badge-failed::before {
            background: #ef4444;
        }

        .date-cell {
            font-size: 12px;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* Action buttons */
        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #ede9fe;
            color: #6d28d9;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.15s;
            white-space: nowrap;
        }

        .btn-view:hover {
            background: #ddd6fe;
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fef2f2;
            color: #dc2626;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            font-family: inherit;
            white-space: nowrap;
        }

        .btn-delete:hover {
            background: #fee2e2;
        }

        /* Pagination */
        .pagination-wrapper {
            padding: 18px 24px;
            border-top: 1.5px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pagination-info {
            font-size: 13px;
            color: #6b7280;
        }

        .pagination-links {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .pagination-links a,
        .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid #e5e7eb;
            color: #374151;
            background: white;
            transition: all 0.15s;
        }

        .pagination-links a:hover {
            background: #ede9fe;
            border-color: #a78bfa;
            color: #6d28d9;
        }

        .pagination-links span.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-color: transparent;
            color: white;
        }

        .pagination-links span.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    {{-- Top bar --}}
    <div class="top-bar">
        <h1>
            <span class="icon">&#9993;</span>
            Sent Emails
        </h1>
        <a href="{{ route('email.compose') }}" class="btn-compose">
            &#43; Compose Email
        </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Stats row --}}
    <div class="stats-row">
        <div class="stat-card total">
            <span class="stat-label">Total Sent</span>
            <span class="stat-value">{{ $emails->total() }}</span>
        </div>
        <div class="stat-card sent">
            <span class="stat-label">Delivered</span>
            <span class="stat-value">{{ \App\Models\SentEmail::where('status', 'sent')->count() }}</span>
        </div>
        <div class="stat-card failed">
            <span class="stat-label">Failed</span>
            <span class="stat-value">{{ \App\Models\SentEmail::where('status', 'failed')->count() }}</span>
        </div>
    </div>

    {{-- Table card --}}
    <div class="card">

        <div class="card-header">
            <span>&#128235; All Email Records</span>
            <span class="count">{{ $emails->total() }} record{{ $emails->total() !== 1 ? 's' : '' }}</span>
        </div>

        @if ($emails->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">&#9993;</div>
                <p>No emails have been sent yet.</p>
                <a href="{{ route('email.compose') }}" class="btn-compose" style="display:inline-flex;">
                    &#43; Send Your First Email
                </a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emails as $index => $email)
                        <tr>
                            <td style="color:#9ca3af; font-size:13px;">
                                {{ ($emails->currentPage() - 1) * $emails->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="recipient-cell">
                                    <span class="recipient-name">{{ $email->recipient_name }}</span>
                                    <span class="recipient-email">{{ $email->recipient_email }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="subject-cell" title="{{ $email->subject }}">
                                    {{ $email->subject }}
                                </div>
                            </td>
                            <td>
                                @if ($email->status === 'sent')
                                    <span class="badge badge-sent">Sent</span>
                                @else
                                    <span class="badge badge-failed">Failed</span>
                                @endif
                            </td>
                            <td>
                                <div class="date-cell">
                                    {{ $email->created_at->format('M j, Y') }}<br>
                                    <span style="font-size:11px;">{{ $email->created_at->format('g:i A') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('email.show', $email->id) }}" class="btn-view">
                                        &#128065; View
                                    </a>
                                    <form action="{{ route('email.destroy', $email->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this email record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            &#128465; Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($emails->hasPages())
                <div class="pagination-wrapper">
                    <span class="pagination-info">
                        Showing {{ $emails->firstItem() }}&ndash;{{ $emails->lastItem() }} of {{ $emails->total() }} records
                    </span>
                    <div class="pagination-links">
                        {{-- Previous --}}
                        @if ($emails->onFirstPage())
                            <span class="disabled">&lsaquo;</span>
                        @else
                            <a href="{{ $emails->previousPageUrl() }}">&lsaquo;</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach ($emails->getUrlRange(1, $emails->lastPage()) as $page => $url)
                            @if ($page == $emails->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($emails->hasMorePages())
                            <a href="{{ $emails->nextPageUrl() }}">&rsaquo;</a>
                        @else
                            <span class="disabled">&rsaquo;</span>
                        @endif
                    </div>
                </div>
            @endif

        @endif
    </div>

</div>

</body>
</html>
