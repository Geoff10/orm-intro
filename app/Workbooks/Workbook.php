<?php

declare(strict_types=1);

namespace App\Workbooks;

use Illuminate\Support\Collection;

abstract class Workbook
{
    abstract public function id(): string;
    abstract public function title(): string;
    abstract protected function chapters(): array;

    protected bool $hideClosures = false;

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'title' => $this->title(),
            'chapters' => $this->getChapters(),
        ];
    }

    public function getChapters(): array
    {
        return collect($this->chapters())
            ->when($this->hideClosures, function (Collection $chapters) {
                return $chapters->each(fn (Chapter $chapter) => $chapter->setHideClosures());
            })
            ->keyBy(fn (Chapter $chapter) => $chapter->id())
            ->toArray();
    }

    public function getChapter(string $chapter): ?Chapter
    {
        return $this->getChapters()[$chapter] ?? null;
    }

    public function getNextChapter(string $chapter): ?Chapter
    {
        $chapters = $this->getChapters();

        $keys = array_keys($chapters);

        $index = array_search($chapter, $keys);

        if ($index === false) {
            return null;
        }

        $nextChapter = $keys[$index + 1] ?? null;

        if (!$nextChapter) {
            return null;
        }

        return $chapters[$nextChapter];
    }

    public function getPreviousChapter(string $chapter): ?Chapter
    {
        $chapters = $this->getChapters();

        $keys = array_keys($chapters);

        $index = array_search($chapter, $keys);

        if ($index === false) {
            return null;
        }

        $previousChapter = $keys[$index - 1] ?? null;

        if (!$previousChapter) {
            return null;
        }

        return $chapters[$previousChapter];
    }

    public function setHideClosures(bool $hideClosures = true): void
    {
        $this->hideClosures = $hideClosures;
    }
}
