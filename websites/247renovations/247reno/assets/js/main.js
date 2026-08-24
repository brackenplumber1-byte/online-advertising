/* 247 Renovations — main.js */

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(function(a){
  a.addEventListener('click',function(e){
    var id=this.getAttribute('href').slice(1);
    if(!id)return;
    var el=document.getElementById(id);
    if(el){
      e.preventDefault();
      var nav=document.querySelector('.site-nav');
      var off=nav?nav.offsetHeight+12:80;
      window.scrollTo({top:el.getBoundingClientRect().top+window.pageYOffset-off,behavior:'smooth'});
    }
  });
});

// Mobile nav with dropdown support
var hb=document.querySelector('.hamburger');
var nm=document.querySelector('.nav-menu');
if(hb&&nm){
  hb.addEventListener('click',function(e){e.stopPropagation();nm.classList.toggle('open');});
  document.addEventListener('click',function(e){if(!nm.contains(e.target)&&!hb.contains(e.target))nm.classList.remove('open');});
  nm.querySelectorAll('.nav-item>a').forEach(function(a){
    if(a.nextElementSibling&&a.nextElementSibling.classList.contains('dropdown')){
      a.addEventListener('click',function(e){
        if(window.innerWidth<=768){e.preventDefault();this.closest('.nav-item').classList.toggle('open');}
      });
    }else{
      a.addEventListener('click',function(){nm.classList.remove('open');});
    }
  });
}

// FAQ accordion
function toggleFaq(el){
  var isOpen=el.classList.contains('open');
  document.querySelectorAll('.faq-q').forEach(function(q){q.classList.remove('open');});
  document.querySelectorAll('.faq-a').forEach(function(a){a.classList.remove('open');});
  if(!isOpen){el.classList.add('open');el.nextElementSibling.classList.add('open');}
}

// Form handler
function handleForm(e){
  e.preventDefault();
  e.target.innerHTML='<div class="form-ok">✓ Request received — we will call you back to discuss your project within 2 hours.</div>';
}

// Scroll-based active nav
window.addEventListener('scroll',function(){
  var pos=window.pageYOffset+140;
  document.querySelectorAll('section[id]').forEach(function(sec){
    var link=document.querySelector('.nav-menu a[href="#'+sec.id+'"]');
    if(!link)return;
    if(pos>=sec.offsetTop&&pos<sec.offsetTop+sec.offsetHeight){link.style.color='var(--orange)';}
    else{link.style.color='';}
  });
});

// Counter animation on scroll
function animateCounters(){
  document.querySelectorAll('.stat-n').forEach(function(el){
    if(el.dataset.animated)return;
    var rect=el.getBoundingClientRect();
    if(rect.top<window.innerHeight-50){
      el.dataset.animated='1';
      var target=parseInt(el.dataset.target||el.textContent)||0;
      var span=el.querySelector('span');
      var suffix=span?span.textContent:'';
      var count=0;
      var step=Math.ceil(target/40);
      var timer=setInterval(function(){
        count=Math.min(count+step,target);
        el.textContent=count+(suffix?'':'')+' ';
        if(span){el.appendChild(span);}
        if(count>=target)clearInterval(timer);
      },40);
    }
  });
}
window.addEventListener('scroll',animateCounters);
