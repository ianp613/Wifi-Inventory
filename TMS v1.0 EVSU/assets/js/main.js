
const cocOverlay = document.getElementById('cocModalOverlay');
document.getElementById('cocNavItem').addEventListener('click', () => cocOverlay.classList.add('open'));
document.getElementById('cocModalClose').addEventListener('click', () => cocOverlay.classList.remove('open'));
cocOverlay.addEventListener('click', e => { if(e.target === cocOverlay) cocOverlay.classList.remove('open'); });
document.addEventListener('keydown', e => { if(e.key === 'Escape') cocOverlay.classList.remove('open'); });
