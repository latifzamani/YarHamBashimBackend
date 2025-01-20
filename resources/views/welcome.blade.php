<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #0c70e2;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.5;
        }
        .email-body h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-footer {
            background-color: #0c70e2;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .email-footer a {
            color: #ffffff;
            text-decoration: underline;
        }
        .info-section {
            background-color: #f0f4f8;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        .info-section h4 {
            margin: 0;
            font-size: 16px;
            color: #0c70e2;
        }
        .info-section p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            .email-body {
                padding: 15px;
            }
            .email-header, .email-footer {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <h1>Contact Message</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello,</h2>
            <p>You have received a new message from the contact form.</p>

            <div class="info-section">
                <h4>Full Name</h4>
                <p>{{ $email['fullName'] }}</p>
            </div>

            <div class="info-section">
                <h4>Email</h4>
                <p>{{ $email['email'] }}</p>
            </div>

            <div class="info-section">
                <h4>Phone</h4>
                <p>{{ $email['phone'] }}</p>
            </div>

            <div class="info-section">
                <h4>Message</h4>
                <p>{{ $email['message'] }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            {{-- <p>Let's stay connected! <a href="#">Visit our website</a></p> --}}
            <p>&copy;Lets be friend/یار هم باشیم</p>
        </div>
    </div>

</body>
</html>
