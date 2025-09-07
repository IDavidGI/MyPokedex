//searching and filtering functionality on type and name

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pokemon-search');
    const typeMenu = document.getElementById('type-filter-menu');
    const typeDropdownBtn = document.getElementById('typeDropdown');
    const favoritesBtn = document.getElementById('favorites-filter-btn');
    let selectedType = '';
    let showFavoritesOnly = false;

    function getUserFavorites() {
        let favs = [];
        document.querySelectorAll('.pokemon-list-item').forEach(card => {
            const star = card.querySelector('.favorite-star');
            const name = card.querySelector('.card-title').textContent.trim().toLowerCase();
            if (star && (star.innerHTML == '&#9733;' || star.innerHTML === '★')) {
                favs.push(name);
            }
        });
        return favs;
    }

    function filterPokemon() {
        const searchText = searchInput.value.trim().toLowerCase();
        const favorites = getUserFavorites();
        document.querySelectorAll('.pokemon-list-item').forEach(card => {
            const name = card.querySelector('.card-title').textContent.trim().toLowerCase();
            let matchesSearch = name.includes(searchText);
            let matchesType = true;
            if (selectedType) {
                const typeBadges = card.querySelectorAll('.type-badge');
                matchesType = Array.from(typeBadges).some(badge => badge.classList.contains('type-' + selectedType));
            }
            let matchesFavorite = !showFavoritesOnly || favorites.includes(name);
            card.parentElement.style.display = (matchesSearch && matchesType && matchesFavorite) ? '' : 'none';
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


    favoritesBtn.addEventListener('click', function() {
        showFavoritesOnly = !showFavoritesOnly;
        if (showFavoritesOnly) {
            favoritesBtn.style.backgroundColor = '#FFD700'; // yellow
            favoritesBtn.style.color = '#222';
            favoritesBtn.textContent = 'Showing Favorites';
        } else {
            favoritesBtn.style.backgroundColor = '#fff'; // white
            favoritesBtn.style.color = '#222';
            favoritesBtn.textContent = 'Favorites';
        }
        filterPokemon();
    });

    //set initial state of favorites button
    favoritesBtn.style.backgroundColor = '#fff';
    favoritesBtn.style.color = '#222';
});