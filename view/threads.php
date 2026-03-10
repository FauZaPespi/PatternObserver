<?php
$newsPublisher = new NewsPublisher();
$subscriber1 = new ConcreteSubscriber("Subscriber 1");
$subscriber2 = new ConcreteSubscriber("Subscriber 2");

$newsPublisher->addSubscriber($subscriber1);
$newsPublisher->addSubscriber($subscriber2);

$newsPublisher->publish("Breaking News 1");
$newsPublisher->removeSubscriber($subscriber1);
$newsPublisher->publish("Breaking News 2");