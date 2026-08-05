<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DDC PULSE — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/auth/signin.css">
    <link rel="stylesheet" href="../../assets/css/splash.css">
</head>

<body>
    <div id="preloader"></div>
    <div class="auth-card">

        <div class="form-head">
            <img src="../../../assets/img/LEYTE-PULSE.png" alt="" srcset="">
  
            <p>Sign in to your LEYTE PULSE workspace.</p>
        </div>

        <div class="form-error" id="formError">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v5M12 16h.01" />
            </svg>
            <span id="formErrorText">Enter your username or email and password.</span>
        </div>
        <div class="form-success" id="formSuccess">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 11l3 3L22 4" />
                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
            </svg>
            <!-- <span>Signing you in — this demo would POST to <code>/api/auth/login.php</code> from here.</span> -->
        </div>

        <form id="signinForm">
            <div class="field-group">
                <label class="field-label" for="siUser">User ID</label>
                <input type="text" id="siUser" placeholder="Enter your user ID" autocomplete="username">
            </div>
            <div class="field-group">
                <label class="field-label" for="siPassword">Password</label>
                <div class="input-wrap">
                    <input type="password" id="siPassword" class="has-toggle" placeholder="Enter your password"
                        autocomplete="current-password">
                    <button type="button" class="pw-toggle" data-toggle-for="siPassword" aria-label="Show password">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="row-between">
                <label class="checkbox-row"><input type="checkbox" id="siRemember"> Remember me</label>
                <a class="link-accent" href="#" id="forgotLink">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary-auth">
                Sign In
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M13 6l6 6-6 6" />
                </svg>
            </button>
        </form>

        <!-- <div class="divider-row"><span class="line"></span><span>New to DDC PULSE</span><span class="line"></span></div> -->

        <!-- <div class="switch-cta">Don't have an account? <a href="signup.html">Create one</a></div> -->

        <div class="form-foot">DDC PULSE — Project Updates, Logging &amp; Scheduling Engine 2026 © Paul Ian</div>
    </div>
    <script src="../../assets/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../../assets/js/sole.js"></script>
    <script src="../../assets/js/sole.swal.js"></script>
    <script src="../../assets/js/auth/signin.js"></script>
    <script src="../../assets/js/splash.js"></script>
</body>

</html>