document.addEventListener('DOMContentLoaded', ()=>{
const chatForm = document.getElementById('chatForm');
if(chatForm){
chatForm.addEventListener('submit', async (e)=>{
e.preventDefault();
const name = document.getElementById('fromName').value || 'Guest';
const msg = document.getElementById('msgInput').value;
if(!msg) return;


// show quick message in local chatbox
const chatbox = document.getElementById('chatbox');
if(chatbox){
const p = document.createElement('div');
p.textContent = name + ': ' + msg;
chatbox.appendChild(p);
}


// submit to backend
const formData = new FormData(chatForm);
await fetch('save_message.php', { method:'POST', body: formData });
document.getElementById('msgInput').value = '';
});
}
}); 