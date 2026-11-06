@php
    $tiers = [
        'VIP Lounge' => ['key' => 'vip', 'price' => 750000, 'perk' => 'Lounge privat, paling dekat panggung', 'seats' => ['VIP · Baris A', 'VIP · Baris B']],
        'Gold Zone' => ['key' => 'gold', 'price' => 450000, 'perk' => 'Kursi tengah, pandangan penuh', 'seats' => ['Gold · Blok G1', 'Gold · Blok G2']],
        'Regular Seat' => ['key' => 'reg', 'price' => 250000, 'perk' => 'Tribun samping', 'seats' => ['Tribun Timur', 'Tribun Barat']],
    ];
    $serviceFee = 25000;
    $selectedTier = old('ticket_type', 'VIP Lounge');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Midnight Echo · Pesan Tiket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;900&family=IBM+Plex+Mono:wght@400;500&family=Schibsted+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --night: #161a4a;
            --night-deep: #0e1135;
            --haze: #9a9dd6;
            --paper: #f1eef8;
            --paper-line: #d9d3ea;
            --ink: #15122e;
            --ink-soft: #5d5880;
            --vip: #e0337e;
            --gold: #f0b134;
            --reg: #38b6c6;
            --error: #c4214f;
            --tier: var(--vip);

            --display: "Big Shoulders Display", "Arial Narrow", sans-serif;
            --body: "Schibsted Grotesk", system-ui, sans-serif;
            --mono: "IBM Plex Mono", ui-monospace, monospace;
        }

        * { box-sizing: border-box; }

        html { overflow-x: clip; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--night);
            color: var(--paper);
            font-family: var(--body);
            font-size: 16px;
            line-height: 1.5;
            overflow-x: clip;
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            padding: clamp(40px, 7vw, 88px) 24px 0;
            max-width: 1120px;
            margin: 0 auto;
            isolation: isolate;
        }

        .rings {
            position: absolute;
            z-index: -1;
            left: 0;
            top: 0;
            width: min(900px, 140vw);
            aspect-ratio: 1;
            transform: translate(-38%, -42%);
            border-radius: 50%;
            background: repeating-radial-gradient(circle, transparent 0 46px, rgba(154, 157, 214, 0.09) 46px 47px);
            mask-image: radial-gradient(circle, #000 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(circle, #000 30%, transparent 70%);
            pointer-events: none;
        }

        .eyebrow {
            font-family: var(--mono);
            font-size: 13px;
            letter-spacing: 0.08em;
            color: var(--haze);
            margin: 0 0 18px;
        }

        .title {
            margin: 0;
            font-family: var(--display);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 0.82;
            letter-spacing: 0.01em;
        }

        .title .word {
            display: block;
            font-size: clamp(4.5rem, 15vw, 11rem);
        }

        .echo {
            display: flex;
            align-items: baseline;
            gap: 0.12em;
            white-space: nowrap;
        }

        .echo span {
            font-size: clamp(4.5rem, 15vw, 11rem);
            color: transparent;
            -webkit-text-stroke: 2px var(--paper);
        }

        .echo span:first-child { color: var(--paper); -webkit-text-stroke: 0; }
        .echo span:nth-child(2) { opacity: 0.55; }
        .echo span:nth-child(3) { opacity: 0.28; }
        .echo span:nth-child(4) { opacity: 0.12; }

        .facts {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 32px;
            margin: 32px 0 0;
            padding: 0;
            list-style: none;
        }

        .facts li { display: flex; flex-direction: column; }

        .facts small {
            font-family: var(--mono);
            font-size: 12px;
            color: var(--haze);
        }

        .facts strong { font-size: 1.05rem; font-weight: 500; }

        /* ---------- Ticket ---------- */
        .wrap {
            max-width: 1120px;
            margin: 0 auto;
            padding: 40px 24px 72px;
        }

        .ticket {
            display: grid;
            grid-template-columns: 1fr 300px;
            background: var(--paper);
            color: var(--ink);
            border-radius: 18px;
            box-shadow: 0 30px 60px -20px rgba(5, 6, 30, 0.7);
            overflow: hidden;
        }

        .ticket-main { padding: clamp(24px, 4vw, 44px); }

        .ticket-main h2 {
            margin: 0;
            font-family: var(--display);
            font-weight: 700;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1;
        }

        .lede { margin: 8px 0 28px; color: var(--ink-soft); }

        .notice {
            margin: 0 0 24px;
            padding: 14px 16px;
            border-radius: 10px;
            border-left: 4px solid currentColor;
            background: #fff;
        }

        .notice-success { color: #1d7a52; }
        .notice-error { color: var(--error); }
        .notice p, .notice ul { margin: 0; color: var(--ink); }
        .notice strong { display: block; margin-bottom: 2px; }
        .notice ul { padding-left: 18px; }

        fieldset { border: 0; margin: 0 0 28px; padding: 0; min-width: 0; }

        legend {
            padding: 0;
            margin-bottom: 14px;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--ink);
        }

        .label {
            display: block;
            margin-bottom: 8px;
            font-family: var(--mono);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--ink-soft);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .grid .wide { grid-column: 1 / -1; }

        input[type="text"], input[type="tel"], input[type="email"], input[type="number"], select {
            width: 100%;
            padding: 12px 14px;
            font: inherit;
            color: var(--ink);
            background: #fff;
            border: 1.5px solid var(--paper-line);
            border-radius: 10px;
            transition: border-color 0.15s;
        }

        input::placeholder { color: #a7a2c0; }

        input:focus-visible, select:focus-visible {
            outline: none;
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(21, 18, 46, 0.12);
        }

        input[aria-invalid="true"], select[aria-invalid="true"] { border-color: var(--error); }

        .field-error { margin: 6px 0 0; font-size: 14px; color: var(--error); }

        /* Tier cards: each tier wears its wristband color */
        .tiers {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .tier { position: relative; display: block; cursor: pointer; }

        .tier input { position: absolute; opacity: 0; pointer-events: none; }

        .tier-card {
            display: block;
            height: 100%;
            padding: 16px 14px 14px;
            background: #fff;
            border: 1.5px solid var(--paper-line);
            border-top: 6px solid var(--band);
            border-radius: 10px;
            transition: border-color 0.15s, transform 0.15s;
        }

        .tier:hover .tier-card { transform: translateY(-2px); }
        .tier input:checked + .tier-card { border-color: var(--band); box-shadow: inset 0 0 0 1.5px var(--band); }
        .tier input:focus-visible + .tier-card { outline: 3px solid var(--ink); outline-offset: 2px; }

        .tier-name { display: block; font-weight: 700; }
        .tier-price { display: block; font-family: var(--mono); font-size: 14px; margin-top: 2px; }
        .tier-perk { display: block; font-size: 13px; color: var(--ink-soft); margin-top: 8px; line-height: 1.35; }

        .tier-vip { --band: var(--vip); }
        .tier-gold { --band: var(--gold); }
        .tier-reg { --band: var(--reg); }

        .submit {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 28px;
            font: inherit;
            font-weight: 700;
            color: var(--paper);
            background: var(--ink);
            border: 0;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .submit:hover { background: #2b2660; }
        .submit:focus-visible { outline: 3px solid var(--tier); outline-offset: 3px; }

        /* ---------- Stub ---------- */
        .stub {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 32px 26px 26px;
            background: var(--paper);
            border-left: 2px dashed var(--paper-line);
        }

        /* punched notches where the stub tears off */
        .stub::before, .stub::after {
            content: "";
            position: absolute;
            left: -15px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--night);
        }
        .stub::before { top: -14px; }
        .stub::after { bottom: -14px; }

        .band {
            height: 10px;
            border-radius: 99px;
            background: var(--tier);
            transition: background 0.25s;
        }

        .stub-tier {
            margin: 14px 0 0;
            font-family: var(--display);
            font-weight: 900;
            font-size: 2.2rem;
            line-height: 0.95;
            text-transform: uppercase;
        }

        .stub dl { margin: 22px 0 0; display: grid; gap: 12px; }
        .stub dt { font-family: var(--mono); font-size: 11px; color: var(--ink-soft); }
        .stub dd { margin: 0; font-weight: 500; overflow-wrap: anywhere; }

        .stub-cost {
            margin-top: 22px;
            padding-top: 14px;
            border-top: 1px solid var(--paper-line);
            font-size: 14px;
        }

        .stub-cost div { display: flex; justify-content: space-between; gap: 8px; color: var(--ink-soft); }
        .stub-cost .total { margin-top: 8px; color: var(--ink); font-weight: 700; font-size: 1.15rem; }
        .stub-cost span:last-child { font-family: var(--mono); }

        .barcode {
            margin-top: auto;
            padding-top: 24px;
        }

        .barcode-bars {
            height: 46px;
            background: repeating-linear-gradient(90deg,
                var(--ink) 0 2px, transparent 2px 4px, var(--ink) 4px 5px, transparent 5px 8px,
                var(--ink) 8px 11px, transparent 11px 12px, var(--ink) 12px 13px, transparent 13px 17px);
        }

        .barcode-code {
            display: block;
            margin-top: 6px;
            font-family: var(--mono);
            font-size: 12px;
            letter-spacing: 0.2em;
            text-align: center;
        }

        .flash { animation: flash 0.4s ease-out; }
        @keyframes flash { from { background: rgba(240, 177, 52, 0.35); } to { background: transparent; } }

        .footnote {
            margin: 20px 0 0;
            font-family: var(--mono);
            font-size: 12px;
            color: var(--haze);
        }

        @media (max-width: 900px) {
            .ticket { grid-template-columns: 1fr; }
            .stub { border-left: 0; border-top: 2px dashed var(--paper-line); }
            .stub::before, .stub::after { top: -15px; bottom: auto; left: auto; }
            .stub::before { left: -14px; }
            .stub::after { right: -14px; }
        }

        @media (max-width: 600px) {
            .hero, .wrap { padding-left: 16px; padding-right: 16px; }
            .grid, .tiers { grid-template-columns: 1fr; }
            .echo span:nth-child(4) { display: none; }
            .submit { width: 100%; justify-content: center; }
        }

        @media (prefers-reduced-motion: no-preference) {
            .rings { animation: ripple 2.4s ease-out both; }
            .echo span { animation: echo-in 0.7s ease-out both; }
            .echo span:nth-child(2) { animation-delay: 0.15s; }
            .echo span:nth-child(3) { animation-delay: 0.3s; }
            .echo span:nth-child(4) { animation-delay: 0.45s; }
        }

        @keyframes ripple { from { opacity: 0; transform: translate(-38%, -42%) scale(0.85); } }
        @keyframes echo-in { from { opacity: 0; transform: translateX(-0.3em); } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>
<body>
    <header class="hero">
        <div class="rings" aria-hidden="true"></div>
        <p class="eyebrow">Konser langsung · Main Stage</p>
        <h1 class="title">
            <span class="word">Midnight</span>
            <span class="echo"><span>Echo</span><span aria-hidden="true">Echo</span><span aria-hidden="true">Echo</span><span aria-hidden="true">Echo</span></span>
        </h1>
        <ul class="facts">
            <li><small>Venue</small><strong>Grand Arena</strong></li>
            <li><small>Pintu dibuka</small><strong>19:00</strong></li>
            <li><small>Konser mulai</small><strong>20:30</strong></li>
        </ul>
    </header>

    <main class="wrap">
        <form class="ticket" method="POST" action="{{ route('registrations.store') }}" novalidate>
            @csrf
            <div class="ticket-main">
                <h2>Pesan tiket</h2>
                <p class="lede">Isi data di bawah. E-tiket dikirim ke email kamu.</p>

                @if (session('success'))
                    <div class="notice notice-success" role="status">
                        <strong>Tiket berhasil dipesan</strong>
                        <p>{{ session('success') }} Cek email kamu untuk e-tiketnya.</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="notice notice-error" role="alert">
                        <strong>Ada {{ $errors->count() }} data yang perlu diperbaiki</strong>
                        <p>Periksa kolom yang ditandai merah di bawah.</p>
                    </div>
                @endif

                <fieldset>
                    <legend>Pilih kategori</legend>
                    <div class="tiers">
                        @foreach ($tiers as $tierName => $tier)
                            <label class="tier tier-{{ $tier['key'] }}">
                                <input type="radio" name="ticket_type" value="{{ $tierName }}"
                                       data-tier="{{ $tier['key'] }}" data-price="{{ $tier['price'] }}"
                                       @checked($selectedTier === $tierName) required>
                                <span class="tier-card">
                                    <span class="tier-name">{{ $tierName }}</span>
                                    <span class="tier-price">Rp {{ number_format($tier['price'], 0, ',', '.') }}</span>
                                    <span class="tier-perk">{{ $tier['perk'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('ticket_type') <p class="field-error">{{ $message }}</p> @enderror
                </fieldset>

                <fieldset>
                    <legend>Kursi</legend>
                    <div class="grid">
                        <div>
                            <label class="label" for="seat">Area kursi</label>
                            <select id="seat" name="seat" required @error('seat') aria-invalid="true" @enderror>
                                @foreach ($tiers as $tierName => $tier)
                                    <optgroup label="{{ $tierName }}" data-tier="{{ $tier['key'] }}">
                                        @foreach ($tier['seats'] as $seat)
                                            <option value="{{ $seat }}" @selected(old('seat') === $seat)>{{ $seat }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('seat') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label" for="quantity">Jumlah tiket (maks. 10)</label>
                            <input id="quantity" name="quantity" type="number" inputmode="numeric" min="1" max="10"
                                   value="{{ old('quantity', 1) }}" required @error('quantity') aria-invalid="true" @enderror>
                            @error('quantity') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Data pemesan</legend>
                    <div class="grid">
                        <div class="wide">
                            <label class="label" for="name">Nama lengkap</label>
                            <input id="name" name="name" type="text" autocomplete="name" placeholder="Sesuai KTP"
                                   value="{{ old('name') }}" required @error('name') aria-invalid="true" @enderror>
                            @error('name') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label" for="email">Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" placeholder="nama@email.com"
                                   value="{{ old('email') }}" required @error('email') aria-invalid="true" @enderror>
                            @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label" for="phone">Nomor HP</label>
                            <input id="phone" name="phone" type="tel" autocomplete="tel" placeholder="08xx xxxx xxxx"
                                   value="{{ old('phone') }}" required @error('phone') aria-invalid="true" @enderror>
                            @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </fieldset>

                <button class="submit" type="submit">Pesan tiket <span aria-hidden="true">→</span></button>
            </div>

            <aside class="stub" aria-label="Ringkasan tiket" aria-live="polite">
                <div class="band"></div>
                <p class="stub-tier" data-out="tier">{{ $selectedTier }}</p>
                <dl>
                    <div><dt>Atas nama</dt><dd data-out="name">{{ old('name') ?: '—' }}</dd></div>
                    <div><dt>Area kursi</dt><dd data-out="seat">{{ old('seat') ?: '—' }}</dd></div>
                    <div><dt>Jumlah</dt><dd data-out="qty">{{ old('quantity', 1) }} tiket</dd></div>
                </dl>
                <div class="stub-cost">
                    <div><span data-out="line">Tiket</span><span data-out="subtotal">—</span></div>
                    <div><span>Biaya layanan</span><span data-out="fee">—</span></div>
                    <div class="total"><span>Total</span><span data-out="total">—</span></div>
                </div>
                <div class="barcode" aria-hidden="true">
                    <div class="barcode-bars"></div>
                    <span class="barcode-code" data-out="code">ME-0000</span>
                </div>
            </aside>
        </form>
        <p class="footnote">Harga sudah termasuk pajak. Biaya layanan Rp {{ number_format($serviceFee, 0, ',', '.') }} per tiket.</p>
    </main>

    <script>
        (() => {
            const form = document.querySelector('.ticket');
            const seat = form.querySelector('#seat');
            const qty = form.querySelector('#quantity');
            const nameInput = form.querySelector('#name');
            const out = (key) => form.querySelector(`[data-out="${key}"]`);
            const fee = {{ $serviceFee }};
            const rupiah = (n) => 'Rp ' + n.toLocaleString('id-ID');
            const colors = { vip: 'var(--vip)', gold: 'var(--gold)', reg: 'var(--reg)' };

            const set = (key, text) => {
                const el = out(key);
                if (el.textContent === text) return;
                el.textContent = text;
                el.classList.remove('flash');
                void el.offsetWidth;
                el.classList.add('flash');
            };

            // Only offer the seat areas that belong to the chosen tier.
            const syncSeats = (tierKey) => {
                let firstVisible = null;
                seat.querySelectorAll('optgroup').forEach((group) => {
                    const match = group.dataset.tier === tierKey;
                    group.hidden = !match;
                    group.disabled = !match;
                    if (match && !firstVisible) firstVisible = group.querySelector('option');
                });
                if (seat.selectedOptions[0]?.parentElement.disabled !== false) {
                    seat.value = firstVisible.value;
                }
            };

            const render = () => {
                const tier = form.querySelector('input[name="ticket_type"]:checked');
                const count = Math.min(10, Math.max(1, parseInt(qty.value, 10) || 1));
                const price = Number(tier.dataset.price);
                const name = nameInput.value.trim();

                document.documentElement.style.setProperty('--tier', colors[tier.dataset.tier]);
                set('tier', tier.value);
                set('name', name || '—');
                set('seat', seat.value);
                set('qty', count + ' tiket');
                set('line', `Tiket ${count} × ${rupiah(price)}`);
                set('subtotal', rupiah(price * count));
                set('fee', rupiah(fee * count));
                set('total', rupiah((price + fee) * count));

                const hash = [...(name + tier.value + seat.value + count)].reduce((h, c) => (h * 31 + c.charCodeAt(0)) % 10000, 7);
                out('code').textContent = 'ME-' + String(hash).padStart(4, '0');
            };

            form.addEventListener('change', (event) => {
                if (event.target.name === 'ticket_type') syncSeats(event.target.dataset.tier);
                render();
            });
            form.addEventListener('input', render);

            syncSeats(form.querySelector('input[name="ticket_type"]:checked').dataset.tier);
            render();
        })();
    </script>
</body>
</html>
