<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application sent</title>
</head>
<body>
<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">New Volunteer Application</h2>
    <p>A new application has been received from the website.</p>
    
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Name:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $volunteer->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Email:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $volunteer->email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Location:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">
                {{ $volunteer->address->city }}, {{ $volunteer->country->name }}
            </td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Occupation:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $volunteer->occupation ?? 'Not provided' }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 20px;">Reason for Joining:</h3>
    <div style="padding: 15px; background: #f9f9f9; border-left: 4px solid #3498db;">
        {{ $volunteer->reason }}
    </div>

    <p style="margin-top: 20px;">
        <a href="{{ url('/admin/volunteers/' . $volunteer->id) }}" 
           style="background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
           Review Application in Admin Panel
        </a>
    </p>
</div>
</body>
</html>