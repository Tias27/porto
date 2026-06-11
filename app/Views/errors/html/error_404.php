<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #050706;
            --panel: rgba(16, 18, 17, 0.78);
            --line: rgba(216, 166, 87, 0.24);
            --text: #f7f5ef;
            --muted: #a8aaa6;
            --accent: #d8a657;
            --accent-soft: rgba(216, 166, 87, 0.16);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            background:
                radial-gradient(circle at 18% 20%, rgba(216, 166, 87, 0.16), transparent 32rem),
                radial-gradient(circle at 86% 72%, rgba(70, 112, 105, 0.16), transparent 30rem),
                linear-gradient(135deg, #050706 0%, #0b0f0f 52%, #10151a 100%);
            color: var(--text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .noise,
        .grid {
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        .noise {
            opacity: 0.15;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, transparent, #000 18%, #000 82%, transparent);
        }

        .grid {
            background: radial-gradient(circle, rgba(216, 166, 87, 0.16) 1px, transparent 1px);
            background-size: 38px 38px;
            opacity: 0.18;
            animation: drift 16s linear infinite;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .card {
            width: min(920px, 100%);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            background: var(--panel);
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(20px);
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, transparent, rgba(216, 166, 87, 0.14), transparent),
                radial-gradient(circle at 70% 0%, rgba(216, 166, 87, 0.14), transparent 22rem);
            transform: translateX(-80%);
            animation: scan 4.8s ease-in-out infinite;
        }

        .content {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 0.8fr;
            gap: 28px;
            align-items: center;
            padding: clamp(28px, 6vw, 70px);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 22px var(--accent);
        }

        h1 {
            margin: 0;
            max-width: 620px;
            font-size: clamp(2.45rem, 8vw, 6.5rem);
            line-height: 0.92;
            letter-spacing: -0.05em;
        }

        p {
            max-width: 560px;
            margin: 22px 0 0;
            color: var(--muted);
            font-size: clamp(1rem, 2vw, 1.12rem);
            line-height: 1.75;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            min-height: 46px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 18px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            font-weight: 800;
            font-size: 0.94rem;
            transition: transform 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            border-color: rgba(216, 166, 87, 0.42);
        }

        .btn.primary {
            border-color: transparent;
            background: #f5f8ee;
            color: #080a08;
        }

        .btn.ghost {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
        }

        .visual {
            position: relative;
            min-height: 330px;
            display: grid;
            place-items: center;
        }

        .orb {
            width: min(320px, 72vw);
            aspect-ratio: 1;
            position: relative;
            border: 1px solid var(--line);
            border-radius: 36px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02)),
                rgba(216, 166, 87, 0.05);
            transform: rotate(-6deg);
            animation: float 5.2s ease-in-out infinite;
        }

        .orb::before,
        .orb::after {
            content: "";
            position: absolute;
            border-radius: 999px;
        }

        .orb::before {
            inset: 42px;
            border: 1px dashed rgba(216, 166, 87, 0.3);
            animation: spin 18s linear infinite;
        }

        .orb::after {
            width: 70px;
            height: 70px;
            right: 46px;
            top: 50px;
            background: var(--accent);
            box-shadow: 0 0 70px rgba(216, 166, 87, 0.42);
        }

        .code {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) rotate(6deg);
            font-size: clamp(5rem, 16vw, 9rem);
            font-weight: 900;
            letter-spacing: -0.08em;
            color: rgba(247, 245, 239, 0.92);
            text-shadow: 0 18px 60px rgba(0, 0, 0, 0.36);
        }

        .chip {
            position: absolute;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 13px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            background: rgba(10, 12, 11, 0.74);
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 800;
            backdrop-filter: blur(14px);
            animation: bob 4.2s ease-in-out infinite;
        }

        .chip.one {
            left: 0;
            top: 34px;
        }

        .chip.two {
            right: 0;
            bottom: 48px;
            animation-delay: 0.8s;
        }

        .chip span {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-6deg); }
            50% { transform: translateY(-16px) rotate(-3deg); }
        }

        @keyframes bob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes scan {
            0%, 100% { transform: translateX(-80%); opacity: 0; }
            35%, 65% { opacity: 1; }
            50% { transform: translateX(70%); }
        }

        @keyframes drift {
            to { background-position: 38px 38px; }
        }

        @media (max-width: 760px) {
            body {
                overflow: auto;
            }

            .page {
                padding: 18px;
            }

            .card {
                border-radius: 22px;
            }

            .content {
                grid-template-columns: 1fr;
                padding: 30px 22px;
            }

            .visual {
                min-height: 250px;
                order: -1;
            }

            .orb {
                width: min(235px, 74vw);
                border-radius: 28px;
            }

            .chip {
                display: none;
            }

            .actions {
                display: grid;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="noise"></div>
    <div class="grid"></div>

    <main class="page">
        <section class="card" aria-labelledby="title-404">
            <div class="content">
                <div>
                    <div class="eyebrow">kamu nyasar nihh</div>
                    <h1 id="title-404">404, halaman tidak ditemukan</h1>
                    <p>
                        kamu cari apa? sepertinya halaman yang kamu tuju belum tersedia nih hehe, coba cek kembali alamatnya yaaa
                    </p>
                    <div class="actions">
                        <a class="btn primary" href="/">Balik ke Beranda</a>
                        <a class="btn ghost" href="/#projects">Lihat Project</a>
                    </div>
                </div>

                <div class="visual" aria-hidden="true">
                    <div class="orb">
                        <div class="code">404</div>
                    </div>
                    <div class="chip one"><span></span> route not found</div>
                    <div class="chip two"><span></span> redirecting energy</div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
