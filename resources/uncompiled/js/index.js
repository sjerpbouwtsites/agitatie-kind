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

function getChildWatcherLog(lastWatcherLog = ''){
    if (!location.href.includes('localhost')) {
        console.log('niet op localhost')
        return;
    }
    fetch("http://localhost/oyvey/wp-content/themes/agitatie-kind/watcher.log").then(a => {
        return a.text()
    }).then(t => {
        if (lastWatcherLog && lastWatcherLog.length){
            if (t === lastWatcherLog) {
                setTimeout(()=>{
                    getChildWatcherLog(t);
                },150)
            } else {
                location.reload();
                return;
            }
        } else {
            setTimeout(()=>{
                getChildWatcherLog(t);
            },200)
        }
        
    })
} 

function faderVideo(faderFigure, hasWentRound = false){
    const faderFigureIndex = Number(faderFigure.getAttribute('data-current-index'));
    const faderFigureCount = Number(faderFigure.getAttribute('data-count'));
    const heightSet = faderFigure.hasAttribute('data-height-set');
    if (!heightSet) {
        faderFigure.setAttribute('style', `height: ${faderFigure.scrollWidth * 10 / 12}px`);
        faderFigure.setAttribute('data-height-set', true);
    }
    let faderFigureNextIndex;
    let hasWentRoundN = hasWentRound || false;
    if (faderFigureIndex +1 < faderFigureCount) {
      faderFigureNextIndex = faderFigureIndex + 1;  
    } else{
        faderFigureNextIndex = 0;
        hasWentRound = true;
    } 
    setFaderImageActive(faderFigure, faderFigureIndex);
    if (!hasWentRoundN) {
        unLazyNextFaderImage(faderFigure, faderFigureNextIndex);
    }
        
    setTimeout(()=>{
        faderFigure.setAttribute('data-current-index', faderFigureNextIndex)
    }, 2900)
    setTimeout(()=>{
        faderVideo(faderFigure, hasWentRoundN);
    }, 3000)
}

function setFaderImageActive(faderFigure, faderFigureIndex){
    const activePicture = faderFigure.querySelector('picture.active');
    if (activePicture) {
        activePicture.classList.remove('active');
    }
    document.getElementById(`fader-video-picture-${faderFigureIndex}`).classList.add('active')
}

function unLazyNextFaderImage(faderFigure, faderFigureNextIndex){
    const image = document.getElementById(`fader-video-image-${faderFigureNextIndex}`);
    image.src = image.getAttribute('data-src');
}

function setFaderVideos(){
    document.querySelectorAll('.fader-video').forEach(fig=>{
        faderVideo(fig, false)
    });
}

function imagesAlignedInTextsNextToText(){
    if (document.body.scrollWidth < 1350){
        return;
    }
    document.querySelectorAll('.bericht .bericht-tekst img.alignleft, .bericht .bericht-tekst img.alignright').forEach(alignedLeftRight => {
        const ruimte = alignedLeftRight.parentNode.offsetLeft;
        const maxWidth = `${ruimte - 40}px`;
        alignedLeftRight.parentNode.style.position = "relative";
        alignedLeftRight.classList.add('absoluted');
        alignedLeftRight.style.maxWidth = maxWidth;
    })
}



function setHexagonsOnHero(){

if (!document.body.classList.contains('home')) return

const hexagonsOuter = document.createElement('div');
hexagonsOuter.className = 'hexagons-outer';
let singleHTML = '';
const bodyWidth = document.body.offsetWidth;
let hexagonCount = bodyWidth > 1500 ? 41 : bodyWidth > 1200 ? 36 : bodyWidth > 900 ? 36 : bodyWidth > 600 ? 9 : 0



const hideIndexAboveWidth1500 = `
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

const hideIndexAboveWidth1200 = `
x1  x2  x3  4  
    x5  6   7   
x8  9   10  x11  
    12  x13 14  
15  x16 x17 x18  
    19  20  x21 
22  23  x24 25  
    26  x27 28  
29  30  x31 32 
33  x34 x35 x36
`.match(/(x\d+)/g).map(a=>Number(a.replace('x','')))

const hideIndexAboveWidth900 = `
x1  x2  x3  4  
    x5  6   7   
x8  9   10  x11  
    12  x13 14  
15  x16 x17 x18  
    19  20  x21 
22  23  24  25  
    26  x27 28  
29  30  x31 32 
33  x34 x35 x36
`.match(/(x\d+)/g).map(a=>Number(a.replace('x','')))


for (let i = 0; i < hexagonCount; i+=1){
singleHTML +=`<div id='hexagons-single-${i+1}' data-index='${i}'class="hexagons-single">
<div  class='hexagons-inner'></div>
</div>`
}
hexagonsOuter.innerHTML = `<div class="hexagons-container">${singleHTML}</div>`;
  
  document.querySelector('.uitgelichte-afbeelding-buiten.hero').appendChild(hexagonsOuter)

  setTimeout(()=>{
      const configToUse = bodyWidth > 1500 ? hideIndexAboveWidth1500 : bodyWidth > 1200 ? hideIndexAboveWidth1200 : bodyWidth > 900 ? hideIndexAboveWidth900 : []
     
    addClassesToHexagon(hexagonCount, configToUse)
  }, 10)

}

function addClassesToHexagon(hexagonCount, config){
    
    const noHexagons = document.querySelectorAll('.hexagons-single').length;
    const thisIndex = (noHexagons - hexagonCount) + 1;
  
    if (!config.includes(thisIndex)) {
        const thisEl = document.getElementById(`hexagons-single-${thisIndex}`);
        thisEl.classList.add('visible');
        
        setTimeout(()=>{
            thisEl.classList.add('rotated');
            setTimeout(()=>{
                thisEl.classList.add('white-background');
            }, 5000)
        }, 250)    
    }


    if (hexagonCount > 1){
        const newcount = hexagonCount -1;
        setTimeout(()=>{
            addClassesToHexagon(newcount, config)
        }, 8)
    }

} 

function initChild(){
    getChildWatcherLog()
    setFaderVideos()
    copyCloseMenuForAccessibility();
    imagesAlignedInTextsNextToText();
    //setHexagonsOnHero()
}

window.addEventListener('load', initChild);

