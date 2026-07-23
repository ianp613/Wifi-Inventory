<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page Not Found — DDC PULSE</title>
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
    --amber-soft:#F5E7D1;
    --radius:14px;
    --shadow-sm:0 1px 2px rgba(27,42,34,0.06);
    --shadow-md:0 10px 30px rgba(27,42,34,0.10);
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

  .wrap{width:100%;max-width:440px;display:flex;flex-direction:column;align-items:center;text-align:center;}

  .brand-row{display:flex;align-items:center;gap:10px;margin-bottom:44px;}
  .brand-mark{
    width:32px;height:32px;border-radius:8px;flex-shrink:0;
    background:linear-gradient(155deg,#2F6F5E 0%, #1F5647 100%);
    display:flex;align-items:center;justify-content:center;
    font-family:'Fraunces',serif;font-weight:700;font-size:15px;color:#fff;
  }
  .brand-word{font-family:'Fraunces',serif;font-size:17px;font-weight:600;letter-spacing:.3px;}
  .brand-head{
    text-align:left;
  }
  .brand-tagline{
    font-family:'IBM Plex Mono',monospace;font-size:9.5px;letter-spacing:.08em;text-transform:uppercase;
    color:var(--ink-faint);margin-top:2px;text-align:left;
  }

  /* ---------- Lost ticket illustration ---------- */
  .lost-ticket{
    position:relative;background:var(--surface);border:1.5px dashed var(--line-strong);border-radius:12px;
    padding:16px 20px;width:230px;box-shadow:var(--shadow-md);transform:rotate(-4deg);margin-bottom:6px;
  }
  .lost-ticket::before{
    content:'';position:absolute;top:50%;left:-8px;width:16px;height:16px;border-radius:50%;
    background:var(--bg);border:1.5px dashed var(--line-strong);transform:translateY(-50%);
  }
  .lost-ticket::after{
    content:'';position:absolute;top:50%;right:-8px;width:16px;height:16px;border-radius:50%;
    background:var(--bg);border:1.5px dashed var(--line-strong);transform:translateY(-50%);
  }
  .lost-ticket-top{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:10px;text-align:left;}
  .lost-ticket-proj{font-size:9.5px;color:var(--ink-faint);font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;}
  .lost-ticket-title{font-size:12px;font-weight:600;color:var(--ink-soft);line-height:1.3;}
  .lost-stamp{
    font-family:'IBM Plex Mono',monospace;font-size:12px;font-weight:700;
    padding:5px 9px;border-radius:6px;border:1.5px solid var(--amber);color:var(--amber);
    background:var(--amber-soft);flex-shrink:0;transform:rotate(6deg);
  }
  .lost-ticket-meta{display:flex;align-items:center;gap:6px;font-size:10px;color:var(--ink-faint);text-align:left;}
  .lost-ticket-bar{flex:1;height:5px;border-radius:4px;background:var(--surface-alt);}

  .error-code{
    font-family:'IBM Plex Mono',monospace;font-size:11.5px;font-weight:700;letter-spacing:.1em;
    color:var(--ink-faint);text-transform:uppercase;margin:26px 0 10px;
  }
  h1{font-family:'Fraunces',serif;font-size:clamp(24px,4vw,30px);font-weight:600;margin:0 0 10px;line-height:1.25;}
  .sub{font-size:13.5px;color:var(--ink-soft);line-height:1.65;max-width:360px;margin:0 0 30px;}

  .actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:34px;}
  .btn-primary-auth{
    background:var(--ink);color:#fff;border:none;border-radius:9px;padding:11px 20px;
    font-size:13.5px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;
    box-shadow:var(--shadow-sm);
  }
  .btn-primary-auth:hover{background:var(--accent-dark);}
  .btn-primary-auth svg{width:15px;height:15px;}
  .btn-secondary-auth{
    background:var(--surface);color:var(--ink-soft);border:1.5px solid var(--line);border-radius:9px;
    padding:11px 20px;font-size:13.5px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;
  }
  .btn-secondary-auth:hover{border-color:var(--line-strong);color:var(--ink);}
  .btn-secondary-auth svg{width:15px;height:15px;}

  .helper-links{font-size:12.5px;color:var(--ink-faint);}
  .helper-links a{color:var(--accent-dark);font-weight:600;}
  .helper-links a:hover{text-decoration:underline;}

  .form-foot{text-align:center;font-size:11px;color:var(--ink-faint);margin-top:36px;}

  @media (max-width:420px){
    .lost-ticket{width:200px;}
    .actions{flex-direction:column;width:100%;}
    .actions .btn-primary-auth, .actions .btn-secondary-auth{width:100%;}
  }
</style>
</head>
<body>

<div class="wrap">
  <div class="brand-row">
    <div class="brand-mark">P</div>
    <div class="brand-head">
      <div class="brand-word">DDC PULSE</div>
      <div class="brand-tagline">Project Updates, Logging &amp; Scheduling</div>
    </div>
  </div>

  <div class="lost-ticket">
    <div class="lost-ticket-top">
      <div>
        <div class="lost-ticket-proj">Unknown Project</div>
        <div class="lost-ticket-title">This page wandered off somewhere</div>
      </div>
      <span class="lost-stamp">?</span>
    </div>
    <div class="lost-ticket-meta">
      <span>Status: Missing</span>
      <span class="lost-ticket-bar"></span>
    </div>
  </div>

  <div class="error-code">Error 404</div>
  <h1>We couldn't find that page</h1>
  <p class="sub">The page you're looking for may have been moved, renamed, or never existed. Let's get you back on track.</p>

  <div class="actions">
    <button class="btn-secondary-auth" id="goBackBtn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      Go Back
    </button>
  </div>
  <div class="form-foot">DDC PULSE — Project Updates, Logging &amp; Scheduling Engine 2026 © Paul Ian</div>
</div>

<script>
document.getElementById('goBackBtn').addEventListener('click', ()=>{
  if(window.history.length > 1){ window.history.back(); }
  else { window.location.href = window.location.origin; }
});
</script>
</body>
</html>