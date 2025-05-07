<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Chatify\Facades\ChatifyMessenger as Chatify;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Listen to the Login event
        Event::listen(Login::class, function ($event) {
            // Fetch the OpenAI API key from the .env file
            $apiKey = env('OPENAI_API_KEY');

            // Send a welcome message to OpenAI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Choose the OpenAI model
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => 'Welcome to My Honorian Buddy!'],
                ],
            ]);
            // Check if the API call was successful
            if ($response->successful()) {
                $aiMessage = $response['choices'][0]['message']['content'];

                // Insert the AI message into the ch_messages table
                $message = Chatify::newMessage([
                    'from_id' => 999999,
                    'to_id' => $event->user->id,
                    'body' => $aiMessage,
                    'attachment' => null,
                ]);
            
                // Notify both users of the new conversation
                Chatify::push("private-chatify." . $event->user->id, 'messaging', [
                    'from_id' => 999999,
                    'to_id' => $event->user->id,
                    'message' => Chatify::messageCard(Chatify::parseMessage($message), true)
                ]);

            }
        });
    }
}
