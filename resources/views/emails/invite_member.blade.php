<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Bergabung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .button:hover {
            background: #218838;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hai,</h2>
        <p>Anda telah diundang untuk bergabung ke grup <strong>{{ $groupName }}</strong>.</p>
        <p>Silakan klik tautan di bawah untuk menerima undangan:</p>
        <p>
            <a href="{{ $inviteLink }}" target="_blank" class="button">Bergabung ke Grup</a>
        </p>
        <p>Jika Anda tidak mengenal undangan ini, silakan abaikan email ini.</p>
        <div class="footer">
            <p>Terima kasih!</p>
        </div>
    </div>
</body>

</html>
