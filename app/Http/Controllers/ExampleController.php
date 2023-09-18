<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $module, string $exercise)
    {
        $example = $this->getExample($module, $exercise);

        if ($example) {
            return view('results', [
                'results' => $example(),
            ]);
        }

        return abort(404);
    }

    private function getExample(string $module, string $exercise): ?callable
    {
        $modules = $this->modules();

        if (!isset($modules[$module])) {
            return null;
        }

        if (!isset($modules[$module][$exercise])) {
            return null;
        }

        return $modules[$module][$exercise];
    }

    private function modules(): array
    {
        return [
            'sqlSelectData' => [
                'sqlSelectAll' => function (): array {
                    return [
                        'properties' => [
                            'Method' => 'SQL',
                        ],
                        'table' => [
                            'headers' => ['id', 'name', 'number of sides'],
                            'rows' => [
                                ['1', 'triangle', 3],
                                ['2', 'square', 4],
                                ['3', 'rectangle', 4],
                            ]
                        ],
                    ];
                },
                'ormSelectAll' => function (): array {
                    return [
                        'properties' => [
                            'Method' => 'Eloquent ORM',
                        ],
                        'table' => [
                            'headers' => ['id', 'name', 'number of sides'],
                            'rows' => [
                                ['1', 'triangle', 3],
                                ['2', 'square', 4],
                                ['3', 'rectangle', 4],
                            ]
                        ],
                    ];
                },
            ],
        ];
    }
}
