<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 28px 32px;
            color: white;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.85;
            margin-top: 4px;
        }

        .form-body {
            padding: 32px;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success::before {
            content: '✔';
            font-weight: bold;
            color: #059669;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-error ul {
            padding-left: 18px;
            margin-top: 6px;
        }

        .alert-error li {
            margin-bottom: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            color: #111827;
            background: #f9fafb;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .form-group input.is-invalid,
        .form-group textarea.is-invalid {
            border-color: #f87171;
            background: #fff5f5;
        }

        .form-group .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
            line-height: 1.6;
        }

        .form-row {
            display: flex;
            gap: 16px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn-send {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 8px;
        }

        .btn-send:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-send:active {
            transform: translateY(0);
            opacity: 1;
        }

        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>&#9993; Compose Email</h1>
        <p>Fill in the details below to send your email.</p>
    </div>

    <div class="form-body">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('email.send') }}" method="POST" novalidate>
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="to">To (Email Address)</label>
                    <input
                        type="email"
                        id="to"
                        name="to"
                        placeholder="recipient@example.com"
                        value="{{ old('to') }}"
                        class="{{ $errors->has('to') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('to')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Recipient Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="John Doe"
                        value="{{ old('name') }}"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    placeholder="Enter the email subject..."
                    value="{{ old('subject') }}"
                    class="{{ $errors->has('subject') ? 'is-invalid' : '' }}"
                    required
                >
                @error('subject')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">Message</label>
                <textarea
                    id="body"
                    name="body"
                    placeholder="Write your message here..."
                    class="{{ $errors->has('body') ? 'is-invalid' : '' }}"
                    required
                >{{ old('body') }}</textarea>
                @error('body')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-send">&#9993; Send Email</button>
        </form>


    </div>
</div>

</body>
</html>
