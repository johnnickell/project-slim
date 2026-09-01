<?php

declare(strict_types=1);

namespace App\Platform;

use Fight\Common\Application\Socket\Publisher;

final class NullPublisher implements Publisher
{
    /** @var list<array{topic: string, message: string}> */
    private array $messages = [];

    public function push(string $topic, string $message): void
    {
        $this->messages[] = ['topic' => $topic, 'message' => $message];
    }

    /** @return list<array{topic: string, message: string}> */
    public function messages(): array
    {
        return $this->messages;
    }
}
