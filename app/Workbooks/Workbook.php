<?php

declare(strict_types=1);

namespace App\Workbooks;

abstract class Workbook
{
    abstract public function title(): string;
    abstract public function content(): array;

    public function toArray(): array
    {
        return [
            'title' => $this->title(),
            'content' => $this->content(),
        ];
    }
}
