<?php

namespace Makosc\Observer\Models;

class Thread
{
    public string $Content;
    public \DateTime $PostDate;
    public int $UserId;
    public static function fromArray(array $data): self
    {
        $thread = new self();
        $thread->Content = $data['content'] ?? '';
        $thread->PostDate = isset($data['created_at']) ? new \DateTime($data['created_at']) : new \DateTime();
        $thread->UserId = (int)($data['user_id'] ?? 0);
        return $thread;
    }

    public function toArray(): array
    {
        return [
            'content' => trim(htmlspecialchars($this->Content)),
            'created_at' => $this->PostDate->format('Y-m-d H:i:s'),
            'user_id' => $this->UserId,
        ];
    }
}
