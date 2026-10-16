<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket Registration</title>
    <style>
        :root {
            --bg-1: #140507;
            --bg-2: #2b090d;
            --panel-1: #1c0d10;
            --panel-2: #2a0d12;
            --line: rgba(255, 214, 214, 0.12);
            --soft: #f6d7d8;
            --muted: #d59ca2;
            --text: #fff5f5;
            --accent: #ef4d5d;
            --accent-2: #b81326;
            --gold: #f9d58b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top, rgba(239,77,93,0.24), transparent 26%),
                radial-gradient(circle at bottom right, rgba(184,19,38,0.52), transparent 18%),
                linear-gradient(135deg, var(--bg-1), var(--bg-2));
            color: var(--text);
            font-family: Arial, sans-serif;
            padding: 32px;
        }

        .ticket-shell {
            width: min(1120px, 100%);
            display: grid;
            grid-template-columns: 0.95fr 1.25fr;
            background: rgba(17, 5, 8, 0.9);
            border: 1px solid var(--line);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 26px 70px rgba(0, 0, 0, 0.45);
        }

        .visual {
            position: relative;
            padding: 30px 30px 28px;
            background: linear-gradient(160deg, rgba(72, 10, 16, 0.92), rgba(16, 7, 9, 0.82));
            border-right: 1px solid var(--line);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 999px;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--soft);
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255, 190, 190, 0.22);
            font-weight: 700;
        }

        .brand::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 12px rgba(239,77,93,0.8);
        }

        .concert-name {
            margin: 26px 0 0;
            font-size: clamp(2.8rem, 5vw, 4.6rem);
            line-height: 0.9;
            letter-spacing: -0.09em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .subtitle {
            margin-top: 18px;
            color: var(--soft);
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .stage {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--gold);
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .stage::before,
        .stage::after {
            content: "";
            display: block;
            flex: 1;
            height: 1px;
            background: rgba(249, 213, 139, 0.28);
        }

        .event-grid {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 16px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
        }

        .info-box {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-box span {
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .info-box strong {
            font-size: 1.06rem;
            font-weight: 700;
        }

        .ticket-id {
            margin-top: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.02);
        }

        .ticket-id span {
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .ticket-id strong {
            color: var(--gold);
            letter-spacing: 0.16em;
            font-size: 1.3rem;
        }

        .panel {
            padding: 32px 28px 28px;
            background: linear-gradient(180deg, rgba(28, 8, 11, 0.96), rgba(18, 6, 8, 0.96));
        }

        .panel h2 {
            margin: 0;
            font-size: clamp(1.9rem, 2vw, 2.5rem);
            letter-spacing: -0.05em;
        }

        .panel p {
            margin: 8px 0 24px;
            color: var(--muted);
            font-size: 0.96rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field label {
            color: var(--soft);
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            background: rgba(255,255,255,0.03);
            color: var(--text);
            padding: 13px 14px;
            font-size: 0.98rem;
            outline: none;
        }

        .field input::placeholder { color: rgba(255,255,255,0.4); }
        .field input:focus,
        .field select:focus {
            border-color: rgba(239,77,93,0.9);
            box-shadow: 0 0 0 3px rgba(239,77,93,0.14);
        }

        .summary {
            margin-top: 6px;
            padding: 18px 18px 12px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255,255,255,0.02);
        }

        .summary-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .summary-head span {
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .summary-head strong {
            color: var(--gold);
            font-size: 1.5rem;
        }

        .summary-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .summary-list div {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 8px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .summary-list div:first-child {
            border-top: none;
            padding-top: 0;
        }

        .summary-list small {
            color: var(--muted);
        }

        .primary-btn {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 16px 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 18px 30px rgba(184, 19, 38, 0.32);
        }

        @media (max-width: 900px) {
            .ticket-shell { grid-template-columns: 1fr; }
            .visual { border-right: none; border-bottom: 1px solid var(--line); }
        }

        @media (max-width: 560px) {
            body { padding: 18px; }
            .row { grid-template-columns: 1fr; }
            .visual, .panel { padding-left: 18px; padding-right: 18px; }
        }
    </style>
</head>
<body>
    <div class="ticket-shell">
        <aside class="visual">
            <div class="brand">Live Concert</div>
            <h1 class="concert-name">Midnight<br>Echo</h1>
            <div class="subtitle">Neon Night Experience</div>

            <div class="stage">Main Stage</div>

            <div class="event-grid">
                <div class="info-box">
                    <span>Venue</span>
                    <strong>Grand Arena</strong>
                </div>
                <div class="info-box">
                    <span>Doors</span>
                    <strong>19:00</strong>
                </div>
                <div class="info-box">
                    <span>Starts</span>
                    <strong>20:30</strong>
                </div>
                <div class="info-box">
                    <span>Category</span>
                    <strong>VIP / Gold</strong>
                </div>
            </div>
{{-- Tiket --}}
            <div class="ticket-id">
                <span>Ticket ID</span>
                <strong>NE-2048</strong>
            </div>
        </aside>

        <main class="panel">
            <h2>Form Pemesanan Tiket</h2>
            <p>Silakan lengkapi data berikut untuk reservasi kursi Anda.</p>

            <form>
                <div class="row">
                    <div class="field">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" type="text" value="Ayu Ramadhani">
                    </div>
                    <div class="field">
                        <label for="phone">Nomor HP</label>
                        <input id="phone" type="tel" value="081234567890">
                    </div>
                </div>

                <div class="row">
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" value="ayu@email.com">
                    </div>
                    <div class="field">
                        <label for="ticket">Jenis Tiket</label>
                        <select id="ticket">
                            <option selected>VIP Lounge</option>
                            <option>Gold Zone</option>
                            <option>Regular Seat</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="field">
                        <label for="qty">Jumlah</label>
                        <input id="qty" type="number" value="2" min="1" max="10">
                    </div>
                    <div class="field">
                        <label for="seat">Kursi</label>
                        <select id="seat">
                            <option selected>VIP-12, VIP-13</option>
                            <option>G-05, G-06</option>
                            <option>R-21, R-22</option>
                        </select>
                    </div>
                </div>

                <div class="summary">
                    <div class="summary-head">
                        <span>Total</span>
                        <strong>Rp 1.200.000</strong>
                    </div>
                    <div class="summary-list">
                        <div>
                            <span>2x VIP Lounge</span>
                            <small>Rp 600.000</small>
                        </div>
                        <div>
                            <span>Biaya layanan</span>
                            <small>Rp 60.000</small>
                        </div>
                        <div>
                            <span>Fee admin</span>
                            <small>Rp 40.000</small>
                        </div>
                    </div>
                </div>

                <button class="primary-btn" type="button">Pesan Sekarang</button>
            </form>
        </main>
    </div>
</body>
</html>
