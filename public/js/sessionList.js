// SESSION LIST DISPLAY _________________________________________________________

let sessionBtn = document.querySelectorAll('.session-display-btn');
let sessionLists = document.querySelectorAll('.session-card-container');

sessionBtn.forEach(btn => {
    btn.addEventListener('click', function() {
    let target = btn.id.replace('-btn', '');
    let targetList = document.querySelector(`.session-card-container__${target}`);

    sessionBtn.forEach(btn => {
        btn.classList.remove('blue-bg');
        btn.classList.add('grey2-bg');
    });
    sessionLists.forEach(list => list.classList.add('hidden'));
    targetList.classList.remove('hidden');

    btn.classList.remove('grey2-bg');
    btn.classList.add('blue-bg');
    });
});

