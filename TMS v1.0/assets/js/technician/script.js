// ---------------- Mock data (would come from PHP/MySQL via fetch()) ----------------
const CURRENT_USER = "Paul Ian Dumdum";
const TEAM_MEMBERS = [
  {name:"Priya Shah", initials:"PS", color:"linear-gradient(155deg,#3B6FA0,#2F5578)"},
  {name:"Marcus Lin", initials:"ML", color:"linear-gradient(155deg,#2F6F5E,#1F5647)"},
  {name:"Elena Cruz", initials:"EC", color:"linear-gradient(155deg,#C98A2E,#B75B39)"},
  {name:"Noah Bennett", initials:"NB", color:"linear-gradient(155deg,#8A6FB0,#6A4F90)"},
];
function memberInfo(name){
  if(name===CURRENT_USER) return {name:CURRENT_USER, initials:"PD", color:"linear-gradient(155deg,#C98A2E,#B75B39)"};
  return TEAM_MEMBERS.find(m=>m.name===name) || {name, initials:name.split(' ').map(w=>w[0]).join(''), color:"var(--ink-soft)"};
}

const TASKS = [
  {id:1, title:"Redesign the pricing page layout", desc:"Rework the pricing section to reflect the new three-tier structure with the annual/monthly toggle.", project:"Website Revamp", priority:"high", status:"progress", due:"Jul 24", overdue:false, dueSoon:true, checklist:[2,4], comments:2, files:2, assignedBy:"Priya Shah", assignee:CURRENT_USER},
  {id:2, title:"Fix broken checkout link on mobile", desc:"Checkout CTA is unresponsive on iOS Safari below 390px width.", project:"Website Revamp", priority:"critical", status:"todo", due:"Jul 22", overdue:true, dueSoon:false, checklist:[0,2], comments:0, files:1, assignedBy:"Priya Shah", assignee:CURRENT_USER},
  {id:3, title:"Write onboarding welcome email", desc:"Draft the first email in the new-client welcome sequence.", project:"Client Onboarding", priority:"medium", status:"todo", due:"Jul 25", overdue:false, dueSoon:true, checklist:[0,3], comments:1, files:0, assignedBy:"Marcus Lin", assignee:CURRENT_USER},
  {id:4, title:"Prepare Q3 social content calendar", desc:"Map out August–September posts across channels.", project:"Q3 Marketing", priority:"medium", status:"hold", due:"Jul 30", overdue:false, dueSoon:false, checklist:[1,6], comments:3, files:1, assignedBy:"Priya Shah", assignee:CURRENT_USER},
  {id:5, title:"Tag and organize client asset library", desc:"Standardize folder naming across shared drive.", project:"Client Onboarding", priority:"low", status:"done", due:"Jul 15", overdue:false, dueSoon:false, checklist:[4,4], comments:0, files:0, assignedBy:"Marcus Lin", assignee:CURRENT_USER},
  {id:6, title:"User-test new nav on 5 participants", desc:"Run moderated sessions and log findings in Notion.", project:"Website Revamp", priority:"high", status:"progress", due:"Jul 27", overdue:false, dueSoon:false, checklist:[1,5], comments:1, files:0, assignedBy:"Priya Shah", assignee:CURRENT_USER},
];

const STATUS_LABEL = {todo:"To Do", progress:"In Progress", hold:"On Hold", done:"Completed"};
const STATUS_CLASS = {todo:"status-todo", progress:"status-progress", hold:"status-hold", done:"status-done"};

let activeFilter = "all";

function iconClock(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>'; }
function iconCheck(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>'; }
function iconComment(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>'; }
function iconClip(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a5 5 0 01-7.07-7.07l9.19-9.19a3.5 3.5 0 014.95 4.95l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>'; }

function iconArrowRight(){ return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>'; }

function renderTicket(t){
  const pct = Math.round((t.checklist[0]/t.checklist[1])*100);
  const turnedOver = t.assignee !== CURRENT_USER;
  return `
  <div class="ticket" onclick="openDrawer(${t.id})">
    <div class="ticket-stub"><input type="checkbox" ${t.status==='done'?'checked':''} onclick="event.stopPropagation()"></div>
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
        <span class="status-tag ${STATUS_CLASS[t.status]}">${STATUS_LABEL[t.status]}</span>
        <span class="meta-item ${t.overdue?'overdue':(t.dueSoon?'due-soon':'')}">${iconClock()} Due ${t.due}</span>
        <span class="meta-item checklist-progress">${iconCheck()} ${t.checklist[0]}/${t.checklist[1]}
          <span class="bar-track"><span class="bar-fill" style="width:${pct}%"></span></span>
        </span>
        ${t.comments ? `<span class="meta-item">${iconComment()} ${t.comments}</span>` : ''}
        ${t.files ? `<span class="meta-item">${iconClip()} ${t.files}</span>` : ''}
        ${turnedOver ? `<span class="assignee-tag">${iconArrowRight()} With ${t.assignee}</span>` : ''}
      </div>
    </div>
  </div>`;
}

function renderList(){
  const list = document.getElementById('ticketList');
  const q = document.getElementById('searchInput').value.toLowerCase();
  const filtered = TASKS.filter(t => (activeFilter==='all' || t.status===activeFilter) &&
    (t.title.toLowerCase().includes(q) || t.project.toLowerCase().includes(q)));
  list.innerHTML = filtered.length ? filtered.map(renderTicket).join('') :
    `<div style="text-align:center;padding:50px 0;color:var(--ink-faint);font-size:13px;">No tasks match this filter.</div>`;
}

document.querySelectorAll('.chip').forEach(c=>{
  c.addEventListener('click', ()=>{
    document.querySelectorAll('.chip').forEach(x=>x.classList.remove('active'));
    c.classList.add('active');
    activeFilter = c.dataset.filter;
    renderList();
  });
});
document.getElementById('searchInput').addEventListener('input', renderList);

// ---------------- View switching ----------------
document.querySelectorAll('.view-tab').forEach(tab=>{
  tab.addEventListener('click', ()=>{
    document.querySelectorAll('.view-tab').forEach(t=>t.classList.remove('active'));
    tab.classList.add('active');
    document.querySelectorAll('.panel').forEach(p=>p.classList.remove('active'));
    document.getElementById('panel-'+tab.dataset.view).classList.add('active');
  });
});

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
        return `
        <div class="kcard" draggable="true" data-id="${t.id}">
          <div onclick="openDrawer(${t.id})">
            <div class="kcard-top"><span class="stamp ${t.priority}">${t.priority}</span></div>
            <div class="kcard-proj">${t.project}</div>
            <div class="kcard-title">${t.title}</div>
            ${t.assignee!==CURRENT_USER ? `<span class="assignee-tag" style="margin-top:6px;">${iconArrowRight()} With ${t.assignee}</span>` : ''}
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

function openDrawer(id){
  currentDrawerTaskId = id;
  const t = TASKS.find(x=>x.id===id) || TASKS[0];
  document.getElementById('dProj').textContent = t.project;
  document.getElementById('dTitle').textContent = t.title;
  document.getElementById('dDesc').textContent = t.desc;
  const pEl = document.getElementById('dPriority');
  pEl.textContent = t.priority;
  pEl.className = 'stamp ' + t.priority;
  const sEl = document.getElementById('dStatusTag');
  sEl.textContent = STATUS_LABEL[t.status];
  sEl.className = 'status-tag ' + STATUS_CLASS[t.status];
  document.querySelectorAll('.status-opt').forEach(o=>{
    o.classList.toggle('sel', o.dataset.status===t.status);
  });

  document.getElementById('dAssignedBy').textContent = t.assignedBy;
  document.getElementById('dAssignedTo').textContent = t.assignee;

  const info = memberInfo(t.assignee);
  const avatarEl = document.getElementById('dAssigneeAvatar');
  avatarEl.textContent = info.initials;
  avatarEl.style.background = info.color;
  document.getElementById('dAssigneeName').textContent = t.assignee===CURRENT_USER ? `${t.assignee} (you)` : t.assignee;

  const select = document.getElementById('turnoverSelect');
  select.innerHTML = '<option value="">Choose a team member…</option>' +
    TEAM_MEMBERS.filter(m=>m.name!==t.assignee).map(m=>`<option value="${m.name}">${m.name}</option>`).join('');
  document.getElementById('turnoverReason').value = '';
  document.getElementById('turnoverError').classList.remove('show');
  document.getElementById('turnoverConfirm').classList.remove('show');
  document.getElementById('turnoverBtn').disabled = false;

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
    const label = opt.textContent;
    const sEl = document.getElementById('dStatusTag');
    sEl.textContent = label;
    sEl.className = 'status-tag ' + STATUS_CLASS[opt.dataset.status];
  });
});

document.querySelectorAll('.checklist-item input').forEach(cb=>{
  cb.addEventListener('change', ()=>{
    cb.closest('.checklist-item').classList.toggle('checked', cb.checked);
  });
});

// ---------------- Turn over task ----------------
function turnOverTask(){
  const t = TASKS.find(x=>x.id===currentDrawerTaskId);
  if(!t) return;
  const select = document.getElementById('turnoverSelect');
  const reasonEl = document.getElementById('turnoverReason');
  const errorEl = document.getElementById('turnoverError');
  const newAssignee = select.value;
  const reason = reasonEl.value.trim();

  if(!newAssignee || !reason){
    errorEl.classList.add('show');
    return;
  }
  errorEl.classList.remove('show');

  const previousAssignee = t.assignee;
  t.assignee = newAssignee;
  t.turnoverHistory = t.turnoverHistory || [];
  t.turnoverHistory.push({from:previousAssignee, to:newAssignee, reason, when:'Just now'});

  // Reflect the handoff as an activity comment so the whole team can see why it moved
  t.comments = (t.comments || 0) + 1;

  document.getElementById('dAssignedTo').textContent = t.assignee;
  const info = memberInfo(t.assignee);
  const avatarEl = document.getElementById('dAssigneeAvatar');
  avatarEl.textContent = info.initials;
  avatarEl.style.background = info.color;
  document.getElementById('dAssigneeName').textContent = t.assignee===CURRENT_USER ? `${t.assignee} (you)` : t.assignee;

  select.innerHTML = '<option value="">Choose a team member…</option>' +
    TEAM_MEMBERS.filter(m=>m.name!==t.assignee).map(m=>`<option value="${m.name}">${m.name}</option>`).join('');
  reasonEl.value = '';

  const confirmEl = document.getElementById('turnoverConfirm');
  document.getElementById('turnoverConfirmText').textContent = `Turned over to ${newAssignee}.`;
  confirmEl.classList.add('show');

  renderList();
  renderKanban();
}
document.getElementById('turnoverBtn').addEventListener('click', turnOverTask);
document.getElementById('turnoverSelect').addEventListener('change', ()=>document.getElementById('turnoverError').classList.remove('show'));
document.getElementById('turnoverReason').addEventListener('input', ()=>document.getElementById('turnoverError').classList.remove('show'));

// ---------------- Init ----------------
renderList();
renderKanban();