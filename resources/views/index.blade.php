<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | District Productivity Promotion Unit</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-fixed-dim": "#83d7b4",
                    "outline": "#747683",
                    "on-primary": "#ffffff",
                    "tertiary": "#26292b",
                    "on-primary-fixed": "#001849",
                    "inverse-surface": "#213145",
                    "tertiary-fixed": "#e0e3e5",
                    "surface-container-highest": "#d3e4fe",
                    "surface-container": "#e5eeff",
                    "tertiary-fixed-dim": "#c4c7c9",
                    "surface-variant": "#d3e4fe",
                    "on-tertiary-container": "#a8aaac",
                    "secondary": "#046c50",
                    "error": "#ba1a1a",
                    "on-surface-variant": "#434652",
                    "surface-container-low": "#eff4ff",
                    "error-container": "#ffdad6",
                    "surface-tint": "#335ab4",
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#3c3f41",
                    "on-surface": "#0b1c30",
                    "on-error": "#ffffff",
                    "secondary-fixed": "#9ef4d0",
                    "on-tertiary-fixed": "#191c1e",
                    "on-background": "#0b1c30",
                    "outline-variant": "#c4c6d4",
                    "surface-dim": "#cbdbf5",
                    "on-secondary-container": "#137255",
                    "on-primary-fixed-variant": "#12419b",
                    "background": "#f8f9ff",
                    "surface-container-lowest": "#ffffff",
                    "inverse-on-surface": "#eaf1ff",
                    "on-primary-container": "#88a7ff",
                    "inverse-primary": "#b3c5ff",
                    "on-secondary-fixed-variant": "#00513b",
                    "on-error-container": "#93000a",
                    "on-secondary-fixed": "#002116",
                    "surface": "#f8f9ff",
                    "primary-container": "#003893",
                    "on-tertiary-fixed-variant": "#444749",
                    "surface-container-high": "#dce9ff",
                    "primary-fixed": "#dae1ff",
                    "primary": "#002465",
                    "surface-bright": "#f8f9ff",
                    "secondary-container": "#9ef4d0",
                    "on-tertiary": "#ffffff",
                    "primary-fixed-dim": "#b3c5ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "sidebar-width": "260px",
                    "margin-desktop": "2rem",
                    "component-padding": "1.25rem",
                    "gutter": "1.5rem",
                    "stack-gap": "1rem",
                    "margin-mobile": "1rem",
                    "container-max": "1440px"
            },
            "fontFamily": {
                    "headline-sm": ["Inter"],
                    "label-md": ["Inter"],
                    "body-md": ["Inter"],
                    "display-lg": ["Inter"],
                    "body-lg": ["Inter"],
                    "label-sm": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-md-mobile": ["Inter"]
            },
            "fontSize": {
                    "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "label-sm": ["11px", {"lineHeight": "14px", "fontWeight": "500"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "headline-md-mobile": ["20px", {"lineHeight": "28px", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .pattern-bg {
            background-color: #f8f9ff;
            background-image: radial-gradient(#003893 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            background-opacity: 0.05;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md min-h-screen flex flex-col items-center justify-center p-4 pattern-bg">
<!-- Login Shell -->
<div class="w-full max-w-[440px] flex flex-col gap-8 animate-in fade-in duration-700">
    <!-- Header Branding Section -->
    <div class="text-center flex flex-col items-center">
        <div class="mb-6 rounded-full bg-white p-4 border border-outline-variant shadow-sm">
            <img alt="NPS Sri Lanka Logo" class="w-16 h-auto" src="{{ asset('images/nps-logo.png') }}"/>
        </div>
        <h1 class="font-headline-md text-headline-md text-primary mb-2">District Productivity Promotion Unit</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Secure access for Productivity Development Officers</p>
    </div>
    <!-- Main Card -->
    <div class="glass-effect rounded-xl border border-outline-variant shadow-lg p-8 md:p-10">
        <div class="mb-8">
            <h2 class="font-headline-sm text-headline-sm text-on-surface">Login</h2>
            <div class="h-1 w-12 bg-secondary rounded-full mt-2"></div>
        </div>

        <!-- Session & Error Messages -->
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="flex flex-col gap-6" action="{{ route('login.post') }}" method="POST">
            @csrf
            <!-- Email Input -->
            <div class="flex flex-col gap-2">
                <label class="font-label-md text-label-md text-on-surface-variant" for="email">OFFICIAL EMAIL ADDRESS</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">mail</span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline-variant focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all outline-none bg-surface-container-lowest text-on-surface font-body-md" id="email" name="email" placeholder="e.g. pdo.office@gov.lk" required="" type="email" value="{{ old('email') }}"/>
                </div>
            </div>
            <!-- Password Input -->
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <label class="font-label-md text-label-md text-on-surface-variant" for="password">PASSWORD</label>
                    <a class="font-label-sm text-label-sm text-primary-container hover:underline transition-colors" href="#">Forgot Password?</a>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">lock</span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline-variant focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all outline-none bg-surface-container-lowest text-on-surface font-body-md" id="password" name="password" placeholder="••••••••" required="" type="password"/>
                </div>
            </div>
            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" id="remember" name="remember" type="checkbox"/>
                <label class="font-body-md text-body-md text-on-surface-variant select-none" for="remember">Remember this device</label>
            </div>
            <!-- Submit Button -->
            <button class="w-full bg-primary-container text-on-primary py-4 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary transition-all active:scale-[0.98] shadow-md" type="submit">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">login</span>
                LOGIN TO PORTAL
            </button>
        </form>
        <!-- Support Info -->
        <div class="mt-8 pt-6 border-t border-outline-variant flex flex-col gap-4">
            <div class="flex items-start gap-3 p-3 rounded-lg bg-surface-container-low border border-outline-variant/30">
                <span class="material-symbols-outlined text-secondary">info</span>
                <p class="font-label-sm text-label-sm text-on-surface-variant leading-relaxed">
                    Authorized personnel only. All access attempts and activities are monitored for security and compliance purposes.
                </p>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="text-center flex flex-col gap-4">
        <div class="flex justify-center gap-6">
            <a class="font-label-sm text-label-sm text-outline hover:text-primary transition-colors" href="#">Support Center</a>
            <span class="w-1 h-1 bg-outline-variant rounded-full self-center"></span>
            <a class="font-label-sm text-label-sm text-outline hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <span class="w-1 h-1 bg-outline-variant rounded-full self-center"></span>
            <a class="font-label-sm text-label-sm text-outline hover:text-primary transition-colors" href="#">Terms of Service</a>
        </div>
        <p class="font-label-sm text-label-sm text-outline">
            © 2024 Government of Sri Lanka - District Productivity Promotion Unit
        </p>
    </footer>
</div>
<!-- Decorative Elements (Subtle Shaders/Atmosphere) -->
<div class="fixed bottom-0 right-0 p-8 pointer-events-none opacity-40">
    <div class="flex flex-col items-end gap-2">
        <span class="font-label-sm text-label-sm text-primary opacity-50">GOV.LK NETWORK SECURED</span>
        <div class="h-1 w-32 bg-primary/20 rounded-full overflow-hidden">
            <div class="h-full bg-primary w-1/3 transition-all duration-1000 ease-in-out" id="progress-bar"></div>
        </div>
    </div>
</div>
<script>
    // Micro-interaction: Animated progress bar simulator for "Secure Connection" feel
    setInterval(() => {
        const bar = document.getElementById('progress-bar');
        if (bar) {
            const randomWidth = Math.floor(Math.random() * (90 - 40 + 1)) + 40;
            bar.style.width = randomWidth + '%';
        }
    }, 3000);

    // Form validation and loading animation feedback
    const form = document.querySelector('form');
    const loginBtn = document.querySelector('button[type="submit"]');
    form.addEventListener('submit', () => {
        loginBtn.innerHTML = `<span class="material-symbols-outlined animate-spin">sync</span> AUTHENTICATING...`;
        loginBtn.classList.add('opacity-80', 'cursor-wait');
    });
</script>
</body>
</html>
