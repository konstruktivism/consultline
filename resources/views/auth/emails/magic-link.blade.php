<!-- resources/views/auth/emails/magic-link.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Link</title>
</head>
<body>
<p>Click the link below to login:</p>
<a href="{{ $link }}">{{ $link }}</a>
</body>
</html>
