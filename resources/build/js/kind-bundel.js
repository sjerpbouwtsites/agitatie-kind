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
    if (!location.href.includes('localhost')) return;
    fetch("http://localhost/oyvey/wp-content/themes/agitatie-kind/watcher.log").then(a => {
        return a.text()
    }).then(t => {
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

window.addEventListener('load', getChildWatcherLog);
 
window.addEventListener('load', copyCloseMenuForAccessibility);


//window.addEventListener('load', setHexagonsOnHero)
