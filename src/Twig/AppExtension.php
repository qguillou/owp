<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('period', [$this, 'formatPeriod']),
        ];
    }

    public function formatPeriod($start, $end = NULL)
    {
        if (empty($end) || $start->getTimestamp() === $end->getTimestamp()) {
            $date = strftime('%A %d %B %Y at %H:%M', $start->getTimestamp());
        } elseif ($start->format('d') === $end->format('d')) {
            $date = strftime('%A %d %B %Y from %H:%M', $start->getTimestamp()) . ' to ' . strftime('%H:%M', $start->getTimestamp());
        } else {
            $date = strftime('From %A %d %B %Y at %H:%M', $start->getTimestamp()) . ' to ' . strftime('%A %d %B %Y at %H:%M', $end->getTimestamp());
        }

        return $date;
    }
}
