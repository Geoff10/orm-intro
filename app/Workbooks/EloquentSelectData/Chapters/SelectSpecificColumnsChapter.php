<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\DB;

class SelectSpecificColumnsChapter extends Chapter
{
    public function id(): string
    {
        return 'selectSpecificColumns';
    }

    public function title(): string
    {
        return 'Select Data With Specific Columns';
    }

    public function content(): array
    {
        $selectableColumns = [
            'id',
            'author_id',
            'title',
            'genre',
            'release_date',
            'created_at',
            'updated_at',
        ];

        return [
            [
                "type" => "h2",
                "content" => "Fetching Specific Columns",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The SQL statement to fetch a record by ID from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Choose Columns to Select",
                "params" => [
                    [
                        "type" => "checkbox",
                        "label" => "Select the columns to fetch from the table.",
                        "id" => "columns",
                        "options" => $selectableColumns,
                        "default" => ["title", "genre", "release_date"],
                    ],
                ],
                "text" => [
                    "\$query = \$this->db->prepare('SELECT title, genre, release_date FROM books;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "code" => function () use ($selectableColumns): array {
                    $params = func_get_args()[0] ?? [];

                    $columns = $params['columns'] ?? ['title', 'genre', 'release_date'];
                    $columns = array_intersect($columns, $selectableColumns);
                    $columns = empty($columns) ? '*' : implode(', ', $columns);

                    $data = DB::select("SELECT {$columns} FROM books");

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys((array) $data[0]),
                            'rows' => $data,
                        ],
                    ];
                },
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The ORM statement to fetch a record by ID from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Choose Columns to Select",
                "params" => [
                    [
                        "type" => "checkbox",
                        "label" => "Select the columns to fetch from the table.",
                        "id" => "ormColumns",
                        "options" => $selectableColumns,
                        "default" => ["title", "genre", "release_date"],
                    ],
                ],
                "text" => [
                    'return Book::select("title", "genre", "release_date")->get();',
                ],
                "code" => function () use ($selectableColumns): array {
                    $params = func_get_args()[0] ?? [];

                    $columns = $params['ormColumns'] ?? ['title', 'genre', 'release_date'];
                    $columns = array_intersect($columns, $selectableColumns);

                    $data = Book::select(...$columns)->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                },
                // "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectChooseColumns']),
            ],
        ];
    }
}
