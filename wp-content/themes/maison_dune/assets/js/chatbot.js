(function () {
  "use strict";

  const API = window.location.origin + "/maison_dune_api/public/index.php/api";

  const SUGGESTIONS = [
    { label: "🍽️ Restaurant", text: "Tell me about the restaurant" },
    { label: "📅 Availability", text: "Are there tables available?" },
    { label: "🏨 Rooms", text: "What rooms do you have?" },
    { label: "📋 My Bookings", text: "View my reservations" },
    { label: "🎉 Events", text: "Information about private events" },
    { label: "📍 Location", text: "Where are you located?" },
  ];

  function createWidget() {
    const wrapper = document.createElement("div");
    wrapper.id = "maison-chatbot";
    wrapper.innerHTML = `
      <button id="chatbot-toggle" aria-label="Chat assistant">
        <svg id="chatbot-icon-open" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
        </svg>
        <svg id="chatbot-icon-close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>

      <div id="chatbot-window">
        <div id="chatbot-header">
          <div class="chatbot-header-info">
            <div class="chatbot-avatar">M</div>
            <div>
              <div class="chatbot-title">Maison Dune</div>
              <div class="chatbot-subtitle">Virtual Concierge</div>
            </div>
          </div>
          <button id="chatbot-minimize" aria-label="Minimize">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
          </button>
        </div>
        
        <div id="chatbot-messages">
          <div class="chat-msg bot">
            <div class="msg-avatar">M</div>
            <div class="msg-content">
              <p>Welcome to <strong>Maison Dune</strong>. I am your virtual concierge. How may I assist you?</p>
            </div>
          </div>
          <div id="chatbot-suggestions">
            ${SUGGESTIONS.map(s => `<button class="suggestion-chip" data-text="${s.text}">${s.label}</button>`).join("")}
          </div>
        </div>

        <div id="chatbot-input-area">
          <input type="text" id="chatbot-input" placeholder="Type your question..." maxlength="500" autocomplete="off" />
          <button id="chatbot-send" aria-label="Send">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
          </button>
        </div>
      </div>
    `;
    document.body.appendChild(wrapper);
  }

  function formatReply(text) {
    return text
      .replace(/\*\*(.+?)\*\*/g, "<strong>$1</strong>")
      .replace(/\n/g, "<br>");
  }

  function addMessage(text, sender, extra) {
    const messagesEl = document.getElementById("chatbot-messages");
    const suggestions = document.getElementById("chatbot-suggestions");
    if (suggestions) suggestions.remove();

    const msg = document.createElement("div");
    msg.className = `chat-msg ${sender}`;

    if (sender === "bot") {
      msg.innerHTML = `
        <div class="msg-avatar">M</div>
        <div class="msg-content"><p>${formatReply(text)}</p>
          ${extra && extra.type === "action" && extra.data
            ? `<a href="${extra.data.link}" class="msg-action-btn">${extra.data.label}</a>`
            : ""
          }
        </div>`;
    } else {
      msg.innerHTML = `<div class="msg-content"><p>${text}</p></div>`;
    }

    messagesEl.appendChild(msg);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function showTyping() {
    const messagesEl = document.getElementById("chatbot-messages");
    const typing = document.createElement("div");
    typing.className = "chat-msg bot typing-indicator";
    typing.id = "chatbot-typing";
    typing.innerHTML = `
      <div class="msg-avatar">M</div>
      <div class="msg-content"><div class="typing-dots"><span></span><span></span><span></span></div></div>`;
    messagesEl.appendChild(typing);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function hideTyping() {
    const el = document.getElementById("chatbot-typing");
    if (el) el.remove();
  }

  async function sendMessage(text) {
    if (!text.trim()) return;

    addMessage(text, "user");
    showTyping();

    const token = localStorage.getItem("maison_token");
    const endpoint = token ? `${API}/chatbot/auth` : `${API}/chatbot`;

    try {
      const res = await fetch(endpoint, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          ...(token ? { Authorization: `Bearer ${token}` } : {}),
        },
        body: JSON.stringify({ message: text }),
      });

      const data = await res.json();
      hideTyping();

      if (data.success) {
        addMessage(data.reply, "bot", data);
      } else {
        addMessage("Sorry, something went wrong. Please try again.", "bot");
      }
    } catch {
      hideTyping();
      addMessage("Could not connect to the server. Please try again later.", "bot");
    }
  }

  function bindEvents() {
    const toggle = document.getElementById("chatbot-toggle");
    const window_ = document.getElementById("chatbot-window");
    const minimize = document.getElementById("chatbot-minimize");
    const input = document.getElementById("chatbot-input");
    const send = document.getElementById("chatbot-send");
    const iconOpen = document.getElementById("chatbot-icon-open");
    const iconClose = document.getElementById("chatbot-icon-close");

    let isOpen = false;

    function toggleChat() {
      isOpen = !isOpen;
      window_.classList.toggle("open", isOpen);
      toggle.classList.toggle("active", isOpen);
      iconOpen.style.display = isOpen ? "none" : "block";
      iconClose.style.display = isOpen ? "block" : "none";
      if (isOpen) input.focus();
    }

    toggle.addEventListener("click", toggleChat);
    minimize.addEventListener("click", toggleChat);

    send.addEventListener("click", () => {
      sendMessage(input.value);
      input.value = "";
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        sendMessage(input.value);
        input.value = "";
      }
    });

    document.addEventListener("click", (e) => {
      if (e.target.classList.contains("suggestion-chip")) {
        sendMessage(e.target.dataset.text);
      }
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    createWidget();
    bindEvents();
  });
})();
