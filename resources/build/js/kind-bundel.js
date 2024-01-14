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

function getChildWatcherLog(lastWatcherLog = ''){
    if (!location.href.includes('localhost')) {
        console.log('niet op localhost');
        return;
    }
    fetch("http://localhost/oyvey/wp-content/themes/agitatie-kind/watcher.log").then(a => {
        return a.text()
    }).then(t => {
        if (lastWatcherLog && lastWatcherLog.length){
            if (t === lastWatcherLog) {
                setTimeout(()=>{
                    getChildWatcherLog(t);
                },150);
            } else {
                location.reload();
                return;
            }
        } else {
            setTimeout(()=>{
                getChildWatcherLog(t);
            },200);
        }
        
    });
} 

function faderVideo(faderFigure, hasWentRound = false){
    
    const faderFigureIndex = Number(faderFigure.getAttribute('data-current-index'));
    const faderFigureCount = Number(faderFigure.getAttribute('data-count'));
    const faderIndex = Number(faderFigure.getAttribute('data-fader-index'));
    const heightSet = faderFigure.hasAttribute('data-height-set');
    if (!heightSet) {
        faderFigure.setAttribute('style', `height: ${faderFigure.scrollWidth * 10 / 12}px`);
        faderFigure.setAttribute('data-height-set', true);
    }
    let faderFigureNextIndex;
    let hasWentRoundN = hasWentRound || false;
    if (faderFigureIndex +1 < faderFigureCount) {
      faderFigureNextIndex = faderFigureIndex + 1;  
    } else {
        faderFigureNextIndex = 0;
        hasWentRound = true;
    } 
    setFaderImageActive(faderFigure, faderIndex, faderFigureIndex);
    if (!hasWentRoundN) {
        unLazyNextFaderImage(faderFigure, faderIndex, faderFigureNextIndex);
    }

    setTimeout(()=>{
        faderFigure.setAttribute('data-current-index', faderFigureNextIndex);
    }, 2400); 
    setTimeout(()=>{
        faderVideo(faderFigure, hasWentRoundN);
    }, 2500);
}

function setFaderImageActive(faderFigure, faderIndex, faderFigureIndex){
    const activePicture = faderFigure.querySelector('picture.active');
    if (activePicture) {
        activePicture.classList.remove('active');
    }
    document.getElementById(`fader-video-picture-${faderIndex}-${faderFigureIndex}`).classList.add('active');
}

function unLazyNextFaderImage(faderFigure, faderIndex, faderFigureNextIndex){
    const image = document.getElementById(`fader-video-image-${faderIndex}-${faderFigureNextIndex}`);
    image.srcset = image.getAttribute('data-srcset');
}

function setFaderVideos(){
    document.querySelectorAll('.fader-video').forEach(fig=>{
        console.log(fig);
        faderVideo(fig, false);
    });
}

function imagesAlignedInTextsNextToText(){
    if (document.body.scrollWidth < 1350){
        return;
    }
    document.querySelectorAll('.bericht .bericht-tekst img.alignleft').forEach(alignedLeft => {
        const ruimte = alignedLeft.parentNode.offsetLeft;
        const maxWidth = `${ruimte - 40}px`;
        alignedLeft.parentNode.style.position = "relative";
        alignedLeft.classList.add('absoluted');
        alignedLeft.style.maxWidth = maxWidth;
    });
    document.querySelectorAll('.bericht .bericht-tekst img.alignright').forEach(alignedRight => {
        const ruimte = alignedRight.parentNode.offsetLeft;
        const maxWidth = `${ruimte - 240}px`;
        alignedRight.parentNode.style.position = "relative";
        alignedRight.classList.add('absoluted');
        alignedRight.style.maxWidth = maxWidth;
    });    
}

function initChild(){
    getChildWatcherLog();
    setFaderVideos();
    copyCloseMenuForAccessibility();
    imagesAlignedInTextsNextToText();
    //setHexagonsOnHero()
}

window.addEventListener('load', initChild);
