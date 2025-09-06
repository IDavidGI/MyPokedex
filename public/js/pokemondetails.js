const detailsDiv = document.getElementById('pokemon-details');

async function fetchDetails(url) {
    try {
        const res = await fetch(url);
        const poke = await res.json();
        let typesHtml = poke.types.map(type => `<span class='type-badge type-${type.type.name}'>${type.type.name.charAt(0).toUpperCase() + type.type.name.slice(1)}</span>`).join(' ');
        let statsHtml = poke.stats.map(stat => `<li class='list-group-item'>${stat.stat.name}: ${stat.base_stat}</li>`).join('');
        // Get primary type color from CSS variable
        let primaryType = poke.types[0].type.name.toLowerCase();
        const rootStyles = getComputedStyle(document.documentElement);
        let cssVarName = `--type-${primaryType}`;
        let shadowColor = rootStyles.getPropertyValue(cssVarName).trim();
        console.log('Type:', primaryType, 'CSS Var:', cssVarName, 'Color:', shadowColor);
        if (!shadowColor || shadowColor === '') shadowColor = '#333';
        detailsDiv.innerHTML = `
            <div class="card" style="border: 3px solid ${shadowColor}; box-shadow: 0 0 24px 0 ${shadowColor}55;">
                <img src="${poke.sprites.other['official-artwork'].front_default}" class="card-img-top bg-white p-3" alt="${poke.name}" style="max-height:200px; object-fit:contain;">
                <div class="card-body text-center">
                    <h3 class="card-title">${poke.name.charAt(0).toUpperCase() + poke.name.slice(1)}</h3>
                    <div>${typesHtml}</div>
                    <hr>
                    <h5>Stats</h5>
                    <ul class="list-group list-group-flush">${statsHtml}</ul>
                </div>
            </div>
        `;
    } catch (e) {
        detailsDiv.innerHTML = `<div class='alert alert-danger'>Failed to load details.</div>`;
    }
}

// Here i add event listeners to each Pokémon item to trigger details fetch
document.querySelectorAll('.pokemon-list-item').forEach(item => {
    item.addEventListener('click', function () {
        fetchDetails(this.dataset.url);
    });
});

// Fetch and display the types of the pokemon
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
