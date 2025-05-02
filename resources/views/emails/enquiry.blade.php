<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
        }
        .content {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Enquiry from AutoServer Online</h1>
        </div>
        <div class="content">
            
        <p>{{$request->message}}</p>
        <p>From: <br>{{$request->name}}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AutoServe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>