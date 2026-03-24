<?php
namespace Makosc\Observer\Models;
class ConcreteSubscriber implements Subscriber {
    private $pusher;

    public function __construct($pusherClient) {
        $this->pusher = $pusherClient;
    }

    public function update($news) {
        $this->pusher->trigger('notifications-channel', 'new-thread', [
            'news' => $news
        ]);
    }
}