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
            <h1>Welcome to AutoServe</h1>
            <h4 style="color: dark-reed;">Your No 1 Automobile Service Management System</h4>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for registering with us. We are excited to have you on board!</p>
            <p>With AutoServe, management of your workshop, sales, inventory and jobs becomes very easy.</p>
            <p>Please proceed to make payment to the bank account below;</p>
            <p>Account Name: <b>Kenton Infotech Systems Ltd </b><br>
            Account Number: <b>2001175618</b><br>
            Bank: <b>FCMB</b><br>
            Sort Code: <b>214081857</b>   
        </p>
        <p>After your payment, please forward/attach the transaction reference to this email.</p>

            <p>If you have any questions or need assistance, feel free to reach out to our support team at <a href="tel:+2349131095135">2349131095135</a> .</p>
            <p>Welcome!</p>
            <p><b>Autoserve Team</b></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AutoServe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>