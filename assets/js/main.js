document.addEventListener('touchstart',()=>{},{passive:true});
document.addEventListener('DOMContentLoaded',()=>{
const toggle=document.querySelector('[data-nav-toggle]'),closeBtn=document.querySelector('[data-nav-close]'),panel=document.querySelector('[data-nav-panel]'),backdrop=document.querySelector('[data-nav-backdrop]');
const siteHeader=document.querySelector('.site-header');
const openNav=()=>{if(siteHeader)siteHeader.classList.remove('header-hidden');if(panel)panel.classList.add('open');if(backdrop)backdrop.classList.add('is-open');document.body.classList.add('nav-open');document.body.style.overflow='hidden';};
const closeNav=()=>{if(panel)panel.classList.remove('open');if(backdrop)backdrop.classList.remove('is-open');document.body.classList.remove('nav-open');document.body.style.overflow='';};
if(toggle&&panel)toggle.addEventListener('click',()=>{panel.classList.contains('open')?closeNav():openNav();});
if(closeBtn)closeBtn.addEventListener('click',closeNav);
if(backdrop)backdrop.addEventListener('click',closeNav);

if(siteHeader){
	let lastY=window.scrollY;
	const scrollThreshold=8;
	window.addEventListener('scroll',()=>{
		if(panel&&panel.classList.contains('open'))return;
		const y=window.scrollY;
		const delta=y-lastY;
		if(Math.abs(delta)<scrollThreshold)return;
		siteHeader.classList.toggle('header-hidden',delta>0&&y>96);
		lastY=y;
	},{passive:true});
}

const revealEls=document.querySelectorAll('[data-reveal]');
if(revealEls.length){
	const reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if(reduced||!('IntersectionObserver' in window)){
		revealEls.forEach(el=>el.classList.add('is-visible'));
	}else{
		const io=new IntersectionObserver(entries=>{
			entries.forEach(entry=>{
				if(entry.isIntersecting){entry.target.classList.add('is-visible');io.unobserve(entry.target);}
			});
		},{threshold:.15,rootMargin:'0px 0px -60px 0px'});
		revealEls.forEach(el=>{
			const r=el.getBoundingClientRect();
			if(r.top<window.innerHeight&&r.bottom>0)el.classList.add('is-visible');
			else io.observe(el);
		});
		setTimeout(()=>{revealEls.forEach(el=>el.classList.add('is-visible'));io.disconnect();},4000);
	}
}

const tocLinks=document.querySelectorAll('[data-toc] a');
if(tocLinks.length&&'IntersectionObserver' in window){
	const sections=Array.from(tocLinks).map(a=>document.getElementById(a.getAttribute('href').slice(1))).filter(Boolean);
	const tocIsSticky=()=>window.matchMedia('(min-width: 1024px)').matches;
	const tocWrap=document.querySelector('[data-toc-wrap]');
	const tocToggle=document.querySelector('[data-toc-toggle]');
	const tocCurrent=document.querySelector('[data-toc-current]');
	const io=new IntersectionObserver(entries=>{
		entries.forEach(entry=>{
			if(entry.isIntersecting){
				tocLinks.forEach(a=>a.classList.remove('is-active'));
				const link=document.querySelector(`[data-toc] a[href="#${entry.target.id}"]`);
				if(link){
					link.classList.add('is-active');
					if(tocIsSticky())link.scrollIntoView({block:'nearest'});
					if(tocCurrent)tocCurrent.textContent=link.textContent;
				}
			}
		});
	},{rootMargin:'-96px 0px -70% 0px',threshold:0});
	sections.forEach(s=>io.observe(s));

	if(tocWrap&&tocToggle){
		const setTocOpen=open=>{
			tocWrap.setAttribute('data-open',String(open));
			tocToggle.setAttribute('aria-expanded',String(open));
			if(!tocIsSticky()){
				document.body.style.overflow=open?'hidden':'';
				if(open){const header=document.querySelector('.site-header');if(header)header.classList.remove('header-hidden');}
			}
		};
		tocToggle.addEventListener('click',()=>setTocOpen(tocWrap.getAttribute('data-open')!=='true'));
		tocWrap.querySelectorAll('[data-toc-close]').forEach(el=>el.addEventListener('click',()=>setTocOpen(false)));
		document.addEventListener('keydown',e=>{if(e.key==='Escape')setTocOpen(false);});
		tocLinks.forEach(a=>a.addEventListener('click',()=>{if(!tocIsSticky())setTocOpen(false);}));
	}
}

document.querySelectorAll('[data-tabs]').forEach(group=>{
	const btns=group.querySelectorAll('[data-tab]');
	const panels=group.querySelectorAll('[data-tab-panel]');
	btns.forEach(btn=>btn.addEventListener('click',()=>{
		btns.forEach(b=>b.classList.remove('is-active'));
		btn.classList.add('is-active');
		panels.forEach(p=>{p.hidden=p.dataset.tabPanel!==btn.dataset.tab;});
	}));
});

const cForm=document.querySelector('.contact-form');
if(cForm){
	const note=cForm.querySelector('.form-note');
	const emailRe=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	cForm.addEventListener('submit',e=>{
		e.preventDefault();
		let valid=true;
		cForm.querySelectorAll('[data-validate]').forEach(field=>{
			const errEl=field.parentElement.querySelector('.field-error');
			const val=field.value.trim();
			let msg='';
			if(!val){
				msg=field.dataset.errorEmpty||'This field is required.';
			}else if(field.type==='email'&&!emailRe.test(val)){
				msg=field.dataset.errorInvalid||'Please enter a valid email address.';
			}
			field.classList.toggle('is-invalid',!!msg);
			if(errEl){errEl.hidden=!msg;if(msg)errEl.textContent=msg;}
			if(msg)valid=false;
		});
		if(!valid){if(note)note.hidden=true;return;}
		if(note)note.hidden=false;
		cForm.reset();
		cForm.querySelectorAll('.field-error').forEach(el=>el.hidden=true);
		cForm.querySelectorAll('.is-invalid').forEach(el=>el.classList.remove('is-invalid'));
	});
}

const form=document.querySelector('.quote-form');
if(!form)return;
const qNote=form.querySelector('.form-note');
const qError=form.querySelector('.form-error');
const qSubmitBtn=form.querySelector('button[type=submit], button:not([type])');
const qSubmitLabel=qSubmitBtn?qSubmitBtn.textContent:'';
function submitQuoteForm(){
	fetch(form.getAttribute('action'),{method:'POST',headers:typeof NEWTRON_REST!=='undefined'?{'X-WP-Nonce':NEWTRON_REST.nonce}:{},body:new FormData(form)})
		.then(res=>res.json())
		.then(data=>{
			if(data&&data.success){
				if(qNote){
					let msg=(data.data&&data.data.message)||'Thanks - your request has been submitted. Our team will follow up shortly.';
					if(data.data&&data.data.file_warnings&&data.data.file_warnings.length)msg+=' '+data.data.file_warnings.join(' ');
					qNote.querySelector('span').textContent=msg;
					qNote.hidden=false;
				}
				form.reset();
				const fileList=form.querySelector('.upload-file-list');
				if(fileList)fileList.innerHTML='';
				const fileWarning=form.querySelector('.upload-file-warning');
				if(fileWarning)fileWarning.hidden=true;
			}else if(qError){
				qError.textContent=(data&&data.data&&data.data.message)||'Something went wrong. Please check the form and try again.';
				qError.hidden=false;
			}
		})
		.catch(()=>{
			if(qError){qError.textContent='Something went wrong submitting your request. Please try again.';qError.hidden=false;}
		})
		.finally(()=>{if(qSubmitBtn){qSubmitBtn.disabled=false;qSubmitBtn.classList.remove('is-loading');qSubmitBtn.textContent=qSubmitLabel;}});
}
form.addEventListener('submit',e=>{
	e.preventDefault();
	if(qNote)qNote.hidden=true;
	if(qError)qError.hidden=true;
	if(qSubmitBtn){qSubmitBtn.disabled=true;qSubmitBtn.classList.add('is-loading');qSubmitBtn.textContent='Sending...';}
	const tokenField=form.querySelector('.recaptcha-token');
	if(typeof grecaptcha!=='undefined'&&typeof NEWTRON_RECAPTCHA!=='undefined'){
		grecaptcha.ready(()=>{
			grecaptcha.execute(NEWTRON_RECAPTCHA.siteKey,{action:'submit_quote'}).then(token=>{
				if(tokenField)tokenField.value=token;
				submitQuoteForm();
			}).catch(submitQuoteForm);
		});
	}else{
		submitQuoteForm();
	}
});

const STATES=typeof NEWTRON_STATES!=='undefined'?NEWTRON_STATES:{};

const countrySel=form.querySelector('.country-select');
const stateSel=form.querySelector('.state-select');
const stateTxt=form.querySelector('.state-text');

function updateState(){
	const list=STATES[countrySel.value];
	if(list&&Object.keys(list).length){
		stateSel.innerHTML='<option value="">Select a state…</option>'+Object.entries(list).map(([code,name])=>`<option value="${code}">${name}</option>`).join('');
		stateSel.style.display='';stateSel.name='company_state';
		stateTxt.style.display='none';stateTxt.removeAttribute('name');stateTxt.value='';
	}else{
		stateSel.style.display='none';stateSel.removeAttribute('name');stateSel.innerHTML='<option value="">Select a state…</option>';
		stateTxt.style.display='';stateTxt.name='company_state';
	}
}
if(countrySel){countrySel.addEventListener('change',updateState);updateState();}

const box=form.querySelector('.upload-box');
const fileInput=box?box.querySelector('input[type=file]'):null;
const fileList=box?box.querySelector('.upload-file-list'):null;
const fileWarning=box?box.querySelector('.upload-file-warning'):null;
const ALLOWED_EXTS=['step','stp','stl','iges','igs','dxf','dwg','pdf','zip','jpg','jpeg','png','gif','webp'];
if(box&&fileInput){
	const getExt=name=>{const i=name.lastIndexOf('.');return i>-1?name.slice(i+1).toLowerCase():'';};
	const renderFiles=()=>{
		const rejected=[];
		const dt=new DataTransfer();
		Array.from(fileInput.files).forEach(f=>{
			if(ALLOWED_EXTS.includes(getExt(f.name)))dt.items.add(f);
			else rejected.push(f.name);
		});
		fileInput.files=dt.files;
		fileList.innerHTML='';
		Array.from(fileInput.files).forEach(f=>{const li=document.createElement('li');li.textContent=f.name;fileList.appendChild(li);});
		if(fileWarning){
			if(rejected.length){fileWarning.textContent=rejected.join(', ')+' - file type not accepted. Allowed types: '+ALLOWED_EXTS.join(', ').toUpperCase()+'.';fileWarning.hidden=false;}
			else{fileWarning.hidden=true;}
		}
	};
	['dragenter','dragover'].forEach(evt=>box.addEventListener(evt,e=>{e.preventDefault();e.stopPropagation();box.classList.add('is-dragover');}));
	['dragleave','drop'].forEach(evt=>box.addEventListener(evt,e=>{e.preventDefault();e.stopPropagation();box.classList.remove('is-dragover');}));
	box.addEventListener('drop',e=>{fileInput.files=e.dataTransfer.files;renderFiles();});
	box.addEventListener('click',e=>{if(e.target!==fileInput)fileInput.click();});
	fileInput.addEventListener('change',renderFiles);
}
});