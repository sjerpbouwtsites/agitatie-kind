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
hexagonsOuter.innerHTML = `

  <div class="hexagons-container">
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
    <div class="hexagons-single"></div>
  </div>
  `;

    document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter)

}

window.addEventListener('load', setHexagonsOnHero)