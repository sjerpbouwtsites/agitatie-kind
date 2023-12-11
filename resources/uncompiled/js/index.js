import '../stijl/style.scss'

function copyCloseMenuForAccessibility(){
    
    
    const nieuweKnop = document.createElement('button');
    nieuweKnop.setAttribute('data-doorschakel', '#mobiele-menu-schakel')
    nieuweKnop.id = 'sluit-openklap-menu-button';
    nieuweKnop.className = 'schakel zichtbaar-op-focus';
    nieuweKnop.textContent = 'Sluit menu';
    const lijstEl = document.createElement('li');
    lijstEl.id = 'sluit-openklap-li';
    lijstEl.appendChild(nieuweKnop);
    document.getElementById('menu-openklap').appendChild(lijstEl)
    
}

window.addEventListener('load', copyCloseMenuForAccessibility)

function setHexagonsOnHero(){

if (!document.body.classList.contains('home')) return

const hexagonsOuter = document.createElement('div');
hexagonsOuter.className = 'hexagons-outer';
let singleHTML = '';
const bodyWidth = document.body.offsetWidth;
let hexagonCount = bodyWidth > 1500 ? 36 : bodyWidth > 1200 ? 21 : bodyWidth > 768 ? 16 : 10

for (let i = 0; i < hexagonCount; i+=1){
singleHTML +=`<div id='hexagons-single-${i+1}' class="hexagons-single">
<div  class='hexagons-inner'></div>
</div>`
}
hexagonsOuter.innerHTML = `<div class="hexagons-container">${singleHTML}</div>`;
  
  document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter)

  setTimeout(()=>{
    addClassesToHexagon(hexagonCount)
  }, 100)

}

function addClassesToHexagon(hexagonCount){
    const thisEl = document.getElementById(`hexagons-single-${hexagonCount}`);
    
        thisEl.classList.add('visible');
    
    setTimeout(()=>{
        thisEl.classList.add('rotated');
    }, 250)    

    if (hexagonCount > 1){
        const newcount = hexagonCount -1;
        setTimeout(()=>{
            addClassesToHexagon(newcount)
        }, 8)
    }

}

console.log('sexHexagonsOnHero uitgecommentarieerd index.js agitatie-kind uncompiled js')
//window.addEventListener('load', setHexagonsOnHero)