<?php

namespace App\Http\Actions;


class Action {

    public function sendTelegramMessage(string $message): void {
        $response = \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
            'chat_id' => env('GROUP_CHAT_ID'),
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);
    
        if ($response->failed()) {
            \Log::error('Telegram message failed', ['error' => $response->body()]);
        }
    }
    
    
}
