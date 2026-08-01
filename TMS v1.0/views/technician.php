<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DDC PULSE — Technician</title>
<link href="../assets/css/splash.css" rel="stylesheet">
<link href="../assets/css/technician/css2.css" rel="stylesheet">
<link href="../assets/css/technician/style.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<div class="shell">
  <!-- ================= SIDEBAR ================= -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-mark">D</div>
      <div>
        <div class="brand-name">DDC PULSE</div>
        <span class="role-pill">Technician</span>
      </div>
    </div>

    <nav class="nav-group">
      <span class="nav-label">Workspace</span>
      <a class="nav-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>Dashboard</a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>My Tasks<span class="nav-count">12</span></a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>Kanban Board</a>
      <a id="cocNavItem" class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 9c-4.5-.5-8-4-8-9V7l8-4z"/><path d="M9 12l2 2l4-4"/></svg>Code of Conduct</a>
    </nav>

    <nav class="nav-group">
      <span class="nav-label">Projects</span>
      <a class="nav-item"><span style="width:8px;height:8px;border-radius:2px;background:#3B6FA0;display:inline-block;"></span>Website Revamp</a>
      <a class="nav-item"><span style="width:8px;height:8px;border-radius:2px;background:#C98A2E;display:inline-block;"></span>Client Onboarding</a>
      <a class="nav-item"><span style="width:8px;height:8px;border-radius:2px;background:#2F6F5E;display:inline-block;"></span>Q3 Marketing</a>
    </nav>

    <div class="sidebar-foot">
      <div class="avatar">PD</div>
      <div class="who">
        <div class="name">Paul Ian Dumdum</div>
        <div class="email">paulian@workbench.io</div>
      </div>
    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <main class="main">
    <div class="topbar">
      <div class="topbar-left">
        <button class="hamburger-btn" id="hamburgerBtn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button>
        <div class="greeting">
          <h1>Hello, Paul Ian.</h1>
          <p>You have <strong>4 tasks</strong> due this week and <strong>1 overdue</strong>. <span class="date-stub">— Tue, Jul 21</span></p>
        </div>
      </div>
      <div class="top-actions">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
          <input type="text" id="searchInput" placeholder="Search tasks…">
        </div>
        <button class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 01-3.4 0"/></svg><span class="dot-badge"></span></button>
      </div>
    </div>

    <div class="stat-strip">
      <div class="stat-card due"><div class="accent-bar"></div><div class="num">4</div><div class="lbl">Due this week</div></div>
      <div class="stat-card progress"><div class="accent-bar"></div><div class="num">5</div><div class="lbl">In progress</div></div>
      <div class="stat-card done"><div class="accent-bar"></div><div class="num">21</div><div class="lbl">Completed this month</div></div>
      <div class="stat-card overdue"><div class="accent-bar"></div><div class="num">1</div><div class="lbl">Overdue</div></div>
    </div>

    <div class="view-tabs">
      <div class="view-tab active" data-view="list">My Tasks</div>
      <div class="view-tab" data-view="kanban">Kanban Board</div>
    </div>

    <!-- -------- LIST VIEW -------- -->
    <section class="panel active" id="panel-list">
      <div class="filter-row">
        <div class="chip active" data-filter="all">All</div>
        <div class="chip" data-filter="todo">To Do</div>
        <div class="chip" data-filter="progress">In Progress</div>
        <div class="chip" data-filter="hold">On Hold</div>
        <div class="chip" data-filter="done">Completed</div>
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

  </main>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

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
      <div class="d-section-title">Turn over task</div>
      <div class="assignee-row">Currently with <div class="avatar" id="dAssigneeAvatar">PD</div> <strong id="dAssigneeName">Paul Ian (you)</strong></div>
      <label class="field-label" for="turnoverSelect">Reassign to</label>
      <select class="turnover-select" id="turnoverSelect">
        <option value="">Choose a team member…</option>
      </select>
      <label class="field-label" for="turnoverReason">Reason for turning it over</label>
      <textarea class="turnover-textarea" id="turnoverReason" placeholder="e.g. I'm out on leave next week and this can't wait until I'm back."></textarea>
      <div class="turnover-error" id="turnoverError">Pick a team member and add a short reason before turning the task over.</div>
      <button class="turnover-btn" id="turnoverBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 014-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 01-4 4H3"/></svg>
        Turn over task
      </button>
      <div class="turnover-confirm" id="turnoverConfirm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
        <span id="turnoverConfirmText">Task turned over.</span>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Description</div>
      <p class="d-desc" id="dDesc">Rework the pricing section to reflect the new three-tier structure. Should match the new type system and include the annual/monthly toggle from the Figma file.</p>
    </div>

    <div class="d-section">
      <div class="d-section-title">Details</div>
      <div class="d-meta-grid">
        <div class="d-meta-item"><div class="k">Assigned by</div><div class="v" id="dAssignedBy">Priya Shah</div></div>
        <div class="d-meta-item"><div class="k">Assigned to</div><div class="v" id="dAssignedTo">Jamie Diaz</div></div>
        <div class="d-meta-item"><div class="k">Due date</div><div class="v">Jul 24, 2026</div></div>
        <div class="d-meta-item"><div class="k">Start date</div><div class="v">Jul 18, 2026</div></div>
        <div class="d-meta-item"><div class="k">Category</div><div class="v">Design</div></div>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Checklist — 2 of 4</div>
      <div id="checklistBox">
        <label class="checklist-item checked"><input type="checkbox" checked><span>Review Figma redlines</span></label>
        <label class="checklist-item checked"><input type="checkbox" checked><span>Confirm copy with marketing</span></label>
        <label class="checklist-item"><input type="checkbox"><span>Build responsive breakpoints</span></label>
        <label class="checklist-item"><input type="checkbox"><span>QA on staging</span></label>
      </div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Attachments</div>
      <div class="attachment"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg><span class="fname">pricing-page-v3.fig</span><span class="fsize">4.2 MB</span></div>
      <div class="attachment"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg><span class="fname">copy-deck.pdf</span><span class="fsize">180 KB</span></div>
    </div>

    <div class="d-section">
      <div class="d-section-title">Comments</div>
      <div class="comment">
        <div class="avatar" style="background:linear-gradient(155deg,#3B6FA0,#2F5578);">PS</div>
        <div class="comment-body">
          <div class="comment-head"><span class="comment-name">Priya Shah</span><span class="comment-time">2 days ago</span></div>
          <div class="comment-text">Let's use the annual price as the default toggle state.</div>
        </div>
      </div>
      <div class="comment">
        <div class="avatar">JD</div>
        <div class="comment-body">
          <div class="comment-head"><span class="comment-name">Jamie Diaz</span><span class="comment-time">Yesterday</span></div>
          <div class="comment-text">Sounds good — updating the component now.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="comment-input">
    <input type="text" placeholder="Add a comment…">
    <button>Send</button>
  </div>
</aside>
<?php require __DIR__ . "/modals/coc_modal.php";?>
<script src="../assets/js/splash.js"></script>
<script src="../assets/js/technician/script.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>