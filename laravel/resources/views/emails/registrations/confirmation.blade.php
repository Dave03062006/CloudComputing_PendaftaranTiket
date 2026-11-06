<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket confirmed</title>
</head>
<body style="margin:0; padding:0; background:#090b1a; color:#f7f4ff; font-family:Arial, Helvetica, sans-serif;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0;">
        Your Midnight Echo ticket registration is confirmed.
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#090b1a;">
        <tr>
            <td align="center" style="padding:36px 16px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:620px;">
                    <tr>
                        <td style="padding:0 0 18px 4px;">
                            <span style="display:inline-block; padding:9px 13px; border:1px solid #6df6ff; border-radius:9px; color:#6df6ff; font-size:12px; font-weight:bold; letter-spacing:2px;">
                                NEON ECHO / 2026
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="overflow:hidden; border:1px solid #2a2d52; border-radius:24px; background:#11152d; box-shadow:0 18px 50px rgba(0,0,0,.35);">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding:42px 42px 36px; background:linear-gradient(135deg,#17194a 0%,#28194d 55%,#5b1d55 100%);">
                                        <div style="font-size:13px; font-weight:bold; letter-spacing:4px; color:#ff77d9;">
                                            LIVE CONCERT
                                        </div>
                                        <div style="margin-top:16px; font-size:42px; line-height:1; font-weight:800; letter-spacing:-2px; color:#ffffff;">
                                            Midnight<br>Echo
                                        </div>
                                        <div style="margin-top:18px; color:#c8c9ef; font-size:15px; letter-spacing:1px;">
                                            Neon Night Experience
                                        </div>
                                        <div style="margin-top:30px; color:#6df6ff; font-size:12px; font-weight:bold; letter-spacing:2px;">
                                            REGISTRATION CONFIRMED
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:34px 42px 40px;">
                                        <p style="margin:0 0 12px; color:#aeb1d1; font-size:14px; letter-spacing:1px;">
                                            HELLO, {{ $registration->name }}
                                        </p>
                                        <h1 style="margin:0; color:#ffffff; font-size:28px; line-height:1.2;">
                                            Your place is reserved.
                                        </h1>
                                        <p style="margin:16px 0 28px; color:#b9bbd5; font-size:15px; line-height:1.7;">
                                            Your ticket registration has been saved successfully. Keep this email as your confirmation at check-in.
                                        </p>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #34385f; border-radius:16px; background:#171b39;">
                                            <tr>
                                                <td style="padding:22px 24px; border-bottom:1px solid #34385f;">
                                                    <div style="color:#8589b0; font-size:11px; font-weight:bold; letter-spacing:2px;">TICKET TYPE</div>
                                                    <div style="margin-top:8px; color:#ffffff; font-size:18px; font-weight:bold;">{{ $registration->ticket_type }}</div>
                                                </td>
                                                <td align="right" style="padding:22px 24px; border-bottom:1px solid #34385f;">
                                                    <div style="color:#8589b0; font-size:11px; font-weight:bold; letter-spacing:2px;">QTY</div>
                                                    <div style="margin-top:8px; color:#6df6ff; font-size:18px; font-weight:bold;">{{ $registration->quantity }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding:22px 24px;">
                                                    <div style="color:#8589b0; font-size:11px; font-weight:bold; letter-spacing:2px;">SEAT ASSIGNMENT</div>
                                                    <div style="margin-top:8px; color:#ff77d9; font-size:22px; font-weight:bold;">{{ $registration->seat }}</div>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin:28px 0 0; color:#777b9f; font-size:12px; line-height:1.7;">
                                            Registered with {{ $registration->email }}<br>
                                            Need help? Reply to this email and our team will assist you.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:20px 42px; background:#0d1025; color:#777b9f; font-size:12px;">
                                        <span style="color:#6df6ff; font-weight:bold; letter-spacing:1px;">NEON ECHO</span>
                                        <span style="float:right;">Grand Arena · 20:30</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:22px 10px 0; color:#666a8e; font-size:11px; line-height:1.6;">
                            This is an automated confirmation from {{ config('app.name') }}.<br>
                            Please do not share your ticket details publicly.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
