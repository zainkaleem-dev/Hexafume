<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Show the email compose form.
     */
    public function compose()
    {
        return view("email.compose");
    }

    /**
     * Show all sent emails.
     */
    public function index()
    {
        $emails = SentEmail::latest()->paginate(10);
        return view("email.index", compact("emails"));
    }

    /**
     * Show a single sent email.
     */
    public function show(SentEmail $email)
    {
        return view("email.show", compact("email"));
    }

    /**
     * Handle the email send request.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            "to" => ["required", "email"],
            "name" => ["required", "string", "max:255"],
            "subject" => ["required", "string", "max:255"],
            "body" => ["required", "string"],
        ]);

        $status = "sent";

        try {
            Mail::to($validated["to"])->send(
                new SendEmail(
                    senderName: $validated["name"],
                    emailSubject: $validated["subject"],
                    emailBody: $validated["body"],
                ),
            );
        } catch (\Exception $e) {
            $status = "failed";
        }

        SentEmail::create([
            "recipient_email" => $validated["to"],
            "recipient_name" => $validated["name"],
            "direction" => "sent",
            "subject" => $validated["subject"],
            "body" => $validated["body"],
            "status" => $status,
        ]);

        if ($status === "failed") {
            return redirect()
                ->route("email.compose")
                ->withInput()
                ->with(
                    "error",
                    "Failed to send email to " .
                        $validated["to"] .
                        ". Please check your mail configuration.",
                );
        }

        return redirect()
            ->route("email.index")
            ->with(
                "success",
                "Email sent successfully to " . $validated["to"] . "!",
            );
    }

    /**
     * Delete a sent email record.
     */
    public function destroy(SentEmail $email)
    {
        $email->delete();
        return redirect()
            ->route("email.index")
            ->with("success", "Email record deleted successfully.");
    }

    /**
     * Admin messages page — list all sent emails for the admin panel.
     */
    public function adminIndex()
    {
        $messages = SentEmail::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(function (SentEmail $msg) {
                $senderEmail = $msg->sender_email;
                $senderName  = $msg->sender_name ?: $msg->recipient_name;

                if (!$senderEmail) {
                    $parsed = $this->parseContactBody($msg->body);
                    $senderEmail = $parsed['sender_email'];
                    $senderName  = $parsed['sender_name'] ?: $senderName;
                }

                return [
                    'id'           => $msg->id,
                    'sender_name'  => $senderName,
                    'sender_email' => $senderEmail,
                    'direction'    => $msg->direction ?: ($senderEmail ? 'received' : 'sent'),
                    'subject'      => $msg->subject,
                    'body'         => $msg->body,
                    'status'       => $msg->status,
                    'created_at'   => $msg->created_at->format('M d, Y h:i A'),
                    'time_ago'     => $msg->created_at->diffForHumans(),
                    'initials'     => strtoupper(substr($senderName, 0, 2)),
                ];
            })
            ->values();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Admin single message view page.
     */
    public function adminShow(SentEmail $email)
    {
        $parsedBody  = $this->parseContactBody($email->body);
        $senderEmail = $email->sender_email ?: $parsedBody['sender_email'];
        $senderName  = $email->sender_name ?: ($parsedBody['sender_name'] ?: $email->recipient_name);

        $message = [
            'id'           => $email->id,
            'sender_name'  => $senderName,
            'sender_email' => $senderEmail,
            'recipient_email' => $email->recipient_email,
            'direction'    => $email->direction ?: ($senderEmail ? 'received' : 'sent'),
            'subject'      => $email->subject,
            'body'         => $email->body,
            'status'       => $email->status,
            'created_at'   => $email->created_at->format('M d, Y h:i A'),
            'time_ago'     => $email->created_at->diffForHumans(),
            'initials'     => strtoupper(substr($senderName, 0, 2)),
            'date_full'    => $email->created_at->format('l, F j, Y \a\t g:i A'),
            'parsed'       => $parsedBody,
        ];

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Admin reply to a message — sends the email TO the sender (the person who filled the contact form).
     */
    public function adminReply(Request $request, SentEmail $email)
    {
        $validated = $request->validate([
            'reply_subject' => ['required', 'string', 'max:255'],
            'reply_body'    => ['required', 'string'],
        ]);

        $senderEmail = $email->sender_email;
        if (!$senderEmail) {
            $parsed = $this->parseContactBody($email->body);
            $senderEmail = $parsed['sender_email'];
        }

        if (!$senderEmail) {
            return response()->json([
                'success' => false,
                'message' => 'No sender email address found for this message.',
            ], 422);
        }

        $senderName = $email->sender_name ?: $email->recipient_name;
        $status = 'sent';

        try {
            Mail::to($senderEmail)->send(
                new SendEmail(
                    senderName: $senderName,
                    emailSubject: $validated['reply_subject'],
                    emailBody: $validated['reply_body'],
                ),
            );
        } catch (\Exception $e) {
            $status = 'failed';
        }

        SentEmail::create([
            'recipient_email' => $senderEmail,
            'recipient_name'  => $senderName,
            'direction'       => 'sent',
            'subject'         => $validated['reply_subject'],
            'body'            => $validated['reply_body'],
            'status'          => $status,
        ]);

        if ($status === 'failed') {
            return response()->json([
                'success' => false,
                'message' => "Failed to send reply to {$senderEmail}. Check your mail configuration.",
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => "Reply sent successfully to {$senderEmail}!",
        ]);
    }

    /**
     * Admin delete a message record (AJAX).
     */
    public function adminDestroy(SentEmail $email)
    {
        $deletedId = $email->id;
        $email->delete();

        return response()->json([
            'success' => true,
            'deleted_id' => $deletedId,
            'message' => 'Message deleted successfully.',
        ]);
    }

    /**
     * Try to extract structured fields from a contact-form body.
     */
    private function parseContactBody(string $body): array
    {
        $parsed = [
            'sender_name'  => null,
            'sender_email' => null,
            'sender_phone' => null,
            'service'      => null,
            'message'      => null,
        ];

        if (preg_match('/^Name:\s*(.+)$/m', $body, $m)) {
            $parsed['sender_name'] = trim($m[1]);
        }
        if (preg_match('/^Email:\s*(.+)$/m', $body, $m)) {
            $parsed['sender_email'] = trim($m[1]);
        }
        if (preg_match('/^Phone:\s*(.+)$/m', $body, $m)) {
            $val = trim($m[1]);
            $parsed['sender_phone'] = ($val !== 'Not provided') ? $val : null;
        }
        if (preg_match('/^Service:\s*(.+)$/m', $body, $m)) {
            $parsed['service'] = trim($m[1]);
        }
        if (preg_match('/Message:\s*\n(.+)/s', $body, $m)) {
            $parsed['message'] = trim($m[1]);
        }

        return $parsed;
    }
}
