<?php
namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class Instance extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceOf']),
        ];
    }

    public function isInstanceOf($object, string $class): bool
    {
        return $object instanceof $class;
    }
}
