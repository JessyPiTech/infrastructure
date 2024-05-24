document.addEventListener('DOMContentLoaded', function () {
    const ratingSystems = document.querySelectorAll('.etoiles');

    ratingSystems.forEach(ratingSystem => {
        const gameNote = parseFloat(ratingSystem.getAttribute('data-note'));
        const stars = ratingSystem.getElementsByClassName('etoile');
        console.log("Note du jeu:", gameNote);
        const gameId = ratingSystem.id.split('-')[2];
        document.getElementById('game-note-' + gameId).innerText = "Note du jeu : " + gameNote;

        function updateStars(note) {
            for (let i = 0; i < stars.length; i++) {
                if (note >= i + 1) {
                    stars[i].classList.add('plein');
                    stars[i].classList.remove('demie');
                } else if (note > i && note < i + 1) {
                    stars[i].classList.add('demie');
                    stars[i].classList.remove('plein');
                } else {
                    stars[i].classList.remove('plein', 'demie');
                }
            }
        }

        updateStars(gameNote);
    });
});