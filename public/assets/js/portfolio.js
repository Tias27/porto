window.addEventListener('load', () => {
    document.getElementById('loader')?.classList.add('hidden');
});

if (window.AOS) {
    AOS.init({ duration: 700, once: true, offset: 80 });
}

const progress = document.getElementById('scrollProgress');
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    const percent = max > 0 ? (window.scrollY / max) * 100 : 0;
    progress.style.width = `${percent}%`;
    backToTop.classList.toggle('show', window.scrollY > 500);
});

backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

document.getElementById('themeToggle')?.addEventListener('click', () => {
    const root = document.documentElement;
    root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
});

const aiWidget = document.getElementById('aiChatWidget');
const aiToggle = document.getElementById('aiChatToggle');
const aiClose = document.getElementById('aiChatClose');
const aiForm = document.getElementById('aiChatForm');
const aiInput = document.getElementById('aiChatInput');
const aiMessages = document.getElementById('aiChatMessages');
const aiHistory = [];
let aiDragState = null;
let aiSkipNextClick = false;

const escapeHtml = (value) => value
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');

const linkifyMessage = (value) => {
    const escaped = escapeHtml(value);

    return escaped
        .replace(/(https?:\/\/[^\s<]+)/g, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>')
        .replace(/([\w.+-]+@[\w-]+\.[\w.-]+)/g, '<a href="mailto:$1">$1</a>');
};

const addAiMessage = (role, content, extraClass = '') => {
    if (!aiMessages) return null;

    const message = document.createElement('div');
    message.className = `ai-message ${role} ${extraClass}`.trim();
    message.innerHTML = linkifyMessage(content);
    aiMessages.appendChild(message);
    aiMessages.scrollTop = aiMessages.scrollHeight;

    return message;
};

const clampAiWidgetPosition = (x, y) => {
    if (!aiWidget) return { x: 0, y: 0 };

    const rect = aiWidget.getBoundingClientRect();
    const padding = 10;
    const maxX = window.innerWidth - rect.width - padding;
    const maxY = window.innerHeight - rect.height - padding;

    return {
        x: Math.min(Math.max(padding, x), Math.max(padding, maxX)),
        y: Math.min(Math.max(padding, y), Math.max(padding, maxY)),
    };
};

const setAiWidgetPosition = (x, y, save = false) => {
    if (!aiWidget) return;

    const position = clampAiWidgetPosition(x, y);
    aiWidget.style.left = `${position.x}px`;
    aiWidget.style.top = `${position.y}px`;
    aiWidget.style.right = 'auto';
    aiWidget.style.bottom = 'auto';

    if (save) {
        localStorage.setItem('aiChatPosition', JSON.stringify(position));
    }
};

const restoreAiWidgetPosition = () => {
    if (!aiWidget) return;

    try {
        const saved = JSON.parse(localStorage.getItem('aiChatPosition') || 'null');
        if (saved && Number.isFinite(saved.x) && Number.isFinite(saved.y)) {
            setAiWidgetPosition(saved.x, saved.y);
        }
    } catch (error) {
        localStorage.removeItem('aiChatPosition');
    }
};

restoreAiWidgetPosition();

window.addEventListener('resize', () => {
    if (!aiWidget || aiWidget.style.left === '') return;

    const rect = aiWidget.getBoundingClientRect();
    setAiWidgetPosition(rect.left, rect.top, true);
});

aiToggle?.addEventListener('pointerdown', (event) => {
    if (!aiWidget) return;

    const rect = aiWidget.getBoundingClientRect();
    aiDragState = {
        pointerId: event.pointerId,
        startX: event.clientX,
        startY: event.clientY,
        offsetX: event.clientX - rect.left,
        offsetY: event.clientY - rect.top,
        moved: false,
    };

    aiToggle.setPointerCapture(event.pointerId);
});

aiToggle?.addEventListener('pointermove', (event) => {
    if (!aiDragState || aiDragState.pointerId !== event.pointerId) return;

    const deltaX = Math.abs(event.clientX - aiDragState.startX);
    const deltaY = Math.abs(event.clientY - aiDragState.startY);

    if (deltaX > 4 || deltaY > 4) {
        aiDragState.moved = true;
        aiWidget?.classList.add('dragging');
        setAiWidgetPosition(event.clientX - aiDragState.offsetX, event.clientY - aiDragState.offsetY);
    }
});

aiToggle?.addEventListener('pointerup', (event) => {
    if (!aiDragState || aiDragState.pointerId !== event.pointerId) return;

    if (aiDragState.moved && aiWidget) {
        const rect = aiWidget.getBoundingClientRect();
        setAiWidgetPosition(rect.left, rect.top, true);
        aiSkipNextClick = true;
        event.preventDefault();
    }

    aiWidget?.classList.remove('dragging');
    aiDragState = null;
});

aiToggle?.addEventListener('click', (event) => {
    if (aiSkipNextClick) {
        aiSkipNextClick = false;
        event.preventDefault();
        return;
    }

    aiWidget?.classList.toggle('open');
    setTimeout(() => aiInput?.focus(), 80);
});

aiClose?.addEventListener('click', () => aiWidget?.classList.remove('open'));

aiForm?.addEventListener('submit', async (event) => {
    event.preventDefault();

    const message = aiInput?.value.trim();
    if (!message) return;

    aiInput.value = '';
    addAiMessage('user', message);
    aiHistory.push({ role: 'user', content: message });

    const loading = addAiMessage('bot', 'Lagi mikir sebentar...', 'loading');

    try {
        const formData = new FormData();
        formData.append('message', message);
        formData.append('history', JSON.stringify(aiHistory.slice(-8)));

        const response = await fetch('/api/chat', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await response.json();
        const reply = data.reply || 'Belum ada jawaban dari AI';

        if (loading) {
            loading.classList.remove('loading');
            loading.innerHTML = linkifyMessage(reply);
        }

        aiHistory.push({ role: 'assistant', content: reply });
    } catch (error) {
        const reply = 'Chat lagi belum nyambung. Coba ulang sebentar lagi ya';

        if (loading) {
            loading.classList.remove('loading');
            loading.innerHTML = linkifyMessage(reply);
        }

        aiHistory.push({ role: 'assistant', content: reply });
    }
});
