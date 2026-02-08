<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DemoRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'lab_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $to = config('mail.demo_request_to', 'support@labtech.lk');

        try {
            Mail::send('emails.demo_request', ['data' => $data], function ($message) use ($data, $to) {
                $subject = 'New Demo Request - ' . $data['lab_name'];
                $message->to($to)->subject($subject);
                $message->replyTo($data['email'], $data['name']);
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->with('demo_error', 'Sorry, we could not send your request right now. Please try again.');
        }

        return back()->with('demo_success', 'Thanks! Your demo request has been sent. We will contact you soon.');
    }
}
