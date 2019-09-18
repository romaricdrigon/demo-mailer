<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Event\MessageEvent;

class MailSubscriber implements EventSubscriberInterface
{
    public function onMessage(MessageEvent $event)
    {
        dump('MailSubscriber was called');

        dump(serialize($event->getMessage()));
    }

    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::class => 'onMessage',
        ];
    }
}
