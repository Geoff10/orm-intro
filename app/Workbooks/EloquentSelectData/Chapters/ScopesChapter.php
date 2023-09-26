<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class ScopesChapter extends Chapter
{
    public function id(): string
    {
        return 'eloquentScopes';
    }

    public function title(): string
    {
        return 'Scopes';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Scopes",
            ],
            [
                "type" => "h3",
                "content" => "Setting up a Scope",
            ],
            // [
            //     "type" => "p",
            //     "content" => "Scopes are a way to define reusable query logic for your models. They are useful for keeping your code DRY, and for encapsulating common query logic.",
            // ],
            [
                "type" => "p",
                "content" => "Scopes are defined as methods on your Eloquent model. To define a scope, prefix an Eloquent model method with scope. Here is an example of a scope that returns all books released in the 20th century:",
            ],
            [
                "type" => "codeBlock",
                "text" => implode("\n", [
                    '<?php',
                    '',
                    'class Book extends Model',
                    '{',
                    "\tpublic function scopeTwentiethCentury(Builder \$query): Builder",
                    "\t{",
                    "\t\treturn \$query->where('release_date', '<', '2000-01-01')",
                    "\t\t\t->where('release_date', '>=', '1900-01-01');",
                    "\t}",
                    '}',
                ]),
            ],
            [
                "type" => "h3",
                "content" => "Using a Scope",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Using a Scope",
                "text" => [
                    'return Book::twentiethCentury()->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormFilterDataUsingScope']),
            ],
        ];
    }
}
