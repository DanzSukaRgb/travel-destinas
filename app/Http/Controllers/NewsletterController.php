<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => ['required', 'email', 'max:255'],
            ]);

            $exists = Newsletter::where('email', $validated['email'])->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed. Thank you!',
                ], 409);
            }

            Newsletter::create([
                'email'         => $validated['email'],
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '🎉 Welcome to Roam! You\'re now subscribed for travel inspiration.',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }
}
