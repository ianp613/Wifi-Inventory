const CURRENT_USER = "Morgan Reyes";
const COLOR_PALETTE = ["#3B6FA0","#C98A2E","#2F6F5E","#B75B39","#A23B3B","#8A6FB0","#5B6B60","#3A8FA0","#6E8B3D","#B08968","#4F6D7A","#9A6B9E","#7A8450","#C4692F","#5C7C99"];

function randomPaletteColor(){
  return COLOR_PALETTE[Math.floor(Math.random() * COLOR_PALETTE.length)];
}

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
const PROJECTS = [];
function projectByName(name){ return PROJECTS.find(p=>p.name===name); }
function projectById(id){ return PROJECTS.find(p=>p.id==id) ? PROJECTS.find(p=>p.id==id) : {name : "No project"}; }

function fetchProjects(){
    return sole.get("../../controllers/main/get_projects.php")
    .then(res => {
      PROJECTS.length = 0;
      res.forEach(p => {
        PROJECTS.push({
          id: p.id,
          name: p.project_name,
          color: p.color,
          dept_id: p.dept_id != "-" ? parseInt(p.dept_id) : ""
        });
      });
      refreshProjectDependents();
      renderWorkload();
    });
}


function fetchTasks(){
  return sole.get("../../controllers/main/get_tasks.php")
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
          rectify: t.rectify,
          task_budy: t.task_budy ? t.task_budy.split("|") : [],
          start_date: t.start_date,
          due_date: t.due_date,
          due: formatTaskDate(t.due_date),
          overdue: isOverdue(t.due_date, t.status),
          dueSoon: isDueSoon(t.due_date),
          checklist: [parseInt(t.checklist[0]) || 0, parseInt(t.checklist[1]) || 0],
          checklistItems: (t.checklist_list || []).map(ci => ({
            id: ci.id,
            text: ci.text,
            done: ci.is_done == "1" || ci.is_done === 1
          })),
          comments: parseInt(t.comments),
          commentList: (t.comments_list || []).map(c => ({
            user_id: c.user_id ? parseInt(c.user_id) : null,
            comment_text: c.comment_text,
            created_at: c.created_at
          })),
          files: parseInt(t.files),
          attachments: (t.attachment_list || []).map(a => ({
            name: a.file_name,
            size: formatFileSize(parseInt(a.file_size) || 0),
            path: a.file_path
          }))
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
        <div>
          <span ${t.rectify == "1" && t.status != "done" ? "" : "hidden"} class="nt-empty-hint" style="color: var(--red);">⚠ This task has been set for correction.</span>
          <span class="stamp ${t.priority}">${t.priority}</span>
        </div>
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

    const matchesStatus = activeFilter==='all' || t.status===activeFilter;

    const matchesAssignee = activeAssignee==='all' ||
      String(t.user_id)===String(activeAssignee) ||
      !!(t.task_budy && t.task_budy.some(id => parseInt(id) === parseInt(activeAssignee)));

    const budyMatchesSearch = t.task_budy && t.task_budy.some(id=>{
      const u = USERS.find(x=>x.id===parseInt(id));
      return u && fullName(u).toLowerCase().includes(q);
    });

    const matchesSearch = !q ||
      t.title.toLowerCase().includes(q) ||
      t.project.toLowerCase().includes(q) ||
      info.name.toLowerCase().includes(q) ||
      budyMatchesSearch;

    return matchesStatus && matchesAssignee && matchesSearch;
  });

  list.innerHTML = filtered.length ? filtered.map(renderTicket).join('') :
    `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No tasks match this filter.</div>`;

  document.getElementById('statTotal').textContent = TASKS.filter(t=>t.status=='progress').length;
  document.getElementById('statOverdue').textContent = TASKS.filter(t=>t.overdue).length;
  const countTask = TASKS.length;
  document.getElementById('allTasksNavCount').hidden = countTask ? false : true
  document.getElementById('allTasksNavCount').textContent = countTask;
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

const VIEW_STORAGE_KEY = 'activeView';

function activateView(view){
  const targets = document.querySelectorAll(`[data-view="${view}"]`);
  if(!targets.length) return; // unknown/stale value, bail out

  document.querySelectorAll('.view-tab, .nav-item[data-view]').forEach(el=>el.classList.remove('active'));
  targets.forEach(el=>el.classList.add('active'));
  document.querySelectorAll('.panel').forEach(p=>p.classList.remove('active'));
  document.getElementById('panel-'+view).classList.add('active');
  updatePrimaryButtonContext(view);
}

// ---------------- View switching ----------------
document.querySelectorAll('.view-tab').forEach(tab=>{
  tab.addEventListener('click', ()=>{
    activateView(tab.dataset.view);
    localStorage.setItem(VIEW_STORAGE_KEY, tab.dataset.view);
  });
});
document.querySelectorAll('.nav-item[data-view]').forEach(item=>{
  item.addEventListener('click', ()=>{
    activateView(item.dataset.view);
    localStorage.setItem(VIEW_STORAGE_KEY, item.dataset.view);
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
            <span ${t.rectify == "1" && t.status != "done" ? "" : "hidden"} class="nt-empty-hint" style="color: var(--red);">⚠ This task has been set for correction.</span>
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
    col.addEventListener('dragover', e=>{
      e.preventDefault();
      if(col.dataset.col === 'todo') return; // no drop-hover highlight on a blocked target
      col.classList.add('drop-hover');
    });
    col.addEventListener('dragleave', ()=>col.classList.remove('drop-hover'));
    col.addEventListener('drop', e=>{
      e.preventDefault();
      col.classList.remove('drop-hover');
      const id = parseInt(e.dataTransfer.getData('text/plain'));
      const task = TASKS.find(t=>t.id===id);
      if(!task) return;

      if(col.dataset.col === 'todo'){
        ss.toast(null, "error", "Tasks can't be moved back to To Do.", null, "#1B2A22");
        return;
      }

      const newStatus = col.dataset.col;
      if(newStatus === task.status) return;

      task.status = newStatus;
      task.overdue = isOverdue(task.due_date, task.status);
      renderKanban();
      renderList();
      renderWorkload();

      updateTaskStatusOnServer(id, newStatus).then(res=>{
        if(!res.status){
          ss.toast(null, res.type, res.message || 'Could not update status.', null, "#1B2A22");
          return;
        }
        ss.toast(null, res.type, res.message, null, "#1B2A22");
      }).catch(err=>{
        ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
        console.error(err);
      });
    });
  });
}

function moveCard(id, dir){
  const task = TASKS.find(t=>t.id===id);
  if(!task) return;
  const idx = KCOLS.findIndex(c=>c.key===task.status);
  const next = idx + dir;
  if(next < 0 || next >= KCOLS.length) return;

  const newStatus = KCOLS[next].key;
  if(newStatus === 'todo'){
    ss.toast(null, "error", "Tasks can't be moved back to To Do.", null, "#1B2A22");
    return;
  }

  task.status = newStatus;
  task.overdue = isOverdue(task.due_date, task.status);
  renderKanban();
  renderList();
  renderWorkload();

  updateTaskStatusOnServer(id, newStatus).then(res=>{
    if(!res.status){
      ss.toast(null, res.type, res.message || 'Could not update status.', null, "#1B2A22");
      return;
    }
    ss.toast(null, res.type, res.message, null, "#1B2A22");
  }).catch(err=>{
    ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
    console.error(err);
  });
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
    <a class="attachment" href="${a.path}" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg><span class="fname">${a.name}</span><span class="fsize">${a.size}</span></a>`).join('');
}

function renderDrawerComments(t){
  const box = document.getElementById('commentsBox');
  if(!t.commentList || !t.commentList.length){
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
  box.scrollTop = box.scrollHeight;
}

// ---------------- Edit task ----------------
const updateTaskModalOverlay = document.getElementById('updateTaskModalOverlay');
let utTaskBudyList = [];

function openUpdateTaskModal(){
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t) return;

  document.getElementById('utTitle').value = t.title;
  document.getElementById('utDesc').value = t.desc === 'No description provided.' ? '' : t.desc;
  document.getElementById('utStart').value = t.start_date || '';
  document.getElementById('utDue').value = t.due_date || '';
  document.getElementById('utError').classList.remove('show');

  const projSel = document.getElementById('utProject');
  projSel.innerHTML = '<option value="-">-- Select Project --</option>' +
    PROJECTS.map(p=>`<option value="${p.id}">${p.name}</option>`).join('');
  projSel.value = t.project_id || '-';

  const assigneeSel = document.getElementById('utAssignee');
  assigneeSel.innerHTML = '<option value="-">-- Select Technician --</option>' + assignableUsers().map(m=>`<option value="${m.id}">${localStorage.getItem("userid") == m.id ? "Yourself" : fullName(m)}</option>`).join('');
  assigneeSel.value = t.user_id || "-";

  const taskBudySel = document.getElementById('utTaskBudy');
  taskBudySel.innerHTML = '<option value="-">-- Select Technician --</option>' + assignableUsers().map(m=>`<option value="${m.id}">${fullName(m)}</option>`).join('');

  document.querySelectorAll('#utPriority .priority-opt').forEach(o=>o.classList.toggle('sel', o.dataset.p===t.priority));

  updateTaskModalOverlay.classList.add('open');

  renderUtTaskBudyList();
}

const assigneeSel_ = document.getElementById('utAssignee');
assigneeSel_.addEventListener("change", ()=> {
  if(assigneeSel_.value == "-") return;
  id = parseInt(assigneeSel_.value);
  utTaskBudyList = utTaskBudyList.filter(user => user.id !== id);
  renderUtTaskBudyList();
})

document.getElementById('utBudyList').addEventListener('click', e=>{
  const btn = e.target.closest('[data-remove-budylist]');
  if(!btn) return;
  utTaskBudyList = utTaskBudyList.filter(u => u.id !== parseInt(btn.dataset.removeBudylist))
  renderUtTaskBudyList();
});

function addUtTaskBudy(){
  const select = document.getElementById('utTaskBudy');
  if(select.value == "-") return;
  const id = parseInt(select.value.trim());
  const name = select.selectedOptions[0].innerText
  if(id == "-" || id == parseInt(utAssignee.value)) return;
  if(!utTaskBudyList.find(u => u.id === id)){
    utTaskBudyList.push({id:id,name:name})
  }
  select.value = "-";
  renderUtTaskBudyList();
  select.focus();
}
document.getElementById('utTaskBudy').addEventListener('change', addUtTaskBudy);

function renderUtTaskBudyList(){
  const box = document.getElementById('utBudyList');
  if(!utTaskBudyList.length){
    box.innerHTML = `<div class="nt-empty-hint">No budy yet — select task budy.</div>`;
    return;
  }
  utTaskBudyList = utTaskBudyList.filter(user => user.id != parseInt(assigneeSel_.value))
  box.innerHTML = utTaskBudyList.map(user =>`
    <div class="nt-list-item">
      <span>${user.name}</span>
      <button type="button" data-remove-budylist="${user.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>`).join('');
}

function renderUtTaskBudyListDrawer(){
  const box = document.getElementById('budyBox');
  if(!utTaskBudyList.length){
    box.innerHTML = `<div class="nt-empty-hint">No task budy assigned.</div>`;
    return;
  }
  utTaskBudyList = utTaskBudyList.filter(user => user.id != parseInt(drawerAssigneeID))
  box.innerHTML = utTaskBudyList.map(user =>`
    <div class="nt-list-item">
      <span>${user.name}</span>
    </div>`).join('');
}


function closeUpdateTaskModal(){ updateTaskModalOverlay.classList.remove('open'); }

document.getElementById('drawerEditBtn').addEventListener('click', openUpdateTaskModal);
document.getElementById('utModalClose').addEventListener('click', closeUpdateTaskModal);
document.getElementById('utModalCancel').addEventListener('click', closeUpdateTaskModal);
updateTaskModalOverlay.addEventListener('click', e=>{ if(e.target===updateTaskModalOverlay) closeUpdateTaskModal(); });

// Scoped to #utPriority specifically — the global .priority-opt selector elsewhere
// in this file also matches #ntPriority and #umStatus, which strip each other's
// 'sel' state on click since they share the same class. Not fixing that here,
// just not adding this new modal to the same problem.
document.querySelectorAll('#utPriority .priority-opt').forEach(opt=>{
  opt.addEventListener('click', ()=>{
    document.querySelectorAll('#utPriority .priority-opt').forEach(o=>o.classList.remove('sel'));
    opt.classList.add('sel');
  });
});

document.getElementById('utSave').addEventListener('click', ()=>{
  const title = document.getElementById('utTitle').value.trim();
  const assignee = document.getElementById('utAssignee').value;
  const errorEl = document.getElementById('utError');
  const projectId = document.getElementById('utProject').value;
  const priorityOpt = document.querySelector('#utPriority .priority-opt.sel');
  const saveBtn = document.getElementById('utSave');
  const startRaw_ = document.getElementById('utStart').value
  const dueRaw_ = document.getElementById('utDue').value

  if(!title){
    errorEl.textContent = 'Please add a title before saving.';
    errorEl.classList.add('show');
    return;
  }

  if(!startRaw_){
    errorEl.textContent = 'Please select a start date before saving.';
    errorEl.classList.add('show');
    return;
  }

    if(!dueRaw_){
    errorEl.textContent = 'Please select a due date before saving.';
    errorEl.classList.add('show');
    return;
  }

  errorEl.classList.remove('show');
  saveBtn.disabled = true;

  sole.post("../../controllers/main/update_task.php", {
    id: currentDrawerTaskId,
    title : title,
    description: document.getElementById('utDesc').value.trim() || 'No description provided.',
    task_budy : utTaskBudyList.map(u => u.id).join('|'),
    project_id: projectId,
    user_id: assignee,
    priority: priorityOpt ? priorityOpt.dataset.p : 'medium',
    start_date: startRaw_,
    due_date: dueRaw_
  }).then(res => {
    saveBtn.disabled = false;

    if(!res.status){
      errorEl.textContent = res.message || 'Something went wrong updating the task.';
      errorEl.classList.add('show');
      return;
    }

    ss.toast(null, res.type, res.message, null, "#1B2A22");
    closeUpdateTaskModal();
    fetchTasks().then(() => openDrawer(currentDrawerTaskId)); // wait for fresh data before re-rendering the drawer
  }).catch(err => {
    saveBtn.disabled = false;
    errorEl.textContent = 'Could not reach the server. Please try again.';
    errorEl.classList.add('show');
    console.error(err);
  });
});

// ---------------- Delete task ----------------
document.getElementById('drawerDeleteBtn').addEventListener('click', ()=>{
  document.getElementById('taskDeleteConfirmSection').style.display = 'block';
});
document.getElementById('taskDeleteCancelBtn').addEventListener('click', ()=>{
  document.getElementById('taskDeleteConfirmSection').style.display = 'none';
});
document.getElementById('taskDeleteConfirmBtn').addEventListener('click', ()=>{
  const confirmBtn = document.getElementById('taskDeleteConfirmBtn');
  confirmBtn.disabled = true;

  sole.post("../../controllers/main/delete_task.php", { id: currentDrawerTaskId })
    .then(res => {
      confirmBtn.disabled = false;

      if(!res.status){
        ss.toast(null, res.type, res.message, null, "#1B2A22");
        return;
      }

      ss.toast(null, res.type, res.message, null, "#1B2A22");
      document.getElementById('taskDeleteConfirmSection').style.display = 'none';
      closeDrawer();
      fetchTasks();
    })
    .catch(err => {
      confirmBtn.disabled = false;
      ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
      console.error(err);
    });
});

let drawerAssigneeID;
function openDrawer(id){
  currentDrawerTaskId = id;
  utTaskBudyList = [];

  const t = TASKS.find(x=>x.id===id) || TASKS[0];
  utTaskBudyList = t.task_budy.map(id => ({id : USERS.find(u => u.id === parseInt(id)).id , name : USERS.find(u => u.id === parseInt(id)).fullname}));
  if(t.status == "done"){
    document.getElementById("utsRow").hidden = true
    if(localStorage.getItem("privileges").toLocaleLowerCase() != "technician"){
      document.getElementById("rectRow").hidden = false
    }
  }else{
    if(t.rectify == "1"){
      document.getElementById("rectNote").hidden = false
    }
    if(parseInt(t.user_id) == parseInt(localStorage.getItem("userid")) || utTaskBudyList.find(u => u.id == parseInt(localStorage.getItem("userid"))) ||localStorage.getItem("privileges").toLocaleLowerCase() != "technician"){
      document.getElementById("utsRow").hidden = false
    }else{
      document.getElementById("utsRow").hidden = true
    }
    document.getElementById("rectRow").hidden = true
  }

  if(parseInt(t.user_id) == parseInt(localStorage.getItem("userid")) || localStorage.getItem("privileges").toLocaleLowerCase() != "technician"){
    if(t.status != "done"){
      document.getElementById("reassignTaskSection").hidden = false
      document.getElementById("currentlyWithSection").hidden = true
    }else{
      document.getElementById("reassignTaskSection").hidden = true
      document.getElementById("currentlyWithSection").hidden = false
    }
  }else{
    document.getElementById("reassignTaskSection").hidden = true
    document.getElementById("currentlyWithSection").hidden = false
  }

  if(localStorage.getItem("privileges") == "Technician"){
    let utManageBtn = document.getElementsByClassName("utManageBtn")
    if(parseInt(localStorage.getItem("userid")) == t.user_id){
      for (let i = 0; i < utManageBtn.length; i++) {
        utManageBtn[i].hidden = false;
        utManageBtn[i].classList.add("project-icon-btn")
      }
    }else{
      for (let i = 0; i < utManageBtn.length; i++) {
        utManageBtn[i].hidden = true;
        utManageBtn[i].classList.remove("project-icon-btn")
      }
    }
  }else{
      let utManageBtn = document.getElementsByClassName("utManageBtn")
      for (let i = 0; i < utManageBtn.length; i++) {
        utManageBtn[i].hidden = false;
        utManageBtn[i].classList.add("project-icon-btn")
      }
  }


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
  renderDrawerComments(t);
  document.getElementById('taskDeleteConfirmSection').style.display = 'none';

  const info = resolveAssignee(t.user_id);
  drawerAssigneeID = t.user_id
  document.getElementById('dAssignedTo').textContent = info.name;
  document.getElementById('dAssigneeAvatar').textContent = info.initials;
  document.getElementById('dAssigneeAvatar').style.background = info.color;
  document.getElementById('dAssigneeName').textContent = info.name;

  document.getElementById('dAssigneeAvatar_').textContent = info.initials;
  document.getElementById('dAssigneeAvatar_').style.background = info.color;
  document.getElementById('dAssigneeName_').textContent = info.name;

  renderUtTaskBudyListDrawer();

  const assignedUser = USERS.find(u => u.id === t.user_id);
  const dept = assignedUser ? DEPARTMENTS.find(d => d.id === assignedUser.dept_id) : null;
  document.getElementById('dDept').textContent = dept ? dept.name : 'Unassigned';

  const select = document.getElementById('reassignSelect');
  select.innerHTML = '<option value="">Choose a technician…</option>' +
    assignableUsers().filter(m=>m.id!==t.user_id).map(m=>`<option value="${m.id}">${localStorage.getItem("userid") == m.id ? "Yourself" :fullName(m)}</option>`).join('');
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
document.getElementById('closeDrawer').addEventListener('click', closeDrawer);
document.getElementById('overlay').addEventListener('click', closeDrawer);

function postComment(){
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t) return;

  const input = document.getElementById('commentInput');
  const text = input.value.trim();
  if(!text) return;

  const sendBtn = document.getElementById('commentSendBtn');
  sendBtn.disabled = true;

  sole.post("../../controllers/main/create_comment.php", {
    task_id: t.id,
    comment_text: text
  }).then(res => {
    sendBtn.disabled = false;

    if(!res.status){
      ss.toast(null, res.type, res.message || 'Could not post comment.', null, "#1B2A22");
      return;
    }

    input.value = '';
    fetchTasks().then(() => openDrawer(currentDrawerTaskId)); // re-render drawer with the new comment included
  }).catch(err => {
    sendBtn.disabled = false;
    ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
    console.error(err);
  });
}
document.getElementById('commentSendBtn').addEventListener('click', postComment);
document.getElementById('commentInput').addEventListener('keydown', e=>{
  if(e.key === 'Enter'){ e.preventDefault(); postComment(); }
});

function updateTaskStatusOnServer(taskId, newStatus){
  return sole.post("../../controllers/main/update_status.php", {
    id: taskId,
    status: newStatus
  });
}

document.querySelectorAll('.status-opt').forEach(opt=>{
  opt.addEventListener('click', ()=>{
    const t = TASKS.find(x=>x.id===currentDrawerTaskId);
    if(!t) return;
    const newStatus = opt.dataset.status;
    if(newStatus === t.status) return; // no-op, nothing changed

    document.querySelectorAll('.status-opt').forEach(o=>o.disabled = true);

    sole.post("../../controllers/main/update_status.php", {
      id: t.id,
      status: newStatus
    }).then(res => {
      document.querySelectorAll('.status-opt').forEach(o=>o.disabled = false);

      if(!res.status){
        ss.toast(null, res.type, res.message || 'Could not update status.', null, "#1B2A22");
        return;
      }

      ss.toast(null, res.type, res.message, null, "#1B2A22");
      fetchTasks().then(() => openDrawer(currentDrawerTaskId)); // wait for fresh data before re-rendering the drawer
    }).catch(err => {
      document.querySelectorAll('.status-opt').forEach(o=>o.disabled = false);
      ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
      console.error(err);
    });
  });
});

if(localStorage.getItem("privileges") === null){
  window.location.replace("../../")
}else{
  if(localStorage.getItem("privileges").toLocaleLowerCase() != window.location.href.split("/").pop() || localStorage.getItem("auth") === null){
    window.location.replace("../../")
  }  
}


document.getElementById('checklistBox').addEventListener('change', e=>{
  const cb = e.target.closest('input[type=checkbox]');
  if(!cb) return;
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t || !t.checklistItems) return;
  const idx = parseInt(cb.dataset.idx);
  const item = t.checklistItems[idx];
  if(!item) return;

  const newDone = cb.checked;

  // Reflect immediately, no rollback
  item.done = newDone;
  t.checklist = [t.checklistItems.filter(i=>i.done).length, t.checklistItems.length];
  cb.closest('.checklist-item').classList.toggle('checked', newDone);
  document.getElementById('checklistTitle').textContent = `Checklist — ${t.checklist[0]} of ${t.checklist[1]}`;
  renderList();
  renderKanban();

  cb.disabled = true;
  sole.post("../../controllers/main/update_checklist_item.php", {
    id: item.id,
    is_done: newDone ? "1" : "0"
  }).then(res => {
    cb.disabled = false;

    if(!res.status){
      ss.toast(null, res.type, res.message || 'Could not update checklist item.', null, "#1B2A22");
      return;
    }
  }).catch(err => {
    cb.disabled = false;
    ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
    console.error(err);
  });
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
    errorEl.innerText = "Pick a technician before reassigning this task."
    errorEl.classList.add('show');
    return;
  }

  if(!noteEl.value){
    errorEl.innerText = "Please add a reassignment reason."
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const reassignBtn = document.getElementById('reassignBtn');
  reassignBtn.disabled = true;

  sole.post("../../controllers/main/reassign_task.php", {
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

    const avatarEl_ = document.getElementById('dAssigneeAvatar_');
    avatarEl_.textContent = info.initials;
    avatarEl_.style.background = info.color;
    document.getElementById('dAssigneeName_').textContent = info.name;

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
let ntTaskBudyList = [];
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

function renderNtTaskBudyList(){
  const box = document.getElementById('ntBudyList');
  if(!ntTaskBudyList.length){
    box.innerHTML = `<div class="nt-empty-hint">No budy yet — select task budy.</div>`;
    return;
  }
  box.innerHTML = ntTaskBudyList.map(user =>`
    <div class="nt-list-item">
      <span>${user.name}</span>
      <button type="button" data-remove-budylist="${user.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
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

function addTaskBudy(){
  const select = document.getElementById('ntTaskBudy');
  if(select.value == "-") return;
  const id = parseInt(select.value.trim());
  const name = select.selectedOptions[0].innerText
  if(id == "-" || id == parseInt(ntAssignee.value)) return;
  if(!ntTaskBudyList.find(u => u.id === id)){
    ntTaskBudyList.push({id:id,name:name})
  }
  select.value = "-";
  renderNtTaskBudyList();
  select.focus();
}
document.getElementById('ntChecklistAdd').addEventListener('click', addNtChecklistItem);
document.getElementById('ntTaskBudy').addEventListener('change', addTaskBudy);
document.getElementById('ntChecklistInput').addEventListener('keydown', e=>{
  if(e.key==='Enter'){ e.preventDefault(); addNtChecklistItem(); }
});
document.getElementById('ntChecklistList').addEventListener('click', e=>{
  const btn = e.target.closest('[data-remove-checklist]');
  if(!btn) return;
  ntChecklistItems.splice(parseInt(btn.dataset.removeChecklist), 1);
  renderNtChecklist();
});

document.getElementById('ntBudyList').addEventListener('click', e=>{
  const btn = e.target.closest('[data-remove-budylist]');
  if(!btn) return;
  ntTaskBudyList = ntTaskBudyList.filter(u => u.id !== parseInt(btn.dataset.removeBudylist))
  renderNtTaskBudyList();
});

document.getElementById('ntFileInput').addEventListener('change', e=>{
  Array.from(e.target.files).forEach(f=>{
    ntAttachments.push({name:f.name, size:formatFileSize(f.size), file:f});
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
  assigneeSelect.innerHTML = '<option value="-">-- Select Technician --</option>'+assignableUsers().map(m=>`<option value="${m.id}">${localStorage.getItem("userid") == m.id ? "Yourself" : m.fname + " " + m.lname}</option>`).join('');
  
  assigneeSelect.addEventListener("change", ()=> {
    if(assigneeSelect.value == "-") return;
    id = parseInt(assigneeSelect.value);
    ntTaskBudyList = ntTaskBudyList.filter(user => user.id !== id);
    renderNtTaskBudyList();
  })
  
  const taskBudySelect = document.getElementById('ntTaskBudy');
  taskBudySelect.innerHTML = '<option value="-">-- Select Technician --</option>'+assignableUsers().map(m=>`<option value="${m.id}">${localStorage.getItem("userid") == m.id ? "Yourself" : m.fname + " " + m.lname}</option>`).join('');

  ntChecklistItems = [];
  ntTaskBudyList = [];
  ntAttachments = [];
  renderNtChecklist();
  renderNtTaskBudyList();
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

  const desc = document.getElementById('ntDesc').value.trim() || 'No description provided.';
  const projectId = document.getElementById('ntProject').value;
  const priority = document.querySelector('.priority-opt.sel').dataset.p;
  const startRaw = document.getElementById('ntStart').value;
  const dueRaw = document.getElementById('ntDue').value;

  if(!title){
    errorEl.textContent = 'Please add a title before creating the task.';
    errorEl.classList.add('show');
    return;
  }

  if(!startRaw){
    errorEl.textContent = 'Please select a start date before creating the task.';
    errorEl.classList.add('show');
    return;
  }

  if(!dueRaw){
    errorEl.textContent = 'Please select a due date before creating the task.';
    errorEl.classList.add('show');
    return;
  }

  errorEl.classList.remove('show');

  const formData = new FormData();
  formData.append('title', title);
  formData.append('description', desc ? desc : "-");
  formData.append('project_id', projectId);
  formData.append('user_id', assignee);
  formData.append('priority', priority);
  formData.append('status', 'todo');
  formData.append('task_budy', ntTaskBudyList.map(user => user.id).join('|'));
  formData.append('start_date', startRaw);
  formData.append('due_date', dueRaw);
  formData.append('checklist', JSON.stringify(ntChecklistItems));
  ntAttachments.forEach(a=>{
    if(a.file) formData.append('attachments[]', a.file, a.name);
  });

  const createBtn = document.getElementById('modalCreate');
  createBtn.disabled = true;

  sole.file("../../controllers/main/create_task.php", formData).then(res => {
    createBtn.disabled = false;
    if(!res.status){
      errorEl.textContent = res.message || 'Something went wrong creating the task.';
      errorEl.classList.add('show');
      return;
    }

    ss.toast(null, res.type, res.message, null, "#1B2A22");
    closeModal();
    fetchTasks();
  }).catch(err => {
    createBtn.disabled = false;
    errorEl.textContent = 'Could not reach the server. Please try again.';
    errorEl.classList.add('show');
    console.error(err);
  });
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
  renderProjectManageList();
  populateNtProjectOptions();
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
    const dept = (p.dept_id && p.dept_id !== '-') ? DEPARTMENTS.find(d=>d.id===p.dept_id) : null;
    const deptLabel = dept ? dept.name : 'Unassigned';
    if(pmDeleteConfirmId === p.id){
      return `
      <div class="project-row">
        <div class="project-delete-row">
          Delete "${p.name}"? ${count ? `This will permanently delete ${count} task${count===1?'':'s'}, along with all their checklist, attachments and comments. This cannot be undone.` : 'This cannot be undone.'}
          <button type="button" class="project-delete-confirm-btn" data-confirm-delete="${p.id}">Delete</button>
          <button type="button" class="project-delete-cancel-btn" data-cancel-delete="${p.id}">Cancel</button>
        </div>
      </div>`;
    }
    return `
    <div class="project-row">
      <span class="project-dot" style="background:${p.color};"></span>
      <div class="project-row-name"><div>${p.name}</div><div class="project-row-dept">${deptLabel}</div></div>
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
    document.getElementById('pmDept').value = p.dept_id || '-';
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
    confirmBtn.disabled = true;

    sole.post("../../controllers/main/delete_project.php", { id: id })
      .then(res => {
        confirmBtn.disabled = false;

        if(!res.status){
          ss.toast(null, res.type, res.message, null, "#1B2A22");
          return;
        }

        ss.toast(null, res.type, res.message, null, "#1B2A22");
        pmDeleteConfirmId = null;
        if(pmEditingId===id) resetProjectForm();

        fetchProjects();
        fetchTasks();
      })
      .catch(err => {
        confirmBtn.disabled = false;
        ss.toast(null, "error", "Could not reach the server. Please try again.", null, "#1B2A22");
        console.error(err);
      });
  }
});

function resetProjectForm(){
  pmEditingId = null;
  pmSelectedColor = randomPaletteColor();
  document.getElementById('pmName').value = '';
  document.getElementById('pmDept').value = '-';
  document.getElementById('pmFormLabel').textContent = 'New project';
  document.getElementById('pmSave').textContent = 'Add project';
  document.getElementById('pmCancelEdit').style.display = 'none';
  document.getElementById('pmError').classList.remove('show');
  renderColorSwatches();
}
document.getElementById('pmCancelEdit').addEventListener('click', resetProjectForm);

document.getElementById('pmSave').addEventListener('click', ()=>{
  const name = document.getElementById('pmName').value.trim();
  const deptId = document.getElementById('pmDept').value;
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

  const saveBtn = document.getElementById('pmSave');

  if(pmEditingId){
    saveBtn.disabled = true;

    sole.post("../../controllers/main/update_project.php", {
      id: pmEditingId,
      project_name: name,
      color: pmSelectedColor,
      dept_id: deptId
    }).then(res => {
      saveBtn.disabled = false;

      if(!res.status){
        errorEl.textContent = res.message || 'Something went wrong updating the project.';
        errorEl.classList.add('show');
        return;
      }

      ss.toast(null, res.type, res.message, null, "#1B2A22");
      resetProjectForm();
      fetchProjects();
      fetchTasks();
    }).catch(err => {
      saveBtn.disabled = false;
      errorEl.textContent = 'Could not reach the server. Please try again.';
      errorEl.classList.add('show');
      console.error(err);
    });
    return;
  }

  saveBtn.disabled = true;

  sole.post("../../controllers/main/create_project.php", {
    project_name: name,
    color: pmSelectedColor,
    dept_id: deptId
  }).then(res => {
    saveBtn.disabled = false;

    if(!res.status){
      errorEl.textContent = res.message || 'Something went wrong saving the project.';
      errorEl.classList.add('show');
      return;
    }

    ss.toast(null, res.type, res.message, null, "#1B2A22");
    resetProjectForm();
    fetchProjects();
  }).catch(err => {
    saveBtn.disabled = false;
    errorEl.textContent = 'Could not reach the server. Please try again.';
    errorEl.classList.add('show');
    console.error(err);
  });
});

function openProjectModal(){
  pmDeleteConfirmId = null;
  populatePmDeptOptions();
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
  sel.innerHTML = '<option value="-">-- Select Project --</option>' +
    PROJECTS.map(p=>`<option value="${p.id}">${p.name}</option>`).join('');
  if(PROJECTS.some(p=>String(p.id)===String(current))) sel.value = current;
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
    const count_projects = PROJECTS.filter(p=>p.dept_id===d.id).length;
    if(dmDeleteConfirmId === d.id){
      const parts = [];
      if(count) parts.push(`${count} user${count===1?'':'s'}`);
      if(count_projects) parts.push(`${count_projects} project${count_projects===1?'':'s'}`);
      const warning = parts.length ? `${parts.join(' and ')} will move to "Unassigned."` : '';
      return `
      <div class="project-row">
        <div class="project-delete-row">
          Delete "${d.name}"? ${warning}
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
      <span class="project-row-count">${count_projects} project${count_projects===1?'':'s'}</span>
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
    confirmBtn.disabled = true;

    sole.post("../../controllers/main/delete_department.php", { id : id })
      .then(res => {
        confirmBtn.disabled = false;

        if(!res.status){
          ss.toast(null, res.type, res.message, null, "#1B2A22");
          return;
        }

        ss.toast(null, res.type, res.message, null, "#1B2A22");
        dmDeleteConfirmId = null;
        if(dmEditingId===id) resetDeptForm();
        fetchDepartments();
        fetchUsers();
      })
  }
});

function resetDeptForm(){
  dmEditingId = null;
  dmSelectedColor = randomPaletteColor();
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
    sole.post("../../controllers/main/update_department.php", {
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

  sole.post("../../controllers/main/create_department.php", {
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
  populatePmDeptOptions();
  renderUserList();
  renderDeptManageList();
  updateAdminStats();
}

function fetchDepartments(){   // <-- paste the new function here
  return sole.post("../../controllers/main/get_departments.php", {
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
  return sole.get("../../controllers/main/get_users.php")
    .then(res => {
      USERS.length = 0;
      res.forEach(u => {
        USERS.push({
          id: u.id,
          fname: u.fname,
          lname: u.lname,
          fullname: `${u.fname} ${u.lname}`,
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
    DEPARTMENTS.map(d=>`<option value="${d.id}">${d.name}</option>`).join('');
  if(current && (current==='all' || DEPARTMENTS.some(d=>String(d.id)===String(current)))) sel.value = current;
}
function populatePmDeptOptions(){
  const sel = document.getElementById('pmDept');
  if(!sel) return;
  const current = sel.value;
  sel.innerHTML = '<option value="-">-- Select Department --</option>' +
    DEPARTMENTS.map(d=>`<option value="${d.id}">${d.name}</option>`).join('');
  if(DEPARTMENTS.some(d=>String(d.id)===String(current))) sel.value = current;
}

function populateUmDeptOptions(){
  const sel = document.getElementById('umDept');
  if(!sel) return;
  const current = sel.value;
  sel.innerHTML = '<option value="-">-- Select Department --</option>' +
    DEPARTMENTS.map(d=>`<option value="${d.id}">${d.name}</option>`).join('');
  if(DEPARTMENTS.some(d=>String(d.id)===String(current))) sel.value = current;
}

// ---------------- Users (create / edit / delete / assign department) ----------------
const userModalOverlay = document.getElementById('userModalOverlay');
let umEditingId = null;
let userEdit = null;
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
      (activeDeptFilter==='all' || String(u.dept_id)===String(activeDeptFilter)) &&
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
      ${u.role == "Administrator" && u.id != localStorage.getItem("userid") ? `<span class="nt-empty-hint" style="color: var(--red);">⚠ You do not have permision to edit the account.</span>` : `
        <div class="user-actions">
          <button type="button" class="project-icon-btn" data-edit-user="${u.id}" aria-label="Edit user"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5z"/></svg></button>
          ${localStorage.getItem("userid") == u.id ? "" : `<button type="button" class="project-icon-btn danger" data-delete-user="${u.id}" aria-label="Delete user"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg></button>`}
        </div>
      `}
      
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

    sole.post("../../controllers/main/delete_user.php", { id : id })
      .then(res => {
        confirmBtn.disabled = false;

        if(!res.status){
          ss.toast(null, res.type, res.message, null, "#1B2A22");
          return;
        }

        ss.toast(null, res.type, res.message, null, "#1B2A22");
        userDeleteConfirmId = null;
        fetchUsers();
        fetchTasks();
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
    userEdit = USERS.find(x=>x.id===umEditingId);
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
    document.getElementById('umDept').value = '-';
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
    if(userEdit.role == "Administrator" && role != userEdit.role){
      Swal.fire({
          title: `Administrative privileges will be removed.`,
          text: `Please note that you cannot change your role back to an administrator. Ask your system administrator or developer to update your permissions.`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          confirmButtonText: "Confirm",
          customClass: {
              popup: 'my-custom-popup',
              actions: 'my-right-buttons'
          }
      }).then((result) => {
        if (result.isConfirmed){
          sole.post("../../controllers/main/update_user.php", {
            id: umEditingId,
            fname,
            lname,
            privileges: role,
            dept_id: department,
            status: umSelectedStatus
          }).then(res => {
            saveBtn.disabled = false;
            localStorage.setItem("privileges",role)
            setTimeout(() => {
              window.location.reload()
            }, 3000);

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
        }else{
          saveBtn.disabled = false;
        }
      });
    }else{
      sole.post("../../controllers/main/update_user.php", {
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
    }
    
    return;
  }

  sole.post("../../controllers/main/create_user.php", {
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
function updateGreetingDate(){
  const today = new Date();
  const formatted = today.toLocaleDateString('en-US', {weekday:'short', month:'short', day:'numeric'});
  document.getElementById('greetDate').textContent = '— ' + formatted;
}

if(localStorage.getItem("greet") !== null){
  ss.toast(`Welcome  ${localStorage.getItem("fname")} ${localStorage.getItem("lname")}`, "success", null, null, "#1B2A22");
  localStorage.removeItem("greet")
}

document.getElementById("greetings").innerText = `Hello, ${localStorage.getItem("fname")} ${localStorage.getItem("lname")}.`
document.getElementById("sbfavatar").innerText = localStorage.getItem("avatar")
document.getElementById("sbfname").innerText = `${localStorage.getItem("fname")} ${localStorage.getItem("lname")}`

const savedView = localStorage.getItem(VIEW_STORAGE_KEY);
if(savedView) activateView(savedView);

renderProjectNav();
fetchProjects();
fetchDepartments();
fetchUsers();
fetchTasks();
renderUserList();
renderWorkload();
renderList();
renderKanban();
updateAdminStats();
updateGreetingDate();


const show_tech = document.getElementsByClassName("show_tech");
const show_sup = document.getElementsByClassName("show_sup");

if(localStorage.getItem("privileges").toLocaleLowerCase() == "administrator"){
  for (let i = 0; i < show_tech.length; i++) {
    show_tech[i].removeAttribute("style")
  }
  for (let i = 0; i < show_sup.length; i++) {
    show_sup[i].removeAttribute("style")
  }
}

if(localStorage.getItem("privileges").toLocaleLowerCase() == "supervisor"){
  for (let i = 0; i < show_sup.length; i++) {
    show_sup[i].removeAttribute("style")
  }
}

const sidebarFootEl = document.getElementById('sidebarFoot');
const sidebarFootMenuEl = document.getElementById('sidebarFootMenu');

sidebarFootEl.addEventListener('click', (e)=>{
  e.stopPropagation();
  sidebarFootEl.classList.toggle('open');
});
document.addEventListener('click', (e)=>{
  if(!sidebarFootEl.contains(e.target)){
    sidebarFootEl.classList.remove('open');
  }
});

document.getElementById('sidebarSignOutBtn').addEventListener('click', (e)=>{
  e.stopPropagation();
  window.location.replace('../../');
});

document.getElementById('sidebarSettingsBtn').addEventListener('click', (e)=>{
  e.stopPropagation();
  sidebarFootEl.classList.remove('open');
  ss.toast(null, 'info', 'Settings page is not available yet.', null, '#1B2A22');
});
document.getElementById('sidebarLogsBtn').addEventListener('click', (e)=>{
  e.stopPropagation();
  sidebarFootEl.classList.remove('open');
  ss.toast(null, 'info', 'Activity logs are not available yet.', null, '#1B2A22');
});
