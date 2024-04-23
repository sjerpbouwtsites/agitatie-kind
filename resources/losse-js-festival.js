function printTitelsFestivalOpHero(){
    let titels = Array.from(document.querySelectorAll('.art-c.in-lijst h3'))
        .map(titel => titel.textContent.trim().replace('📽️',''))  

        titels = shuffle(titels)

        printTitelsRecursief(titels)
}

function printTitelsRecursief(lijst, index = 0){
    if (!lijst.length){
        if (window.scrollY < 300){
            setTimeout(()=>{

                window.scrollTo({
                    top: document.querySelector('.uitgelichte-afbeelding-buiten + div').offsetTop - 50,
                    behavior: 'smooth',
                  })            
            }, 50)
        }
        return;
    }

    const dezeTitel = lijst.shift();
    const afbeeldingBuiten = document.querySelector('.uitgelichte-afbeelding-buiten.hero');

    const nieuweMarquee = document.createElement('div');
    nieuweMarquee.className = 'serif-letter quasi-marquee quasi-marquee--ongeladen quasi-marquee--niet-geanimeerd';
    nieuweMarquee.textContent = dezeTitel;
    const hoogteAfbeeldingBuiten = afbeeldingBuiten.offsetHeight * 0.75;
    const randomDing = (Math.random() * hoogteAfbeeldingBuiten) + afbeeldingBuiten.offsetHeight * .0625
    nieuweMarquee.style.top = `${randomDing}px`;
    afbeeldingBuiten.appendChild(nieuweMarquee)

    const scaleFactor = ((Math.random()) + .5) ;
    nieuweMarquee.style.scale = scaleFactor;
    nieuweMarquee.style.marginLeft = `${index * Math.random * 4.5 * 20}px`;
    const hueRotate = (Math.random - 0.5) * 90;
    

    setTimeout(()=>{
        nieuweMarquee.classList.add('quasi-marquee--geladen')
    }, 10)

    setTimeout(()=>{
        nieuweMarquee.classList.add('quasi-marquee--halverwege-geanimeerd')
        nieuweMarquee.style.filter = `hue-rotate(${hueRotate}deg);`
    }, 200)

    
    setTimeout(()=>{
        nieuweMarquee.classList.add('quasi-marquee--weg-geanimeerd')
    },1100)
    setTimeout(()=>{
        nieuweMarquee.classList.add('quasi-marquee--verdwijnt')
    }, 1200)

    setTimeout(()=>{
        nieuweMarquee.parentNode.removeChild(nieuweMarquee)
    }, 1500)

    //printen
    setTimeout(()=>{
        const j = index + 1;
        printTitelsRecursief(lijst, j)
    }, 750)
}


printTitelsFestivalOpHero()

function shuffle(array) {
    let currentIndex = array.length;
  
    // While there remain elements to shuffle...
    while (currentIndex != 0) {
  
      // Pick a remaining element...
      let randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;
  
      // And swap it with the current element.
      [array[currentIndex], array[randomIndex]] = [
        array[randomIndex], array[currentIndex]];

    }
    return array;
  }


document.querySelector('h1').id = 'pagina-titel';
document.querySelectorAll('.navigation a').forEach(anker => {
    anker.href = `${anker.href}#pagina-titel`
})

document.querySelectorAll('.open-festival-trailer').forEach(button => {
    button.addEventListener('click', e=> {
        e.preventDefault();
        e.stopPropagation();
        let btn = e.target;
        const yt = btn.getAttribute('data-youtube');
        
        const ytHTML = `
        <div class='youtube-buiten' id='youtube-buiten'>
        <button id='sluit-youtube'>❌</button>
        <div class='youtube-binnen'>
        <iframe width="560" height="315" anonymous
        src="${yt}&origin=http://dev.sjerpbouwtsites.nl" title="YouTube video player" 
        frameborder="0" allow=" picture-in-picture; web-share" 
        crossorigin="sameorigin"
         allowfullscreen>
        </iframe></div></div>
        `
        document.querySelector('#stop-youtube-hier').innerHTML = ytHTML;
    })
})

document.body.addEventListener('click', e => {
    if (e.target.id !== 'sluit-youtube') return;
    document.getElementById('stop-youtube-hier').innerHTML = '';
})