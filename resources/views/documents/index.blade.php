<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Async Document Processing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 40px;
        }
        h1 {
            margin-bottom: 5px;
        }
        p {
            color: #555;
            margin-top: 0;
        }
        form {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .status {
            font-weight: bold;
        }
        .pending { color: orange; }
        .processing { color: blue; }
        .processed { color: green; }
        .failed { color: red; }
    </style>
</head>
<body>

<h1>Async Document Processing Demo</h1>
<p>Visualizing background jobs, queues, and retries in Laravel.</p>

<form id="uploadForm">
    <input type="file" name="file" required>
    <button type="submit">Upload Document</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>File Name</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
    </thead>
    <tbody id="documentsTable">
        @foreach ($documents as $doc)
            <tr>
                <td>{{ $doc->id }}</td>
                <td>{{ $doc->original_name }}</td>
                <td class="status {{ $doc->status }}">{{ $doc->status }}</td>
                <td>{{ $doc->created_at }}</td>
                <td>{{ $doc->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    const form = document.getElementById('uploadForm');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        await fetch('/api/documents', {
            method: 'POST',
            body: formData
        });

        form.reset();
    });

    setInterval(async () => {
        const response = await fetch('/');
        const html = await response.text();
        const temp = document.createElement('div');
        temp.innerHTML = html;
        document.getElementById('documentsTable').innerHTML =
            temp.querySelector('#documentsTable').innerHTML;
    }, 3000);
</script>

</body>
</html>