<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Basic page settings --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Conference Scheduler')</title>

    <style>

        /* =========================================================
           RESET & GLOBAL SETTINGS
        ========================================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
        }

        :root {
            --bg: #f5f7fb;

            --surface: #ffffff;
            --surface-soft: #f8fafc;

            --text: #0f172a;
            --muted: #64748b;

            --line: #e2e8f0;

            --primary: #2563eb;
            --primary-dark: #1d4ed8;

            --secondary: #64748b;
            --secondary-dark: #475569;

            --danger: #dc2626;
            --danger-dark: #b91c1c;

            --success-bg: #dcfce7;
            --success-text: #166534;

            --shadow: 0 10px 35px rgba(15, 23, 42, 0.08);

            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;

            --max-width: 1180px;
        }

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 30%),
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.10), transparent 25%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);

            color: var(--text);

            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        a,
        input,
        textarea,
        select {
            outline-offset: 2px;
        }

        /* =========================================================
           SCROLLBAR
        ========================================================== */

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* =========================================================
           REUSABLE UTILITY CLASSES
        ========================================================== */

        .flex-wrap-gap {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .center-flex {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* =========================================================
           HEADER & NAVIGATION
        ========================================================== */

        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;

            backdrop-filter: blur(16px);

            background: rgba(255, 255, 255, 0.82);

            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .nav {
            max-width: var(--max-width);

            margin: 0 auto;

            padding: 18px 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;
        }

        .nav-left,
        .nav-right {
            display: flex;
            align-items: center;

            gap: 12px;

            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;

            gap: 10px;

            font-weight: 800;
            font-size: 24px;

            color: var(--text);

            margin-right: 14px;
        }

        .brand-badge {
            width: 40px;
            height: 40px;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #0ea5e9
                );

            display: inline-flex;
            align-items: center;
            justify-content: center;

            color: white;

            font-weight: 800;

            box-shadow:
                0 12px 24px rgba(37, 99, 235, 0.22);
        }

        .nav-link {
            padding: 10px 14px;

            border-radius: 12px;

            font-weight: 600;

            color: var(--muted);
        }

        .nav-link:hover {
            background: #eef4ff;
            color: var(--primary);
        }

        .user-pill {
            padding: 10px 14px;

            border-radius: 999px;

            background: #eef4ff;

            color: var(--primary);

            font-size: 14px;
            font-weight: 700;
        }

        /* =========================================================
           PAGE LAYOUT
        ========================================================== */

        .page-shell {
            max-width: var(--max-width);

            margin: 0 auto;

            padding: 36px 20px 60px;
        }

        .page-header {
            background:
                linear-gradient(
                    135deg,
                    rgba(37, 99, 235, 0.10),
                    rgba(14, 165, 233, 0.08)
                );

            border: 1px solid rgba(191, 219, 254, 0.9);

            padding: 34px;

            border-radius: var(--radius-lg);

            margin-bottom: 28px;

            box-shadow: var(--shadow);
        }

        .page-header h1 {
            font-size: 42px;

            line-height: 1.1;

            margin-bottom: 12px;

            letter-spacing: -0.03em;
        }

        .page-header p {
            color: var(--muted);

            font-size: 17px;

            max-width: 760px;

            line-height: 1.7;
        }

        /* =========================================================
           CARDS
        ========================================================== */

        .card {
            background: var(--surface);

            border: 1px solid rgba(226, 232, 240, 0.9);

            border-radius: var(--radius-lg);

            padding: 26px;

            margin-bottom: 22px;

            box-shadow: var(--shadow);
        }

        .card h2 {
            font-size: 28px;

            line-height: 1.2;

            margin-bottom: 16px;

            letter-spacing: -0.02em;
        }

        /* =========================================================
           GRID LAYOUTS
        ========================================================== */

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        /* =========================================================
           BUTTONS
        ========================================================== */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            border: none;

            border-radius: 12px;

            padding: 12px 18px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color: white;

            font-weight: 700;
            font-size: 15px;

            cursor: pointer;

            box-shadow:
                0 10px 20px rgba(37, 99, 235, 0.18);
        }

        .btn:hover {
            transform: translateY(-2px);

            opacity: 0.98;

            box-shadow:
                0 14px 28px rgba(37, 99, 235, 0.22);
        }

        .btn-secondary {
            background: var(--secondary);
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: var(--secondary-dark);
        }

        .btn-danger {
            background: var(--danger);
            box-shadow: none;
        }

        .btn-danger:hover {
            background: var(--danger-dark);
        }

        .logout-btn {
            border: none;

            background: #0f172a;

            color: white;

            padding: 11px 16px;

            border-radius: 12px;

            font-weight: 700;

            cursor: pointer;
        }

        /* =========================================================
           TABLES
        ========================================================== */

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        thead th {
            text-align: left;

            font-size: 14px;

            color: var(--muted);

            font-weight: 700;

            padding: 16px 14px;

            border-bottom: 1px solid var(--line);

            background: #f8fafc;
        }

        tbody td {
            padding: 16px 14px;

            border-bottom: 1px solid #eef2f7;

            vertical-align: top;
        }

        tbody tr:hover {
            background: #fbfdff;
        }

        /* =========================================================
           FORMS
        ========================================================== */

        input,
        textarea,
        select {
            width: 100%;

            border: 1px solid #dbe4ef;

            border-radius: 14px;

            padding: 14px 16px;

            font-size: 15px;

            margin-top: 8px;
            margin-bottom: 18px;

            background: #fcfdff;

            color: var(--text);
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #93c5fd;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.12);

            background: white;
        }

        label {
            display: block;

            font-weight: 700;

            margin-top: 8px;

            color: var(--text);
        }

        /* =========================================================
           ALERT BOXES
        ========================================================== */

        .error-box {
            background: #fef2f2;

            border: 1px solid #fecaca;

            color: #991b1b;

            border-radius: 14px;

            padding: 14px 16px;

            margin-bottom: 20px;
        }

        .success-box {
            background: var(--success-bg);

            color: var(--success-text);

            border-radius: 14px;

            padding: 14px 16px;

            margin-bottom: 20px;

            font-weight: 600;
        }

        .empty {
            color: var(--muted);
            line-height: 1.7;
        }

        /* =========================================================
           FOOTER
        ========================================================== */

        .footer {
            max-width: var(--max-width);

            margin: 0 auto;

            padding: 0 20px 40px;

            color: var(--muted);
        }

        .footer-inner {
            background: rgba(255, 255, 255, 0.7);

            border: 1px solid #e2e8f0;

            border-radius: 22px;

            padding: 22px;

            text-align: center;
        }

        /* =========================================================
           RESPONSIVE DESIGN
        ========================================================== */

        @media (max-width: 1024px) {

            .grid-4,
            .grid-3,
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 34px;
            }
        }

        @media (max-width: 768px) {

            .nav {
                flex-direction: column;
                align-items: stretch;
            }

            .nav-left,
            .nav-right {
                justify-content: center;
            }

            .page-shell {
                padding-top: 24px;
            }

            .page-header,
            .card {
                padding: 20px;
            }

            table,
            thead,
            tbody,
            tr,
            th,
            td {
                display: block;
            }

            thead {
                display: none;
            }

            tbody tr {
                border-bottom: 1px solid var(--line);
                padding: 10px 0;
            }

            tbody td {
                border-bottom: none;
                padding: 10px 0;
            }

            tbody td::before {
                font-weight: 700;
                color: var(--muted);
                display: block;
                margin-bottom: 4px;
            }
        }

    </style>
</head>

<body>

    {{-- =========================================================
         ROLE DETECTION
    ========================================================== --}}
    @auth

        @php

            $role = 'Attendee';

            if(auth()->user()->is_admin) {

                $role = 'Admin';

            } elseif(\App\Models\Speaker::where('user_id', auth()->id())->exists()) {

                $role = 'Speaker';
            }

        @endphp

    @endauth


    {{-- =========================================================
         HEADER & NAVIGATION
    ========================================================== --}}
    <header class="site-header">

        <nav class="nav">

            <div class="nav-left">

                <a class="brand" href="{{ url('/') }}">

                    <span class="brand-badge">
                        C
                    </span>

                    <span>
                        Conference Scheduler
                    </span>

                </a>

                @auth

                    <a class="nav-link" href="{{ url('/') }}">
                        Home
                    </a>

                    <a class="nav-link" href="{{ url('/dashboard') }}">
                        Dashboard
                    </a>

                    <a class="nav-link" href="{{ url('/events') }}">
                        Schedule
                    </a>

                    <a class="nav-link" href="{{ url('/category') }}">
                        Tracks
                    </a>

                    <a class="nav-link" href="{{ url('/speakers') }}">
                        Speakers
                    </a>

                    @if(auth()->user()->is_admin)

                        <a class="nav-link" href="{{ url('/users') }}">
                            Users
                        </a>

                    @endif

                @else

                    <a class="nav-link" href="{{ url('/') }}">
                        Home
                    </a>

                @endauth

            </div>

            <div class="nav-right">

                @auth

                    <span class="user-pill">
                        {{ $role }} · {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ url('/logout') }}">

                        @csrf

                        <button type="submit" class="logout-btn">
                            Logout
                        </button>

                    </form>

                @else

                    <a class="btn btn-secondary" href="{{ url('/login') }}">
                        Login
                    </a>

                    <a class="btn" href="{{ url('/register') }}">
                        Get Started
                    </a>

                @endauth

            </div>

        </nav>

    </header>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <div class="page-shell">

        @yield('content')

    </div>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="footer">

        <div class="footer-inner">

            Conference Scheduler ·
            A modern platform for managing sessions,
            speakers, tracks and attendee registrations.

        </div>

    </footer>

</body>
</html>