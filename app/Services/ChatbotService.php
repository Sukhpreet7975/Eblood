<?php

namespace App\Services;

class ChatbotService
{
    public function getReply(string $message): string
    {
        $message = trim($message);

        if ($message === '') {
            return 'How can I help you today?';
        }

        $keywords = ['blood', 'donor', 'request', 'availability', 'profile'];

        foreach ($keywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                return 'I can help with donor matching, emergency request guidance, and profile updates. Please tell me what you need.';
            }
        }

        return 'I can help with donor matching, donor availability, and emergency request support.';
    }
}
