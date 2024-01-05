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


//window.addEventListener('load', setHexagonsOnHero)
