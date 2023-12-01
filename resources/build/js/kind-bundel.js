function copyCloseMenuForAccessibility(){
    
    
    const nieuweKnop = document.createElement('button');
    nieuweKnop.setAttribute('data-doorschakel', '#mobiele-menu-schakel');
    nieuweKnop.id = 'sluit-openklap-menu-button';
    nieuweKnop.className = 'schakel zichtbaar-op-focus';
    nieuweKnop.textContent = 'Sluit menu';
    const lijstEl = document.createElement('li');
    lijstEl.id = 'sluit-openklap-li';
    lijstEl.appendChild(nieuweKnop);
    document.getElementById('menu-openklap').appendChild(lijstEl);
    
}

window.addEventListener('load', copyCloseMenuForAccessibility);

function setHexagonsOnHero(){

if (!document.body.classList.contains('home')) return

const hexagonsOuter = document.createElement('div');
hexagonsOuter.className = 'hexagons-outer';
let singleHTML = '';

let hexagonCount = screen.availWidth > 1500 ? 36 : screen.availWidth > 1200 ? 27 : screen.availWidth > 768 ? 16 : screen.availWidth > 460 ? 10 : 6;

for (let i = 0; i < hexagonCount; i+=1){
singleHTML +=`<div id='hexagons-single-${i+1}' class="hexagons-single">
<div  class='hexagons-inner'></div>
</div>`;
}
hexagonsOuter.innerHTML = `<div class="hexagons-container">${singleHTML}</div>`;
  
  document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter);

  for (let i = hexagonCount; i >= 1; i-=1){
    setTimeout(()=>{
        document.getElementById(`hexagons-single-${i+1}`).classList.add('visible');
    }, 50 + (i * 8));
  }

}

window.addEventListener('load', setHexagonsOnHero);
