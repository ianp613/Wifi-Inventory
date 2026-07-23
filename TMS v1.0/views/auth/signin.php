<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DDC PULSE — Sign In</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#F4F6F3;
    --surface:#FFFFFF;
    --surface-alt:#ECEFE9;
    --ink:#1B2A22;
    --ink-soft:#5B6B60;
    --ink-faint:#8A968C;
    --line:#DBE1D5;
    --line-strong:#C3CCBB;
    --accent:#2F6F5E;
    --accent-dark:#1F5647;
    --accent-soft:#DCEBE4;
    --amber:#C98A2E;
    --red:#A23B3B;
    --red-soft:#F3DCDC;
    --radius:14px;
    --shadow-sm:0 1px 2px rgba(27,42,34,0.06);
    --shadow-lg:0 24px 60px rgba(27,42,34,0.14);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    background:
      radial-gradient(circle at 15% 10%, rgba(47,111,94,.07) 0%, rgba(47,111,94,0) 45%),
      radial-gradient(circle at 90% 85%, rgba(138,111,176,.06) 0%, rgba(138,111,176,0) 45%),
      var(--bg);
    color:var(--ink);
    font-family:'Inter',sans-serif;
    font-size:14px;
    -webkit-font-smoothing:antialiased;
    min-height:100vh;
    display:flex;align-items:center;justify-content:center;
    padding:32px 20px;
  }
  a{color:inherit;text-decoration:none;}
  button{font-family:inherit;cursor:pointer;}
  ::selection{background:var(--accent-soft);}

  /* ---------- Card ---------- */
  .auth-card{
    width:100%;max-width:400px;background:var(--surface);border:1px solid var(--line);
    border-radius:var(--radius);box-shadow:var(--shadow-lg);padding:36px 34px 32px;
  }

  .brand-row{display:flex;align-items:center;gap:10px;justify-content:center;margin-bottom:26px;}
  .brand-mark{
    width:32px;height:32px;border-radius:8px;flex-shrink:0;
    background:linear-gradient(155deg,#2F6F5E 0%, #1F5647 100%);
    display:flex;align-items:center;justify-content:center;
    font-family:'Fraunces',serif;font-weight:700;font-size:15px;color:#fff;
  }
  .brand-word{font-family:'Fraunces',serif;font-size:17px;font-weight:600;letter-spacing:.3px;}
  .brand-tagline{
    font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.08em;text-transform:uppercase;
    color:var(--ink-faint);margin-top:2px;
  }

  .form-head{text-align:center;margin-bottom:26px;}
  .form-head h2{font-family:'Fraunces',serif;font-size:23px;font-weight:600;margin:0 0 6px;}
  .form-head p{font-size:13px;color:var(--ink-soft);margin:0;}

  .field-group{margin-bottom:16px;}
  .field-label{font-size:12px;font-weight:600;color:var(--ink-soft);margin:0 0 6px;display:block;}
  .input-wrap{position:relative;}
  input[type=text], input[type=password]{
    width:100%;border:1.5px solid var(--line);border-radius:9px;padding:11px 13px;font-size:13.5px;
    font-family:inherit;color:var(--ink);background:var(--surface);outline:none;transition:border-color .12s ease;
  }
  input[type=text]:focus, input[type=password]:focus{border-color:var(--accent);}
  input.has-toggle{padding-right:42px;}
  .pw-toggle{
    position:absolute;right:6px;top:50%;transform:translateY(-50%);width:30px;height:30px;border:none;background:none;
    display:flex;align-items:center;justify-content:center;color:var(--ink-faint);border-radius:6px;
  }
  .pw-toggle:hover{color:var(--ink-soft);background:var(--surface-alt);}
  .pw-toggle svg{width:16px;height:16px;}

  .row-between{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;}
  .checkbox-row{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--ink-soft);}
  .checkbox-row input{width:15px;height:15px;accent-color:var(--accent);}
  .link-accent{font-size:12.5px;font-weight:600;color:var(--accent-dark);}
  .link-accent:hover{text-decoration:underline;}

  .btn-primary-auth{
    width:100%;background:var(--ink);color:#fff;border:none;border-radius:9px;padding:12px 0;
    font-size:13.5px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;
    box-shadow:var(--shadow-sm);
  }
  .btn-primary-auth:hover{background:var(--accent-dark);}
  .btn-primary-auth svg{width:15px;height:15px;}

  .form-error{
    display:none;align-items:flex-start;gap:9px;background:var(--red-soft);color:var(--red);border-radius:9px;
    padding:11px 13px;font-size:12.5px;margin-bottom:18px;line-height:1.5;
  }
  .form-error.show{display:flex;}
  .form-error svg{width:15px;height:15px;flex-shrink:0;margin-top:1px;}

  .form-success{
    display:none;align-items:flex-start;gap:9px;background:var(--accent-soft);color:var(--accent-dark);border-radius:9px;
    padding:11px 13px;font-size:12.5px;margin-bottom:18px;line-height:1.5;
  }
  .form-success.show{display:flex;}
  .form-success svg{width:15px;height:15px;flex-shrink:0;margin-top:1px;}

  .divider-row{display:flex;align-items:center;gap:12px;margin:24px 0 18px;}
  .divider-row .line{flex:1;height:1px;background:var(--line);}
  .divider-row span{font-size:11.5px;color:var(--ink-faint);white-space:nowrap;}

  /* .switch-cta{text-align:center;font-size:13px;color:var(--ink-soft);}
  .switch-cta a{color:var(--accent-dark);font-weight:600;}
  .switch-cta a:hover{text-decoration:underline;} */

  .form-foot{text-align:center;font-size:11px;color:var(--ink-faint);margin-top:22px;}

  /* ---------- Mobile: full screen ---------- */
  @media (max-width:520px){
    body{padding:0;align-items:stretch;}
    .auth-card{
      max-width:100%;min-height:100vh;border-radius:0;border:none;box-shadow:none;
      display:flex;flex-direction:column;justify-content:center;padding:32px 24px;
    }
  }
</style>
</head>
<body>

<div class="auth-card">
  <div class="brand-row">
    <div class="brand-mark">P</div>
    <div>
      <div class="brand-word">DDC PULSE</div>
      <div class="brand-tagline">Project Updates, Logging &amp; Scheduling</div>
    </div>
  </div>

  <div class="form-head">
    <h2>Welcome</h2>
    <p>Sign in to your DDC PULSE workspace.</p>
  </div>

  <div class="form-error" id="formError">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v5M12 16h.01"/></svg>
    <span id="formErrorText">Enter your username or email and password.</span>
  </div>
  <div class="form-success" id="formSuccess">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
    <span>Signing you in — this demo would POST to <code>/api/auth/login.php</code> from here.</span>
  </div>

  <form id="signinForm">
    <div class="field-group">
      <label class="field-label" for="siUser">User ID</label>
      <input type="text" id="siUser" placeholder="Enter your user ID" autocomplete="username">
    </div>
    <div class="field-group">
      <label class="field-label" for="siPassword">Password</label>
      <div class="input-wrap">
        <input type="password" id="siPassword" class="has-toggle" placeholder="Enter your password" autocomplete="current-password">
        <button type="button" class="pw-toggle" data-toggle-for="siPassword" aria-label="Show password">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
      </div>
    </div>

    <div class="row-between">
      <label class="checkbox-row"><input type="checkbox" id="siRemember"> Remember me</label>
      <a class="link-accent" href="#" id="forgotLink">Forgot password?</a>
    </div>

    <button type="submit" class="btn-primary-auth">
      Sign In
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </button>
  </form>

  <!-- <div class="divider-row"><span class="line"></span><span>New to DDC PULSE</span><span class="line"></span></div> -->

  <!-- <div class="switch-cta">Don't have an account? <a href="signup.html">Create one</a></div> -->

  <div class="form-foot">DDC PULSE — Project Updates, Logging &amp; Scheduling Engine 2026 © Paul Ian</div>
</div>

<script>
document.querySelectorAll('.pw-toggle').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const input = document.getElementById(btn.dataset.toggleFor);
    const isPw = input.type === 'password';
    input.type = isPw ? 'text' : 'password';
    btn.setAttribute('aria-label', isPw ? 'Hide password' : 'Show password');
    btn.innerHTML = isPw
      ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a21.8 21.8 0 015.06-6.06M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.8 21.8 0 01-3.22 4.34M14.12 14.12a3 3 0 11-4.24-4.24"/><path d="M1 1l22 22"/></svg>'
      : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>';
  });
});

document.getElementById('forgotLink').addEventListener('click', e=>{
  e.preventDefault();
  document.getElementById('formErrorText').textContent = "Password reset isn't wired up in this prototype — it would send a reset link via /api/auth/forgot-password.php.";
  document.getElementById('formSuccess').classList.remove('show');
  document.getElementById('formError').classList.add('show');
});

document.getElementById('signinForm').addEventListener('submit', e=>{
  e.preventDefault();
  const user = document.getElementById('siUser').value.trim();
  const pw = document.getElementById('siPassword').value;
  const errEl = document.getElementById('formError');
  const okEl = document.getElementById('formSuccess');

  if(!user || !pw){
    document.getElementById('formErrorText').textContent = 'Enter your username or email and password.';
    okEl.classList.remove('show');
    errEl.classList.add('show');
    return;
  }
  errEl.classList.remove('show');
  okEl.classList.add('show');
});
</script>
</body>
</html>