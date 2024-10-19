<!DOCTYPE html>
<html>
<head>
    <title>Reply to your contact message</title>
</head>
<body>
    <h1>Reply to your contact message</h1>
    <p>Xin chào {{ $contact->email }}</p>
    <p>commet của bạn :{{ $contact->message }}</p>
    <p>{{ $reply }}</p>
    <p>Best regards,</p>
    <p>Your Company</p>
</body>
</html>
