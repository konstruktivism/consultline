<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Chat</title>
</head>
<body>
<form action="{{ route('chat.start') }}" method="POST">
    @csrf
    <label for="professional_id">Select Professional:</label>
    <select name="professional_id" id="professional_id">
        <!-- Populate with professionals -->
        <option value="1">Professional 1</option>
        <option value="2">Professional 2</option>
    </select>
    <button type="submit">Start Chat</button>
</form>
</body>
</html>
