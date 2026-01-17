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

// Get current time in 12-hour format
function getCurrentTime() {
   const now = new Date();
   let hours = now.getHours();
   const minutes = now.getMinutes();
   const ampm = hours >= 12 ? 'PM' : 'AM';
   
   hours = hours % 12;
   hours = hours ? hours : 12; // 0 should be 12
   const minutesStr = minutes < 10 ? '0' + minutes : minutes;
   
   return `${hours}:${minutesStr} ${ampm}`;
}

// Show typing indicator
function showTypingIndicator() {
   const typingDiv = document.createElement('div');
   typingDiv.className = 'message bot show';
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

// Remove all buttons from previous messages
function removeAllButtons() {
   document.querySelectorAll('.quick-replies, .action-buttons').forEach(el => el.remove());
}

// Initialize chat (back to main menu)
async function initializeChat() {
   // Don't clear messages, just remove buttons
   removeAllButtons();
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
         addBotMessage(data.message, data.buttons);
      }
   }, 1500);
}

// Send message (typed or clicked)
async function sendMessage(message = null) {
   const userMessage = message || chatbotInput.value.trim();
   if (!userMessage) return;

   addMessage(userMessage, 'user');
   chatbotInput.value = '';
   removeAllButtons();
   showTypingIndicator();

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
         removeTypingIndicator();

         if (data.success) {
            addBotMessage(data.message, data.buttons, data.button);
         }
      } catch (error) {
         removeTypingIndicator();
         addMessage('Sorry, I encountered an error: ' + error.message, 'bot');
         console.error('Chatbot error:', error);
      }
   }, 1500);
}

// Select menu option
async function selectMenu(menuId, buttonText, isAskAgain = false) {
   if (buttonText && !isAskAgain) {
      addMessage(buttonText, 'user');
   }
   
   removeAllButtons();
   showTypingIndicator();
   
   setTimeout(async () => {
      const response = await fetch('/Soleil-Lune/api/chatbot.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
         body: `action=menu&menu_id=${menuId}&is_ask_again=${isAskAgain ? '1' : '0'}`
      });
      
      const data = await response.json();
      removeTypingIndicator();
      
      if (data.success) {
         // Check if has children buttons
         const hasChildren = data.buttons && data.buttons.length > 0;
         addBotMessage(data.message, data.buttons, null, menuId, !hasChildren, data.parent_id);
      }
   }, 1500);
}

function addMessage(text, sender) {
   const messageDiv = document.createElement('div');
   messageDiv.className = `message ${sender}`;
   
   const timestamp = getCurrentTime();
   
   messageDiv.innerHTML = `
      <div class="message-content">${escapeHtml(text)}</div>
      <div class="message-timestamp">${timestamp}</div>
   `;
   chatbotMessages.appendChild(messageDiv);
   
   // Trigger animation
   setTimeout(() => {
      messageDiv.classList.add('show');
   }, 10);
   
   setTimeout(() => scrollToBottom(), 100);
}

function addBotMessage(text, buttons = [], actionButton = null, menuId = null, showAskAgain = false, parentId = null) {
   const messageDiv = document.createElement('div');
   messageDiv.className = 'message bot';
   
   const timestamp = getCurrentTime();
   
   let buttonsHtml = '';
   
   // Quick reply buttons
   if (buttons && buttons.length > 0) {
      buttonsHtml = '<div class="quick-replies">';
      buttons.forEach(btn => {
         if (btn.id) {
            buttonsHtml += `<button class="quick-reply-btn" onclick="selectMenu(${btn.id}, '${escapeHtml(btn.text).replace(/'/g, "\\'")}')">${escapeHtml(btn.text)}</button>`;
         }
      });
      buttonsHtml += '</div>';
   }
   
   // External link button
   if (actionButton) {
      buttonsHtml += `<div class="quick-replies" style="margin-top: 8px;"><a href="${actionButton.link}" class="message-button" target="_blank">${escapeHtml(actionButton.text)}</a></div>`;
   }
   
   // Action buttons - removed emoji from Ask Again button
   if (menuId) {
      buttonsHtml += '<div class="action-buttons">';
      buttonsHtml += `<button class="action-btn back-btn" onclick="initializeChat()">← Back to Menu</button>`;
      
      // "Ask Again" brings back the parent menu's options - NO EMOJI
      if (showAskAgain && parentId) {
         buttonsHtml += `<button class="action-btn ask-again-btn" onclick="selectMenu(${parentId}, null, true)">Ask Again</button>`;
      }
      
      buttonsHtml += '</div>';
   }
   
   messageDiv.innerHTML = `
      <div class="message-content">${escapeHtml(text).replace(/\n/g, '<br>')}</div>
      <div class="message-timestamp">${timestamp}</div>
      ${buttonsHtml}
   `;
   chatbotMessages.appendChild(messageDiv);
   
   // Trigger animation
   setTimeout(() => {
      messageDiv.classList.add('show');
   }, 10);
   
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