<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Models\Book;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\DB;

class SortingDataChapter extends Chapter
{
    public function id(): string
    {
        return 'sortingData';
    }

    public function title(): string
    {
        return 'Sorting Data';
    }

    public function content(): array
    {
        $selectableOrders = ['ASC', 'DESC'];

        return [
            [
                "type" => "h2",
                "content" => "Sorting Data",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            // [
            //     "type" => "p",
            //     "content" => "The SQL statement to sort all data from a table is:",
            // ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL: Sort Data",
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books ORDER BY release_date;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'sqlSortData']),
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
                "title" => "ORM: Sort Data",
                "text" => [
                    'return Book::orderBy("release_date")->get();',
                ],
                "route" => route('example', ['module' => 'sqlSelectData', 'exercise' => 'ormSortData']),
            ],
            [
                "type" => "h2",
                "content" => "Controlling the sort order",
            ],
            [
                "type" => "p",
                "content" => "By default, the sort order is ascending, but sometimes we want to sort in descending order.",
            ],
            [
                "type" => "h3",
                "content" => "SQL",
            ],
            [
                "type" => "runnableCodeBlock",
                "title" => "SQL",
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Choose the sort order.",
                        "id" => "order",
                        "options" => $selectableOrders,
                        "default" => 'DESC',
                    ],
                ],
                "text" => [
                    "\$query = \$this->db->prepare('SELECT * FROM books ORDER BY release_date DESC;');",
                    '$query->setFetchMode(PDO::FETCH_ASSOC);',
                    '$query->execute();',
                    '',
                    'return $query->fetchAll();',
                ],
                "code" => function () use ($selectableOrders): array {
                    $params = func_get_args()[0] ?? [];

                    $order = $params['order'] ?? null;
                    if (!in_array($order, $selectableOrders)) {
                        $order = 'DESC';
                    }

                    $data = DB::select('SELECT * FROM books ORDER BY release_date ' . $order);

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
            [
                "type" => "runnableCodeBlock",
                "title" => "ORM",
                "params" => [
                    [
                        "type" => "select",
                        "label" => "Choose the sort order.",
                        "id" => "ormOrder",
                        "options" => $selectableOrders,
                        "default" => 'DESC',
                    ],
                ],
                "text" => [
                    'return Book::orderBy("release_date", "desc")->get();',
                ],
                "code" => function () use ($selectableOrders): array {
                    $params = func_get_args()[0] ?? [];

                    $order = $params['ormOrder'] ?? null;
                    if (!in_array($order, $selectableOrders)) {
                        $order = 'DESC';
                    }

                    $data = Book::orderBy('release_date', $order)->get();

                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => array_keys($data->first()->toArray()),
                            'rows' => $data->toArray(),
                        ],
                    ];
                }
            ]
        ];
    }
}
