<?php

declare(strict_types=1);

namespace App\Workbooks;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Chapter
{
    abstract public function id(): string;
    abstract public function title(): string;
    abstract public function content(): array;

    protected bool $hideClosures = false;

    public function toArray(?array $properties = null): array
    {
        $array = [
            'id' => $this->id(),
            'title' => $this->title(),
            'content' => $this->getContent(),
        ];

        return $properties ?
            array_filter($array, fn ($key) => in_array($key, $properties), ARRAY_FILTER_USE_KEY) :
            $array;
    }

    public function workbookId(): string
    {
        return Str::of($this::class)
            ->replaceFirst('App\\Workbooks\\', '')
            ->explode('\\')
            ->first();
    }

    public function getContent(): array
    {
        return collect($this->content())
            ->when($this->hideClosures, function (Collection $content) {
                return $content->map(function (array $content) {
                    if (isset($content['code'])) {
                        $content['code'] = null;
                    }

                    return $content;
                });
            })
            ->map(function (array $content, int $index) {
                if (
                    ($content['type'] === 'runnableCodeBlock' || $content['type'] === 'triggerButton') &&
                    !isset($content['route'])
                ) {
                    $content['route'] = route('preview', [
                        'workbook' => $this->workbookId(),
                        'chapter' => $this->id(),
                        'exercise' => $index,
                    ]);
                }

                return $content;
            })->toArray();
    }

    public function setHideClosures(bool $hideClosures = true): void
    {
        $this->hideClosures = $hideClosures;
    }
}
