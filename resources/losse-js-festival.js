function printTitelsFestivalOpHero() {
  let titels = Array.from(document.querySelectorAll(".art-c.in-lijst h3")).map(
    (titel) => titel.textContent.trim().replace("trailer", "")
  );

  titels = shuffle(titels);

  printTitelsRecursief(titels);
}

function printTitelsRecursief(lijst, index = 0) {
  if (!lijst.length) {
    if (window.scrollY < 300) {
      setTimeout(() => {
        window.scrollTo({
          top:
            document.querySelector(".uitgelichte-afbeelding-buiten + div")
              .offsetTop - 50,
          behavior: "smooth",
        });
      }, 50);
    }
    return;
  }

  const dezeTitel = lijst.shift();
  const afbeeldingBuiten = document.querySelector(
    ".uitgelichte-afbeelding-buiten.hero"
  );

  const nieuweMarquee = document.createElement("div");
  nieuweMarquee.className =
    "serif-letter quasi-marquee quasi-marquee--ongeladen quasi-marquee--niet-geanimeerd";
  nieuweMarquee.textContent = dezeTitel;
  const hoogteAfbeeldingBuiten = afbeeldingBuiten.offsetHeight * 0.75;
  const randomDing =
    Math.random() * hoogteAfbeeldingBuiten +
    afbeeldingBuiten.offsetHeight * 0.0625;
  nieuweMarquee.style.top = `${randomDing}px`;
  afbeeldingBuiten.appendChild(nieuweMarquee);

  const scaleFactor = Math.random() + 0.5;
  nieuweMarquee.style.scale = scaleFactor;
  nieuweMarquee.style.marginLeft = `${index * Math.random * 4.5 * 20}px`;
  const hueRotate = (Math.random - 0.5) * 90;

  setTimeout(() => {
    nieuweMarquee.classList.add("quasi-marquee--geladen");
  }, 10);

  setTimeout(() => {
    nieuweMarquee.classList.add("quasi-marquee--halverwege-geanimeerd");
    nieuweMarquee.style.filter = `hue-rotate(${hueRotate}deg);`;
  }, 200);

  setTimeout(() => {
    nieuweMarquee.classList.add("quasi-marquee--weg-geanimeerd");
  }, 1100);
  setTimeout(() => {
    nieuweMarquee.classList.add("quasi-marquee--verdwijnt");
  }, 1200);

  setTimeout(() => {
    nieuweMarquee.parentNode.removeChild(nieuweMarquee);
  }, 1500);

  //printen
  setTimeout(() => {
    const j = index + 1;
    printTitelsRecursief(lijst, j);
  }, 750);
}
function shuffle(array) {
  let currentIndex = array.length;

  // While there remain elements to shuffle...
  while (currentIndex != 0) {
    // Pick a remaining element...
    let randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex],
      array[currentIndex],
    ];
  }
  return array;
}

function navNaarPaginaTitel() {
  document.querySelector("h1").id = "pagina-titel";
  document.querySelectorAll(".navigation a").forEach((anker) => {
    anker.href = `${anker.href}#pagina-titel`;
  });
}

function openFestivalTrailerEventListeners() {
  document.querySelectorAll(".open-festival-trailer").forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      let btn = e.target;
      const ACFyt = btn.getAttribute("data-youtube");

      const ytHTML = `
        <div class='youtube-buiten' id='youtube-buiten'>
        
        <div class='youtube-midden'>
        <button class='sluit-youtube' id='sluit-youtube'>❌</button>
        <div class='youtube-binnen'>
        <iframe 
            src="https://www.youtube.com/embed/${ACFyt}?autoplay=1&controls=0&modestbranding=0&rel=0&playsinline=1&playlist=${ACFyt}">
        </iframe>
        </div></div></div>
        `;
      document.querySelector("#stop-youtube-hier").innerHTML = ytHTML;
    });
  });
}
function sluitYoutubeButtonEventListener() {
  document.body.addEventListener("click", (e) => {
    if (e.target.id !== "sluit-youtube") return;
    verwijderYoutube(e);
  });
}
function verwijderYoutube(e) {
  e.preventDefault();
  e.stopPropagation();
  document.getElementById("stop-youtube-hier").innerHTML = "";
}
function verwijderYoutubeEscape() {
  document.body.addEventListener("keyup", (e) => {
    if (e?.key === "Escape") {
      verwijderYoutube(e);
    }
  });
}
// A $( document ).ready() block.
$(document).ready(function () {
  console.log("ready!");
  printTitelsFestivalOpHero();
  navNaarPaginaTitel();
  openFestivalTrailerEventListeners();
  sluitYoutubeButtonEventListener();
  verwijderYoutubeEscape();
});
