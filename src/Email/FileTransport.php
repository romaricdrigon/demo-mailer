<?php

namespace App\Email;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

/**
 * File transport used in tests, we store messages on disk.
 */
class FileTransport extends AbstractTransport
{
    const FOLDER = 'var/emails';
    const FILE_EXTENSION = 'ser';

    private $path;

    public function setProjectDir(string $path): void
    {
        $this->path = sprintf('%s/%s', $path, self::FOLDER);
    }

    protected function doSend(SentMessage $message): void
    {
        dump('File transport called');

        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->path)) {
            $filesystem->mkdir($this->path);
        }

        $filename = uniqid('message_');

        // We should get rendered Message - called "original", the other "RawMessage" is a Generator to generate body chunk-by-chunk.
        $email = $message->getOriginalMessage();

        // We can serialize only Emails
        if (!$email instanceof Email) {
            return;
        }

        dump(serialize($message->getMessage()));

        // We keep classname around, as TemplatedEmail and Email serialization are incompatible
        $serialized = [
            'class' => get_class($email),
            'data' => $email->serialize(),
        ];

        $filesystem->dumpFile(
            sprintf('%s/%s.%s', $this->path, $filename, self::FILE_EXTENSION),
            serialize($serialized)
        );
    }
}
