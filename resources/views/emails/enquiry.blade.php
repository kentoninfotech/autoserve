<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0;
        }
        .content {
            margin-bottom: 20px;
        }
        .content p {
            font-size: 16px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Enquiry from AutoServe Online</h1>
        </div>
        <div class="content">
            <p><strong>Message:</strong></p>
            <p>{{ $user_message }}</p>
            <p><strong>From:</strong></p>
            <p>{{ $name }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AutoServe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>