function setupFavoriteButtonListeners() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const star = btn.querySelector('.favorite-star');
            if (star.innerHTML == '&#9733;' || star.innerHTML === '★') {
                //if star is filled, unfill it
                star.innerHTML = '&#9734;';
                star.style.color = '#FFD700';
            } else {
                star.innerHTML = '&#9733;';
                star.style.color = '#FFD700';
            }
        });
    });
}

window.onload = setupFavoriteButtonListeners;

//handles favorites logic and AJAX
let userFavorites = [];

async function loadUserFavorites() {
    try {
        const res = await fetch('/favorites');
        console.log(res);
        if (res.ok) {
            userFavorites = await res.json();
            console.log(userFavorites);
            document.querySelectorAll('.pokemon-list-item').forEach(card => {
                const name = card.querySelector('.card-title').textContent.trim().toLowerCase();
                const star = card.querySelector('.favorite-star');
                if (userFavorites.includes(name)) {
                    star.innerHTML = '&#9733;';
                    star.style.color = '#FFD700';
                } else {
                    star.innerHTML = '&#9734;';
                    star.style.color = '#FFD700';
                }
            });
        }
    } catch {}
}

async function addFavorite(name) {
    await fetch('/favorites', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
        body: JSON.stringify({ pokemon_name: name })
    });
    userFavorites.push(name);
}

async function removeFavorite(name) {
    await fetch('/favorites', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
        body: JSON.stringify({ pokemon_name: name })
    });
    userFavorites = userFavorites.filter(fav => fav !== name);
}

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function setupFavoriteButtonListeners() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            const star = btn.querySelector('.favorite-star');
            const card = btn.closest('.pokemon-list-item');
            const name = card.querySelector('.card-title').textContent.trim().toLowerCase();
            if (star.innerHTML == '&#9733;' || star.innerHTML === '★') {
                await removeFavorite(name);
                star.innerHTML = '&#9734;';
                star.style.color = '#FFD700';
            } else {
                await addFavorite(name);
                star.innerHTML = '&#9733;';
                star.style.color = '#FFD700';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadUserFavorites();
    setupFavoriteButtonListeners();
});