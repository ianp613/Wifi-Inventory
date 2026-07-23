<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Workbench — Administrator</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
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
    --rust:#B75B39;
    --rust-soft:#F3E0D5;
    --red:#A23B3B;
    --red-soft:#F3DCDC;
    --blue:#3B6FA0;
    --blue-soft:#DCE6EF;
    --purple:#8A6FB0;
    --purple-soft:#EAE3F3;
    --radius:10px;
    --shadow-sm: 0 1px 2px rgba(27,42,34,0.06);
    --shadow-md: 0 6px 20px rgba(27,42,34,0.09);
    --shadow-lg: 0 20px 60px rgba(27,42,34,0.22);
  }
  *{box-sizing:border-box;}
  html,body{margin:0;padding:0;}
  body{
    background:var(--bg);
    color:var(--ink);
    font-family:'Inter',sans-serif;
    font-size:14px;
    -webkit-font-smoothing:antialiased;
  }
  .mono{font-family:'IBM Plex Mono',monospace;}
  .display{font-family:'Fraunces',serif;}
  a{color:inherit;text-decoration:none;}
  button{font-family:inherit;cursor:pointer;}
  ::selection{background:var(--accent-soft);}

  /* ---------- Shell ---------- */
  .shell{display:grid;grid-template-columns:240px 1fr;min-height:100vh;}

  /* ---------- Sidebar ---------- */
  .sidebar{
    background:var(--ink);color:#EFF3EE;padding:22px 16px;
    display:flex;flex-direction:column;gap:26px;
  }
  .brand{display:flex;align-items:center;gap:10px;padding:0 4px;}
  .brand-mark{
    width:30px;height:30px;border-radius:7px;
    background:linear-gradient(155deg,var(--purple) 0%, #5F4A82 100%);
    display:flex;align-items:center;justify-content:center;
    font-family:'Fraunces',serif;font-weight:600;font-size:15px;color:#fff;flex-shrink:0;
  }
  .brand-name{font-family:'Fraunces',serif;font-size:17px;font-weight:600;letter-spacing:.2px;}
  .role-pill{
    font-family:'IBM Plex Mono',monospace;font-size:10.5px;letter-spacing:.06em;text-transform:uppercase;
    color:#AEC3B7;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
    padding:3px 8px;border-radius:20px;display:inline-block;margin-top:2px;
  }
  .nav-group{display:flex;flex-direction:column;gap:2px;}
  .nav-label{
    font-family:'IBM Plex Mono',monospace;font-size:10px;letter-spacing:.1em;text-transform:uppercase;
    color:#7C8B80;padding:0 10px;margin-bottom:6px;
  }
  .nav-label-row{display:flex;align-items:center;justify-content:space-between;padding:0 10px;margin-bottom:6px;}
  .nav-add-btn{
    width:20px;height:20px;border-radius:6px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06);
    color:#C7D2C3;display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .nav-add-btn svg{width:12px;height:12px;}
  .nav-add-btn:hover{background:rgba(255,255,255,.12);color:#fff;}
  .nav-item{
    display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:8px;
    color:#D4DCD2;font-size:13.5px;font-weight:500;border:1px solid transparent;
  }
  .nav-item svg{width:16px;height:16px;flex-shrink:0;opacity:.85;}
  .nav-item:hover{background:rgba(255,255,255,.05);}
  .nav-item.active{background:rgba(255,255,255,.09);color:#fff;border-color:rgba(255,255,255,.08);}
  .nav-count{
    margin-left:auto;font-family:'IBM Plex Mono',monospace;font-size:10.5px;
    background:rgba(255,255,255,.08);padding:1px 6px;border-radius:20px;color:#C7D2C3;
  }
  .sidebar-foot{
    margin-top:auto;display:flex;align-items:center;gap:10px;padding:10px;border-radius:9px;
    background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);
  }
  .avatar{
    width:32px;height:32px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(155deg,#3B6FA0,#274F72);
    display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:12.5px;
  }
  .sidebar-foot .who{line-height:1.25;}
  .sidebar-foot .name{font-size:13px;font-weight:600;color:#fff;}
  .sidebar-foot .email{font-size:11px;color:#93A093;}

  /* ---------- Main ---------- */
  .main{padding:26px 34px 60px;max-width:1320px;}
  .hamburger-btn{display:none;}
  .sidebar-overlay{
    position:fixed;inset:0;background:rgba(27,42,34,.4);opacity:0;pointer-events:none;
    transition:opacity .2s ease;z-index:59;
  }
  .sidebar-overlay.open{opacity:1;pointer-events:auto;}

  .topbar{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:26px;flex-wrap:wrap;}
  .topbar-left{display:flex;align-items:center;gap:10px;}
  .greeting h1{font-family:'Fraunces',serif;font-weight:500;font-size:26px;margin:0 0 4px;}
  .greeting p{margin:0;color:var(--ink-soft);font-size:13.5px;}
  .greeting .date-stub{font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--ink-faint);letter-spacing:.04em;}

  .top-actions{display:flex;align-items:center;gap:10px;}
  .search-box{
    display:flex;align-items:center;gap:8px;background:var(--surface);
    border:1px solid var(--line);border-radius:9px;padding:8px 12px;width:230px;box-shadow:var(--shadow-sm);
  }
  .search-box input{border:none;outline:none;background:transparent;font-size:13px;width:100%;font-family:inherit;color:var(--ink);}
  .search-box svg{width:15px;height:15px;color:var(--ink-faint);flex-shrink:0;}
  .icon-btn{
    width:36px;height:36px;border-radius:9px;background:var(--surface);border:1px solid var(--line);
    display:flex;align-items:center;justify-content:center;position:relative;box-shadow:var(--shadow-sm);flex-shrink:0;
  }
  .icon-btn svg{width:16px;height:16px;color:var(--ink-soft);}
  .dot-badge{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:var(--rust);border:1.5px solid var(--surface);}

  .btn-primary{
    display:flex;align-items:center;gap:7px;background:var(--ink);color:#fff;border:none;border-radius:9px;
    padding:9px 16px;font-size:13px;font-weight:600;box-shadow:var(--shadow-sm);white-space:nowrap;flex-shrink:0;
  }
  .btn-primary svg{width:15px;height:15px;}

  /* ---------- Stat strip ---------- */
  .stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
  .stat-card{
    background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);
    padding:16px 18px;box-shadow:var(--shadow-sm);position:relative;overflow:hidden;
  }
  .stat-card .num{font-family:'Fraunces',serif;font-size:28px;font-weight:600;line-height:1;}
  .stat-card .lbl{font-size:12px;color:var(--ink-soft);margin-top:6px;}
  .stat-card .accent-bar{position:absolute;left:0;top:0;bottom:0;width:3px;}
  .stat-card.total .accent-bar{background:var(--blue);}
  .stat-card.overdue .accent-bar{background:var(--red);}
  .stat-card.done .accent-bar{background:var(--accent);}
  .stat-card.team .accent-bar{background:var(--purple);}

  /* ---------- Team workload ---------- */
  .section-title{
    font-size:12px;text-transform:uppercase;letter-spacing:.07em;font-weight:700;color:var(--ink-soft);
    margin:0 0 12px;
  }
  .workload-strip{
    display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:28px;
  }
  .workload-card{
    background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);
    padding:14px 15px;box-shadow:var(--shadow-sm);cursor:pointer;transition:box-shadow .15s ease;
  }
  .workload-card:hover{box-shadow:var(--shadow-md);}
  .workload-card.filtered{border-color:var(--accent);box-shadow:0 0 0 2px var(--accent-soft);}
  .workload-top{display:flex;align-items:center;gap:9px;margin-bottom:10px;}
  .workload-top .name{font-size:13px;font-weight:700;}
  .workload-top .role{font-size:10.5px;color:var(--ink-faint);}
  .workload-nums{display:flex;justify-content:space-between;font-size:11px;color:var(--ink-soft);margin-bottom:6px;}
  .workload-nums strong{color:var(--ink);font-weight:700;}
  .bar-track{width:100%;height:6px;border-radius:4px;background:var(--surface-alt);overflow:hidden;}
  .bar-fill{height:100%;background:var(--accent);border-radius:4px;}
  .workload-flag{font-size:10px;color:var(--red);font-weight:600;margin-top:6px;}

  /* ---------- View tabs ---------- */
  .view-tabs{display:flex;gap:4px;border-bottom:1px solid var(--line);margin-bottom:22px;overflow-x:auto;white-space:nowrap;}
  .view-tab{
    padding:10px 4px;margin-right:22px;font-size:13.5px;font-weight:600;color:var(--ink-faint);
    border-bottom:2px solid transparent;position:relative;top:1px;
  }
  .view-tab.active{color:var(--ink);border-color:var(--blue);}
  .panel{display:none;}
  .panel.active{display:block;}

  /* ---------- Filters ---------- */
  .filter-row{display:flex;align-items:center;gap:8px;margin-bottom:18px;flex-wrap:wrap;}
  .chip{
    font-size:12px;font-weight:500;padding:6px 12px;border-radius:20px;border:1px solid var(--line);
    background:var(--surface);color:var(--ink-soft);
  }
  .chip.active{background:var(--ink);color:#fff;border-color:var(--ink);}
  .filter-spacer{flex:1;}
  .select-filter, .sort-select{
    font-size:12px;border:1px solid var(--line);background:var(--surface);border-radius:8px;
    padding:6px 10px;color:var(--ink-soft);font-family:inherit;
  }

  /* ---------- Task ticket list ---------- */
  .ticket-list{display:flex;flex-direction:column;gap:10px;}
  .ticket{
    display:flex;background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);
    box-shadow:var(--shadow-sm);cursor:pointer;position:relative;transition:box-shadow .15s ease, transform .15s ease;
  }
  .ticket:hover{box-shadow:var(--shadow-md);transform:translateY(-1px);}
  .ticket-stub{
    width:46px;flex-shrink:0;border-right:1px dashed var(--line-strong);
    display:flex;align-items:center;justify-content:center;
  }
  .ticket-body{flex:1;padding:14px 16px;min-width:0;}
  .ticket-top{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;}
  .ticket-title{font-size:14px;font-weight:600;margin:0 0 4px;}
  .ticket-proj{font-size:11.5px;color:var(--blue);font-weight:600;}
  .ticket-desc{font-size:12.5px;color:var(--ink-soft);margin:4px 0 10px;max-width:520px;
    overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .ticket-meta{display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
  .meta-item{display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--ink-faint);}
  .meta-item svg{width:13px;height:13px;}
  .meta-item.due-soon{color:var(--amber);}
  .meta-item.overdue{color:var(--red);font-weight:600;}
  .meta-item.assignee{font-weight:600;color:var(--ink-soft);}

  .stamp{
    font-family:'IBM Plex Mono',monospace;font-size:9.5px;font-weight:600;letter-spacing:.08em;
    text-transform:uppercase;border-radius:5px;padding:4px 8px;border:1.5px solid;white-space:nowrap;flex-shrink:0;
  }
  .stamp.low{color:var(--ink-soft);border-color:var(--line-strong);background:var(--surface-alt);}
  .stamp.medium{color:var(--amber);border-color:var(--amber);background:var(--amber-soft);}
  .stamp.high{color:var(--rust);border-color:var(--rust);background:var(--rust-soft);}
  .stamp.critical{color:var(--red);border-color:var(--red);background:var(--red-soft);}

  .status-tag{font-size:10.5px;font-weight:600;padding:3px 9px;border-radius:20px;}
  .status-todo{background:var(--surface-alt);color:var(--ink-soft);}
  .status-progress{background:var(--blue-soft);color:var(--blue);}
  .status-hold{background:var(--amber-soft);color:var(--amber);}
  .status-done{background:var(--accent-soft);color:var(--accent-dark);}

  .checklist-progress{display:flex;align-items:center;gap:6px;}
  .mini-bar-track{width:60px;height:5px;border-radius:4px;background:var(--surface-alt);overflow:hidden;}
  .mini-bar-fill{height:100%;background:var(--accent);border-radius:4px;}

  /* ---------- Kanban ---------- */
  .kanban{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;align-items:start;}
  .kcol{background:var(--surface-alt);border-radius:12px;padding:12px;min-height:120px;}
  .kcol-head{display:flex;align-items:center;justify-content:space-between;padding:2px 4px 12px;}
  .kcol-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-soft);}
  .kcol-count{font-family:'IBM Plex Mono',monospace;font-size:11px;background:var(--surface);border:1px solid var(--line);
    padding:1px 7px;border-radius:20px;color:var(--ink-faint);}
  .kcard{
    background:var(--surface);border:1px solid var(--line);border-radius:9px;padding:12px 12px 10px;
    margin-bottom:10px;box-shadow:var(--shadow-sm);cursor:grab;
  }
  .kcard:active{cursor:grabbing;}
  .kcard.drag-ghost{opacity:.4;}
  .kcard-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;gap:6px;}
  .kcard-title{font-size:13px;font-weight:600;line-height:1.3;}
  .kcard-proj{font-size:10.5px;color:var(--blue);font-weight:600;margin-bottom:6px;}
  .kcard-assignee{display:flex;align-items:center;gap:6px;margin-top:8px;}
  .kcard-assignee .avatar{width:20px;height:20px;font-size:9px;}
  .kcard-assignee span{font-size:11px;color:var(--ink-soft);font-weight:600;}
  .kcard-foot{display:flex;align-items:center;justify-content:space-between;margin-top:8px;}
  .kcard-due{font-size:10.5px;color:var(--ink-faint);font-family:'IBM Plex Mono',monospace;}
  .kcol.drop-hover{outline:2px dashed var(--blue);outline-offset:-4px;}
  .kcard-move{display:none;}

  /* ---------- Modal (new task) ---------- */
  .modal-overlay{
    position:fixed;inset:0;background:rgba(27,42,34,.45);opacity:0;pointer-events:none;
    transition:opacity .2s ease;z-index:70;display:flex;align-items:flex-start;justify-content:center;
    padding:40px 16px;overflow-y:auto;
  }
  .modal-overlay.open{opacity:1;pointer-events:auto;}
  .modal{
    background:var(--surface);border-radius:14px;width:100%;max-width:560px;box-shadow:var(--shadow-lg);
    transform:translateY(-14px);transition:transform .2s ease;
  }
  .modal-overlay.open .modal{transform:translateY(0);}
  .modal-head{display:flex;align-items:center;justify-content:space-between;padding:20px 22px;border-bottom:1px solid var(--line);}
  .modal-head h2{font-family:'Fraunces',serif;font-size:19px;font-weight:600;margin:0;}
  .modal-close{width:30px;height:30px;border-radius:8px;border:1px solid var(--line);background:var(--surface);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .modal-close svg{width:14px;height:14px;}
  .modal-body{padding:20px 22px;max-height:70vh;overflow-y:auto;}
  .modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;border-top:1px solid var(--line);}

  .field-label{font-size:11.5px;font-weight:600;color:var(--ink-soft);margin:0 0 5px;display:block;}
  .field-group{margin-bottom:14px;}
  .field-row2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
  input[type=text], input[type=date], select, textarea{
    width:100%;border:1px solid var(--line);border-radius:8px;padding:9px 11px;font-size:12.5px;
    font-family:inherit;color:var(--ink);background:var(--surface);outline:none;
  }
  input[type=text]:focus, input[type=date]:focus, select:focus, textarea:focus{border-color:var(--blue);}
  textarea{resize:vertical;min-height:70px;}
  .priority-picker{display:flex;gap:8px;}
  .priority-opt{
    flex:1;text-align:center;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;
    padding:8px 4px;border-radius:8px;border:1.5px solid var(--line);color:var(--ink-soft);cursor:pointer;
  }
  .priority-opt.sel.low{border-color:var(--line-strong);background:var(--surface-alt);color:var(--ink-soft);}
  .priority-opt.sel.medium{border-color:var(--amber);background:var(--amber-soft);color:var(--amber);}
  .priority-opt.sel.high{border-color:var(--rust);background:var(--rust-soft);color:var(--rust);}
  .priority-opt.sel.critical{border-color:var(--red);background:var(--red-soft);color:var(--red);}

  .btn-secondary{
    background:var(--surface);border:1px solid var(--line);border-radius:9px;padding:9px 16px;
    font-size:13px;font-weight:600;color:var(--ink-soft);
  }
  .btn-primary-modal{
    background:var(--ink);color:#fff;border:none;border-radius:9px;padding:9px 18px;font-size:13px;font-weight:600;
  }

  /* ---------- New task: checklist + attachment builders ---------- */
  .nt-checklist-row{display:flex;gap:8px;margin-bottom:8px;}
  .nt-checklist-row input{flex:1;}
  .nt-add-btn{
    background:var(--surface-alt);border:1px solid var(--line);border-radius:8px;padding:0 16px;
    font-size:12.5px;font-weight:600;color:var(--ink-soft);white-space:nowrap;flex-shrink:0;
  }
  .nt-list-item{
    display:flex;align-items:center;gap:8px;background:var(--surface-alt);border-radius:8px;
    padding:8px 10px;margin-bottom:6px;font-size:12.5px;
  }
  .nt-list-item span:first-of-type{flex:1;word-break:break-word;}
  .nt-list-item .fsize{color:var(--ink-faint);font-family:'IBM Plex Mono',monospace;font-size:10.5px;flex-shrink:0;}
  .nt-list-item button{
    background:none;border:none;color:var(--ink-faint);width:20px;height:20px;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;padding:0;
  }
  .nt-list-item button svg{width:13px;height:13px;}
  .nt-file-btn{
    display:inline-flex;align-items:center;gap:7px;background:var(--surface-alt);
    border:1px dashed var(--line-strong);border-radius:8px;padding:9px 14px;font-size:12.5px;
    font-weight:600;color:var(--ink-soft);cursor:pointer;
  }
  .nt-file-btn svg{width:14px;height:14px;flex-shrink:0;}
  .nt-empty-hint{font-size:11.5px;color:var(--ink-faint);padding:2px;}

  /* ---------- Manage Projects modal ---------- */
  .swatch-row{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:4px;}
  .swatch{
    width:26px;height:26px;border-radius:50%;border:2px solid transparent;flex-shrink:0;position:relative;
  }
  .swatch.sel{border-color:var(--ink);}
  .swatch.sel::after{
    content:'';position:absolute;inset:4px;border-radius:50%;border:2px solid #fff;
  }
  .project-form-btns{display:flex;gap:8px;margin-top:14px;}
  .project-form-btns .btn-primary-modal{flex:1;}
  .project-divider{border:none;border-top:1px solid var(--line);margin:20px 0 14px;}
  .project-row{
    display:flex;align-items:center;gap:10px;padding:9px 4px;border-bottom:1px solid var(--surface-alt);
  }
  .project-row:last-child{border-bottom:none;}
  .project-dot{width:11px;height:11px;border-radius:50%;flex-shrink:0;}
  .project-row-name{flex:1;font-size:13px;font-weight:600;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .project-row-count{font-size:10.5px;color:var(--ink-faint);font-family:'IBM Plex Mono',monospace;flex-shrink:0;}
  .project-row-actions{display:flex;gap:4px;flex-shrink:0;}
  .project-icon-btn{
    width:26px;height:26px;border-radius:7px;border:1px solid var(--line);background:var(--surface);
    display:flex;align-items:center;justify-content:center;color:var(--ink-soft);flex-shrink:0;
  }
  .project-icon-btn svg{width:13px;height:13px;}
  .project-icon-btn.danger:hover{color:var(--red);border-color:var(--red);background:var(--red-soft);}
  .project-delete-row{
    display:flex;align-items:center;gap:8px;padding:8px 4px;background:var(--red-soft);border-radius:8px;
    font-size:11.5px;color:var(--red);flex:1;
  }
  .project-delete-row button{
    font-size:11px;font-weight:700;border:none;border-radius:6px;padding:5px 10px;flex-shrink:0;
  }
  .project-delete-confirm-btn{background:var(--red);color:#fff;}
  .project-delete-cancel-btn{background:var(--surface);color:var(--ink-soft);border:1px solid var(--line) !important;}
  .project-empty{font-size:12px;color:var(--ink-faint);padding:16px 4px;text-align:center;}

  /* ---------- Users panel ---------- */
  .user-row{
    display:flex;align-items:center;gap:14px;flex-wrap:wrap;
    background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);
    box-shadow:var(--shadow-sm);padding:14px 16px;
  }
  .user-row .avatar{width:38px;height:38px;font-size:13px;flex-shrink:0;}
  .user-info{flex:1 1 220px;min-width:0;}
  .user-name-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:3px;}
  .user-name{font-size:14px;font-weight:700;}
  .user-email{font-size:12px;color:var(--ink-soft);}
  .user-meta-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-top:7px;}
  .role-badge{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:3px 8px;border-radius:20px;flex-shrink:0;}
  .role-badge.role-admin{background:var(--purple-soft);color:var(--purple);}
  .role-badge.role-supervisor{background:var(--blue-soft);color:var(--blue);}
  .role-badge.role-member{background:var(--accent-soft);color:var(--accent-dark);}
  .dept-tag{
    font-size:10.5px;font-weight:600;padding:3px 9px;border-radius:20px;background:var(--surface-alt);
    color:var(--ink-soft);display:inline-flex;align-items:center;gap:5px;
  }
  .dept-tag .dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
  .user-status{font-size:10.5px;font-weight:600;display:flex;align-items:center;gap:5px;color:var(--accent-dark);}
  .user-status .dot{width:7px;height:7px;border-radius:50%;background:var(--accent);flex-shrink:0;}
  .user-status.inactive{color:var(--ink-faint);}
  .user-status.inactive .dot{background:var(--ink-faint);}
  .user-actions{display:flex;gap:6px;flex-shrink:0;margin-left:auto;}
  .user-delete-wrap{flex:1;width:100%;}

  /* ---------- Detail drawer ---------- */
  .overlay{position:fixed;inset:0;background:rgba(27,42,34,.35);opacity:0;pointer-events:none;
    transition:opacity .2s ease;z-index:40;}
  .overlay.open{opacity:1;pointer-events:auto;}
  .drawer{
    position:fixed;top:0;right:0;bottom:0;width:420px;background:var(--surface);
    box-shadow:-10px 0 40px rgba(27,42,34,.15);transform:translateX(100%);
    transition:transform .25s ease;z-index:41;display:flex;flex-direction:column;
  }
  .drawer.open{transform:translateX(0);}
  .drawer-head{padding:20px 22px 14px;border-bottom:1px solid var(--line);position:relative;}
  .drawer-close{position:absolute;top:18px;right:18px;width:28px;height:28px;border-radius:7px;
    border:1px solid var(--line);background:var(--surface);display:flex;align-items:center;justify-content:center;}
  .drawer-close svg{width:14px;height:14px;}
  .drawer-proj{font-size:11px;color:var(--blue);font-weight:700;text-transform:uppercase;letter-spacing:.04em;}
  .drawer-title{font-family:'Fraunces',serif;font-size:19px;font-weight:600;margin:6px 60px 10px 0;line-height:1.3;}
  .drawer-tags{display:flex;gap:8px;flex-wrap:wrap;}
  .drawer-body{padding:16px 22px;overflow-y:auto;flex:1;}
  .d-section{margin-bottom:22px;}
  .d-section-title{font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:var(--ink-faint);
    font-weight:700;margin-bottom:9px;}
  .d-desc{font-size:13px;color:var(--ink-soft);line-height:1.6;}
  .d-meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
  .d-meta-item{background:var(--surface-alt);border-radius:8px;padding:9px 11px;}
  .d-meta-item .k{font-size:10px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;}
  .d-meta-item .v{font-size:12.5px;font-weight:600;}

  .checklist-item{display:flex;align-items:center;gap:9px;padding:7px 0;border-bottom:1px solid var(--surface-alt);}
  .checklist-item input{width:15px;height:15px;accent-color:var(--accent);}
  .checklist-item span{font-size:13px;}
  .checklist-item.checked span{color:var(--ink-faint);text-decoration:line-through;}

  .attachment{display:flex;align-items:center;gap:9px;padding:8px 10px;background:var(--surface-alt);
    border-radius:8px;margin-bottom:7px;font-size:12.5px;}
  .attachment svg{width:15px;height:15px;color:var(--ink-soft);flex-shrink:0;}
  .attachment .fname{font-weight:600;flex:1;}
  .attachment .fsize{color:var(--ink-faint);font-family:'IBM Plex Mono',monospace;font-size:10.5px;}

  .comment{display:flex;gap:9px;margin-bottom:14px;}
  .comment .avatar{width:26px;height:26px;font-size:10.5px;}
  .comment-body{flex:1;}
  .comment-head{display:flex;align-items:baseline;gap:7px;margin-bottom:2px;}
  .comment-name{font-size:12.5px;font-weight:700;}
  .comment-time{font-size:10.5px;color:var(--ink-faint);font-family:'IBM Plex Mono',monospace;}
  .comment-text{font-size:12.5px;color:var(--ink-soft);line-height:1.5;}
  .comment-input{display:flex;gap:8px;padding:14px 22px;border-top:1px solid var(--line);align-items:center;}
  .comment-input input{flex:1;border:1px solid var(--line);border-radius:20px;padding:9px 14px;font-size:12.5px;outline:none;}
  .comment-input button{
    background:var(--blue);color:#fff;border:none;border-radius:20px;padding:9px 16px;font-size:12.5px;font-weight:600;flex-shrink:0;
  }

  .status-select-row{display:flex;gap:8px;flex-wrap:wrap;}
  .status-opt{
    flex:1;text-align:center;font-size:11.5px;font-weight:600;padding:8px 4px;border-radius:8px;
    border:1.5px solid var(--line);color:var(--ink-soft);min-width:70px;cursor:pointer;
  }
  .status-opt.sel{border-color:var(--blue);background:var(--blue-soft);color:var(--blue);}

  /* ---------- Reassign task ---------- */
  .assignee-row{display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:12.5px;color:var(--ink-soft);}
  .assignee-row .avatar{width:24px;height:24px;font-size:10px;flex-shrink:0;}
  .assignee-row strong{color:var(--ink);}
  .reassign-select, .reassign-textarea{
    width:100%;border:1px solid var(--line);border-radius:8px;padding:9px 11px;font-size:12.5px;
    font-family:inherit;color:var(--ink);background:var(--surface);outline:none;margin-bottom:10px;
  }
  .reassign-select:focus, .reassign-textarea:focus{border-color:var(--blue);}
  .reassign-textarea{resize:vertical;min-height:54px;}
  .reassign-btn{
    width:100%;background:var(--blue);color:#fff;border:none;border-radius:8px;padding:10px 0;
    font-size:12.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:7px;
  }
  .reassign-btn svg{width:14px;height:14px;}
  .reassign-btn:disabled{opacity:.5;cursor:not-allowed;}
  .reassign-error{font-size:11.5px;color:var(--red);margin:-4px 0 10px;display:none;}
  .reassign-error.show{display:block;}
  .reassign-confirm{
    display:none;align-items:center;gap:8px;background:var(--blue-soft);color:var(--blue);
    border-radius:8px;padding:9px 12px;font-size:12px;font-weight:600;margin-top:10px;
  }
  .reassign-confirm.show{display:flex;}
  .reassign-confirm svg{width:15px;height:15px;flex-shrink:0;}
  .assignee-tag{
    display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:600;color:var(--purple);
    background:var(--purple-soft);padding:3px 8px;border-radius:20px;
  }
  .assignee-tag svg{width:10px;height:10px;}

  /* ================= RESPONSIVE / MOBILE ================= */
  @media (max-width:980px){
    .shell{grid-template-columns:1fr;}

    .hamburger-btn{
      display:flex;width:36px;height:36px;border-radius:9px;background:var(--surface);
      border:1px solid var(--line);align-items:center;justify-content:center;box-shadow:var(--shadow-sm);flex-shrink:0;
    }
    .hamburger-btn svg{width:17px;height:17px;color:var(--ink-soft);}

    .sidebar{
      position:fixed;top:0;left:0;bottom:0;width:250px;max-width:80vw;z-index:60;
      transform:translateX(-100%);transition:transform .25s ease;box-shadow:12px 0 30px rgba(0,0,0,.25);
    }
    .sidebar.mobile-open{transform:translateX(0);}

    .main{padding:16px 16px 60px;}
    .topbar{gap:12px;}
    .topbar-left{width:100%;}
    .greeting h1{font-size:20px;}
    .greeting p{font-size:12.5px;}
    .top-actions{width:100%;}
    .search-box{flex:1;width:auto;}
    .btn-primary span{display:none;}
    .btn-primary{padding:9px 12px;}

    .stat-strip{grid-template-columns:repeat(2,1fr);gap:10px;}
    .stat-card{padding:12px 14px;}
    .stat-card .num{font-size:22px;}

    .workload-strip{grid-template-columns:1fr 1fr;gap:10px;}

    .filter-row{gap:6px;}
    .chip{padding:5px 10px;font-size:11.5px;}
    .filter-spacer{display:none;}
    .select-filter, .sort-select{width:100%;margin-top:4px;}

    .ticket-stub{width:38px;}
    .ticket-desc{display:none;}
    .ticket-meta{gap:10px;}

    .kanban{
      grid-template-columns:none;display:flex;overflow-x:auto;gap:12px;padding-bottom:8px;
      scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;
    }
    .kcol{min-width:78vw;scroll-snap-align:start;}
    .kcard{cursor:pointer;}
    .kcard-move{
      display:flex;gap:6px;margin-top:8px;padding-top:8px;border-top:1px solid var(--line);
    }
    .kcard-move button{
      flex:1;background:var(--surface-alt);border:1px solid var(--line);border-radius:6px;
      padding:7px 0;display:flex;align-items:center;justify-content:center;
    }
    .kcard-move button svg{width:14px;height:14px;color:var(--ink-soft);}
    .kcard-move button:disabled{opacity:.3;}

    .drawer{width:100%;max-width:none;}
    .drawer-body{padding-bottom:90px;}
    .comment-input{position:sticky;bottom:0;background:var(--surface);}

    .modal{max-width:none;margin:0;border-radius:14px 14px 0 0;position:fixed;left:0;right:0;bottom:0;
      max-height:88vh;transform:translateY(100%);}
    .modal-overlay{align-items:flex-end;padding:0;}
    .modal-overlay.open .modal{transform:translateY(0);}
    .modal-body{max-height:calc(88vh - 140px);}
    .field-row2{grid-template-columns:1fr;}
  }
  @media (max-width:420px){
    .stat-strip{grid-template-columns:1fr 1fr;}
    .workload-strip{grid-template-columns:1fr;}
    .d-meta-grid{grid-template-columns:1fr;}
    .kcol{min-width:85vw;}
  }
</style>
</head>
<body>

<div class="shell">
  <!-- ================= SIDEBAR ================= -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-mark">W</div>
      <div>
        <div class="brand-name">Workbench</div>
        <span class="role-pill">Administrator</span>
      </div>
    </div>

    <nav class="nav-group">
      <span class="nav-label">Workspace</span>
      <a class="nav-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>Dashboard</a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>All Tasks<span class="nav-count">6</span></a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>Kanban Board</a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>Users<span class="nav-count" id="usersNavCount">7</span></a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-4"/></svg>Reports</a>
    </nav>

    <nav class="nav-group">
      <div class="nav-label-row">
        <span class="nav-label" style="margin:0;">Projects</span>
        <button class="nav-add-btn" id="manageProjectsBtn" title="Manage projects" aria-label="Manage projects">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
      </div>
      <div id="projectNavList"></div>
    </nav>

    <nav class="nav-group">
      <div class="nav-label-row">
        <span class="nav-label" style="margin:0;">Departments</span>
        <button class="nav-add-btn" id="manageDeptsBtn" title="Manage departments" aria-label="Manage departments">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
      </div>
      <div id="deptNavList"></div>
    </nav>

    <div class="sidebar-foot">
      <div class="avatar">MR</div>
      <div class="who">
        <div class="name">Morgan Reyes</div>
        <div class="email">morgan@workbench.io</div>
      </div>
    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <main class="main">
    <div class="topbar">
      <div class="topbar-left">
        <button class="hamburger-btn" id="hamburgerBtn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button>
        <div class="greeting">
          <h1>Morning, Morgan.</h1>
          <p>You manage <strong id="greetDeptCount">4 departments</strong> and <strong id="greetUserCount">7 users</strong> across <strong id="greetProjectCount">3 projects</strong>. <span class="date-stub">— Tue, Jul 21</span></p>
        </div>
      </div>
      <div class="top-actions">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
          <input type="text" id="searchInput" placeholder="Search tasks…">
        </div>
        <button class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 01-3.4 0"/></svg><span class="dot-badge"></span></button>
        <button class="btn-primary" id="newTaskBtn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          <span id="newTaskBtnLabel">New Task</span>
        </button>
      </div>
    </div>

    <div class="stat-strip">
      <div class="stat-card total"><div class="accent-bar"></div><div class="num" id="statTotal">6</div><div class="lbl">Active tasks</div></div>
      <div class="stat-card overdue"><div class="accent-bar"></div><div class="num" id="statOverdue">2</div><div class="lbl">Overdue</div></div>
      <div class="stat-card done"><div class="accent-bar"></div><div class="num">14</div><div class="lbl">Completed this month</div></div>
      <div class="stat-card team"><div class="accent-bar"></div><div class="num" id="statUsers">7</div><div class="lbl">Total users</div></div>
    </div>

    <div class="section-title">Team workload</div>
    <div class="workload-strip" id="workloadStrip"></div>

    <div class="view-tabs">
      <div class="view-tab active" data-view="list">All Tasks</div>
      <div class="view-tab" data-view="kanban">Kanban Board</div>
      <div class="view-tab" data-view="users">Users</div>
    </div>

    <!-- -------- LIST VIEW -------- -->
    <section class="panel active" id="panel-list">
      <div class="filter-row">
        <div class="chip active" data-filter="all">All</div>
        <div class="chip" data-filter="todo">To Do</div>
        <div class="chip" data-filter="progress">In Progress</div>
        <div class="chip" data-filter="hold">On Hold</div>
        <div class="chip" data-filter="done">Completed</div>
        <select class="select-filter" id="assigneeFilter">
          <option value="all">All team members</option>
        </select>
        <div class="filter-spacer"></div>
        <select class="sort-select">
          <option>Sort: Due date</option>
          <option>Sort: Priority</option>
          <option>Sort: Recently updated</option>
        </select>
      </div>
      <div class="ticket-list" id="ticketList"></div>
    </section>

    <!-- -------- KANBAN VIEW -------- -->
    <section class="panel" id="panel-kanban">
      <div class="kanban" id="kanbanBoard"></div>
    </section>

    <!-- -------- USERS VIEW -------- -->
    <section class="panel" id="panel-users">
      <div class="filter-row">
        <div class="chip active" data-role-filter="all">All roles</div>
        <div class="chip" data-role-filter="Administrator">Administrator</div>
        <div class="chip" data-role-filter="Supervisor">Supervisor</div>
        <div class="chip" data-role-filter="Team Member">Team Member</div>
        <select class="select-filter" id="deptFilter">
          <option value="all">All departments</option>
        </select>
        <div class="filter-spacer"></div>
        <button class="btn-secondary" id="newUserBtnInline">+ New user</button>
      </div>
      <div class="ticket-list" id="userList"></div>
    </section>
  </main>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ================= NEW TASK MODAL ================= -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-head">
      <h2>Create task</h2>
      <button class="modal-close" id="modalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>
    <div class="modal-body">
      <div class="field-group">
        <label class="field-label" for="ntTitle">Task title</label>
        <input type="text" id="ntTitle" placeholder="e.g. Update client contract template">
      </div>
      <div class="field-group">
        <label class="field-label" for="ntDesc">Description</label>
        <textarea id="ntDesc" placeholder="Add any details the assignee will need…"></textarea>
      </div>
      <div class="field-row2">
        <div class="field-group">
          <label class="field-label" for="ntProject">Project</label>
          <select id="ntProject"></select>
        </div>
        <div class="field-group">
          <label class="field-label" for="ntAssignee">Assign to</label>
          <select id="ntAssignee"></select>
        </div>
      </div>
      <div class="field-row2">
        <div class="field-group">
          <label class="field-label" for="ntStart">Start date</label>
          <input type="date" id="ntStart">
        </div>
        <div class="field-group">
          <label class="field-label" for="ntDue">Due date</label>
          <input type="date" id="ntDue">
        </div>
      </div>
      <div class="field-group">
        <label class="field-label">Priority</label>
        <div class="priority-picker" id="ntPriority">
          <div class="priority-opt low" data-p="low">Low</div>
          <div class="priority-opt sel medium" data-p="medium">Medium</div>
          <div class="priority-opt high" data-p="high">High</div>
          <div class="priority-opt critical" data-p="critical">Critical</div>
        </div>
      </div>
      <div class="field-group">
        <label class="field-label" for="ntChecklistInput">Checklist items</label>
        <div class="nt-checklist-row">
          <input type="text" id="ntChecklistInput" placeholder="e.g. Get sign-off from client">
          <button type="button" class="nt-add-btn" id="ntChecklistAdd">Add</button>
        </div>
        <div id="ntChecklistList"></div>
      </div>
      <div class="field-group">
        <label class="field-label">Attachments</label>
        <label class="nt-file-btn" for="ntFileInput">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a5 5 0 01-7.07-7.07l9.19-9.19a3.5 3.5 0 014.95 4.95l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
          Add files
        </label>
        <input type="file" id="ntFileInput" multiple style="display:none;">
        <div id="ntAttachmentList" style="margin-top:8px;"></div>
      </div>
      <div class="reassign-error" id="ntError">Please add a title and pick an assignee before creating the task.</div>
    </div>
    <div class="modal-foot">
      <button class="btn-secondary" id="modalCancel">Cancel</button>
      <button class="btn-primary-modal" id="modalCreate">Create task</button>
    </div>
  </div>
</div>

<!-- ================= MANAGE PROJECTS MODAL ================= -->
<div class="modal-overlay" id="projectModalOverlay">
  <div class="modal">
    <div class="modal-head">
      <h2>Manage projects</h2>
      <button class="modal-close" id="projectModalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>
    <div class="modal-body">
      <div class="field-group">
        <label class="field-label" for="pmName" id="pmFormLabel">New project</label>
        <input type="text" id="pmName" placeholder="e.g. Product Launch">
      </div>
      <div class="field-group">
        <label class="field-label">Color</label>
        <div class="swatch-row" id="pmColorPicker"></div>
      </div>
      <div class="reassign-error" id="pmError">Give the project a name before saving.</div>
      <div class="project-form-btns">
        <button class="btn-secondary" id="pmCancelEdit" style="display:none;">Cancel edit</button>
        <button class="btn-primary-modal" id="pmSave">Add project</button>
      </div>

      <hr class="project-divider">

      <div class="field-label" style="margin-bottom:10px;">Existing projects</div>
      <div id="projectManageList"></div>
    </div>
    <div class="modal-foot">
      <button class="btn-primary-modal" id="projectModalDone">Done</button>
    </div>
  </div>
</div>

<!-- ================= NEW / EDIT USER MODAL ================= -->
<div class="modal-overlay" id="userModalOverlay">
  <div class="modal">
    <div class="modal-head">
      <h2 id="umModalTitle">Create user</h2>
      <button class="modal-close" id="userModalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>
    <div class="modal-body">
      <div class="field-group">
        <label class="field-label" for="umName">Full name</label>
        <input type="text" id="umName" placeholder="e.g. Sam Okafor">
      </div>
      <div class="field-group">
        <label class="field-label" for="umEmail">Email address</label>
        <input type="text" id="umEmail" placeholder="e.g. sam@workbench.io">
      </div>
      <div class="field-row2">
        <div class="field-group">
          <label class="field-label" for="umRole">Role</label>
          <select id="umRole">
            <option value="Team Member">Team Member</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Administrator">Administrator</option>
          </select>
        </div>
        <div class="field-group">
          <label class="field-label" for="umDept">Department</label>
          <select id="umDept"></select>
        </div>
      </div>
      <div class="field-group">
        <label class="field-label">Status</label>
        <div class="priority-picker" id="umStatus">
          <div class="priority-opt sel low" data-status="active">Active</div>
          <div class="priority-opt medium" data-status="inactive">Inactive</div>
        </div>
      </div>
      <div class="reassign-error" id="umError">Add a name, valid email, and department before saving.</div>
      <div style="font-size:11.5px;color:var(--ink-faint);margin-top:2px;" id="umInviteHint">An invite email would be sent to this address once created.</div>
    </div>
    <div class="modal-foot">
      <button class="btn-secondary" id="userModalCancel">Cancel</button>
      <button class="btn-primary-modal" id="umSave">Create user</button>
    </div>
  </div>
</div>

<!-- ================= MANAGE DEPARTMENTS MODAL ================= -->
<div class="modal-overlay" id="deptModalOverlay">
  <div class="modal">
    <div class="modal-head">
      <h2>Manage departments</h2>
      <button class="modal-close" id="deptModalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>
    <div class="modal-body">
      <div class="field-group">
        <label class="field-label" for="dmName" id="dmFormLabel">New department</label>
        <input type="text" id="dmName" placeholder="e.g. Customer Success">
      </div>
      <div class="field-group">
        <label class="field-label">Color</label>
        <div class="swatch-row" id="dmColorPicker"></div>
      </div>
      <div class="reassign-error" id="dmError">Give the department a name before saving.</div>
      <div class="project-form-btns">
        <button class="btn-secondary" id="dmCancelEdit" style="display:none;">Cancel edit</button>
        <button class="btn-primary-modal" id="dmSave">Add department</button>
      </div>

      <hr class="project-divider">

      <div class="field-label" style="margin-bottom:10px;">Existing departments</div>
      <div id="deptManageList"></div>
    </div>
    <div class="modal-foot">
      <button class="btn-primary-modal" id="deptModalDone">Done</button>
    </div>
  </div>
</div>

<!-- ================= TASK DETAIL DRAWER ================= -->
<div class="overlay" id="overlay"></div>
<aside class="drawer" id="drawer">
  <div class="drawer-head">
    <button class="drawer-close" id="drawerClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    <div class="drawer-proj" id="dProj">Website Revamp</div>
    <div class="drawer-title" id="dTitle">Redesign the pricing page layout</div>
    <div class="drawer-tags">
      <span class="stamp high" id="dPriority">High</span>
      <span class="status-tag status-progress" id="dStatusTag">In Progress</span>
    </div>
  </div>
  <div class="drawer-body">
    <div class="d-section">
      <div class="d-section-title">Update status</div>
      <div class="status-select-row" id="statusRow">
        <div class="status-opt" data-status="todo">To Do</div>
        <div class="status-opt sel" data-status="progress">In Progress</div>
        <div class="status-opt" data-status="hold">On Hold</div>
        <div class="status-opt" data-status="done">Done</div>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Reassign task</div>
      <div class="assignee-row">Currently with <div class="avatar" id="dAssigneeAvatar">JD</div> <strong id="dAssigneeName">Jamie Diaz</strong></div>
      <label class="field-label" for="reassignSelect">Reassign to</label>
      <select class="reassign-select" id="reassignSelect">
        <option value="">Choose a team member…</option>
      </select>
      <label class="field-label" for="reassignNote">Note (optional)</label>
      <textarea class="reassign-textarea" id="reassignNote" placeholder="e.g. Moving this to Elena since she owns the checkout flow."></textarea>
      <div class="reassign-error" id="reassignError">Pick a team member before reassigning this task.</div>
      <button class="reassign-btn" id="reassignBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 014-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 01-4 4H3"/></svg>
        Reassign task
      </button>
      <div class="reassign-confirm" id="reassignConfirm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
        <span id="reassignConfirmText">Task reassigned.</span>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Description</div>
      <p class="d-desc" id="dDesc">Rework the pricing section to reflect the new three-tier structure. Should match the new type system and include the annual/monthly toggle from the Figma file.</p>
    </div>

    <div class="d-section">
      <div class="d-section-title">Details</div>
      <div class="d-meta-grid">
        <div class="d-meta-item"><div class="k">Created by</div><div class="v" id="dCreatedBy">You</div></div>
        <div class="d-meta-item"><div class="k">Assigned to</div><div class="v" id="dAssignedTo">Jamie Diaz</div></div>
        <div class="d-meta-item"><div class="k">Due date</div><div class="v" id="dDue">Jul 24, 2026</div></div>
        <div class="d-meta-item"><div class="k">Category</div><div class="v">Design</div></div>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title" id="checklistTitle">Checklist — 2 of 4</div>
      <div id="checklistBox">
        <label class="checklist-item checked"><input type="checkbox" checked><span>Review Figma redlines</span></label>
        <label class="checklist-item checked"><input type="checkbox" checked><span>Confirm copy with marketing</span></label>
        <label class="checklist-item"><input type="checkbox"><span>Build responsive breakpoints</span></label>
        <label class="checklist-item"><input type="checkbox"><span>QA on staging</span></label>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Attachments</div>
      <div id="attachmentsBox">
        <div class="attachment"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg><span class="fname">pricing-page-v3.fig</span><span class="fsize">4.2 MB</span></div>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Comments</div>
      <div class="comment">
        <div class="avatar" style="background:linear-gradient(155deg,#3B6FA0,#274F72);">PS</div>
        <div class="comment-body">
          <div class="comment-head"><span class="comment-name">Priya Shah</span><span class="comment-time">2 days ago</span></div>
          <div class="comment-text">Let's use the annual price as the default toggle state.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="comment-input">
    <input type="text" placeholder="Add a comment…">
    <button>Send</button>
  </div>
</aside>

<script>
// ---------------- Mock data (would come from PHP/MySQL via fetch()) ----------------
const CURRENT_USER = "Morgan Reyes";
const COLOR_PALETTE = ["#3B6FA0","#C98A2E","#2F6F5E","#B75B39","#A23B3B","#8A6FB0","#5B6B60","#3A8FA0"];

let nextDeptId = 5;
const DEPARTMENTS = [
  {id:1, name:"Engineering", color:"#3B6FA0"},
  {id:2, name:"Design", color:"#8A6FB0"},
  {id:3, name:"Marketing", color:"#C98A2E"},
  {id:4, name:"Client Services", color:"#2F6F5E"},
];
function deptByName(name){ return DEPARTMENTS.find(d=>d.name===name); }

let nextUserId = 8;
const USERS = [
  {id:1, name:"Morgan Reyes", email:"morgan@workbench.io", role:"Administrator", department:"Engineering", status:"active", initials:"MR", color:"linear-gradient(155deg,#8A6FB0,#5F4A82)"},
  {id:2, name:"Priya Shah", email:"priya@workbench.io", role:"Supervisor", department:"Engineering", status:"active", initials:"PS", color:"linear-gradient(155deg,#3B6FA0,#274F72)"},
  {id:3, name:"Jamie Diaz", email:"jamie@workbench.io", role:"Team Member", department:"Design", status:"active", initials:"JD", color:"linear-gradient(155deg,#C98A2E,#B75B39)"},
  {id:4, name:"Marcus Lin", email:"marcus@workbench.io", role:"Team Member", department:"Engineering", status:"active", initials:"ML", color:"linear-gradient(155deg,#2F6F5E,#1F5647)"},
  {id:5, name:"Elena Cruz", email:"elena@workbench.io", role:"Team Member", department:"Marketing", status:"active", initials:"EC", color:"linear-gradient(155deg,#8A6FB0,#6A4F90)"},
  {id:6, name:"Noah Bennett", email:"noah@workbench.io", role:"Team Member", department:"Client Services", status:"active", initials:"NB", color:"linear-gradient(155deg,#A23B3B,#7E2E2E)"},
  {id:7, name:"Sam Okafor", email:"sam@workbench.io", role:"Supervisor", department:"Marketing", status:"inactive", initials:"SO", color:"linear-gradient(155deg,#3A8FA0,#2A6B78)"},
];
function memberInfo(name){
  const u = USERS.find(x=>x.name===name);
  if(u) return u;
  return {name, initials:name.split(' ').map(w=>w[0]).join(''), color:"var(--ink-soft)"};
}
// Users who can actually be assigned tasks: active, non-administrator accounts
function assignableUsers(){
  return USERS.filter(u=>u.role!=='Administrator' && u.status==='active');
}

let nextProjectId = 4;
const PROJECTS = [
  {id:1, name:"Website Revamp", color:"#3B6FA0"},
  {id:2, name:"Client Onboarding", color:"#C98A2E"},
  {id:3, name:"Q3 Marketing", color:"#2F6F5E"},
];
function projectByName(name){ return PROJECTS.find(p=>p.name===name); }

let nextId = 7;
const TASKS = [
  {id:1, title:"Redesign the pricing page layout", desc:"Rework the pricing section to reflect the new three-tier structure with the annual/monthly toggle.", project:"Website Revamp", priority:"high", status:"progress", due:"Jul 24", overdue:false, dueSoon:true, checklist:[2,4], comments:2, files:1, assignee:"Jamie Diaz",
    checklistItems:[{text:"Review Figma redlines", done:true},{text:"Confirm copy with marketing", done:true},{text:"Build responsive breakpoints", done:false},{text:"QA on staging", done:false}],
    attachments:[{name:"pricing-page-v3.fig", size:"4.2 MB"}]},
  {id:2, title:"Fix broken checkout link on mobile", desc:"Checkout CTA is unresponsive on iOS Safari below 390px width.", project:"Website Revamp", priority:"critical", status:"todo", due:"Jul 22", overdue:true, dueSoon:false, checklist:[0,2], comments:0, files:1, assignee:"Jamie Diaz",
    checklistItems:[{text:"Reproduce on device", done:false},{text:"Patch and deploy fix", done:false}],
    attachments:[{name:"checkout-bug-screenshot.png", size:"850 KB"}]},
  {id:3, title:"Write onboarding welcome email", desc:"Draft the first email in the new-client welcome sequence.", project:"Client Onboarding", priority:"medium", status:"todo", due:"Jul 25", overdue:false, dueSoon:true, checklist:[0,3], comments:1, files:0, assignee:"Marcus Lin",
    checklistItems:[{text:"Draft subject lines", done:false},{text:"Write body copy", done:false},{text:"Get legal sign-off", done:false}],
    attachments:[]},
  {id:4, title:"Prepare Q3 social content calendar", desc:"Map out August–September posts across channels.", project:"Q3 Marketing", priority:"medium", status:"hold", due:"Jul 30", overdue:false, dueSoon:false, checklist:[1,6], comments:3, files:1, assignee:"Elena Cruz",
    checklistItems:[{text:"Pull Q2 performance data", done:true},{text:"Draft Instagram posts", done:false},{text:"Draft LinkedIn posts", done:false},{text:"Draft X posts", done:false},{text:"Schedule in Buffer", done:false},{text:"Get manager sign-off", done:false}],
    attachments:[{name:"q2-performance-report.pdf", size:"1.1 MB"}]},
  {id:5, title:"Tag and organize client asset library", desc:"Standardize folder naming across shared drive.", project:"Client Onboarding", priority:"low", status:"done", due:"Jul 15", overdue:false, dueSoon:false, checklist:[4,4], comments:0, files:0, assignee:"Marcus Lin",
    checklistItems:[{text:"Audit existing folders", done:true},{text:"Define naming convention", done:true},{text:"Rename and re-file assets", done:true},{text:"Share guide with team", done:true}],
    attachments:[]},
  {id:6, title:"User-test new nav on 5 participants", desc:"Run moderated sessions and log findings in Notion.", project:"Website Revamp", priority:"high", status:"progress", due:"Jul 27", overdue:true, dueSoon:false, checklist:[1,5], comments:1, files:0, assignee:"Noah Bennett",
    checklistItems:[{text:"Recruit 5 participants", done:true},{text:"Write test script", done:false},{text:"Run sessions", done:false},{text:"Log findings in Notion", done:false},{text:"Share summary with team", done:false}],
    attachments:[]},
];

const STATUS_LABEL = {todo:"To Do", progress:"In Progress", hold:"On Hold", done:"Completed"};
const STATUS_CLASS = {todo:"status-todo", progress:"status-progress", hold:"status-hold", done:"status-done"};

let activeFilter = "all";
let activeAssignee = "all";

function iconClock(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>'; }
function iconCheck(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>'; }
function iconComment(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>'; }
function iconClip(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a5 5 0 01-7.07-7.07l9.19-9.19a3.5 3.5 0 014.95 4.95l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>'; }

// ---------------- Team workload ----------------
function renderWorkload(){
  const strip = document.getElementById('workloadStrip');
  strip.innerHTML = assignableUsers().map(m=>{
    const mine = TASKS.filter(t=>t.assignee===m.name);
    const active = mine.filter(t=>t.status!=='done').length;
    const overdue = mine.filter(t=>t.overdue).length;
    const done = mine.filter(t=>t.status==='done').length;
    const total = mine.length || 1;
    const pct = Math.round((done/total)*100);
    return `
    <div class="workload-card ${activeAssignee===m.name?'filtered':''}" onclick="toggleAssigneeFilter('${m.name}')">
      <div class="workload-top">
        <div class="avatar" style="background:${m.color}">${m.initials}</div>
        <div><div class="name">${m.name}</div><div class="role">${m.role}</div></div>
      </div>
      <div class="workload-nums"><span>${active} active</span><strong>${pct}% done</strong></div>
      <div class="bar-track"><div class="bar-fill" style="width:${pct}%"></div></div>
      ${overdue ? `<div class="workload-flag">⚠ ${overdue} overdue</div>` : ''}
    </div>`;
  }).join('');
}
function toggleAssigneeFilter(name){
  activeAssignee = (activeAssignee===name) ? 'all' : name;
  document.getElementById('assigneeFilter').value = activeAssignee;
  renderWorkload();
  renderList();
}

// ---------------- List view ----------------
function renderTicket(t){
  const pct = Math.round((t.checklist[0]/t.checklist[1])*100) || 0;
  const info = memberInfo(t.assignee);
  return `
  <div class="ticket" onclick="openDrawer(${t.id})">
    <div class="ticket-stub"><div class="avatar" style="background:${info.color}">${info.initials}</div></div>
    <div class="ticket-body">
      <div class="ticket-top">
        <div>
          <div class="ticket-proj">${t.project}</div>
          <h3 class="ticket-title">${t.title}</h3>
        </div>
        <span class="stamp ${t.priority}">${t.priority}</span>
      </div>
      <p class="ticket-desc">${t.desc}</p>
      <div class="ticket-meta">
        <span class="meta-item assignee">${t.assignee}</span>
        <span class="status-tag ${STATUS_CLASS[t.status]}">${STATUS_LABEL[t.status]}</span>
        <span class="meta-item ${t.overdue?'overdue':(t.dueSoon?'due-soon':'')}">${iconClock()} Due ${t.due}</span>
        <span class="meta-item checklist-progress">${iconCheck()} ${t.checklist[0]}/${t.checklist[1]}
          <span class="mini-bar-track"><span class="mini-bar-fill" style="width:${pct}%"></span></span>
        </span>
        ${t.comments ? `<span class="meta-item">${iconComment()} ${t.comments}</span>` : ''}
        ${t.files ? `<span class="meta-item">${iconClip()} ${t.files}</span>` : ''}
      </div>
    </div>
  </div>`;
}

function renderList(){
  const list = document.getElementById('ticketList');
  const q = document.getElementById('searchInput').value.toLowerCase();
  const filtered = TASKS.filter(t =>
    (activeFilter==='all' || t.status===activeFilter) &&
    (activeAssignee==='all' || t.assignee===activeAssignee) &&
    (t.title.toLowerCase().includes(q) || t.project.toLowerCase().includes(q) || t.assignee.toLowerCase().includes(q))
  );
  list.innerHTML = filtered.length ? filtered.map(renderTicket).join('') :
    `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No tasks match this filter.</div>`;

  document.getElementById('statTotal').textContent = TASKS.filter(t=>t.status!=='done').length;
  document.getElementById('statOverdue').textContent = TASKS.filter(t=>t.overdue).length;
}

document.querySelectorAll('.chip[data-filter]').forEach(c=>{
  c.addEventListener('click', ()=>{
    c.parentElement.querySelectorAll('.chip[data-filter]').forEach(x=>x.classList.remove('active'));
    c.classList.add('active');
    activeFilter = c.dataset.filter;
    renderList();
  });
});
document.getElementById('searchInput').addEventListener('input', ()=>{
  const activeView = document.querySelector('.view-tab.active').dataset.view;
  if(activeView === 'users') renderUserList(); else renderList();
});
document.getElementById('assigneeFilter').addEventListener('change', e=>{
  activeAssignee = e.target.value;
  renderWorkload();
  renderList();
});

// ---------------- View switching ----------------
document.querySelectorAll('.view-tab').forEach(tab=>{
  tab.addEventListener('click', ()=>{
    document.querySelectorAll('.view-tab').forEach(t=>t.classList.remove('active'));
    tab.classList.add('active');
    document.querySelectorAll('.panel').forEach(p=>p.classList.remove('active'));
    document.getElementById('panel-'+tab.dataset.view).classList.add('active');
    updatePrimaryButtonContext(tab.dataset.view);
  });
});
function updatePrimaryButtonContext(view){
  const label = document.getElementById('newTaskBtnLabel');
  const search = document.getElementById('searchInput');
  const searchVal = search.value;
  if(view === 'users'){
    label.textContent = 'New User';
    search.placeholder = 'Search users…';
  } else {
    label.textContent = 'New Task';
    search.placeholder = 'Search tasks…';
  }
  search.value = searchVal;
}

// ---------------- Kanban ----------------
const KCOLS = [
  {key:'todo', label:'To Do'},
  {key:'progress', label:'In Progress'},
  {key:'hold', label:'On Hold'},
  {key:'done', label:'Done'},
];
function renderKanban(){
  const board = document.getElementById('kanbanBoard');
  board.innerHTML = KCOLS.map(col=>{
    const items = TASKS.filter(t=>t.status===col.key);
    return `
    <div class="kcol" data-col="${col.key}">
      <div class="kcol-head"><span class="kcol-title">${col.label}</span><span class="kcol-count">${items.length}</span></div>
      ${items.map(t=>{
        const idx = KCOLS.findIndex(c=>c.key===t.status);
        const info = memberInfo(t.assignee);
        return `
        <div class="kcard" draggable="true" data-id="${t.id}">
          <div onclick="openDrawer(${t.id})">
            <div class="kcard-top"><span class="stamp ${t.priority}">${t.priority}</span></div>
            <div class="kcard-proj">${t.project}</div>
            <div class="kcard-title">${t.title}</div>
            <div class="kcard-assignee"><div class="avatar" style="background:${info.color}">${info.initials}</div><span>${t.assignee}</span></div>
            <div class="kcard-foot">
              <span class="kcard-due">${t.overdue?'⚠ ':''}Due ${t.due}</span>
              <span style="font-size:10.5px;color:var(--ink-faint);">${t.checklist[0]}/${t.checklist[1]}</span>
            </div>
          </div>
          <div class="kcard-move">
            <button onclick="event.stopPropagation();moveCard(${t.id},-1)" ${idx===0?'disabled':''} aria-label="Move to previous column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button onclick="event.stopPropagation();moveCard(${t.id},1)" ${idx===KCOLS.length-1?'disabled':''} aria-label="Move to next column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
          </div>
        </div>`;}).join('')}
    </div>`;
  }).join('');
  attachDragEvents();
}

function attachDragEvents(){
  document.querySelectorAll('.kcard').forEach(card=>{
    card.addEventListener('dragstart', e=>{
      e.dataTransfer.setData('text/plain', card.dataset.id);
      setTimeout(()=>card.classList.add('drag-ghost'),0);
    });
    card.addEventListener('dragend', ()=>card.classList.remove('drag-ghost'));
  });
  document.querySelectorAll('.kcol').forEach(col=>{
    col.addEventListener('dragover', e=>{ e.preventDefault(); col.classList.add('drop-hover'); });
    col.addEventListener('dragleave', ()=>col.classList.remove('drop-hover'));
    col.addEventListener('drop', e=>{
      e.preventDefault();
      col.classList.remove('drop-hover');
      const id = parseInt(e.dataTransfer.getData('text/plain'));
      const task = TASKS.find(t=>t.id===id);
      if(task){ task.status = col.dataset.col; renderKanban(); renderList(); }
    });
  });
}
function moveCard(id, dir){
  const task = TASKS.find(t=>t.id===id);
  if(!task) return;
  const idx = KCOLS.findIndex(c=>c.key===task.status);
  const next = idx + dir;
  if(next < 0 || next >= KCOLS.length) return;
  task.status = KCOLS[next].key;
  renderKanban();
  renderList();
}

// ---------------- Mobile off-canvas sidebar ----------------
const sidebarEl = document.querySelector('.sidebar');
const sidebarOverlayEl = document.getElementById('sidebarOverlay');
function openSidebar(){ sidebarEl.classList.add('mobile-open'); sidebarOverlayEl.classList.add('open'); }
function closeSidebar(){ sidebarEl.classList.remove('mobile-open'); sidebarOverlayEl.classList.remove('open'); }
document.getElementById('hamburgerBtn').addEventListener('click', openSidebar);
sidebarOverlayEl.addEventListener('click', closeSidebar);
document.querySelectorAll('.sidebar .nav-item').forEach(item=>item.addEventListener('click', closeSidebar));

// ---------------- Drawer ----------------
let currentDrawerTaskId = null;

function renderDrawerChecklist(t){
  document.getElementById('checklistTitle').textContent = `Checklist — ${t.checklist[0]} of ${t.checklist[1]}`;
  const box = document.getElementById('checklistBox');
  if(!t.checklistItems || !t.checklistItems.length){
    box.innerHTML = `<div class="nt-empty-hint">No checklist items yet.</div>`;
    return;
  }
  box.innerHTML = t.checklistItems.map((item, i)=>`
    <label class="checklist-item ${item.done?'checked':''}">
      <input type="checkbox" data-idx="${i}" ${item.done?'checked':''}><span>${item.text}</span>
    </label>`).join('');
}
function renderDrawerAttachments(t){
  const box = document.getElementById('attachmentsBox');
  if(!t.attachments || !t.attachments.length){
    box.innerHTML = `<div class="nt-empty-hint">No files attached.</div>`;
    return;
  }
  box.innerHTML = t.attachments.map(a=>`
    <div class="attachment"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg><span class="fname">${a.name}</span><span class="fsize">${a.size}</span></div>`).join('');
}

function openDrawer(id){
  currentDrawerTaskId = id;
  const t = TASKS.find(x=>x.id===id) || TASKS[0];
  document.getElementById('dProj').textContent = t.project;
  document.getElementById('dTitle').textContent = t.title;
  document.getElementById('dDesc').textContent = t.desc;
  document.getElementById('dDue').textContent = 'Due ' + t.due + ', 2026';
  const pEl = document.getElementById('dPriority');
  pEl.textContent = t.priority;
  pEl.className = 'stamp ' + t.priority;
  const sEl = document.getElementById('dStatusTag');
  sEl.textContent = STATUS_LABEL[t.status];
  sEl.className = 'status-tag ' + STATUS_CLASS[t.status];
  document.querySelectorAll('.status-opt').forEach(o=>{
    o.classList.toggle('sel', o.dataset.status===t.status);
  });
  renderDrawerChecklist(t);
  renderDrawerAttachments(t);

  document.getElementById('dAssignedTo').textContent = t.assignee;
  const info = memberInfo(t.assignee);
  const avatarEl = document.getElementById('dAssigneeAvatar');
  avatarEl.textContent = info.initials;
  avatarEl.style.background = info.color;
  document.getElementById('dAssigneeName').textContent = t.assignee;

  const select = document.getElementById('reassignSelect');
  select.innerHTML = '<option value="">Choose a team member…</option>' +
    assignableUsers().filter(m=>m.name!==t.assignee).map(m=>`<option value="${m.name}">${m.name}</option>`).join('');
  document.getElementById('reassignNote').value = '';
  document.getElementById('reassignError').classList.remove('show');
  document.getElementById('reassignConfirm').classList.remove('show');

  document.getElementById('overlay').classList.add('open');
  document.getElementById('drawer').classList.add('open');
}
function closeDrawer(){
  document.getElementById('overlay').classList.remove('open');
  document.getElementById('drawer').classList.remove('open');
}
document.getElementById('drawerClose').addEventListener('click', closeDrawer);
document.getElementById('overlay').addEventListener('click', closeDrawer);

document.querySelectorAll('.status-opt').forEach(opt=>{
  opt.addEventListener('click', ()=>{
    document.querySelectorAll('.status-opt').forEach(o=>o.classList.remove('sel'));
    opt.classList.add('sel');
    const t = TASKS.find(x=>x.id===currentDrawerTaskId);
    if(t){
      t.status = opt.dataset.status;
      t.overdue = false;
    }
    const sEl = document.getElementById('dStatusTag');
    sEl.textContent = opt.textContent;
    sEl.className = 'status-tag ' + STATUS_CLASS[opt.dataset.status];
    renderList();
    renderKanban();
    renderWorkload();
  });
});

// Checklist checkboxes are re-rendered per task, so use delegation rather than binding once
document.getElementById('checklistBox').addEventListener('change', e=>{
  const cb = e.target.closest('input[type=checkbox]');
  if(!cb) return;
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t || !t.checklistItems) return;
  const idx = parseInt(cb.dataset.idx);
  t.checklistItems[idx].done = cb.checked;
  t.checklist = [t.checklistItems.filter(i=>i.done).length, t.checklistItems.length];
  cb.closest('.checklist-item').classList.toggle('checked', cb.checked);
  document.getElementById('checklistTitle').textContent = `Checklist — ${t.checklist[0]} of ${t.checklist[1]}`;
  renderList();
  renderKanban();
});

// ---------------- Reassign task (supervisor) ----------------
function reassignTask(){
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t) return;
  const select = document.getElementById('reassignSelect');
  const noteEl = document.getElementById('reassignNote');
  const errorEl = document.getElementById('reassignError');
  const newAssignee = select.value;

  if(!newAssignee){
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const previousAssignee = t.assignee;
  t.assignee = newAssignee;
  t.reassignHistory = t.reassignHistory || [];
  t.reassignHistory.push({from:previousAssignee, to:newAssignee, note:noteEl.value.trim(), by:CURRENT_USER, when:'Just now'});
  t.comments = (t.comments || 0) + 1;

  document.getElementById('dAssignedTo').textContent = t.assignee;
  const info = memberInfo(t.assignee);
  const avatarEl = document.getElementById('dAssigneeAvatar');
  avatarEl.textContent = info.initials;
  avatarEl.style.background = info.color;
  document.getElementById('dAssigneeName').textContent = t.assignee;

  select.innerHTML = '<option value="">Choose a team member…</option>' +
    assignableUsers().filter(m=>m.name!==t.assignee).map(m=>`<option value="${m.name}">${m.name}</option>`).join('');
  noteEl.value = '';

  const confirmEl = document.getElementById('reassignConfirm');
  document.getElementById('reassignConfirmText').textContent = `Reassigned to ${newAssignee}.`;
  confirmEl.classList.add('show');

  renderList();
  renderKanban();
  renderWorkload();
}
document.getElementById('reassignBtn').addEventListener('click', reassignTask);
document.getElementById('reassignSelect').addEventListener('change', ()=>document.getElementById('reassignError').classList.remove('show'));

// ---------------- New task modal ----------------
const modalOverlay = document.getElementById('modalOverlay');
let ntChecklistItems = [];
let ntAttachments = [];

function formatFileSize(bytes){
  if(bytes < 1024) return bytes + ' B';
  if(bytes < 1024*1024) return Math.round(bytes/1024) + ' KB';
  return (bytes/(1024*1024)).toFixed(1) + ' MB';
}

function renderNtChecklist(){
  const box = document.getElementById('ntChecklistList');
  if(!ntChecklistItems.length){
    box.innerHTML = `<div class="nt-empty-hint">No items yet — add the steps this task needs.</div>`;
    return;
  }
  box.innerHTML = ntChecklistItems.map((text, i)=>`
    <div class="nt-list-item">
      <span>${text}</span>
      <button type="button" data-remove-checklist="${i}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>`).join('');
}

function renderNtAttachments(){
  const box = document.getElementById('ntAttachmentList');
  if(!ntAttachments.length){
    box.innerHTML = `<div class="nt-empty-hint">No files added yet.</div>`;
    return;
  }
  box.innerHTML = ntAttachments.map((f, i)=>`
    <div class="nt-list-item">
      <span>${f.name}</span>
      <span class="fsize">${f.size}</span>
      <button type="button" data-remove-attachment="${i}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>`).join('');
}

function addNtChecklistItem(){
  const input = document.getElementById('ntChecklistInput');
  const text = input.value.trim();
  if(!text) return;
  ntChecklistItems.push(text);
  input.value = '';
  renderNtChecklist();
  input.focus();
}
document.getElementById('ntChecklistAdd').addEventListener('click', addNtChecklistItem);
document.getElementById('ntChecklistInput').addEventListener('keydown', e=>{
  if(e.key==='Enter'){ e.preventDefault(); addNtChecklistItem(); }
});
document.getElementById('ntChecklistList').addEventListener('click', e=>{
  const btn = e.target.closest('[data-remove-checklist]');
  if(!btn) return;
  ntChecklistItems.splice(parseInt(btn.dataset.removeChecklist), 1);
  renderNtChecklist();
});

document.getElementById('ntFileInput').addEventListener('change', e=>{
  Array.from(e.target.files).forEach(f=>{
    ntAttachments.push({name:f.name, size:formatFileSize(f.size)});
  });
  e.target.value = ''; // allow re-selecting the same file later
  renderNtAttachments();
});
document.getElementById('ntAttachmentList').addEventListener('click', e=>{
  const btn = e.target.closest('[data-remove-attachment]');
  if(!btn) return;
  ntAttachments.splice(parseInt(btn.dataset.removeAttachment), 1);
  renderNtAttachments();
});

function openModal(){
  document.getElementById('ntTitle').value = '';
  document.getElementById('ntDesc').value = '';
  populateNtProjectOptions();
  document.getElementById('ntStart').value = '';
  document.getElementById('ntDue').value = '';
  document.getElementById('ntError').classList.remove('show');
  document.querySelectorAll('.priority-opt').forEach(o=>o.classList.toggle('sel', o.dataset.p==='medium'));

  const assigneeSelect = document.getElementById('ntAssignee');
  assigneeSelect.innerHTML = assignableUsers().map(m=>`<option value="${m.name}">${m.name}</option>`).join('');

  ntChecklistItems = [];
  ntAttachments = [];
  renderNtChecklist();
  renderNtAttachments();

  modalOverlay.classList.add('open');
}
function closeModal(){ modalOverlay.classList.remove('open'); }
document.getElementById('newTaskBtn').addEventListener('click', ()=>{
  const activeView = document.querySelector('.view-tab.active').dataset.view;
  if(activeView === 'users') openUserModal(); else openModal();
});
document.getElementById('newUserBtnInline').addEventListener('click', ()=>openUserModal());
document.getElementById('modalClose').addEventListener('click', closeModal);
document.getElementById('modalCancel').addEventListener('click', closeModal);
modalOverlay.addEventListener('click', e=>{ if(e.target===modalOverlay) closeModal(); });

document.querySelectorAll('.priority-opt').forEach(opt=>{
  opt.addEventListener('click', ()=>{
    document.querySelectorAll('.priority-opt').forEach(o=>o.classList.remove('sel'));
    opt.classList.add('sel');
  });
});

document.getElementById('modalCreate').addEventListener('click', ()=>{
  const title = document.getElementById('ntTitle').value.trim();
  const assignee = document.getElementById('ntAssignee').value;
  const errorEl = document.getElementById('ntError');
  if(!title || !assignee){
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const desc = document.getElementById('ntDesc').value.trim() || 'No description provided.';
  const project = document.getElementById('ntProject').value;
  const priority = document.querySelector('.priority-opt.sel').dataset.p;
  const dueRaw = document.getElementById('ntDue').value;
  const dueLabel = dueRaw ? new Date(dueRaw+'T00:00:00').toLocaleDateString('en-US',{month:'short', day:'numeric'}) : 'Not set';

  const checklistItems = ntChecklistItems.map(text=>({text, done:false}));
  const attachments = ntAttachments.slice();

  TASKS.unshift({
    id: nextId++, title, desc, project, priority, status:'todo',
    due: dueLabel, overdue:false, dueSoon:false,
    checklist:[0, checklistItems.length], checklistItems,
    comments:0, files:attachments.length, attachments,
    assignee
  });

  closeModal();
  renderList();
  renderKanban();
  renderWorkload();
});

// ---------------- Projects (create / edit / delete) ----------------
const projectModalOverlay = document.getElementById('projectModalOverlay');
let pmEditingId = null;
let pmSelectedColor = COLOR_PALETTE[0];
let pmDeleteConfirmId = null;

function renderProjectNav(){
  const nav = document.getElementById('projectNavList');
  nav.innerHTML = PROJECTS.length ? PROJECTS.map(p=>`
    <a class="nav-item"><span style="width:8px;height:8px;border-radius:2px;background:${p.color};display:inline-block;"></span>${p.name}</a>
  `).join('') : `<div style="padding:6px 10px;font-size:11.5px;color:#7C8B80;">No projects yet.</div>`;
}

function refreshProjectDependents(){
  renderProjectNav();
  renderList();
  renderKanban();
}

function renderColorSwatches(){
  const row = document.getElementById('pmColorPicker');
  row.innerHTML = COLOR_PALETTE.map(c=>`
    <button type="button" class="swatch ${c===pmSelectedColor?'sel':''}" style="background:${c};" data-color="${c}"></button>
  `).join('');
}
document.getElementById('pmColorPicker').addEventListener('click', e=>{
  const btn = e.target.closest('.swatch');
  if(!btn) return;
  pmSelectedColor = btn.dataset.color;
  renderColorSwatches();
});

function renderProjectManageList(){
  const list = document.getElementById('projectManageList');
  if(!PROJECTS.length){
    list.innerHTML = `<div class="project-empty">No projects yet — add one above.</div>`;
    return;
  }
  list.innerHTML = PROJECTS.map(p=>{
    const count = TASKS.filter(t=>t.project===p.name).length;
    if(pmDeleteConfirmId === p.id){
      return `
      <div class="project-row">
        <div class="project-delete-row">
          Delete "${p.name}"? ${count ? `${count} task${count===1?'':'s'} will move to "No Project."` : ''}
          <button type="button" class="project-delete-confirm-btn" data-confirm-delete="${p.id}">Delete</button>
          <button type="button" class="project-delete-cancel-btn" data-cancel-delete="${p.id}">Cancel</button>
        </div>
      </div>`;
    }
    return `
    <div class="project-row">
      <span class="project-dot" style="background:${p.color};"></span>
      <span class="project-row-name">${p.name}</span>
      <span class="project-row-count">${count} task${count===1?'':'s'}</span>
      <div class="project-row-actions">
        <button type="button" class="project-icon-btn" data-edit="${p.id}" aria-label="Edit project"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5z"/></svg></button>
        <button type="button" class="project-icon-btn danger" data-delete="${p.id}" aria-label="Delete project"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg></button>
      </div>
    </div>`;
  }).join('');
}

document.getElementById('projectManageList').addEventListener('click', e=>{
  const editBtn = e.target.closest('[data-edit]');
  const delBtn = e.target.closest('[data-delete]');
  const confirmBtn = e.target.closest('[data-confirm-delete]');
  const cancelBtn = e.target.closest('[data-cancel-delete]');

  if(editBtn){
    const p = PROJECTS.find(x=>x.id===parseInt(editBtn.dataset.edit));
    if(!p) return;
    pmEditingId = p.id;
    pmSelectedColor = p.color;
    document.getElementById('pmName').value = p.name;
    document.getElementById('pmFormLabel').textContent = 'Edit project';
    document.getElementById('pmSave').textContent = 'Save changes';
    document.getElementById('pmCancelEdit').style.display = 'inline-flex';
    document.getElementById('pmError').classList.remove('show');
    renderColorSwatches();
    document.getElementById('pmName').focus();
  }
  if(delBtn){
    pmDeleteConfirmId = parseInt(delBtn.dataset.delete);
    renderProjectManageList();
  }
  if(cancelBtn){
    pmDeleteConfirmId = null;
    renderProjectManageList();
  }
  if(confirmBtn){
    const id = parseInt(confirmBtn.dataset.confirmDelete);
    const p = PROJECTS.find(x=>x.id===id);
    if(p){
      TASKS.forEach(t=>{ if(t.project===p.name) t.project = 'No Project'; });
      const idx = PROJECTS.findIndex(x=>x.id===id);
      PROJECTS.splice(idx,1);
    }
    pmDeleteConfirmId = null;
    if(pmEditingId===id) resetProjectForm();
    renderProjectManageList();
    refreshProjectDependents();
  }
});

function resetProjectForm(){
  pmEditingId = null;
  pmSelectedColor = COLOR_PALETTE[0];
  document.getElementById('pmName').value = '';
  document.getElementById('pmFormLabel').textContent = 'New project';
  document.getElementById('pmSave').textContent = 'Add project';
  document.getElementById('pmCancelEdit').style.display = 'none';
  document.getElementById('pmError').classList.remove('show');
  renderColorSwatches();
}
document.getElementById('pmCancelEdit').addEventListener('click', resetProjectForm);

document.getElementById('pmSave').addEventListener('click', ()=>{
  const name = document.getElementById('pmName').value.trim();
  const errorEl = document.getElementById('pmError');
  if(!name){
    errorEl.textContent = 'Give the project a name before saving.';
    errorEl.classList.add('show');
    return;
  }
  const dup = PROJECTS.find(p=>p.name.toLowerCase()===name.toLowerCase() && p.id!==pmEditingId);
  if(dup){
    errorEl.textContent = 'A project with that name already exists.';
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  if(pmEditingId){
    const p = PROJECTS.find(x=>x.id===pmEditingId);
    const oldName = p.name;
    p.name = name;
    p.color = pmSelectedColor;
    TASKS.forEach(t=>{ if(t.project===oldName) t.project = name; });
  } else {
    PROJECTS.push({id: nextProjectId++, name, color: pmSelectedColor});
  }
  resetProjectForm();
  renderProjectManageList();
  refreshProjectDependents();
});

function openProjectModal(){
  pmDeleteConfirmId = null;
  resetProjectForm();
  renderProjectManageList();
  projectModalOverlay.classList.add('open');
}
function closeProjectModal(){
  projectModalOverlay.classList.remove('open');
  // keep the New Task project dropdown in sync with any adds/edits/deletes made here
  populateNtProjectOptions();
}
document.getElementById('manageProjectsBtn').addEventListener('click', ()=>{ closeSidebar(); openProjectModal(); });
document.getElementById('projectModalClose').addEventListener('click', closeProjectModal);
document.getElementById('projectModalDone').addEventListener('click', closeProjectModal);
projectModalOverlay.addEventListener('click', e=>{ if(e.target===projectModalOverlay) closeProjectModal(); });

function populateNtProjectOptions(){
  const sel = document.getElementById('ntProject');
  if(!sel) return;
  const current = sel.value;
  sel.innerHTML = PROJECTS.map(p=>`<option value="${p.name}">${p.name}</option>`).join('');
  if(PROJECTS.some(p=>p.name===current)) sel.value = current;
}

// ---------------- Departments (create / edit / delete) ----------------
const deptModalOverlay = document.getElementById('deptModalOverlay');
let dmEditingId = null;
let dmSelectedColor = COLOR_PALETTE[0];
let dmDeleteConfirmId = null;

function renderDeptNav(){
  const nav = document.getElementById('deptNavList');
  nav.innerHTML = DEPARTMENTS.length ? DEPARTMENTS.map(d=>`
    <a class="nav-item"><span style="width:8px;height:8px;border-radius:2px;background:${d.color};display:inline-block;"></span>${d.name}</a>
  `).join('') : `<div style="padding:6px 10px;font-size:11.5px;color:#7C8B80;">No departments yet.</div>`;
}

function renderDeptColorSwatches(){
  const row = document.getElementById('dmColorPicker');
  row.innerHTML = COLOR_PALETTE.map(c=>`
    <button type="button" class="swatch ${c===dmSelectedColor?'sel':''}" style="background:${c};" data-color="${c}"></button>
  `).join('');
}
document.getElementById('dmColorPicker').addEventListener('click', e=>{
  const btn = e.target.closest('.swatch');
  if(!btn) return;
  dmSelectedColor = btn.dataset.color;
  renderDeptColorSwatches();
});

function renderDeptManageList(){
  const list = document.getElementById('deptManageList');
  if(!DEPARTMENTS.length){
    list.innerHTML = `<div class="project-empty">No departments yet — add one above.</div>`;
    return;
  }
  list.innerHTML = DEPARTMENTS.map(d=>{
    const count = USERS.filter(u=>u.department===d.name).length;
    if(dmDeleteConfirmId === d.id){
      return `
      <div class="project-row">
        <div class="project-delete-row">
          Delete "${d.name}"? ${count ? `${count} user${count===1?'':'s'} will move to "Unassigned."` : ''}
          <button type="button" class="project-delete-confirm-btn" data-confirm-delete-dept="${d.id}">Delete</button>
          <button type="button" class="project-delete-cancel-btn" data-cancel-delete-dept="${d.id}">Cancel</button>
        </div>
      </div>`;
    }
    return `
    <div class="project-row">
      <span class="project-dot" style="background:${d.color};"></span>
      <span class="project-row-name">${d.name}</span>
      <span class="project-row-count">${count} user${count===1?'':'s'}</span>
      <div class="project-row-actions">
        <button type="button" class="project-icon-btn" data-edit-dept="${d.id}" aria-label="Edit department"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5z"/></svg></button>
        <button type="button" class="project-icon-btn danger" data-delete-dept="${d.id}" aria-label="Delete department"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg></button>
      </div>
    </div>`;
  }).join('');
}

document.getElementById('deptManageList').addEventListener('click', e=>{
  const editBtn = e.target.closest('[data-edit-dept]');
  const delBtn = e.target.closest('[data-delete-dept]');
  const confirmBtn = e.target.closest('[data-confirm-delete-dept]');
  const cancelBtn = e.target.closest('[data-cancel-delete-dept]');

  if(editBtn){
    const d = DEPARTMENTS.find(x=>x.id===parseInt(editBtn.dataset.editDept));
    if(!d) return;
    dmEditingId = d.id;
    dmSelectedColor = d.color;
    document.getElementById('dmName').value = d.name;
    document.getElementById('dmFormLabel').textContent = 'Edit department';
    document.getElementById('dmSave').textContent = 'Save changes';
    document.getElementById('dmCancelEdit').style.display = 'inline-flex';
    document.getElementById('dmError').classList.remove('show');
    renderDeptColorSwatches();
    document.getElementById('dmName').focus();
  }
  if(delBtn){
    dmDeleteConfirmId = parseInt(delBtn.dataset.deleteDept);
    renderDeptManageList();
  }
  if(cancelBtn){
    dmDeleteConfirmId = null;
    renderDeptManageList();
  }
  if(confirmBtn){
    const id = parseInt(confirmBtn.dataset.confirmDeleteDept);
    const d = DEPARTMENTS.find(x=>x.id===id);
    if(d){
      USERS.forEach(u=>{ if(u.department===d.name) u.department = 'Unassigned'; });
      const idx = DEPARTMENTS.findIndex(x=>x.id===id);
      DEPARTMENTS.splice(idx,1);
    }
    dmDeleteConfirmId = null;
    if(dmEditingId===id) resetDeptForm();
    renderDeptManageList();
    refreshDeptDependents();
  }
});

function resetDeptForm(){
  dmEditingId = null;
  dmSelectedColor = COLOR_PALETTE[0];
  document.getElementById('dmName').value = '';
  document.getElementById('dmFormLabel').textContent = 'New department';
  document.getElementById('dmSave').textContent = 'Add department';
  document.getElementById('dmCancelEdit').style.display = 'none';
  document.getElementById('dmError').classList.remove('show');
  renderDeptColorSwatches();
}
document.getElementById('dmCancelEdit').addEventListener('click', resetDeptForm);

document.getElementById('dmSave').addEventListener('click', ()=>{
  const name = document.getElementById('dmName').value.trim();
  const errorEl = document.getElementById('dmError');
  if(!name){
    errorEl.textContent = 'Give the department a name before saving.';
    errorEl.classList.add('show');
    return;
  }
  const dup = DEPARTMENTS.find(d=>d.name.toLowerCase()===name.toLowerCase() && d.id!==dmEditingId);
  if(dup){
    errorEl.textContent = 'A department with that name already exists.';
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  if(dmEditingId){
    const d = DEPARTMENTS.find(x=>x.id===dmEditingId);
    const oldName = d.name;
    d.name = name;
    d.color = dmSelectedColor;
    USERS.forEach(u=>{ if(u.department===oldName) u.department = name; });
  } else {
    DEPARTMENTS.push({id: nextDeptId++, name, color: dmSelectedColor});
  }
  resetDeptForm();
  renderDeptManageList();
  refreshDeptDependents();
});

function refreshDeptDependents(){
  renderDeptNav();
  populateDeptFilterOptions();
  populateUmDeptOptions();
  renderUserList();
  updateAdminStats();
}

function openDeptModal(){
  dmDeleteConfirmId = null;
  resetDeptForm();
  renderDeptManageList();
  deptModalOverlay.classList.add('open');
}
function closeDeptModal(){
  deptModalOverlay.classList.remove('open');
  populateUmDeptOptions();
}
document.getElementById('manageDeptsBtn').addEventListener('click', ()=>{ closeSidebar(); openDeptModal(); });
document.getElementById('deptModalClose').addEventListener('click', closeDeptModal);
document.getElementById('deptModalDone').addEventListener('click', closeDeptModal);
deptModalOverlay.addEventListener('click', e=>{ if(e.target===deptModalOverlay) closeDeptModal(); });

function populateDeptFilterOptions(){
  const sel = document.getElementById('deptFilter');
  const current = sel.value;
  sel.innerHTML = '<option value="all">All departments</option>' +
    DEPARTMENTS.map(d=>`<option value="${d.name}">${d.name}</option>`).join('');
  if(current && (current==='all' || DEPARTMENTS.some(d=>d.name===current))) sel.value = current;
}
function populateUmDeptOptions(){
  const sel = document.getElementById('umDept');
  const current = sel.value;
  sel.innerHTML = DEPARTMENTS.map(d=>`<option value="${d.name}">${d.name}</option>`).join('');
  if(DEPARTMENTS.some(d=>d.name===current)) sel.value = current;
}

// ---------------- Users (create / edit / delete / assign department) ----------------
const userModalOverlay = document.getElementById('userModalOverlay');
let umEditingId = null;
let umSelectedStatus = 'active';
let activeRoleFilter = 'all';
let activeDeptFilter = 'all';
let userDeleteConfirmId = null;

function roleBadgeClass(role){
  if(role==='Administrator') return 'role-admin';
  if(role==='Supervisor') return 'role-supervisor';
  return 'role-member';
}

function renderUserList(){
  const list = document.getElementById('userList');
  const q = document.getElementById('searchInput').value.toLowerCase();
  const filtered = USERS.filter(u=>
    (activeRoleFilter==='all' || u.role===activeRoleFilter) &&
    (activeDeptFilter==='all' || u.department===activeDeptFilter) &&
    (u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q) || u.department.toLowerCase().includes(q))
  );

  if(!filtered.length){
    list.innerHTML = `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No users match this filter.</div>`;
    return;
  }

  list.innerHTML = filtered.map(u=>{
    const dept = deptByName(u.department);
    if(userDeleteConfirmId === u.id){
      const taskCount = TASKS.filter(t=>t.assignee===u.name).length;
      return `
      <div class="user-row">
        <div class="user-delete-wrap">
          <div class="project-delete-row">
            Delete "${u.name}"? ${taskCount ? `${taskCount} task${taskCount===1?'':'s'} will move to "Unassigned."` : 'This account will be permanently removed.'}
            <button type="button" class="project-delete-confirm-btn" data-confirm-delete-user="${u.id}">Delete</button>
            <button type="button" class="project-delete-cancel-btn" data-cancel-delete-user="${u.id}">Cancel</button>
          </div>
        </div>
      </div>`;
    }
    return `
    <div class="user-row">
      <div class="avatar" style="background:${u.color}">${u.initials}</div>
      <div class="user-info">
        <div class="user-name-row">
          <span class="user-name">${u.name}</span>
          <span class="role-badge ${roleBadgeClass(u.role)}">${u.role}</span>
        </div>
        <div class="user-email">${u.email}</div>
        <div class="user-meta-row">
          <span class="dept-tag"><span class="dot" style="background:${dept?dept.color:'var(--ink-faint)'}"></span>${u.department}</span>
          <span class="user-status ${u.status==='inactive'?'inactive':''}"><span class="dot"></span>${u.status==='active'?'Active':'Inactive'}</span>
        </div>
      </div>
      <div class="user-actions">
        <button type="button" class="project-icon-btn" data-edit-user="${u.id}" aria-label="Edit user"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5z"/></svg></button>
        <button type="button" class="project-icon-btn danger" data-delete-user="${u.id}" aria-label="Delete user"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg></button>
      </div>
    </div>`;
  }).join('');
}

document.querySelectorAll('.chip[data-role-filter]').forEach(c=>{
  c.addEventListener('click', ()=>{
    c.parentElement.querySelectorAll('.chip[data-role-filter]').forEach(x=>x.classList.remove('active'));
    c.classList.add('active');
    activeRoleFilter = c.dataset.roleFilter;
    renderUserList();
  });
});
document.getElementById('deptFilter').addEventListener('change', e=>{
  activeDeptFilter = e.target.value;
  renderUserList();
});

document.getElementById('userList').addEventListener('click', e=>{
  const editBtn = e.target.closest('[data-edit-user]');
  const delBtn = e.target.closest('[data-delete-user]');
  const confirmBtn = e.target.closest('[data-confirm-delete-user]');
  const cancelBtn = e.target.closest('[data-cancel-delete-user]');

  if(editBtn) openUserModal(parseInt(editBtn.dataset.editUser));
  if(delBtn){
    userDeleteConfirmId = parseInt(delBtn.dataset.deleteUser);
    renderUserList();
  }
  if(cancelBtn){
    userDeleteConfirmId = null;
    renderUserList();
  }
  if(confirmBtn){
    const id = parseInt(confirmBtn.dataset.confirmDeleteUser);
    const u = USERS.find(x=>x.id===id);
    if(u){
      TASKS.forEach(t=>{ if(t.assignee===u.name) t.assignee = 'Unassigned'; });
      const idx = USERS.findIndex(x=>x.id===id);
      USERS.splice(idx,1);
    }
    userDeleteConfirmId = null;
    renderUserList();
    renderWorkload();
    renderList();
    renderKanban();
    updateAdminStats();
  }
});

document.querySelectorAll('#umStatus .priority-opt').forEach(opt=>{
  opt.addEventListener('click', ()=>{
    document.querySelectorAll('#umStatus .priority-opt').forEach(o=>o.classList.remove('sel'));
    opt.classList.add('sel');
    umSelectedStatus = opt.dataset.status;
  });
});

function openUserModal(editId){
  umEditingId = editId || null;
  populateUmDeptOptions();
  document.getElementById('umError').classList.remove('show');

  if(umEditingId){
    const u = USERS.find(x=>x.id===umEditingId);
    document.getElementById('umModalTitle').textContent = 'Edit user';
    document.getElementById('umSave').textContent = 'Save changes';
    document.getElementById('umInviteHint').style.display = 'none';
    document.getElementById('umName').value = u.name;
    document.getElementById('umEmail').value = u.email;
    document.getElementById('umRole').value = u.role;
    document.getElementById('umDept').value = u.department;
    umSelectedStatus = u.status;
  } else {
    document.getElementById('umModalTitle').textContent = 'Create user';
    document.getElementById('umSave').textContent = 'Create user';
    document.getElementById('umInviteHint').style.display = 'block';
    document.getElementById('umName').value = '';
    document.getElementById('umEmail').value = '';
    document.getElementById('umRole').value = 'Team Member';
    umSelectedStatus = 'active';
  }
  document.querySelectorAll('#umStatus .priority-opt').forEach(o=>o.classList.toggle('sel', o.dataset.status===umSelectedStatus));

  userModalOverlay.classList.add('open');
}
function closeUserModal(){ userModalOverlay.classList.remove('open'); }
document.getElementById('userModalClose').addEventListener('click', closeUserModal);
document.getElementById('userModalCancel').addEventListener('click', closeUserModal);
userModalOverlay.addEventListener('click', e=>{ if(e.target===userModalOverlay) closeUserModal(); });

document.getElementById('umSave').addEventListener('click', ()=>{
  const name = document.getElementById('umName').value.trim();
  const email = document.getElementById('umEmail').value.trim();
  const role = document.getElementById('umRole').value;
  const department = document.getElementById('umDept').value;
  const errorEl = document.getElementById('umError');
  const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  if(!name || !emailValid || !department){
    errorEl.textContent = !name ? 'Add a name before saving.' : (!emailValid ? 'Enter a valid email address.' : 'Choose a department.');
    errorEl.classList.add('show');
    return;
  }
  const dupEmail = USERS.find(u=>u.email.toLowerCase()===email.toLowerCase() && u.id!==umEditingId);
  if(dupEmail){
    errorEl.textContent = 'A user with that email already exists.';
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  if(umEditingId){
    const u = USERS.find(x=>x.id===umEditingId);
    const oldName = u.name;
    u.name = name; u.email = email; u.role = role; u.department = department; u.status = umSelectedStatus;
    u.initials = name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
    if(oldName !== name){
      TASKS.forEach(t=>{ if(t.assignee===oldName) t.assignee = name; });
    }
  } else {
    const palette = ["linear-gradient(155deg,#3B6FA0,#274F72)","linear-gradient(155deg,#C98A2E,#B75B39)","linear-gradient(155deg,#2F6F5E,#1F5647)","linear-gradient(155deg,#8A6FB0,#6A4F90)","linear-gradient(155deg,#A23B3B,#7E2E2E)","linear-gradient(155deg,#3A8FA0,#2A6B78)"];
    USERS.push({
      id: nextUserId++, name, email, role, department, status: umSelectedStatus,
      initials: name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2),
      color: palette[USERS.length % palette.length]
    });
  }

  closeUserModal();
  renderUserList();
  renderWorkload();
  renderList();
  renderKanban();
  updateAdminStats();
});

function updateAdminStats(){
  const activeUsers = USERS.filter(u=>u.status==='active');
  document.getElementById('statUsers').textContent = USERS.length;
  document.getElementById('usersNavCount').textContent = USERS.length;
  document.getElementById('greetUserCount').textContent = `${USERS.length} user${USERS.length===1?'':'s'}`;
  document.getElementById('greetDeptCount').textContent = `${DEPARTMENTS.length} department${DEPARTMENTS.length===1?'':'s'}`;
  document.getElementById('greetProjectCount').textContent = `${PROJECTS.length} project${PROJECTS.length===1?'':'s'}`;
}

// ---------------- Init ----------------
(function initAssigneeFilterOptions(){
  const sel = document.getElementById('assigneeFilter');
  assignableUsers().forEach(m=>{
    const opt = document.createElement('option');
    opt.value = m.name; opt.textContent = m.name;
    sel.appendChild(opt);
  });
})();
renderProjectNav();
renderDeptNav();
populateDeptFilterOptions();
renderUserList();
renderWorkload();
renderList();
renderKanban();
updateAdminStats();
</script>
</body>
</html>