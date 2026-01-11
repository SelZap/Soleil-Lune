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
         showGreeting();
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

// Send message (typed or clicked)
async function sendMessage(message = null) {
   const userMessage = message || chatbotInput.value.trim();
   if (!userMessage) return;

   // Add user message
   addMessage(userMessage, 'user');
   chatbotInput.value = '';

   // Show typing indicator
   const typingDiv = document.createElement('div');
   typingDiv.className = 'message bot';
   typingDiv.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
   chatbotMessages.appendChild(typingDiv);
   
   setTimeout(() => scrollToBottom(), 50);

   // Send to server - FIXED PATH
   try {
      const response = await fetch(window.location.origin + '/Soleil-Lune/includes/chatbot.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify({ message: userMessage })
      });

      if (!response.ok) {
         throw new Error('HTTP error! status: ' + response.status);
      }

      const data = await response.json();
      
      // Remove typing indicator
      typingDiv.remove();

      // Add bot response
addMessage(data.response, 'bot', data.button_text, data.button_link);

// Show additional menu if help was requested
if (userMessage.includes('help') || userMessage.includes('more topics')) {
   setTimeout(() => {
      addQuickReplies([
         { text: '🏪 Business Account', value: 'business' },
         { text: '📊 Trending Posts', value: 'trending' },
         { text: '📤 Post Format', value: 'post format' },
         { text: '🏷️ Categories', value: 'category' },
         { text: '🚫 Block Users', value: 'block' },
         { text: '📢 Report Content', value: 'report' }
      ]);
   }, 500);
}
   } catch (error) {
      typingDiv.remove();
      addMessage('Sorry, I encountered an error: ' + error.message, 'bot');
      console.error('Chatbot error:', error);
   }
}

function addMessage(text, sender, buttonText = null, buttonLink = null) {
   const messageDiv = document.createElement('div');
   messageDiv.className = `message ${sender}`;
   messageDiv.style.opacity = '0';
   messageDiv.style.transform = 'translateY(10px)';
   messageDiv.style.transition = 'all 0.3s ease';
   
   let html = `<div class="message-content">${text}</div>`;
   
   if (buttonText && buttonLink) {
      html += `<a href="${buttonLink}" class="message-button">${buttonText}</a>`;
   }
   
   messageDiv.innerHTML = html;
   chatbotMessages.appendChild(messageDiv);
   
   // Animate message in
   setTimeout(() => {
      messageDiv.style.opacity = '1';
      messageDiv.style.transform = 'translateY(0)';
   }, 10);
   
   setTimeout(() => scrollToBottom(), 100);
}

function addQuickReplies(options) {
   const quickReplyDiv = document.createElement('div');
   quickReplyDiv.className = 'quick-replies';
   
   options.forEach(option => {
      const btn = document.createElement('button');
      btn.className = 'quick-reply-btn';
      btn.textContent = option.text;
      btn.onclick = () => {
         quickReplyDiv.remove();
         sendMessage(option.value);
      };
      quickReplyDiv.appendChild(btn);
   });
   
   chatbotMessages.appendChild(quickReplyDiv);
   setTimeout(() => scrollToBottom(), 100);
}

function scrollToBottom() {
   chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

function showGreeting() {
   addMessage("Bonjour! 👋 I'm Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?", 'bot');
   
   // Add main topic buttons
   setTimeout(() => {
      addQuickReplies([
         { text: '✨ Account & Profile', value: 'personalize' },
         { text: '📝 Post Rules', value: 'post rules' },
         { text: '💬 Comment Rules', value: 'comment rules' },
         { text: '⚠️ Warnings & Bans', value: 'warnings' },
         { text: '🔍 Find People', value: 'find people' },
         { text: '📋 More Topics', value: 'help' }
      ]);
   }, 500);
}

function showMoreTopics() {
   addMessage("Here are more topics I can help with:", 'bot');
   
   setTimeout(() => {
      addQuickReplies([
         { text: '🏪 Business Account', value: 'business' },
         { text: '📊 Trending Posts', value: 'trending' },
         { text: '📤 Post Format', value: 'post format' },
         { text: '🏷️ Categories', value: 'category' },
         { text: '🚫 Blocking Users', value: 'block' },
         { text: '📢 Report Content', value: 'report' },
         { text: '🔙 Back to Main', value: 'help' }
      ]);
   }, 500);
}

chatbotSend.addEventListener('click', () => sendMessage());
chatbotInput.addEventListener('keypress', (e) => {
   if (e.key === 'Enter') sendMessage();
});