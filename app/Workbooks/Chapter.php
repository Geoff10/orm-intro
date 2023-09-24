<?php

declare(strict_types=1);

namespace App\Workbooks;

abstract class Chapter
{
    abstract public function id(): string;
    abstract public function title(): string;
    abstract public function content(): array;

    public function toArray(?array $properties = null): array
    {
        $array = [
            'id' => $this->id(),
            'title' => $this->title(),
            'content' => $this->content(),
        ];

        return $properties ?
            array_filter($array, fn ($key) => in_array($key, $properties), ARRAY_FILTER_USE_KEY) :
            $array;
    }
}
