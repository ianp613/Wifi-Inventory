<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DDC PULSE — Supervisor</title>
<link rel="stylesheet" href="../assets/css/splash.css">
<link rel="stylesheet" href="../assets/css/supervisor/css2.css">
<link rel="stylesheet" href="../assets/css/supervisor/style.css">
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
        <span class="role-pill">Supervisor</span>
      </div>
    </div>

    <nav class="nav-group">
      <span class="nav-label">Workspace</span>
      <a class="nav-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>Dashboard</a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>All Tasks<span class="nav-count">6</span></a>
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>Kanban Board</a>
      <!-- <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>Team</a> -->
      <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-4"/></svg>Reports</a>
      <a id="cocNavItem" class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l8 4v5c0 5-3.5 8.5-8 9c-4.5-.5-8-4-8-9V7l8-4z"/><path d="M9 12l2 2l4-4"/></svg>Code of Conduct</a>
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

    <div class="sidebar-foot">
      <div class="avatar">PS</div>
      <div class="who">
        <div class="name">Priya Shah</div>
        <div class="email">priya@workbench.io</div>
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
          <p>Your team has <strong>2 tasks overdue</strong> and <strong>3 due this week</strong>. <span class="date-stub">— Tue, Jul 21</span></p>
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
          <span>New Task</span>
        </button>
      </div>
    </div>

    <div class="stat-strip">
      <div class="stat-card total"><div class="accent-bar"></div><div class="num" id="statTotal">6</div><div class="lbl">Active tasks</div></div>
      <div class="stat-card overdue"><div class="accent-bar"></div><div class="num" id="statOverdue">2</div><div class="lbl">Overdue</div></div>
      <div class="stat-card done"><div class="accent-bar"></div><div class="num">14</div><div class="lbl">Completed this month</div></div>
      <div class="stat-card team"><div class="accent-bar"></div><div class="num">4</div><div class="lbl">Team members</div></div>
    </div>

    <div class="section-title">Team workload</div>
    <div class="workload-strip" id="workloadStrip"></div>

    <div class="view-tabs">
      <div class="view-tab active" data-view="list">All Tasks</div>
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
<?php require __DIR__ . "/modals/coc_modal.php";?>
<script src="../assets/js/splash.js"></script>
<script src="../assets/js/supervisor/script.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>