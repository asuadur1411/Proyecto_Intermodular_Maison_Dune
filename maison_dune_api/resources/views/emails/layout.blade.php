<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Maison Dune</title>
    <style>
        body, table, td, p, a, h1, h2, h3 { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }

        @media only screen and (max-width: 600px) {
            .md-container       { width: 100% !important; max-width: 100% !important; }
            .md-card            { margin: 0 12px !important; padding: 28px 20px !important; }
            .md-header-pad      { padding: 30px 20px 20px !important; }
            .md-h1              { font-size: 26px !important; letter-spacing: 3px !important; }
            .md-stack           { display: block !important; width: 100% !important; box-sizing: border-box !important; }
            .md-stack-cell      { display: block !important; width: 100% !important; padding: 0 !important; text-align: center !important; }
            .md-qr-cell         { padding: 0 0 18px !important; }
            .md-detail-label    { width: 90px !important; font-size: 10px !important; }
            .md-detail-value    { font-size: 13px !important; }
            .md-confirm-code    { font-size: 22px !important; letter-spacing: 1.5px !important; }
            .md-greet           { font-size: 15px !important; }
            .md-body            { font-size: 13px !important; }
            .md-footer          { padding: 20px 12px !important; }
        }

        @media (prefers-color-scheme: dark) {
            .md-card { background-color: #ffffff !important; }
        }
    </style>
</head>
<body style="font-family: 'Georgia', 'Times New Roman', serif; background-color: #1a1714; color: #1a1a1a; margin: 0; padding: 0;">
    <div class="md-container" style="max-width: 600px; margin: 0 auto; background-color: #1a1714;">

        <div class="md-header-pad" style="text-align: center; padding: 40px 30px 30px;">
            <h1 class="md-h1" style="font-size: 32px; font-weight: 300; color: #c9a84c; margin: 0; letter-spacing: 4px; font-family: 'Georgia', serif;">MAISON DUNE</h1>
            <div style="width: 60px; height: 1px; background-color: #c9a84c; margin: 12px auto 0;"></div>
        </div>

        <div class="md-card" style="background-color: #ffffff; margin: 0 20px; border-radius: 2px; padding: 40px 36px;">
            <p style="text-align: center; font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: #c9a84c; margin: 0 0 30px; font-family: Arial, sans-serif;">@yield('subtitle')</p>

            @yield('content')
        </div>

        <div class="md-footer" style="text-align: center; padding: 30px; font-family: Arial, sans-serif;">
            <p style="font-size: 11px; color: #8a7d6b; letter-spacing: 1px; margin: 0 0 8px;">MAISON DUNE — WHERE LUXURY MEETS TRADITION</p>
            <p style="font-size: 10px; color: #5a5247; margin: 0;">This is an automated message. Please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
