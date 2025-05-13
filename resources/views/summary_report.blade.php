<!DOCTYPE html>
<html>
    <head>
        <title>Report Summary</title>
    </head>
    <body>
        <h2>Report Summary</h2>
        <table border="1" cellpadding="6" cellspacing="0" class="table table-striped">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($summary as $key => $item)
                        <tr>
                            <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                            <td>{{ $item }}</td>
                        </tr>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </body>
</html>
