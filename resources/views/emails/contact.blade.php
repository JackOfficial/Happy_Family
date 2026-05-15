<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>
</head>
<body>
   <h2>New Contact Message</h2>
<p><strong>From:</strong> {{ $contact->name }} ({{ $contact->email }})</p>
<p><strong>Phone:</strong> {{ $contact->phone ?? 'N/A' }}</p>
<p><strong>Subject:</strong> {{ $contact->subject }}</p>
<hr>
<p><strong>Message:</strong></p>
<p>{{ $contact->message }}</p>
<br>
<small>Sent from the Happy Family Rwanda contact form.</small>
</body>
</html>