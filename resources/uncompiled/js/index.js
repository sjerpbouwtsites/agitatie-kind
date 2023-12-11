import '../stijl/style.scss'

function copyCloseMenuForAccessibility(){
    
    if (!document.getElementById('menu-openklap')) {
        console.error('geen uitklap menu gemaakt! agitatie kind uncompiled index.js');
        return;
    }
    
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
let hexagonCount = bodyWidth > 1500 ? 41 : bodyWidth > 1200 ? 21 : bodyWidth > 768 ? 16 : 10

const hideIndexAtWidth1500 = `
x1  x2  x3  x4  5
    x6  7   8   9
x10 11  x12 13  14
    15  x16 17  18
19  x20 21  22  23
    24  25  x26 27
x28 29  x30 31  32
    33  34  35  36
37  38  x39 x40 x41
`.match(/(x\d+)/g).map(a=>Number(a.replace('x','')))


for (let i = 0; i < hexagonCount; i+=1){
singleHTML +=`<div id='hexagons-single-${i+1}' data-index='${i}'class="hexagons-single">
<div  class='hexagons-inner'></div>
</div>`
}
hexagonsOuter.innerHTML = `<div class="hexagons-container">${singleHTML}</div>`;
  
  document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter)

  setTimeout(()=>{
      const configToUse = bodyWidth > 1500 ? hideIndexAtWidth1500 : []
      console.log(configToUse)
    addClassesToHexagon(hexagonCount, configToUse)
  }, 10)

}

function addClassesToHexagon(hexagonCount, config){
    
    if (!config.includes(hexagonCount)) {
        const thisEl = document.getElementById(`hexagons-single-${hexagonCount}`);
        thisEl.classList.add('visible');
        
        setTimeout(()=>{
            thisEl.classList.add('rotated');
        }, 250)    
    }


    if (hexagonCount > 1){
        const newcount = hexagonCount -1;
        setTimeout(()=>{
            addClassesToHexagon(newcount, config)
        }, 8)
    }

}

console.log('sexHexagonsOnHero uitgecommentarieerd index.js agitatie-kind uncompiled js')
window.addEventListener('load', setHexagonsOnHero)