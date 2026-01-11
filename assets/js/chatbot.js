// Chatbot functionality
const chatbotBtn = document.getElementById('chatbot-btn');
const chatbotWindow = document.querySelector('.chatbot-window');
const chatbotOverlay = document.querySelector('.chatbot-overlay');
const chatbotClose = document.querySelector('.chatbot-close');
const chatbotMessages = document.querySelector('.chatbot-messages');
const chatbotInput = document.querySelector('.chatbot-input');
const chatbotSend = document.querySelector('.chatbot-send');

// Toggle chatbot
chatbotBtn.addEventListener('click', () => {
   chatbotWindow.classList.add('active');
   chatbotOverlay.classList.add('active');
   
   if (chatbotMessages.children.length === 0) {
      setTimeout(() => {
         initializeChat();
      }, 300);
   }
});

chatbotClose.addEventListener('click', () => {
   chatbotWindow.classList.remove('active');
   chatbotOverlay.classList.remove('active');
});

chatbotOverlay.addEventListener('click', () => {
   chatbotWindow.classList.remove('active');
   chatbotOverlay.classList.remove('active');
});

// Show typing indicator
function showTypingIndicator() {
   const typingDiv = document.createElement('div');
   typingDiv.className = 'message bot';
   typingDiv.id = 'typing-indicator';
   typingDiv.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
   chatbotMessages.appendChild(typingDiv);
   scrollToBottom();
}

// Remove typing indicator
function removeTypingIndicator() {
   const typing = document.getElementById('typing-indicator');
   if (typing) typing.remove();
}

// Initialize chat
async function initializeChat() {
   showTypingIndicator();
   
   setTimeout(async () => {
      const response = await fetch('/Soleil-Lune/api/chatbot.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
         body: 'action=init'
      });
      
      const data = await response.json();
      removeTypingIndicator();
      
      if (data.success) {
         addBotMessage(data.message, data.buttons, null, false);
      }
   }, 2000);
}

// Send message (typed or clicked)
async function sendMessage(message = null) {
   const userMessage = message || chatbotInput.value.trim();
   if (!userMessage) return;

   // Add user message
   addMessage(userMessage, 'user');
   chatbotInput.value = '';

   // Show typing indicator
   showTypingIndicator();

   // Send to server
   setTimeout(async () => {
      try {
         const response = await fetch('/Soleil-Lune/api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=message&message=${encodeURIComponent(userMessage)}`
         });

         if (!response.ok) {
            throw new Error('HTTP error! status: ' + response.status);
         }

         const data = await response.json();
         
         // Remove typing indicator
         removeTypingIndicator();

         // Add bot response
         if (data.success) {
            addBotMessage(data.message, data.buttons, data.button, false);
         }
      } catch (error) {
         removeTypingIndicator();
         addMessage('Sorry, I encountered an error: ' + error.message, 'bot');
         console.error('Chatbot error:', error);
      }
   }, 2000);
}

// Select menu option
async function selectMenu(menuId, buttonText) {
   // Add user message showing what they selected
   if (buttonText) {
      addMessage(buttonText, 'user');
   }
   
   showTypingIndicator();
   
   setTimeout(async () => {
      const response = await fetch('/Soleil-Lune/api/chatbot.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
         body: `action=menu&menu_id=${menuId}`
      });
      
      const data = await response.json();
      removeTypingIndicator();
      
      if (data.success) {
         // Check if this is a submenu (has more options) or final answer
         const hasSubOptions = data.buttons && data.buttons.length > 0 && !data.buttons[0].action;
         addBotMessage(data.message, data.buttons, null, hasSubOptions, menuId);
      }
   }, 2000);
}

function addMessage(text, sender) {
   const messageDiv = document.createElement('div');
   messageDiv.className = `message ${sender}`;
   messageDiv.style.opacity = '0';
   messageDiv.style.transform = 'translateY(10px)';
   messageDiv.style.transition = 'all 0.3s ease';
   
   messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
   chatbotMessages.appendChild(messageDiv);
   
   // Animate message in
   setTimeout(() => {
      messageDiv.style.opacity = '1';
      messageDiv.style.transform = 'translateY(0)';
   }, 10);
   
   setTimeout(() => scrollToBottom(), 100);
}

function addBotMessage(text, buttons = [], actionButton = null, showActions = false, menuId = null) {
   const messageDiv = document.createElement('div');
   messageDiv.className = 'message bot';
   
   let buttonsHtml = '';
   if (buttons && buttons.length > 0) {
      buttonsHtml = '<div class="quick-replies">';
      buttons.forEach(btn => {
         if (btn.action === 'init') {
            // Skip - we'll handle back button in action buttons
         } else if (btn.id) {
            // Pass button text to selectMenu function
            buttonsHtml += `<button class="quick-reply-btn" onclick="selectMenu(${btn.id}, '${escapeHtml(btn.text).replace(/'/g, "\\'")}')">${escapeHtml(btn.text)}</button>`;
         }
      });
      buttonsHtml += '</div>';
   }
   
   if (actionButton) {
      buttonsHtml += `<div class="quick-replies" style="margin-top: 8px;"><a href="${actionButton.link}" class="message-button" target="_blank">${escapeHtml(actionButton.text)}</a></div>`;
   }
   
   // Add action buttons ONLY if user has selected a submenu option
   if (showActions && menuId) {
      buttonsHtml += `
         <div class="action-buttons">
            <button class="action-btn back-btn" onclick="initializeChat()">
               ← Back to Menu
            </button>
            <button class="action-btn ask-again-btn" onclick="selectMenu(${menuId})">
               🔄 Ask Again
            </button>
         </div>
      `;
   } else if (menuId) {
      // Just show Back to Menu button for main menu items
      buttonsHtml += `
         <div class="action-buttons">
            <button class="action-btn back-btn" onclick="initializeChat()">
               ← Back to Menu
            </button>
         </div>
      `;
   }
   
   messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text).replace(/\n/g, '<br>')}</div>${buttonsHtml}`;
   chatbotMessages.appendChild(messageDiv);
   
   setTimeout(() => scrollToBottom(), 100);
}

function escapeHtml(text) {
   const div = document.createElement('div');
   div.textContent = text;
   return div.innerHTML;
}

function scrollToBottom() {
   chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

chatbotSend.addEventListener('click', () => sendMessage());
chatbotInput.addEventListener('keypress', (e) => {
   if (e.key === 'Enter') sendMessage();
});