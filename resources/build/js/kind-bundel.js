function copyCloseMenuForAccessibility(){
    
    if (!document.getElementById('menu-openklap')) {
        console.error('geen uitklap menu gemaakt! agitatie kind uncompiled index.js');
        return;
    }
    
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
const bodyWidth = document.body.offsetWidth;
let hexagonCount = bodyWidth > 1500 ? 37 : bodyWidth > 1200 ? 21 : bodyWidth > 768 ? 16 : 10;

const hideIndexAtWidth1500 = `
5	x4	3	2	1
	9	8	7	6
x14	13	x12	11	10
	18	x17	16	15
23	x22	21	20	19
	27	26	x25	24
x33 32	x31	29	28
    37	36	35	34	
`.match(/(x\d+)/g).map(a=>Number(a.replace('x','')));


for (let i = 0; i < hexagonCount; i+=1){
singleHTML +=`<div id='hexagons-single-${i+1}' data-index='${i}'class="hexagons-single">
<div  class='hexagons-inner'></div>
</div>`;
}
hexagonsOuter.innerHTML = `<div class="hexagons-container">${singleHTML}</div>`;
  
  document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter);

  setTimeout(()=>{
    addClassesToHexagon(hexagonCount, {hideIndexAtWidth1500});
  }, 10);

}

function addClassesToHexagon(hexagonCount, configs){
    const {hideIndexAtWidth1500} = configs;
    
    if (!hideIndexAtWidth1500.includes(hexagonCount)) {
        const thisEl = document.getElementById(`hexagons-single-${hexagonCount}`);
        thisEl.classList.add('visible');
        
        setTimeout(()=>{
            thisEl.classList.add('rotated');
        }, 250);    
    }


    if (hexagonCount > 1){
        const newcount = hexagonCount -1;
        setTimeout(()=>{
            addClassesToHexagon(newcount);
        }, 8);
    }

}

console.log('sexHexagonsOnHero uitgecommentarieerd index.js agitatie-kind uncompiled js');
window.addEventListener('load', setHexagonsOnHero);
