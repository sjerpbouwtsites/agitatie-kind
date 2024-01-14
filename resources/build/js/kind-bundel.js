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
        console.log(lastWatcherLog, t);
        if (lastWatcherLog && lastWatcherLog.length){
            if (t === lastWatcherLog) {
                setTimeout(()=>{
                    getChildWatcherLog(t);
                },250);
            } else {
                location.reload();
                return;
            }
        } else {
            setTimeout(()=>{
                getChildWatcherLog(t);
            },500);
        }
        
    });
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
    } else {
        faderFigureNextIndex = 0;
        hasWentRound = true;
    } 
    setFaderImageActive(faderFigure, faderFigureIndex);
    if (!hasWentRoundN) {
        unLazyNextFaderImage(faderFigure, faderFigureNextIndex);
    }
        
    setTimeout(()=>{
        faderFigure.setAttribute('data-current-index', faderFigureNextIndex);
    }, 2900);
    setTimeout(()=>{
        faderVideo(faderFigure, hasWentRoundN);
    }, 3000);
}

function setFaderImageActive(faderFigure, faderFigureIndex){
    const activePicture = faderFigure.querySelector('picture.active');
    if (activePicture) {
        activePicture.classList.remove('active');
    }
    document.getElementById(`fader-video-picture-${faderFigureIndex}`).classList.add('active');
}

function unLazyNextFaderImage(faderFigure, faderFigureNextIndex){
    const image = document.getElementById(`fader-video-image-${faderFigureNextIndex}`);
    image.src = image.getAttribute('data-src');
}

function setFaderVideos(){
    document.querySelectorAll('.fader-video').forEach(fig=>{
        faderVideo(fig, false);
    });
}

function initChild(){
    getChildWatcherLog();
    setFaderVideos();
    copyCloseMenuForAccessibility();
    //setHexagonsOnHero()
}

window.addEventListener('load', initChild);
