<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\DB;

class SelectDataChapter extends Chapter
{
    public function id(): string
    {
        return 'selectData';
    }

    public function title(): string
    {
        return 'Select Data';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Fetching all data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The SQL statement to fetch all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Select All",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                'code' => function (): array {
                    $data = DB::select('SELECT * FROM books');

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
            //     "content" => "The ORM statement to fetch all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM: Select All",
                "text" => [
                    'return Book::get();',
                ],
                "code" => function (): array {
                    $data = Book::get();

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
                // "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSelectAll']),
            ],
        ];
    }
}
