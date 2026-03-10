<?php
namespace Makosc\Observer\Models;
class ConcreteSubscriber implements Subscriber {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update($news) {
        echo "{$this->name} received news: {$news}\n";
    }
}