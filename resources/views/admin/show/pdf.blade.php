<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Event Report - {{ $event->title }}</title>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 13px; }
        
        /* Layout Tables */
        .w-100 { width: 100%; }
        .align-top { vertical-align: top; }
        
        /* Header Section */
        .header-table { border-bottom: 3px solid #762b6f; padding-bottom: 20px; margin-bottom: 30px; }
        .brand-name { font-size: 24px; font-weight: bold; color: #762b6f; text-transform: uppercase; }
        .report-title { font-size: 14px; color: #777; margin-top: 5px; }
        
        /* QR & Details Section */
        .meta-box { background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #e9ecef; }
        .label { font-size: 10px; font-weight: bold; color: #888; text-transform: uppercase; margin-bottom: 2px; }
        .value { font-size: 13px; color: #333; margin-bottom: 12px; font-weight: 500; }
        
        /* Content Area */
        .event-title { font-size: 22px; font-weight: bold; color: #111; margin-bottom: 15px; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #e2e3e5; color: #383d41; }
        
        .description-box { margin-top: 20px; color: #555; text-align: justify; }
        
        /* Footer */
        .footer { position: fixed; bottom: 0; width: 100%; border-top: 1px solid #eee; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>

    {{-- Header --}}
    <table class="w-100 header-table">
        <tr>
            <td class="align-top">
                <div class="brand-name">Event Management</div>
                <div class="report-title">Official Event Summary Report</div>
            </td>
            <td align="right" class="align-top">
                <div style="margin-bottom: 5px;">
                    <img src="data:image/png;base64, {!! $qrcode !!}" width="80">
                </div>
                <div style="font-size: 9px; color: #888;">Scan to view online</div>
            </td>
        </tr>
    </table>

    <table class="w-100">
        <tr>
            {{-- Main Content --}}
            <td class="align-top" style="padding-right: 30px;">
                <div class="event-title">{{ $event->title }}</div>
                
                <div class="status-badge {{ $event->status == 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ strtoupper($event->status) }}
                </div>

                <div class="description-box">
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;">Event Description</h4>
                    {!! $event->description !!}
                </div>
            </td>

            {{-- Sidebar Meta Data --}}
            <td class="align-top" style="width: 200px;">
                <div class="meta-box">
                    <div class="label">Date</div>
                    <div class="value">{{ $event->date ? $event->date->format('l, d M Y') : 'TBD' }}</div>

                    <div class="label">Time</div>
                    <div class="value">{{ $event->time ?? '--:--' }}</div>

                    <div class="label">Location</div>
                    <div class="value">{{ $event->location ?? 'Virtual' }}</div>

                    @if($event->link)
                        <div class="label">Registration Link</div>
                        <div class="value" style="font-size: 11px; word-break: break-all; color: #007bff;">{{ $event->link }}</div>
                    @endif

                    <div style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px;">
                        <div class="label">Generated On</div>
                        <div class="value" style="font-size: 11px;">{{ date('d M Y, H:i') }}</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        This is a computer-generated document. © {{ date('Y') }} Foxx-kennels IT Solutions.
    </div>

</body>
</html>