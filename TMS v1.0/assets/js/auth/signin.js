document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.toggleFor);
        const isPw = input.type === 'password';
        input.type = isPw ? 'text' : 'password';
        btn.setAttribute('aria-label', isPw ? 'Hide password' : 'Show password');
        btn.innerHTML = isPw ?
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a21.8 21.8 0 015.06-6.06M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.8 21.8 0 01-3.22 4.34M14.12 14.12a3 3 0 11-4.24-4.24"/><path d="M1 1l22 22"/></svg>' :
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>';
    });
});

document.getElementById('forgotLink').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('formErrorText').textContent =
        "Password reset isn't wired up in this prototype — it would send a reset link via /api/auth/forgot-password.php.";
    document.getElementById('formSuccess').classList.remove('show');
    document.getElementById('formError').classList.add('show');
});

document.getElementById('signinForm').addEventListener('submit', e => {
    e.preventDefault();
    const user = document.getElementById('siUser').value.trim();
    const pw = document.getElementById('siPassword').value;
    const errEl = document.getElementById('formError');
    const okEl = document.getElementById('formSuccess');

    if (!user || !pw) {
        document.getElementById('formErrorText').textContent = 'Enter your username or email and password.';
        errEl.classList.add('show');
        return;
    }
    errEl.classList.remove('show');

    sole.post("../../controllers/auth/signin.php",{
        userid : user,
        password : pw,
        rem_user : false
    }).then(res => {
        if(res.status){
            localStorage.setItem("greet","enabled")
            localStorage.setItem("fname",res.fname)
            localStorage.setItem("lname",res.lname)
            localStorage.setItem("avatar",res.avatar)
            localStorage.setItem("privileges",res.privileges)
            localStorage.removeItem("activeView")
            window.location.replace("../"+res.privileges.toLowerCase())
        }
        ss.toast(null,res.type,res.message,null,"#1B2A22")
    })
});

// ss.toast(null,"info","Sample",null,"#1B2A22")