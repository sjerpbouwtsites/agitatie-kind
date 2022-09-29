import '../stijl/style.scss'
console.log('hallo dit is het kind');

if (localStorage.getItem('cancellation-seen') !== 'true') {
  const headerkop = document.getElementById('stek-kop');
  const ridersCancelled = document.createElement('div');
  ridersCancelled.className = 'radical-riders-cancelled radical-riders-cancelled--hidden';
  ridersCancelled.id = 'radical-riders-cancelled';
  ridersCancelled.innerHTML = `
  <style> 
      .radical-riders-cancelled {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 330px;
        transform: translate(-50%, -50%);
        background-color: black;
        color: white;
        font-weight: bold;
        z-index: 1000000000000;
        padding: 20px;
        font-size: 12px;
        font-family: sans-serif;
      }
  .cancel-button {
    margin-top: 20px;
  background-color: #ccc;
  }
  </style>
  
      <p>De Radical Riders zijn in het proces van ontbinden.<br>The Radical Riders are in the process of dissolving.</p>
      <p>We zijn niet langer beschikbaar voor solidaritet e.d.<br>
      We are no longer available for solidarity</p>
      <p>Onze vrienden van de <a href='https://www.ridersunion.nl/'>FNV</a> zijn ook riders aan het organiseren.<br>
      Our friends from the <a href='https://www.ridersunion.nl/ '>FNV</a> are also organising riders.</p>
      <p>Meer info volgt. More info will follow. <br> Radical Riders.
      <button class='cancel-button' id='close-cancel-notification'>Sluiten en niet meer tonen / close and don't show anymore</button>
  
  `;
  headerkop.appendChild(ridersCancelled)

  document.getElementById('close-cancel-notification').addEventListener('click', closeCancelNotification)
}




function closeCancelNotification() {
  const cancelEl = document.getElementById('radical-riders-cancelled')
  cancelEl.parentNode.removeChild(cancelEl)
  localStorage.setItem('cancellation-seen', 'true')
}