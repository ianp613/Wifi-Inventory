// ---------------- Mock data (would come from PHP/MySQL via fetch()) ----------------
const CURRENT_USER = "Morgan Reyes";
const COLOR_PALETTE = ["#3B6FA0","#C98A2E","#2F6F5E","#B75B39","#A23B3B","#8A6FB0","#5B6B60","#3A8FA0"];

let nextDeptId = 5;
const DEPARTMENTS = [];
function deptByName(name){ return DEPARTMENTS.find(d=>d.name===name); }

let nextUserId = 8;
const USERS = [];
function memberInfo(name){
  const u = USERS.find(x => fullName(x) === name);
  if(u) return u;
  return {fname:'', lname:'', name, initials:name.split(' ').map(w=>w[0]).join(''), color:"var(--ink-soft)"};
}
// Users who can actually be assigned tasks: active, non-administrator accounts
function assignableUsers(){
  return USERS.filter(u=>u.role!=='Administrator' && u.status==='active');
}

function resolveAssignee(userId){
  const u = USERS.find(x => x.id === userId);
  if(u) return { name: fullName(u), initials: u.initials, color: u.color, needsAssignment: false };
  return { name: 'Unassigned', initials: '—', color: 'var(--ink-faint)', needsAssignment: true };
}

function resolveCommentAuthor(userId){
  const u = USERS.find(x => x.id === userId);
  if(u) return { name: fullName(u), initials: u.initials, color: u.color, deleted: false };
  return { name: 'Deleted Account', initials: '–', color: 'var(--ink-faint)', deleted: true };
}

let nextProjectId = 4;
const PROJECTS = [
  {id:1, name:"Website Revamp", color:"#3B6FA0"},
  {id:2, name:"Client Onboarding", color:"#C98A2E"},
  {id:3, name:"Q3 Marketing", color:"#2F6F5E"},
];
function projectByName(name){ return PROJECTS.find(p=>p.name===name); }
function projectById(id){ return PROJECTS.find(p=>p.id==id); }


function fetchProjects(){
    return sole.get("../../controllers/administrator/get_projects.php")
    .then(res => {
      PROJECTS.length = 0;
      res.forEach(p => {
        PROJECTS.push({
          id: p.id,
          name: p.project_name,
          color: p.color
        });
      });
      renderList();
      renderKanban();
      renderWorkload();
    });
}


function fetchTasks(){
  return sole.get("../../controllers/administrator/get_tasks.php")
    .then(res => {
      TASKS.length = 0;
      res.forEach(t => {
        TASKS.push({
          id: t.id,
          title: t.title,
          desc: t.description || 'No description provided.',
          project : projectById(t.project_id).name,
          project_id: t.project_id ? parseInt(t.project_id) : null,
          user_id: t.user_id ? parseInt(t.user_id) : null,
          priority: t.priority,
          status: t.status,
          start_date: t.start_date,
          due_date: t.due_date,
          due: formatTaskDate(t.due_date),
          overdue: isOverdue(t.due_date, t.status),
          dueSoon: isDueSoon(t.due_date),
          checklist: [parseInt(t.checklist[0]) || 0,parseInt(t.checklist[1]) || 0],
          comments: parseInt(t.comments),
          files: parseInt(t.files)
        });
      });
      renderList();
      renderKanban();
      renderWorkload();
    });
}

function formatTaskDate(dateStr){
  if(!dateStr) return 'Not set';
  return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {month:'long', day:'numeric'});
}
function isOverdue(dateStr, status){
  if(!dateStr || status === 'done') return false;
  return new Date(dateStr + 'T00:00:00') < new Date(new Date().toDateString());
}
function isDueSoon(dateStr){
  if(!dateStr) return false;
  const due = new Date(dateStr + 'T00:00:00');
  const days = (due - new Date(new Date().toDateString())) / 86400000;
  return days >= 0 && days <= 3;
}

let nextId = 7;
const TASKS = [];

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
    const mine = TASKS.filter(t=>t.user_id===m.id);
    const active = mine.filter(t=>t.status=='progress').length;
    const overdue = mine.filter(t=>t.overdue).length;
    const done = mine.filter(t=>t.status==='done').length;
    const total = mine.length || 1;
    const pct = Math.round((done/total)*100);
    return `
    <div class="workload-card ${String(activeAssignee)===String(m.id)?'filtered':''}" onclick="toggleAssigneeFilter(${m.id})">
      <div class="workload-top">
        <div class="avatar" style="background:${m.color}">${m.initials}</div>
        <div><div class="name">${fullName(m)}</div><div class="role">${m.role}</div></div>
      </div>
      <div class="workload-nums"><span>${active} active</span><strong>${pct}% done</strong></div>
      <div class="bar-track"><div class="bar-fill" style="width:${pct}%"></div></div>
      ${overdue ? `<div class="workload-flag">⚠ ${overdue} overdue</div>` : ''}
    </div>`;
  }).join('');
}
function toggleAssigneeFilter(userId){
  activeAssignee = (activeAssignee===userId) ? 'all' : userId;
  document.getElementById('assigneeFilter').value = activeAssignee;
  renderWorkload();
  renderList();
}
function populateAssigneeFilterOptions(){
  const sel = document.getElementById('assigneeFilter');
  const current = sel.value;
  sel.innerHTML = '<option value="all">All technicians</option>' +
    assignableUsers().map(m=>`<option value="${m.id}">${fullName(m)}</option>`).join('');
  sel.value = current || 'all';
}

// ---------------- List view ----------------
function renderTicket(t){
  const pct = Math.round((t.checklist[0]/t.checklist[1])*100) || 0;
  const info = resolveAssignee(t.user_id);   // was: memberInfo(t.assignee)
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
        <span class="meta-item assignee ${info.needsAssignment ? 'needs-assignment' : ''}">${info.name}</span>
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
  const filtered = TASKS.filter(t => {
    const info = resolveAssignee(t.user_id);
    return (activeFilter==='all' || t.status===activeFilter) &&
      (activeAssignee==='all' || String(t.user_id)===String(activeAssignee)) &&
      (t.title.toLowerCase().includes(q) || t.project.toLowerCase().includes(q) || info.name.toLowerCase().includes(q));
  });
  list.innerHTML = filtered.length ? filtered.map(renderTicket).join('') :
    `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No tasks match this filter.</div>`;

  document.getElementById('statTotal').textContent = TASKS.filter(t=>t.status=='progress').length;
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
        const info = resolveAssignee(t.user_id);
        return `
        <div class="kcard" draggable="true" data-id="${t.id}">
          <div onclick="openDrawer(${t.id})">
            <div class="kcard-top"><span class="stamp ${t.priority}">${t.priority}</span></div>
            <div class="kcard-proj">${t.project}</div>
            <div class="kcard-title">${t.title}</div>
            <div class="kcard-assignee"><div class="avatar" style="background:${info.color}">${info.initials}</div><span>${info.name}</span></div>
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

function renderDrawerComments(t){
  const box = document.getElementById('commentsBox');
  if(!t.comments || !t.commentList || !t.commentList.length){
    box.innerHTML = `<div class="nt-empty-hint">No comments yet.</div>`;
    return;
  }
  box.innerHTML = t.commentList.map(c => {
    const author = resolveCommentAuthor(c.user_id);
    return `
    <div class="comment ${author.deleted ? 'comment-deleted' : ''}">
      <div class="avatar" style="background:${author.color}">${author.initials}</div>
      <div class="comment-body">
        <div class="comment-head">
          <span class="comment-name">${author.name}</span>
          <span class="comment-time">${c.created_at || ''}</span>
        </div>
        <div class="comment-text">${c.comment_text}</div>
      </div>
    </div>`;
  }).join('');
}

function openDrawer(id){
  currentDrawerTaskId = id;
  const t = TASKS.find(x=>x.id===id) || TASKS[0];
  document.getElementById('dProj').textContent = t.project;
  document.getElementById('dTitle').textContent = t.title;
  document.getElementById('dDesc').textContent = t.desc;
  document.getElementById('dStart').textContent = formatTaskDateFull(t.start_date);
  document.getElementById('dDue').textContent = formatTaskDateFull(t.due_date);
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

  const info = resolveAssignee(t.user_id);
  document.getElementById('dAssignedTo').textContent = info.name;
  document.getElementById('dAssigneeAvatar').textContent = info.initials;
  document.getElementById('dAssigneeAvatar').style.background = info.color;
  document.getElementById('dAssigneeName').textContent = info.name;

  const assignedUser = USERS.find(u => u.id === t.user_id);
  const dept = assignedUser ? DEPARTMENTS.find(d => d.id === assignedUser.dept_id) : null;
  document.getElementById('dDept').textContent = dept ? dept.name : 'Unassigned';

  const select = document.getElementById('reassignSelect');
  select.innerHTML = '<option value="">Choose a technician…</option>' +
    assignableUsers().filter(m=>m.id!==t.user_id).map(m=>`<option value="${m.id}">${fullName(m)}</option>`).join('');
  document.getElementById('reassignNote').value = '';
  document.getElementById('reassignError').classList.remove('show');
  document.getElementById('reassignConfirm').classList.remove('show');

  document.getElementById('overlay').classList.add('open');
  document.getElementById('drawer').classList.add('open');
}
function formatTaskDateFull(dateStr){
  if(!dateStr) return 'Not set';
  return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {month:'long', day:'numeric', year:'numeric'});
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
  const newUserId = select.value;

  if(!newUserId){
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const reassignBtn = document.getElementById('reassignBtn');
  reassignBtn.disabled = true;

  sole.post("../../controllers/administrator/reassign_task.php", {
    id: t.id,
    user_id: newUserId,
    note: noteEl.value.trim()
  }).then(res => {
    reassignBtn.disabled = false;

    if(!res.status){
      errorEl.textContent = res.message || 'Something went wrong reassigning the task.';
      errorEl.classList.add('show');
      return;
    }

    t.user_id = parseInt(newUserId);
    const info = resolveAssignee(t.user_id);

    document.getElementById('dAssignedTo').textContent = info.name;
    const avatarEl = document.getElementById('dAssigneeAvatar');
    avatarEl.textContent = info.initials;
    avatarEl.style.background = info.color;
    document.getElementById('dAssigneeName').textContent = info.name;

    const assignedUser = USERS.find(u => u.id === t.user_id);
    const dept = assignedUser ? DEPARTMENTS.find(d => d.id === assignedUser.dept_id) : null;
    document.getElementById('dDept').textContent = dept ? dept.name : 'Unassigned';

    select.innerHTML = '<option value="">Choose a technician…</option>' +
      assignableUsers().filter(m=>m.id!==t.user_id).map(m=>`<option value="${m.id}">${fullName(m)}</option>`).join('');
    noteEl.value = '';

    ss.toast(null, res.type, res.message, null, "#1B2A22");
    const confirmEl = document.getElementById('reassignConfirm');
    document.getElementById('reassignConfirmText').textContent = `Reassigned to ${info.name}.`;
    confirmEl.classList.add('show');

    renderList();
    renderKanban();
    renderWorkload();
  }).catch(err => {
    reassignBtn.disabled = false;
    errorEl.textContent = 'Could not reach the server. Please try again.';
    errorEl.classList.add('show');
    console.error(err);
  });
}
document.getElementById('reassignBtn').addEventListener('click', reassignTask);
document.getElementById('reassignSelect').addEventListener('change', ()=>document.getElementById('reassignError').classList.remove('show'));

function deptForAssignee(userId){
  const u = USERS.find(x => x.id === userId);
  const d = u ? DEPARTMENTS.find(dep => dep.id === u.dept_id) : null;
  return d ? d.name : 'Unassigned';
}

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
  assigneeSelect.innerHTML = '<option value="-">-- Select User --</option>'+assignableUsers().map(m=>`<option value="${m.id}">${m.fname + " " + m.lname}</option>`).join('');

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
  const dueLabel = dueRaw ? new Date(dueRaw+'T00:00:00').toLocaleDateString('en-US',{month:'long', day:'numeric'}) : 'Not set';

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
    const count = USERS.filter(u=>u.dept_id===d.id).length;
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

  const saveBtn = document.getElementById('dmSave');
  saveBtn.disabled = true;

  if(dmEditingId){
    sole.post("../../controllers/administrator/update_department.php", {
      id: dmEditingId,
      dept_name: name,
      dept_color: dmSelectedColor
    }).then(res => {
      saveBtn.disabled = false;

      if(!res.status){
        errorEl.textContent = res.message || 'Something went wrong updating the department.';
        errorEl.classList.add('show');
        return;
      }

      ss.toast(null, res.type, res.message, null, "#1B2A22");

      resetDeptForm();
      fetchDepartments();
    });
    return;
  }

  sole.post("../../controllers/administrator/create_department.php", {
    dept_name: name,
    dept_color: dmSelectedColor
  }).then(res => {
    saveBtn.disabled = false;

    if(!res.status){
      errorEl.textContent = res.message || 'Something went wrong saving the department.';
      errorEl.classList.add('show');
      return;
    }

    ss.toast(null, res.type, res.message, null, "#1B2A22");
    
    resetDeptForm();
    fetchDepartments();
  })
});

function refreshDeptDependents(){
  renderDeptNav();
  populateDeptFilterOptions();
  populateUmDeptOptions();
  renderUserList();
  renderDeptManageList();
  updateAdminStats();
}

function fetchDepartments(){   // <-- paste the new function here
  return sole.post("../../controllers/administrator/get_departments.php", {
    user_id : 0 //temp
  })
    .then(res => {
      DEPARTMENTS.length = 0;
      res.forEach(d => {
        DEPARTMENTS.push({ id: d.id, name: d.dept_name, color: d.dept_color });
      });
      refreshDeptDependents();
    })
}

function fetchUsers(){
  return sole.get("../../controllers/administrator/get_users.php")
    .then(res => {
      USERS.length = 0;
      res.forEach(u => {
        USERS.push({
          id: u.id,
          fname: u.fname,
          lname: u.lname,
          role: u.privileges,
          dept_id: u.dept_id != "-" ? parseInt(u.dept_id) : u.dept_id,
          status: u.status,
          initials: (u.fname[0] + u.lname[0]).toUpperCase(),
          color: memberColorFor(u.id)
        });
      });
      renderUserList();
      renderWorkload();
      updateAdminStats();
      populateAssigneeFilterOptions();
    })
}

function fullName(u){
  return u.fname + " " + u.lname;
}

function memberColorFor(id){
  const palette = ["linear-gradient(155deg,#3B6FA0,#274F72)","linear-gradient(155deg,#C98A2E,#B75B39)","linear-gradient(155deg,#2F6F5E,#1F5647)","linear-gradient(155deg,#8A6FB0,#6A4F90)","linear-gradient(155deg,#A23B3B,#7E2E2E)","linear-gradient(155deg,#3A8FA0,#2A6B78)"];
  return palette[id % palette.length];
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
  sel.innerHTML = '<option value="-">-- Select Department --</option>' +
    DEPARTMENTS.map(d=>`<option value="${d.id}">${d.name}</option>`).join('');
  if(DEPARTMENTS.some(d=>d.id===current)) sel.value = current;
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
  const filtered = USERS.filter(u=>{
    const dept = DEPARTMENTS.find(d=>d.id===u.dept_id);
    return (activeRoleFilter==='all' || u.role===activeRoleFilter) &&
      (activeDeptFilter==='all' || u.dept_id===activeDeptFilter) &&
      (fullName(u).toLowerCase().includes(q) || (dept ? dept.name.toLowerCase().includes(q) : false));
  });

  if(!filtered.length){
    list.innerHTML = `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No users match this filter.</div>`;
    return;
  }

  list.innerHTML = filtered.map(u=>{
    const name = fullName(u);
    const dept = DEPARTMENTS.find(d=>d.id===u.dept_id);
    if(userDeleteConfirmId === u.id){
      const taskCount = TASKS.filter(t=>t.assignee===name).length;
      return `
      <div class="user-row">
        <div class="user-delete-wrap">
          <div class="project-delete-row">
            Delete "${name}"? ${taskCount ? `${taskCount} task${taskCount===1?'':'s'} will move to "Unassigned."` : 'This account will be permanently removed.'}
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
          <span class="user-name">${name}</span>
          <span class="role-badge ${roleBadgeClass(u.role)}">${u.role}</span>
        </div>
        <div class="user-meta-row">
          <span class="dept-tag"><span class="dot" style="background:${dept?dept.color:'var(--ink-faint)'}"></span>${dept?dept.name:'Unassigned'}</span>
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
    confirmBtn.disabled = true;

    sole.post("../../controllers/administrator/delete_user.php", { id : id })
      .then(res => {
        confirmBtn.disabled = false;

        if(!res.status){
          ss.toast(null, res.type, res.message, null, "#1B2A22");
          return;
        }

        ss.toast(null, res.type, res.message, null, "#1B2A22");
        userDeleteConfirmId = null;
        fetchUsers(); // re-renders userList, workload, and stats internally
        renderList();
        renderKanban();
      })
      .catch(err => {
        confirmBtn.disabled = false;
        ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
        console.error(err);
      });
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
  document.getElementById('umUsername').value = '';

  if(umEditingId){
    const u = USERS.find(x=>x.id===umEditingId);
    document.getElementById('umModalTitle').textContent = 'Edit user';
    document.getElementById('umSave').textContent = 'Save changes';
    document.getElementById('umInviteHint').style.display = 'none';
    document.getElementById('umFname').value = u.fname;
    document.getElementById('umLname').value = u.lname;
    document.getElementById('umRole').value = u.role;
    document.getElementById('umDept').value = u.dept_id;
    document.getElementById('umCredentialField').hidden = true;
    document.getElementById('umCredentialField').classList.remove('field-row2');
    document.getElementById('umPasswordHint').textContent = '';
    umSelectedStatus = u.status;
  } else {
    document.getElementById('umModalTitle').textContent = 'Create user';
    document.getElementById('umSave').textContent = 'Create user';
    document.getElementById('umInviteHint').style.display = 'block';
    document.getElementById('umFname').value = '';
    document.getElementById('umLname').value = '';
    document.getElementById('umRole').value = 'Technician';
    document.getElementById('umCredentialField').hidden = false;
    document.getElementById('umCredentialField').classList.add('field-row2');
    document.getElementById('umPasswordHint').textContent = 'The user must change their password after their first sign-in.';
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
  const fname = document.getElementById('umFname').value.trim();
  const lname = document.getElementById('umLname').value.trim();
  const username = document.getElementById('umUsername').value.trim();
  const password = document.getElementById('umPassword').value;
  const role = document.getElementById('umRole').value;
  const department = document.getElementById('umDept').value;
  const errorEl = document.getElementById('umError');

  const usernameValid = /^[a-zA-Z0-9._-]{3,}$/.test(username);

  if(!fname || !lname || (!umEditingId && !usernameValid)){
    errorEl.textContent = (!fname || !lname) ? 'Add a complete name before saving.'
      : 'Username must be at least 3 characters (letters, numbers, . _ -).';
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const saveBtn = document.getElementById('umSave');
  saveBtn.disabled = true;

  if(umEditingId){
    sole.post("../../controllers/administrator/update_user.php", {
      id: umEditingId,
      fname,
      lname,
      privileges: role,
      dept_id: department,
      status: umSelectedStatus
    }).then(res => {
      saveBtn.disabled = false;

      if(!res.status){
        errorEl.textContent = res.message;
        errorEl.classList.add('show');
        return;
      }

      ss.toast(null, res.type, res.message, null, "#1B2A22");
      closeUserModal();
      fetchUsers();
    }).catch(err => {
      saveBtn.disabled = false;
      errorEl.textContent = 'Could not reach the server. Please try again.';
      errorEl.classList.add('show');
      console.error(err);
    });
    return;
  }

  sole.post("../../controllers/administrator/create_user.php", {
    fname,
    lname,
    username,
    password,
    privileges: role,
    dept_id: department,
    status: umSelectedStatus
  }).then(res => {
    saveBtn.disabled = false;

    if(!res.status){
      errorEl.textContent = res.message;
      errorEl.classList.add('show');
      return;
    }

    ss.toast(null,res.type,res.message,null,"#1B2A22")
    closeUserModal();
    fetchUsers();
    
  }).catch(err => {
    saveBtn.disabled = false;
    errorEl.textContent = 'Could not reach the server. Please try again.';
    errorEl.classList.add('show');
    console.error(err);
  });
});

function updateAdminStats(){
  const activeUsers = USERS.filter(u=>u.status==='active');
  document.getElementById('statUsers').textContent = USERS.length;
  document.getElementById('usersNavCount').textContent = USERS.length;
  document.getElementById('greetUserCount').textContent = `${USERS.length} user${USERS.length===1?'':'s'}`;
  document.getElementById('greetDeptCount').textContent = `${DEPARTMENTS.length} department${DEPARTMENTS.length===1?'':'s'}`;
  document.getElementById('greetProjectCount').textContent = `${PROJECTS.length} project${PROJECTS.length===1?'':'s'}`;
}

renderProjectNav();
fetchDepartments();   // replaces renderDeptNav() + populateDeptFilterOptions()
fetchUsers();
fetchProjects();
fetchTasks();
renderUserList();
renderWorkload();
renderList();
renderKanban();
updateAdminStats();


