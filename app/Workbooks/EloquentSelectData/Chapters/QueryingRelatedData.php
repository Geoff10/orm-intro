<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class QueryingRelatedData extends Chapter
{
    public function id(): string
    {
        return 'queryingRelatedData';
    }

    public function title(): string
    {
        return 'Querying Related Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Querying Related Data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Select Books and Authors",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT books.id, authors.name, books.title, books.genre, books.release_date FROM books INNER JOIN authors ON books.author_id = authors.id;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSelectBooksAndAuthors']),
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            [
                "type" => "p",
                "content" => "Define a relations between the Book and Author models."
            ],
            [
                "type" => "codeBlock",
                "title" => "Snippet of book model with relationship to author",
                "text" => implode("\n", [
                    'class Book extends Model',
                    '{',
                    '    public function author(): BelongsTo',
                    '    {',
                    '        return $this->belongsTo(Author::class);',
                    '    }',
                    '}',
                ]),
            ],
            [
                "type" => "p",
                "content" => "Query the books table and pass the result of the query to the view code that is responsible for displaying the data.",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select Books and Authors",
                "text" => [
                    '$books = Book::all();',
                    '',
                    '// view code - for displaying the data',
                    'foreach ($books as $book) {',
                    '    echo "<td>" . $book->id . "</td>";',
                    '    echo "<td>" . $book->title . "</td>";',
                    '    echo "<td>" . $book->author->name . "</td>";',
                    '    echo "<td>" . $book->genre . "</td>";',
                    '    echo "<td>" . $book->release_date . "</td>";',
                    '}',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectBooksAndAuthors']),
            ],
            [
                "type" => "h3",
                "content" => "ORM: Improved with Eager Loading",
            ],
            [
                "type" => "p",
                "content" => "This time when querying the books table, eloquent is told to also load the author data for each book. This is called eager loading.",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select Books and Authors with Eager Loading",
                "text" => [
                    '$books = Book::with("author")->get();',
                    '',
                    '// view code - for displaying the data',
                    'foreach ($books as $book) {',
                    '    echo "<td>" . $book->id . "</td>";',
                    '    echo "<td>" . $book->title . "</td>";',
                    '    echo "<td>" . $book->author->name . "</td>";',
                    '    echo "<td>" . $book->genre . "</td>";',
                    '    echo "<td>" . $book->release_date . "</td>";',
                    '}',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectBooksAndAuthorsEagerLoading']),
            ]
        ];
    }
}
