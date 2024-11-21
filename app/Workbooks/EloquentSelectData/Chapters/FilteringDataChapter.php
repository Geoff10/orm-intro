<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\DB;

class FilteringDataChapter extends Chapter
{
    public function id(): string
    {
        return 'filteringData';
    }

    public function title(): string
    {
        return 'Filtering Records';
    }

    public function content(): array
    {
        $selectableGenres = Book::pluck('genre')->unique()->values()->toArray();

        return [
            [
                "type" => "h2",
                "content" => "Filtering Data",
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
                "title" => "SQL: Filter Data",
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Select the genre of book to filter by.",
                        "id" => "genre",
                        "options" => $selectableGenres,
                        "default" => 'Fantasy',
                    ],
                ],
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books WHERE release_date < \"1955-01-01\" AND genre = \"Fantasy\";');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "code" => function () use ($selectableGenres): array {
                    $params = func_get_args()[0] ?? [];

                    $genre = $params['genre'] ?? 'Fantasy';

                    if (!in_array($genre, $selectableGenres)) {
                        $genre = 'Fantasy';
                    }

                    $data = DB::select('SELECT * FROM books WHERE release_date < ? AND genre = ?', [
                        '1955-01-01',
                        $genre,
                    ]);

                    if (empty($data)) {
                        $data = [
                            [
                                'Results' => 'No results found',
                            ]
                        ];
                    }

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
                "title" => "ORM: Filter Data",
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Select the genre of book to filter by.",
                        "id" => "ormGenre",
                        "options" => $selectableGenres,
                        "default" => 'Fantasy',
                    ],
                ],
                "text" => [
                    'return Book::where("release_date", "<", "1955-01-01")',
                    "\t->where(\"genre\", \"Fantasy\")",
                    "\t->get();",
                ],
                "code" => function () use ($selectableGenres): array {
                    $params = func_get_args()[0] ?? [];

                    $genre = $params['ormGenre'] ?? 'Fantasy';

                    if (!in_array($genre, $selectableGenres)) {
                        $genre = 'Fantasy';
                    }

                    $data = Book::where('release_date', '<', '1955-01-01')->where('genre', $genre)->get();

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
            ],
        ];
    }
}
