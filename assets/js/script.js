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

// Sample suggested searches (you can replace with dynamic data)
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
    
    // Remove if already exists
    history = history.filter(term => term.toLowerCase() !== searchTerm.toLowerCase());
    
    // Add to beginning
    history.unshift(searchTerm);
    
    // Keep only last 5 searches
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
// Confirmation Modal for Deletes
// ==========================================

function createModal() {
    if (document.querySelector('.modal-overlay')) return;
    
    const modalHTML = `
        <div class="modal-overlay">
            <div class="modal">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3>Confirm Delete</h3>
                <p>Are you sure you want to delete this? This action cannot be undone.</p>
                <div class="modal-buttons">
                    <button class="modal-cancel">Cancel</button>
                    <button class="modal-confirm">Delete</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

function showConfirmModal(message, onConfirm) {
    createModal();
    
    const overlay = document.querySelector('.modal-overlay');
    const modal = document.querySelector('.modal');
    const modalText = modal.querySelector('p');
    const confirmBtn = modal.querySelector('.modal-confirm');
    const cancelBtn = modal.querySelector('.modal-cancel');
    
    // Update message
    if (message) {
        modalText.textContent = message;
    }
    
    // Show modal
    overlay.classList.add('active');
    
    // Confirm handler
    const handleConfirm = () => {
        overlay.classList.remove('active');
        if (onConfirm) onConfirm();
        cleanup();
    };
    
    // Cancel handler
    const handleCancel = () => {
        overlay.classList.remove('active');
        cleanup();
    };
    
    // Cleanup listeners
    const cleanup = () => {
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        overlay.removeEventListener('click', handleOverlayClick);
    };
    
    // Overlay click (close on background click)
    const handleOverlayClick = (e) => {
        if (e.target === overlay) {
            handleCancel();
        }
    };
    
    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
    overlay.addEventListener('click', handleOverlayClick);
}

// Replace all delete confirmations with modal
document.querySelectorAll('[onclick*="confirm"]').forEach(element => {
    const onclickAttr = element.getAttribute('onclick');
    const message = onclickAttr.match(/'([^']+)'/)?.[1] || 'Are you sure you want to delete this?';
    
    element.removeAttribute('onclick');
    
    element.addEventListener('click', (e) => {
        e.preventDefault();
        
        showConfirmModal(message, () => {
            // Find the parent form and submit it
            const form = element.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
});

// Handle delete comment buttons specifically
document.querySelectorAll('button[name="delete_comment"]').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        
        showConfirmModal('Are you sure you want to delete this comment?', () => {
            const form = button.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
});

// Handle delete post buttons
document.querySelectorAll('button[name="delete_post"]').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        
        showConfirmModal('Are you sure you want to delete this post? All comments will also be deleted.', () => {
            const form = button.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
});

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
    // Find the "read more" link inside the card
    const readMoreLink = card.querySelector('.inline-btn');
    
    if (readMoreLink) {
        const postUrl = readMoreLink.getAttribute('href');
        
        // Make entire card clickable
        card.style.cursor = 'pointer';
        card.addEventListener('click', (e) => {
            // Don't trigger if clicking on interactive elements
            if (!e.target.closest('button, a, form')) {
                window.location.href = postUrl;
            }
        });
        
        // Remove the "read more" button since card is clickable
        readMoreLink.style.display = 'none';
    }
});

// ==========================================
// Auto-dismiss Messages
// ==========================================

const messages = document.querySelectorAll('.message');
messages.forEach(message => {
    // Auto-dismiss after 5 seconds
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

console.log('✨ Soleil|Lune loaded successfully!');