const detailsDiv = document.getElementById('pokemon-details');

async function fetchDetails(url) {
    try {
        const res = await fetch(url);
        const poke = await res.json();

        // Types and stats HTML
        const typesHtml = poke.types.map(type =>
            `<span class='type-badge type-${type.type.name}'>${type.type.name[0].toUpperCase() + type.type.name.slice(1)}</span>`
        ).join(' ');

        const statsHtml = poke.stats.map(stat =>
            `<li class='list-group-item border-0 d-flex justify-content-between align-items-center' style='padding:4px 0; width:180px; margin-left:13%;'>
                <span style='flex:1; text-align:right; font-weight:500; color:#555;'>${stat.stat.name.replace('-', ' ').toUpperCase()}</span>
                <span style='flex:0 0 48px; text-align:left; font-weight:bold; color:#222;'>&emsp;${stat.base_stat}</span>
            </li>`
        ).join('');

        // Border/shadow color
        const primaryType = poke.types[0].type.name.toLowerCase();
        const shadowColor = getComputedStyle(document.documentElement).getPropertyValue(`--type-${primaryType}`).trim() || '#333';

        detailsDiv.innerHTML = `
            <div class="card" style="border:3px solid ${shadowColor}; box-shadow:0 0 24px 0 ${shadowColor}55;">
                <img src="${poke.sprites.other['official-artwork'].front_default}" class="card-img-top bg-white p-3" alt="${poke.name}" style="max-height:200px; object-fit:contain;">
                <div class="card-body text-center">
                    <h3 class="card-title">${poke.name[0].toUpperCase() + poke.name.slice(1)}</h3>
                    <div>${typesHtml}</div>
                    <hr>
                    <ul class="list-group list-group-flush">${statsHtml}</ul>
                </div>
            </div>
        `;

        // To show the evo chain of a Pokémon
        const evoDiv = document.getElementById('evolution-chain');
        evoDiv.innerHTML = '<span class="text-muted">Loading evolution...</span>';

        const species = await (await fetch(poke.species.url)).json();
        if (species.evolution_chain?.url) {
            const evoData = await (await fetch(species.evolution_chain.url)).json();
            let evo = evoData.chain, evoHtml = '';
            while (evo) {
                const match = evo.species.url.match(/\/pokemon-species\/(\d+)/);
                const id = match ? match[1] : '';
                if (id) {
                    evoHtml += `<img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${id}.png" alt="${evo.species.name}" title="${evo.species.name}" style="width:64px; height:64px; object-fit:contain;">`;
                }
                if (evo.evolves_to?.length) evoHtml += `<span style="font-size:2em; color:#888; margin:0 8px;">&#8594;</span>`;
                evo = evo.evolves_to?.[0];
            }
            evoDiv.innerHTML = evoHtml;
        } else {
            evoDiv.innerHTML = '<span class="text-muted">No evolution data.</span>';
        }
    } catch {
        detailsDiv.innerHTML = `<div class='alert alert-danger'>Failed to load details.</div>`;
        document.getElementById('evolution-chain').innerHTML = '';
    }
}

//function to update the progress bar
const foundKey = 'foundPokemon151';
let foundPokemon = JSON.parse(localStorage.getItem(foundKey) || '[]');

function updateProgressBar() {
    const bar = document.getElementById('found-progress-bar');
    const foundCount = foundPokemon.length;
    const percent = Math.round((foundCount / 151) * 100);
    bar.style.width = percent + '%';
    bar.setAttribute('aria-valuenow', foundCount);
    bar.textContent = `${foundCount} / 151 Found`;
    bar.classList.toggle('bg-success', foundCount > 0);
    bar.classList.toggle('bg-secondary', foundCount === 0);
}

document.querySelectorAll('.pokemon-list-item').forEach(item => {
    item.addEventListener('click', function () {
        fetchDetails(this.dataset.url);
        const pokeName = this.querySelector('.card-title').textContent.trim().toLowerCase();
        //after fetching details, add to found list if not already present
        if (!foundPokemon.includes(pokeName)) {
            foundPokemon.push(pokeName);
            localStorage.setItem(foundKey, JSON.stringify(foundPokemon));
            updateProgressBar();
        }
    });
});

document.addEventListener('DOMContentLoaded', updateProgressBar);

//fetch and display the types of the pokemon
document.querySelectorAll('.pokemon-list-item').forEach(item => {
    const typeDiv = item.querySelector('.pokemon-type-list');
    const url = item.getAttribute('data-url');
    if (typeDiv && url) {
        fetch(url)
            .then(res => res.json())
            .then(poke => {
                const typesHtml = poke.types.map(type => `<span class='type-badge type-${type.type.name}'>${type.type.name.charAt(0).toUpperCase() + type.type.name.slice(1)}</span>`).join(' ');
                typeDiv.innerHTML = typesHtml;
            })
            .catch(() => {
                typeDiv.innerHTML = `<span class='text-danger'>Type error</span>`;
            });
    }
});

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

//searching and filtering functionality on type and name
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pokemon-search');
    const typeMenu = document.getElementById('type-filter-menu');
    const typeDropdownBtn = document.getElementById('typeDropdown');
    let selectedType = '';

    function filterPokemon() {
        const searchText = searchInput.value.trim().toLowerCase();
        document.querySelectorAll('.pokemon-list-item').forEach(card => {
            const name = card.querySelector('.card-title').textContent.trim().toLowerCase();
            let matchesSearch = name.includes(searchText);
            let matchesType = true;
            if (selectedType) {
                const typeBadges = card.querySelectorAll('.type-badge');
                matchesType = Array.from(typeBadges).some(badge => badge.classList.contains('type-' + selectedType));
            }
            card.parentElement.style.display = (matchesSearch && matchesType) ? '' : 'none';
        });
    }

    function updateTypeButtonText() {
        if (!selectedType) {
            typeDropdownBtn.textContent = 'Filter by Type';
        } else {
            typeDropdownBtn.textContent = selectedType.charAt(0).toUpperCase() + selectedType.slice(1);
        }
    }

    searchInput.addEventListener('input', filterPokemon);
    typeMenu.querySelectorAll('.type-filter-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            selectedType = this.getAttribute('data-type');
            updateTypeButtonText();
            filterPokemon();
        });
    });
});