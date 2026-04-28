<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle the Hexafume contact form submission.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "phone" => ["nullable", "string", "max:50"],
            "service" => ["required", "string", "max:255"],
            "message" => ["required", "string", "min:10"],
        ]);

        $adminEmail = env("ADMIN_EMAIL", "mujtaba@quadtrum.com");
        $subject = "New Inquiry: " . $validated["service"];
        $body = $this->formatBody($validated);
        $status = "sent";

        try {
            Mail::to($adminEmail)->send(
                (new ContactMail(
                    senderName: $validated["name"],
                    senderEmail: $validated["email"],
                    senderPhone: $validated["phone"] ?? null,
                    service: $validated["service"],
                    userMessage: $validated["message"],
                ))->replyTo($validated["email"], $validated["name"]),
            );
        } catch (\Exception $e) {
            Log::error("Email Sending Failed: " . $e->getMessage());
            $status = "failed";
        }

        SentEmail::create([
            "recipient_email" => $adminEmail,
            "recipient_name" => $validated["name"],
            "sender_email"   => $validated["email"],
            "sender_name"    => $validated["name"],
            "direction"      => "received",
            "subject"        => $subject,
            "body"           => $body,
            "status"         => $status,
        ]);

        return response()->json([
            "success" => $status === "sent",
            "message" =>
                $status === "sent"
                    ? "Thank you, {$validated["name"]}! Your message has been sent. We'll be in touch shortly."
                    : "There was an issue sending your message. Please try again or reach us at support@hexafume.com.",
        ]);
    }

    /**
     * Format all contact details into a plain-text body for logging.
     */
    private function formatBody(array $data): string
    {
        $phone = $data["phone"] ?? "Not provided";

        return implode("\n", [
            "Name:    {$data["name"]}",
            "Email:   {$data["email"]}",
            "Phone:   {$phone}",
            "Service: {$data["service"]}",
            "",
            "Message:",
            $data["message"],
        ]);
    }
}
