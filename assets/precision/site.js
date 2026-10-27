(()=>{'use strict';
const toggle=document.querySelector('.menu-toggle'),nav=document.querySelector('#navigation');
function closeMenu(){nav.classList.remove('open');toggle.setAttribute('aria-expanded','false')}
toggle?.addEventListener('click',()=>{const open=toggle.getAttribute('aria-expanded')!=='true';toggle.setAttribute('aria-expanded',String(open));nav.classList.toggle('open',open)});
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&nav.classList.contains('open')){closeMenu();toggle.focus()}});
document.addEventListener('click',e=>{if(!e.target.closest('.header'))closeMenu()});
nav?.addEventListener('click',e=>{if(e.target.closest('a'))closeMenu()});
matchMedia('(min-width: 801px)').addEventListener('change',e=>{if(e.matches)closeMenu()});
const filters=[...document.querySelectorAll('[data-filter]')],cards=[...document.querySelectorAll('[data-category]')],material=document.querySelector('#material');let category='all';
function filter(){let count=0;for(const card of cards){const show=(category==='all'||card.dataset.category===category)&&(!material||material.value==='all'||material.value===card.dataset.material);card.hidden=!show;if(show)count++}const status=document.querySelector('#result-count');if(status)status.textContent=`${count} ${status.dataset.label}`;const empty=document.querySelector('.empty-results');if(empty)empty.hidden=count!==0}
filters.forEach(button=>button.addEventListener('click',()=>{category=button.dataset.filter;filters.forEach(b=>b.setAttribute('aria-pressed',String(b===button)));filter()}));material?.addEventListener('change',filter);
const form=document.querySelector('#contact-form');form?.addEventListener('submit',event=>{event.preventDefault();if(!form.reportValidity())return;const data=new FormData(form),body=[`${form.querySelector('[name=name]').closest('label').textContent.trim()}: ${data.get('name')}`,`${form.querySelector('[name=company]').closest('label').textContent.trim()}: ${data.get('company')}`,`Email: ${data.get('email')}`,`${data.get('interest')}`,'',data.get('message')].join('\n');const uri=`mailto:info@mcassistance.it?subject=${encodeURIComponent(form.dataset.subject)}&body=${encodeURIComponent(body)}`;const fallback=document.querySelector('#email-fallback');fallback.href=uri;fallback.hidden=false;document.querySelector('#form-status').textContent=document.documentElement.lang==='it'?'Email preparata. Conferma l’invio nel tuo programma di posta. Se non si apre, usa il link qui sotto o scrivi a info@mcassistance.it.':'Email prepared. Confirm sending in your email app. If it does not open, use the link below or write to info@mcassistance.it.';fallback.focus()});
document.querySelector('#load-map')?.addEventListener('click',function(){const frame=document.createElement('iframe');frame.title=this.dataset.title;frame.src='https://maps.google.com/maps?q=M.C.Assistance%20Rovato&t=&z=15&ie=UTF8&iwloc=&output=embed';frame.referrerPolicy='no-referrer';frame.loading='lazy';document.querySelector('#map-container').append(frame);this.closest('.map-placeholder').hidden=true});
// Decorative hero video: no media request under reduced motion or data saving.
const heroVideo=document.querySelector('#hero-video'),heroToggle=document.querySelector('#hero-video-toggle');
if(heroVideo&&heroToggle){
 const motion=matchMedia('(prefers-reduced-motion: reduce)'),connection=navigator.connection;
 let userPaused=motion.matches||Boolean(connection?.saveData),inView=true,loaded=document.readyState==='complete';
 heroVideo.muted=true;heroToggle.hidden=false;
 const label=()=>{heroToggle.textContent=heroVideo.paused?heroToggle.dataset.play:heroToggle.dataset.pause};
 const play=async()=>{if(!loaded||document.hidden||!inView)return;if(!heroVideo.getAttribute('src')){heroVideo.poster=document.querySelector('.hero-img').currentSrc;heroVideo.src=matchMedia('(max-width: 800px)').matches?heroVideo.dataset.mobileSrc:heroVideo.dataset.desktopSrc}try{await heroVideo.play()}catch{label()}};
 heroVideo.addEventListener('playing',()=>{heroVideo.classList.add('is-playing');label()});heroVideo.addEventListener('pause',label);
 heroVideo.addEventListener('error',()=>{heroVideo.classList.remove('is-playing');heroToggle.hidden=true});
 heroToggle.addEventListener('click',()=>{if(heroVideo.paused){userPaused=false;loaded=true;play()}else{userPaused=true;heroVideo.pause()}});
 const sync=()=>{if(userPaused||document.hidden||!inView)heroVideo.pause();else play()};
 document.addEventListener('visibilitychange',sync);
 motion.addEventListener('change',()=>{if(motion.matches){userPaused=true;heroVideo.pause();heroVideo.classList.remove('is-playing')}});
 connection?.addEventListener?.('change',()=>{if(connection.saveData){userPaused=true;heroVideo.pause()}});
 if('IntersectionObserver' in window){new IntersectionObserver(entries=>{inView=entries[0].isIntersecting;sync()},{threshold:.05}).observe(document.querySelector('.hero'))}
 const ready=()=>{loaded=true;if(!userPaused)sync()};if(document.readyState==='complete')ready();else window.addEventListener('load',ready,{once:true});
}
// Load video posters near the viewport; preload=none alone does not defer posters.
const videos=[...document.querySelectorAll('video[data-poster]')];if('IntersectionObserver' in window){const posters=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.poster=entry.target.dataset.poster;posters.unobserve(entry.target)}}),{rootMargin:'200px'});videos.forEach(video=>posters.observe(video))}else{videos.forEach(video=>video.poster=video.dataset.poster)}
// Progressive enhancement: content stays visible if observers are unavailable.
if('IntersectionObserver' in window&&!matchMedia('(prefers-reduced-motion: reduce)').matches){document.documentElement.classList.add('js');const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('visible');observer.unobserve(entry.target)}}),{threshold:.08});document.querySelectorAll('.solution-card,.process-steps,.numbers,.history article').forEach(el=>{el.classList.add('reveal');observer.observe(el)})}
// Preserve useful links from the previous one-page site.
const en=document.documentElement.lang==='en';const legacy={about:en?'company':'azienda',contact:en?'contact':'contatti',team:en?'company':'azienda',trasparenza:en?'transparency':'trasparenza',supportoattrezzatura:en?'solutions':'soluzioni'};const base=document.body.dataset.siteBase||'/';const localPath=location.pathname.slice(base.length-1);if(['/','/index.php','/en/','/en/index.php'].includes(localPath)&&legacy[location.hash.slice(1)])location.replace(base+(en?'en/':'')+legacy[location.hash.slice(1)]+'/');
})();
