<style>
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    display: none;
}

.chatbot-widget.show-trigger {
    display: block;
}

.chatbot-trigger {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #AD6B4B 0%, #4F493F 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: transform 0.3s ease;
}

.chatbot-trigger:hover {
    transform: scale(1.1);
}

.chatbot-window {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 380px;
    height: 550px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    flex-direction: column;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.chatbot-window.active {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

.chatbot-header {
    background: linear-gradient(135deg, #AD6B4B 0%, #4F493F 100%);
    color: white;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chatbot-header-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.chatbot-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.chatbot-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}

.chatbot-status {
    font-size: 12px;
    opacity: 0.9;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f5f5f5;
}

.chatbot-message {
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbot-message.bot {
    display: flex;
    gap: 10px;
}

.chatbot-message.user {
    display: flex;
    justify-content: flex-end;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #AD6B4B;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.message-bubble {
    max-width: 75%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}

.message-bubble.bot {
    background: white;
    color: #333;
    border-bottom-left-radius: 5px;
}

.message-bubble.user {
    background: #AD6B4B;
    color: white;
    border-bottom-right-radius: 5px;
}

.chatbot-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}

.chatbot-btn {
    padding: 8px 14px;
    border-radius: 20px;
    border: 1px solid #AD6B4B;
    background: white;
    color: #AD6B4B;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.chatbot-btn:hover {
    background: #AD6B4B;
    color: white;
}

.chatbot-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #e0e0e0;
    display: flex;
    gap: 10px;
}

.chatbot-input {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
}

.chatbot-input:focus {
    border-color: #AD6B4B;
}

.chatbot-send {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #AD6B4B;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.chatbot-send:hover {
    background: #4F493F;
}

.chatbot-send:disabled {
    background: #ccc;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 120px);
        right: 20px;
        bottom: 90px;
    }
    
    .chatbot-window.active {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>

<div class="chatbot-widget">
    <button class="chatbot-trigger" id="chatbotTrigger">
        🌙
    </button>
    
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-avatar">🌙</div>
                <div>
                    <div class="chatbot-title">Ami</div>
                    <div class="chatbot-status">Ready to help!</div>
                </div>
            </div>
            <button class="chatbot-close" id="chatbotClose">×</button>
        </div>
        
        <div class="chatbot-messages" id="chatbotMessages"></div>
        
        <div class="chatbot-input-area">
            <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Type your message...">
            <button class="chatbot-send" id="chatbotSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
const chatbot = {
    isOpen: false,
    
    init() {
        this.bindEvents();
        this.initChat();
    },
    
    bindEvents() {
        const trigger = document.getElementById('chatbotTrigger');
        const headerTrigger = document.getElementById('chatbotHeaderBtn');
        
        if (trigger) {
            trigger.addEventListener('click', () => this.toggle());
        }
        
        if (headerTrigger) {
            headerTrigger.addEventListener('click', () => this.toggle());
        }
        
        document.getElementById('chatbotClose').addEventListener('click', () => this.close());
        document.getElementById('chatbotSend').addEventListener('click', () => this.sendMessage());
        document.getElementById('chatbotInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    },
    
    toggle() {
        this.isOpen = !this.isOpen;
        document.getElementById('chatbotWindow').classList.toggle('active', this.isOpen);
        if (this.isOpen) {
            document.getElementById('chatbotInput').focus();
        }
    },
    
    close() {
        this.isOpen = false;
        document.getElementById('chatbotWindow').classList.remove('active');
    },
    
    async initChat() {
        const response = await fetch('/Soleil-Lune/api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=init'
        });
        
        const data = await response.json();
        if (data.success) {
            this.addBotMessage(data.message, data.buttons);
        }
    },
    
    async sendMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();
        
        if (!message) return;
        
        this.addUserMessage(message);
        input.value = '';
        
        const response = await fetch('/Soleil-Lune/api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=message&message=${encodeURIComponent(message)}`
        });
        
        const data = await response.json();
        if (data.success) {
            this.addBotMessage(data.message, data.buttons, data.button);
        }
    },
    
    async selectMenu(menuId) {
        const response = await fetch('/Soleil-Lune/api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=menu&menu_id=${menuId}`
        });
        
        const data = await response.json();
        if (data.success) {
            this.addBotMessage(data.message, data.buttons);
        }
    },
    
    addUserMessage(text) {
        const messagesDiv = document.getElementById('chatbotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'chatbot-message user';
        messageDiv.innerHTML = `
            <div class="message-bubble user">${this.escapeHtml(text)}</div>
        `;
        messagesDiv.appendChild(messageDiv);
        this.scrollToBottom();
    },
    
    addBotMessage(text, buttons = [], actionButton = null) {
        const messagesDiv = document.getElementById('chatbotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'chatbot-message bot';
        
        let buttonsHtml = '';
        if (buttons && buttons.length > 0) {
            buttonsHtml = '<div class="chatbot-buttons">';
            buttons.forEach(btn => {
                if (btn.action === 'init') {
                    buttonsHtml += `<button class="chatbot-btn" onclick="chatbot.initChat()">${this.escapeHtml(btn.text)}</button>`;
                } else if (btn.id) {
                    buttonsHtml += `<button class="chatbot-btn" onclick="chatbot.selectMenu(${btn.id})">${this.escapeHtml(btn.text)}</button>`;
                }
            });
            buttonsHtml += '</div>';
        }
        
        if (actionButton) {
            buttonsHtml += `<div class="chatbot-buttons" style="margin-top: 8px;"><a href="${actionButton.link}" class="chatbot-btn" style="background: #AD6B4B; color: white; border-color: #AD6B4B;" target="_blank"><i class="fas fa-external-link-alt" style="font-size: 11px; margin-right: 5px;"></i>${this.escapeHtml(actionButton.text)}</a></div>`;
        }
        
        messageDiv.innerHTML = `
            <div class="message-avatar">🌙</div>
            <div>
                <div class="message-bubble bot">${this.escapeHtml(text).replace(/\n/g, '<br>')}</div>
                ${buttonsHtml}
            </div>
        `;
        
        messagesDiv.appendChild(messageDiv);
        this.scrollToBottom();
    },
    
    scrollToBottom() {
        const messagesDiv = document.getElementById('chatbotMessages');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    },
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
};

// Initialize chatbot when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => chatbot.init());
} else {
    chatbot.init();
}
</script>