<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\DB;

class ConditionallyFilteringDataChapter extends Chapter
{
    public function id(): string
    {
        return 'conditionallyFilteringData';
    }

    public function title(): string
    {
        return 'Conditionally Filtering Records';
    }

    public function content(): array
    {
        $selectableGenres = array_merge(
            [''],
            Book::pluck('genre')->unique()->values()->toArray()
        );

        return [
            [
                "type" => "h2",
                "content" => "Conditionally Filtering Data",
            ],
            [
                "type" => "p",
                "content" => "Often, we don't know what data we want to filter on until the user has submitted a form.
                For example, we might have a form with a number of filters that the user can select from. We can then
                use these filters to filter the data that we fetch from the database.",
            ],
            [
                "type" => "codeBlock",
                "text" => "\$filters = [
    'release_date' => '1955-01-01',
    'genre' => 'Fantasy',
]",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
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
                    "\$parameters = [];",
                    "\$sql = 'SELECT * FROM books WHERE'",
                    '',
                    "if (isset(\$filters['release_date'])) {",
                    "\t\$sql .= ' release_date < :release_date AND';",
                    "\t\$parameters['release_date'] = \$filters['release_date'];",
                    "}",
                    '',
                    "if (isset(\$filters['genre'])) {",
                    "\t\$sql .= ' genre = :genre AND';",
                    "\t\$parameters['genre'] = \$filters['genre'];",
                    "}",
                    '',
                    "\$sql = rtrim(\$sql, ' AND');",
                    '',
                    "\$query = \$this->db->prepare(\$sql);",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute($parameters);',
                    '',
                    'return $query->fetchAll();',
                ],
                "code" => function () use ($selectableGenres): array {
                    if (count(func_get_args()) === 0) {
                        return [];
                    }

                    $filters = [
                        'release_date' => '1955-01-01',
                    ];

                    $params = func_get_args()[0] ?? [];

                    $genre = $params['genre'];
                    if (in_array($genre, $selectableGenres) && $genre !== '') {
                        $filters['genre'] = $genre;
                    }

                    $parameters = [];
                    $sql = 'SELECT * FROM books WHERE';

                    if (isset($filters['release_date'])) {
                        $sql .= ' release_date < :release_date AND';
                        $parameters['release_date'] = $filters['release_date'];
                    }

                    if (isset($filters['genre'])) {
                        $sql .= ' genre = :genre AND';
                        $parameters['genre'] = $filters['genre'];
                    }

                    $sql = rtrim($sql, ' AND');

                    $data = DB::select($sql, $parameters);

                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => array_keys((array) $data[0]),
                            'rows' => $data,
                        ],
                        'sql' => $sql,
                        'parameters' => $parameters,
                    ];
                },
            ],
            [
                "type" => "h3",
                "content" => "ORM",
            ],
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
                    '$query = Book::query();',
                    'if (isset($filters[\'release_date\'])) {',
                    "\t\$query->where('release_date', '<', \$filters['release_date']);",
                    '}',
                    'if (isset($filters[\'genre\'])) {',
                    "\t\$query->where('genre', \$filters['genre']);",
                    '}',
                    'return $query->get();',
                ],
                "code" => function () use ($selectableGenres): array {
                    if (count(func_get_args()) === 0) {
                        return [];
                    }

                    $filters = [
                        'release_date' => '1955-01-01',
                    ];

                    $params = func_get_args()[0] ?? [];

                    $genre = $params['ormGenre'];
                    if (in_array($genre, $selectableGenres) && $genre !== '') {
                        $filters['genre'] = $genre;
                    }

                    $query = Book::query();

                    if (isset($filters['release_date'])) {
                        $query->where('release_date', '<', $filters['release_date']);
                    }

                    if (isset($filters['genre'])) {
                        $query->where('genre', $filters['genre']);
                    }

                    $data = $query->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                        'sql' => $query->toSql(),
                        'parameters' => $query->getBindings(),
                    ];
                },
            ],
        ];
    }
}
