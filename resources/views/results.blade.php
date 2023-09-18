<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <style>
        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        td, th {
            padding: 0.5rem;
            border: 1px solid black;
        }

        .properties {
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    @isset($results['properties'])
        <div class="properties">
            @foreach ($results['properties'] as $property => $value)
                <strong>{{ $property }}:</strong> {{ $value }}
            @endforeach
        </div>
    @endisset
    {{-- TODO: When this is an object, make a 'hasTable' method and use it --}}
    @isset($results['table'])
        <table>
            <thead>
                <tr>
                    @foreach ($results['table']['headers'] as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($results['table']['rows'] as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
</body>
</html>
