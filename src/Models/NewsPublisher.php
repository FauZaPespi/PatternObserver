<?php
namespace Makosc\Observer\Models;

class NewsPublisher {
    private $subscribers = [];

    public function addSubscriber(Subscriber $subscriber) {
        $this->subscribers[] = $subscriber;
    }

    public function removeSubscriber(Subscriber $subscriber) {
        $this->subscribers = array_filter($this->subscribers, function ($sub) use ($subscriber) {
            return $sub !== $subscriber;
        });
    }

    public function publish($news) {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($news);
        }
    }
}