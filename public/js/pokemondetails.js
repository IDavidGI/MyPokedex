const detailsDiv = document.getElementById('pokemon-details');

document.querySelectorAll('.pokemon-list-item').forEach(item => {
    item.addEventListener('click', async function () {
        fetchDetails(this.dataset.url);
        const pokeName = this.querySelector('.card-title').textContent.trim().toLowerCase();
        // Mark as found in backend if not already found
        try {
            const res = await fetch('/found', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({ pokemon_name: pokeName })
            });
            if (res.ok) {
                updateProgressBar();
            }
        } catch {}
    });
// Helper to get CSRF token from meta tag
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}
});

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
async function updateProgressBar() {
    try {
        const res = await fetch('/found');
        if (res.ok) {
            const foundList = await res.json();
            const foundCount = Array.isArray(foundList) ? foundList.length : 0;
            const bar = document.getElementById('found-progress-bar');
            const percent = Math.round((foundCount / 151) * 100);
            bar.style.width = percent + '%';
            bar.setAttribute('aria-valuenow', foundCount);
            bar.classList.toggle('bg-success', foundCount > 0);
            bar.classList.toggle('bg-secondary', foundCount === 0);
            var textSpan = document.getElementById('found-progress-text');
            if (textSpan) {
                textSpan.textContent = `${foundCount} / 151 Found`;
            }
        }
    } catch {}
}

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