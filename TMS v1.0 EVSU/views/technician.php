<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workbench — Technician</title>
    <link rel="stylesheet" href="../assets/css/splash.css">
    <link rel="stylesheet" href="../assets/css/main/css2.css">
    <link rel="stylesheet" href="../assets/css/main/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="shortcut icon" href="../assets/img/LEYTE-PULSE.png" type="image/x-icon">
</head>

<body>
    <div id="preloader"></div>
    <div class="shell">
        <!-- ================= SIDEBAR ================= -->
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">W</div>
                <div>
                    <div class="brand-name">Workbench</div>
                    <span class="role-pill">Technician</span>
                </div>
            </div>

            <nav class="nav-group">
                <span class="nav-label">Workspace</span>
                <a class="nav-item" data-view="list"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                    </svg>All Tasks<span class="nav-count" id="allTasksNavCount">0</span></a>
                <a class="nav-item" data-view="kanban"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 6h16M4 12h10M4 18h6" />
                    </svg>Kanban Board</a>
                <a class="nav-item show_tech" style="display: none !important;" data-view="users"><svg
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>Users<span class="nav-count" id="usersNavCount">0</span></a>
                <!-- <a class="nav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3v18h18" />
                        <path d="M18 17V9M13 17V5M8 17v-4" />
                    </svg>Reports</a> -->
                <a hidden id="cocNavItem" class=""><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 3l8 4v5c0 5-3.5 8.5-8 9c-4.5-.5-8-4-8-9V7l8-4z" />
                        <path d="M9 12l2 2l4-4" />
                    </svg>Code of Conduct</a>
            </nav>

            <nav class="nav-group">
                <div class="nav-label-row">
                    <span class="nav-label" style="margin:0;">Projects</span>
                    <button class="nav-add-btn show_sup show_tech" style="display: none !important;"
                        id="manageProjectsBtn" title="Manage projects" aria-label="Manage projects">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                </div>
                <div id="projectNavList"></div>
            </nav>

            <nav class="nav-group">
                <div class="nav-label-row">
                    <span class="nav-label" style="margin:0;">Sites</span>
                    <button class="nav-add-btn show_tech" style="display: none !important;" id="manageDeptsBtn"
                        title="Manage departments" aria-label="Manage departments">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                </div>
                <div id="deptNavList"></div>
            </nav>

            <div class="sidebar-foot" id="sidebarFoot">
                <div class="avatar" id="sbfavatar">PI</div>
                <div class="who">
                    <div id="sbfname" class="name">Paul Ian Dumdum</div>
                    <div class="email">EVSU PULSE 2026 © Paul Ian</div>
                </div>
                <div class="sidebar-foot-menu" id="sidebarFootMenu">
                    <button type="button" class="sidebar-foot-menu-item" id="sidebarSettingsBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                        </svg>
                        Settings
                    </button>
                    <button type="button" class="sidebar-foot-menu-item show_tech" style="display: none !important;"
                        id="sidebarLogsBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <path d="M14 2v6h6" />
                            <path d="M16 13H8" />
                            <path d="M16 17H8" />
                            <path d="M10 9H8" />
                        </svg>
                        Logs
                    </button>
                    <button type="button" class="sidebar-foot-menu-item danger" id="sidebarSignOutBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <path d="M16 17l5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                        Sign out
                    </button>
                </div>
            </div>
        </aside>

        <!-- ================= MAIN ================= -->
        <main class="main">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="hamburger-btn" id="hamburgerBtn"><svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M3 12h18M3 18h18" />
                        </svg></button>
                    <div class="greeting">
                        <h1 id="greetings"></h1>
                        <p>You manage <strong id="greetProjectCount">0 projects</strong> and <strong
                                id="greetUserCount">0 users</strong> across <strong id="greetDeptCount">0
                                departments</strong>. <span class="date-stub" id="greetDate"></span></p>
                    </div>
                </div>
                <div class="top-actions">
                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.3-4.3" />
                        </svg>
                        <input type="text" id="searchInput" placeholder="Search tasks…">
                    </div>
                    <button class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.7 21a2 2 0 01-3.4 0" />
                        </svg><span class="dot-badge"></span></button>
                    <button class="btn-primary" id="newTaskBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        <span id="newTaskBtnLabel">New Task</span>
                    </button>
                </div>
            </div>
            <div class="section-title">Status</div>

            <div class="stat-strip">
                <div class="stat-card total">
                    <div class="accent-bar"></div>
                    <div class="num" id="statTotal">0</div>
                    <div class="lbl">Active tasks</div>
                </div>
                <div class="stat-card overdue">
                    <div class="accent-bar"></div>
                    <div class="num" id="statOverdue">0</div>
                    <div class="lbl">Overdue</div>
                </div>
                <div class="stat-card done">
                    <div class="accent-bar"></div>
                    <div class="num">0</div>
                    <div class="lbl">Completed this month</div>
                </div>
                <div class="stat-card team">
                    <div class="accent-bar"></div>
                    <div class="num" id="statUsers">0</div>
                    <div class="lbl">Total users</div>
                </div>
            </div>

            <div class="section-title">Team workload</div>
            <div class="workload-strip" id="workloadStrip"></div>

            <div class="view-tabs">
                <div class="view-tab active" data-view="list">All Tasks</div>
                <div class="view-tab" data-view="kanban">Kanban Board</div>
                <div class="view-tab show_tech" style="display: none !important;" data-view="users">Users</div>
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
                        <option value="all">All technicians</option>
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
                    <div class="chip" data-role-filter="Technician">Technician</div>
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
                <button class="modal-close" id="modalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="field-group">
                    <label class="field-label" for="ntTitle">Task title</label>
                    <input type="text" id="ntTitle" placeholder="e.g. Annual terminal cleaning">
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
                        <label class="field-label" for="ntAssignee">Assign to (Taskmaster)</label>
                        <select id="ntAssignee"></select>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field-group">
                        <label class="field-label" for="ntTaskBudy">Task Budy (Affiliate)</label>
                        <select id="ntTaskBudy"></select>
                    </div>
                    <div id="ntBudyList" style="margin-top:8px;"></div>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M21.44 11.05l-9.19 9.19a5 5 0 01-7.07-7.07l9.19-9.19a3.5 3.5 0 014.95 4.95l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                        </svg>
                        Add files
                    </label>
                    <input type="file" id="ntFileInput" multiple style="display:none;">
                    <div id="ntAttachmentList" style="margin-top:8px;"></div>
                </div>
                <div class="reassign-error" id="ntError">Please add a title and pick an assignee before creating the
                    task.</div>
            </div>
            <div class="modal-foot">
                <button class="btn-secondary" id="modalCancel">Cancel</button>
                <button class="btn-primary-modal" id="modalCreate">Create task</button>
            </div>
        </div>
    </div>

    <!-- ================= UPDATE TASK MODAL ================= -->
    <div class="modal-overlay" id="updateTaskModalOverlay">
        <div class="modal">
            <div class="modal-head">
                <h2>Update task</h2>
                <button class="modal-close" id="utModalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="field-group">
                    <label class="field-label" for="utTitle">Task title</label>
                    <input type="text" id="utTitle">
                </div>
                <div class="field-group">
                    <label class="field-label" for="utDesc">Description</label>
                    <textarea id="utDesc" placeholder="Add any details the assignee will need…"></textarea>
                </div>
                <div class="field-row2">
                    <div class="field-group">
                        <label class="field-label" for="utProject">Project</label>
                        <select id="utProject"></select>
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="utAssignee">Assign to (Taskmaster)</label>
                        <select id="utAssignee"></select>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field-group">
                        <label class="field-label" for="utTaskBudy">Task Budy (Affiliate)</label>
                        <select id="utTaskBudy"></select>
                    </div>
                    <div id="utBudyList" style="margin-top:8px;"></div>
                </div>
                <div class="field-row2">
                    <div class="field-group">
                        <label class="field-label" for="utStart">Start date</label>
                        <input type="date" id="utStart">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="utDue">Due date</label>
                        <input type="date" id="utDue">
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Priority</label>
                    <div class="priority-picker" id="utPriority">
                        <div class="priority-opt low" data-p="low">Low</div>
                        <div class="priority-opt medium" data-p="medium">Medium</div>
                        <div class="priority-opt high" data-p="high">High</div>
                        <div class="priority-opt critical" data-p="critical">Critical</div>
                    </div>
                </div>
                <div class="reassign-error" id="utError">Please add a title and pick an assignee before saving.</div>
            </div>
            <div class="modal-foot">
                <button class="btn-secondary" id="utModalCancel">Cancel</button>
                <button class="btn-primary-modal" id="utSave">Save changes</button>
            </div>
        </div>
    </div>

    <!-- ================= MANAGE PROJECTS MODAL ================= -->
    <div class="modal-overlay" id="projectModalOverlay">
        <div class="modal">
            <div class="modal-head">
                <h2>Manage projects</h2>
                <button class="modal-close" id="projectModalClose"><svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="field-group">
                    <label class="field-label" for="pmName" id="pmFormLabel">New project</label>
                    <input type="text" id="pmName" placeholder="e.g. Product Launch">
                </div>
                <div class="field-group">
                    <label class="field-label" for="pmDept">Department</label>
                    <select id="pmDept"></select>
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
                <button class="modal-close" id="userModalClose"><svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="field-row2">
                    <div class="field-group">
                        <label class="field-label" for="umFname">First Name</label>
                        <input type="text" id="umFname" autocomplete="off">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="umLname">Last Name</label>
                        <div class="builder-add-row">
                            <input type="text" id="umLname" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="field-row2" id="umCredentialField">
                    <div class="field-group">
                        <label class="field-label" for="umUsername">Username</label>
                        <input type="text" id="umUsername" placeholder="ID No." autocomplete="off">
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="umPassword">Password</label>
                        <div class="builder-add-row">
                            <input type="text" id="umPassword" placeholder="" autocomplete="new-password" readonly
                                value="12345">
                        </div>
                    </div>
                </div>
                <div style="font-size:11px;color:var(--ink-faint);margin:-8px 0 14px;" id="umPasswordHint">The user must
                    change their password after their first sign-in.</div>
                <div class="field-row2">
                    <div class="field-group">
                        <label class="field-label" for="umRole">Role</label>
                        <select id="umRole">
                            <option value="Technician">Technician</option>
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
                <div class="reassign-error" id="umError">Add a name, username, and department before saving.</div>
                <div style="font-size:11.5px;color:var(--ink-faint);margin-top:2px;" id="umInviteHint">This account will
                    be ready to sign in with the username and password above.</div>
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
                <button class="modal-close" id="deptModalClose"><svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="modal-body">
                <div class="field-group">
                    <label class="field-label" for="dmName" id="dmFormLabel">New department</label>
                    <input type="text" id="dmName" placeholder="e.g. IT Department">
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
            <div class="drawer-head-actions">
                <button hidden class="utManageBtn" id="drawerEditBtn" aria-label="Edit task"><svg viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 3a2.85 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5z" />
                    </svg></button>
                <button hidden class="utManageBtn danger" id="drawerDeleteBtn" aria-label="Delete task"><svg
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" />
                    </svg></button>
                <button class="drawer-close" id="drawerClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg></button>
            </div>
            <div class="drawer-proj" id="dProj"></div>
            <div class="drawer-title" id="dTitle"></div>
            <div class="drawer-tags">
                <span class="stamp" id="dPriority"></span>
                <span class="status-tag" id="dStatusTag"></span>
            </div>
        </div>
        <div class="drawer-body">
            <div class="d-section" id="taskDeleteConfirmSection" style="display:none;">
                <div class="project-delete-row">
                    Delete this task permanently, including its checklist, attachments, and comments?
                    <button type="button" class="project-delete-confirm-btn" id="taskDeleteConfirmBtn">Delete</button>
                    <button type="button" class="project-delete-cancel-btn" id="taskDeleteCancelBtn">Cancel</button>
                </div>
            </div>
            <div class="d-section" id="utsRow" hidden>
                <div class="d-section-title">Update status</div>
                <div class="status-select-row" id="statusRow">
                    <div class="status-opt" data-status="todo">To Do</div>
                    <div class="status-opt" data-status="progress">In Progress</div>
                    <div class="status-opt" data-status="hold">On Hold</div>
                    <div class="status-opt" data-status="done">Done</div>
                    <div hidden class="nt-empty-hint" id="rectNote" style="color: var(--red);">⚠ This task has been set for correction.</div>
                </div>
            </div>

            <div class="d-section" id="rectRow" hidden>
                <div class="d-section-title">Rectify Task</div>
                <div class="status-select-row" id="statusRow">
                    <div class="status-opt" data-status="rectify">Rectify</div>
                </div>
                <div class="nt-empty-hint">Note: Once rectified, the task status will be set to TO DO with a rectification note.</div>
            </div>

            <div id="reassignTaskSection" class="d-section" hidden>
                <div class="d-section-title">Reassign task</div>
                <div class="assignee-row">Currently with <div class="avatar" id="dAssigneeAvatar"></div> <strong
                        id="dAssigneeName"></strong></div>
                <label class="field-label" for="reassignSelect">Reassign to (Taskmaster)</label>
                <select class="reassign-select" id="reassignSelect">
                    <option value="">Choose a technician…</option>
                </select>
                <label class="field-label" for="reassignNote">Reassignment Reason (Required)</label>
                <textarea class="reassign-textarea" id="reassignNote"
                    placeholder="e.g. Moving this to Juan Dela Cruz since he owns the checkout flow."></textarea>
                <div class="reassign-error" id="reassignError"></div>
                <button class="reassign-btn" id="reassignBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 1l4 4-4 4" />
                        <path d="M3 11V9a4 4 0 014-4h14" />
                        <path d="M7 23l-4-4 4-4" />
                        <path d="M21 13v2a4 4 0 01-4 4H3" />
                    </svg>
                    Reassign task
                </button>
                <div class="reassign-confirm" id="reassignConfirm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                    </svg>
                    <span id="reassignConfirmText">Task reassigned.</span>
                </div>
            </div>

            <div hidden id="currentlyWithSection" class="d-section">
                <div class="assignee-row">Currently with <div class="avatar" id="dAssigneeAvatar_"></div> <strong
                    id="dAssigneeName_"></strong></div>
            </div>

            <div class="d-section">
                <div class="d-section-title">Task Budy (Affiliate)</div>
                <div id="budyBox"></div>
            </div>

            <div class="d-section">
                <div class="d-section-title">Description</div>
                <p class="d-desc" id="dDesc"></p>
            </div>

            <div class="d-section">
                <div class="d-section-title">Details</div>
                <div class="d-meta-grid">
                    <div class="d-meta-item">
                        <div class="k">Start Date</div>
                        <div class="v" id="dStart"></div>
                    </div>
                    <div class="d-meta-item">
                        <div class="k">Due date</div>
                        <div class="v" id="dDue"></div>
                    </div>
                    <div class="d-meta-item">
                        <div class="k">Technician Department</div>
                        <div class="v" id="dDept"></div>
                    </div>
                    <div class="d-meta-item">
                        <div class="k">Assigned to</div>
                        <div class="v" id="dAssignedTo"></div>
                    </div>
                </div>
            </div>

            <div class="d-section">
                <div class="d-section-title" id="checklistTitle">Checklist</div>
                <div id="checklistBox"></div>
            </div>



            <div class="d-section">
                <div class="d-section-title">Attachments</div>
                <div id="attachmentsBox"></div>
            </div>

            <div class="d-section">
                <div class="d-section-title">Comments</div>
                <div id="commentsBox"></div>
            </div>
        </div>
        <div class="comment-input">
            <input type="text" id="commentInput" placeholder="Add a turnover note or comment...">
            <button type="button" id="commentSendBtn">Submit</button>
        </div>
        <div class="close-drawer">
            <button class="close-btn" id="closeDrawer">
                Close
            </button>
        </div>
    </aside>
    <?php require __DIR__ . "/modals/coc_modal.php";?>
    <script src="../../assets/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../../assets/js/sole.js"></script>
    <script src="../../assets/js/sole.swal.js"></script>
    <script src="../assets/js/splash.js"></script>
    <script src="../assets/js/main/script.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>