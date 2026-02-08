<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Demo Request</title>
</head>
<body style="font-family: Arial, sans-serif; color:#111;">
    <h2>New Demo Request</h2>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Lab Name:</strong> {{ $data['lab_name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Mobile:</strong> {{ $data['phone'] }}</p>
    @if (!empty($data['message']))
        <p><strong>Message:</strong></p>
        <p>{{ $data['message'] }}</p>
    @endif
</body>
</html>
