<!-- resources/views/auth/emails/magic-link.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Link</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            width: 100%;
            margin: 40px auto 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007BFF;
        }

        .content {
            line-height: 1.6;
        }

        .content p {
            margin: 0;
            margin-bottom: 20px;
        }


        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <div style="display: inline-block; width: auto;">
                        Thank you for creating a chat! <br /><br /> <a href="{{ $link }}" style="background-color: #007bff; color: #ffffff; display: inline-block; padding: 10px 20px; text-decoration: none; margin: 0; font-weight: bold; border-radius: 6px;">Login</a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
