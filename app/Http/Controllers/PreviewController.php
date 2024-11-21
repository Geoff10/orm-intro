<?php

namespace App\Http\Controllers;

use App\Workbooks\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $workbook, string $chapter, int $exercise)
    {
        $chapter = ucfirst($chapter);
        $chapterClass = "App\\Workbooks\\{$workbook}\\Chapters\\{$chapter}Chapter";
        if (!is_subclass_of($chapterClass, Chapter::class)) {
            return abort(418);
        }

        Log::error("Previewing {$workbook} {$chapter} exercise {$exercise}");

        $content = (new $chapterClass())->getContent();
        $block = $content[$exercise] ?? null;

        if (!$block || $block['type'] !== 'runnableCodeBlock' || !isset($block['code'])) {
            Log::error("There is no block, or the block is not a runnable code block, or the block does not have code.");
            return abort(404);
        }

        DB::connection()->enableQueryLog();

        $example = $block['code'];

        if ($example) {
            try {
                $results = view('results', [
                    'results' => $example($request->input('params', [])),
                ])->render();
            } catch (\Throwable $th) {
                $results = view('exception', [
                    'type' => get_class($th),
                    'message' => $th->getMessage(),
                ])->render();
            }

            $queryLog = collect(DB::getQueryLog())
                ->map(function ($query) {
                    $bindings = array_map(function ($binding) use (&$count) {
                        if ($binding instanceof \DateTimeInterface) {
                            $format = $binding->format('Y-m-d H:i:s');
                            return "'{$format}'";
                        }

                        if (is_string($binding)) {
                            return "'{$binding}'";
                        }

                        if (is_bool($binding)) {
                            return $binding ? 'true' : 'false';
                        }

                        if (is_null($binding)) {
                            return 'null';
                        }

                        return $binding;
                    }, $query['bindings']);

                    $query['sql'] = Str::replaceArray('?', $bindings, $query['query']);

                    return $query;
                });

            return response()->json([
                'results' => $results,
                'queries' => $queryLog,
            ]);
        }

        Log::error("There was an error running the example.");
        return abort(404);
    }
}
