// ==========================================
// Simple Navigation Controls
// ==========================================

const navbar = document.querySelector('.header .flex .navbar');
const profile = document.querySelector('.header .flex .profile');
const searchForm = document.querySelector('.header .flex .search-form');
const menuBtn = document.querySelector('#menu-btn');
const userBtn = document.querySelector('#user-btn');
const searchBtn = document.querySelector('#search-btn');

// Toggle navbar (mobile only)
menuBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    navbar?.classList.toggle('active');
    searchForm?.classList.remove('active');
    profile?.classList.remove('active');
});

// Toggle profile
userBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    profile?.classList.toggle('active');
    searchForm?.classList.remove('active');
});

// Toggle search (mobile only)
searchBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    searchForm?.classList.toggle('active');
    profile?.classList.remove('active');
    if (window.innerWidth <= 768) {
        navbar?.classList.remove('active');
    }
});

// Close dropdowns when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.header .flex')) {
        profile?.classList.remove('active');
        if (window.innerWidth <= 768) {
            navbar?.classList.remove('active');
        }
        searchForm?.classList.remove('active');
    }
});

// Close dropdowns on scroll
window.addEventListener('scroll', () => {
    profile?.classList.remove('active');
    if (window.innerWidth <= 768) {
        navbar?.classList.remove('active');
    }
    searchForm?.classList.remove('active');
});

// ==========================================
// Search History & Suggestions
// ==========================================

const searchInput = document.querySelector('.search-form .box');
const searchFormElement = document.querySelector('.search-form');

// Sample suggested searches
const suggestedSearches = [
    'gaming',
    'travels',
    'education',
    'fashion',
    'entertainment',
    'music'
];

// Get search history from localStorage
function getSearchHistory() {
    const history = localStorage.getItem('searchHistory');
    return history ? JSON.parse(history) : [];
}

// Save search to history
function saveSearchHistory(searchTerm) {
    if (!searchTerm.trim()) return;
    
    let history = getSearchHistory();
    history = history.filter(term => term.toLowerCase() !== searchTerm.toLowerCase());
    history.unshift(searchTerm);
    history = history.slice(0, 5);
    
    localStorage.setItem('searchHistory', JSON.stringify(history));
}

// Clear search history
function clearSearchHistory() {
    localStorage.removeItem('searchHistory');
    updateSearchSuggestions();
}

// Create suggestions dropdown
function createSuggestionsDropdown() {
    if (document.querySelector('.search-suggestions')) return;
    
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'search-suggestions';
    searchFormElement?.appendChild(suggestionsDiv);
}

// Update search suggestions
function updateSearchSuggestions(query = '') {
    const suggestionsDiv = document.querySelector('.search-suggestions');
    if (!suggestionsDiv) return;
    
    const history = getSearchHistory();
    let html = '';
    
    // Show history if no query
    if (!query && history.length > 0) {
        html += `
            <div class="suggestion-section">
                <div class="suggestion-title">Recent Searches</div>
                ${history.map(term => `
                    <div class="suggestion-item" data-search="${term}">
                        <i class="fas fa-history"></i>
                        <span>${term}</span>
                    </div>
                `).join('')}
                <div class="clear-history">Clear History</div>
            </div>
        `;
    }
    
    // Show suggested searches
    const filteredSuggestions = query 
        ? suggestedSearches.filter(s => s.toLowerCase().includes(query.toLowerCase()))
        : suggestedSearches;
    
    if (filteredSuggestions.length > 0) {
        html += `
            <div class="suggestion-section">
                <div class="suggestion-title">Suggested</div>
                ${filteredSuggestions.map(term => `
                    <div class="suggestion-item" data-search="${term}">
                        <i class="fas fa-search"></i>
                        <span>${term}</span>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    suggestionsDiv.innerHTML = html;
    
    // Add click handlers
    document.querySelectorAll('.suggestion-item').forEach(item => {
        item.addEventListener('click', () => {
            const searchTerm = item.dataset.search;
            searchInput.value = searchTerm;
            saveSearchHistory(searchTerm);
            searchFormElement.submit();
        });
    });
    
    // Clear history handler
    const clearBtn = document.querySelector('.clear-history');
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearchHistory);
    }
}

// Initialize search functionality
if (searchInput && searchFormElement) {
    createSuggestionsDropdown();
    
    searchInput.addEventListener('focus', () => {
        const suggestionsDiv = document.querySelector('.search-suggestions');
        if (suggestionsDiv) {
            updateSearchSuggestions(searchInput.value);
            suggestionsDiv.classList.add('active');
        }
    });
    
    searchInput.addEventListener('input', (e) => {
        updateSearchSuggestions(e.target.value);
    });
    
    // Close suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-form')) {
            const suggestionsDiv = document.querySelector('.search-suggestions');
            suggestionsDiv?.classList.remove('active');
        }
    });
    
    // Save search on form submit
    searchFormElement.addEventListener('submit', () => {
        if (searchInput.value.trim()) {
            saveSearchHistory(searchInput.value.trim());
        }
    });
}

// ==========================================
// Content Truncation
// ==========================================

document.querySelectorAll('.post-content.content-150').forEach(content => {
    const text = content.textContent;
    if (text.length > 150) {
        content.textContent = text.slice(0, 150) + '...';
    }
});

// ==========================================
// Make Post Cards Clickable
// ==========================================

document.querySelectorAll('.posts-container .box-container .box').forEach(card => {
    const readMoreLink = card.querySelector('.inline-btn');
    
    if (readMoreLink) {
        const postUrl = readMoreLink.getAttribute('href');
        
        card.style.cursor = 'pointer';
        card.addEventListener('click', (e) => {
            if (!e.target.closest('button, a, form')) {
                window.location.href = postUrl;
            }
        });
        
        readMoreLink.style.display = 'none';
    }
});

// ==========================================
// Auto-dismiss Messages
// ==========================================

const messages = document.querySelectorAll('.message');
messages.forEach(message => {
    setTimeout(() => {
        message.style.opacity = '0';
        message.style.transform = 'translateY(-2rem)';
        setTimeout(() => {
            message.remove();
        }, 300);
    }, 5000);
});

// ==========================================
// Simple Like Button Effect
// ==========================================

document.querySelectorAll('.icons button[name="like_post"]').forEach(button => {
    button.addEventListener('click', function() {
        const heart = this.querySelector('.fa-heart');
        if (heart) {
            heart.style.transform = 'scale(1.2)';
            setTimeout(() => {
                heart.style.transform = 'scale(1)';
            }, 200);
        }
    });
});

console.log('Soleil|Lune loaded successfully!');