document.documentElement.classList.add('js');

window.dataLayer = window.dataLayer || [];
function trackEvent(event, details = {}) {
    window.dataLayer.push({ event, ...details });
}

const registrationModal = document.querySelector('#registration-modal');
const successModal = document.querySelector('#success-modal');
const participationModal = document.querySelector('#participation-modal');
const legalModal = document.querySelector('#legal-modal');
const storyModal = document.querySelector('#story-modal');
const registrationForms = [...document.querySelectorAll('[data-registration-form]')];
const dialogOpeners = new WeakMap();
const switchingDialogs = new WeakSet();
let legalReturnDialog = null;
const successPath = successModal?.dataset.successPath || '/dang-ky-thanh-cong';
let successReturnUrl = '';
let closingSuccessFromHistory = false;

function openDialog(dialog, opener = document.activeElement) {
    if (!dialog) return;
    if (dialog.open) return;
    document.querySelectorAll('dialog[open]').forEach((other) => {
        switchingDialogs.add(other);
        closeDialog(other);
    });
    dialogOpeners.set(dialog, opener);
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
}

function closeDialog(dialog) {
    if (!dialog) return;
    if (typeof dialog.close === 'function') {
        dialog.close();
    } else {
        dialog.removeAttribute('open');
    }
}

function currentRelativeUrl() {
    return `${window.location.pathname}${window.location.search}${window.location.hash}`;
}

function showSuccessDialog(result, opener) {
    if (!successModal) return;
    const reference = successModal.querySelector('[data-success-reference]');
    if (reference) {
        reference.textContent = result.reference ? `Mã hồ sơ: ${result.reference}` : '';
        reference.hidden = !result.reference;
    }
    successReturnUrl = currentRelativeUrl();
    if (result.duplicate !== true && window.location.pathname !== successPath) {
        history.pushState({ registrationSuccess: true, returnUrl: successReturnUrl }, '', successPath);
    }
    openDialog(successModal, opener);
}

function syncRegistrationForms(sourceForm = null) {
    const source = sourceForm || registrationForms[0];
    if (!source) return;

    const values = new FormData(source);
    const samePhone = source.querySelector('[data-zalo-same-phone]');
    if (samePhone?.checked) {
        source.elements.namedItem('zalo').value = source.elements.namedItem('phone').value;
        values.set('zalo', source.elements.namedItem('phone').value);
    }
    source.elements.namedItem('zalo').readOnly = Boolean(samePhone?.checked);
    registrationForms.forEach((target) => {
        if (target === source) return;
        values.forEach((value, name) => {
            if (name === 'form_location' || name === 'website') return;
            const field = target.elements.namedItem(name);
            if (field && field.type !== 'checkbox') field.value = value;
        });
        target.querySelector('[data-zalo-same-phone]').checked = Boolean(samePhone?.checked);
        target.elements.namedItem('zalo').readOnly = Boolean(samePhone?.checked);
    });
}

document.querySelectorAll('[data-open-registration]').forEach((trigger) => {
    trigger.addEventListener('click', () => {
        trackEvent('form_open', { source_page: document.body.className.replace('page page--', '') });
        syncRegistrationForms();
        openDialog(registrationModal);
    });
});

const attributionNames = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
const attribution = {};
const currentParameters = new URLSearchParams(window.location.search);
attributionNames.forEach((name) => {
    const incoming = currentParameters.get(name);
    if (incoming) {
        attribution[name] = incoming.slice(0, 255);
        try { sessionStorage.setItem(`xanhsm_${name}`, attribution[name]); } catch { /* Attribution remains in memory. */ }
    } else {
        try { attribution[name] = sessionStorage.getItem(`xanhsm_${name}`) || ''; } catch { attribution[name] = ''; }
    }
});
const incomingClickId = currentParameters.get('gclid') || currentParameters.get('fbclid') || '';
if (incomingClickId) {
    attribution.click_id = incomingClickId.slice(0, 255);
    try { sessionStorage.setItem('xanhsm_click_id', attribution.click_id); } catch { /* Attribution remains in memory. */ }
} else {
    try { attribution.click_id = sessionStorage.getItem('xanhsm_click_id') || ''; } catch { attribution.click_id = ''; }
}

registrationForms.forEach((form) => {
    const sourceUrl = form.elements.namedItem('source_url');
    if (sourceUrl) sourceUrl.value = window.location.href.slice(0, 2048);
    Object.entries(attribution).forEach(([name, value]) => {
        const field = form.elements.namedItem(name);
        if (field) field.value = value;
    });
});

document.querySelectorAll('[data-open-legal]').forEach((trigger) => {
    trigger.addEventListener('click', () => {
        const parentDialog = trigger.closest('dialog');
        legalReturnDialog = parentDialog;
        openDialog(legalModal, trigger);
    });
});

document.querySelectorAll('[data-close-modal]').forEach((button) => {
    button.addEventListener('click', () => closeDialog(button.closest('dialog')));
});

document.querySelectorAll('dialog').forEach((dialog) => {
    dialog.addEventListener('keydown', (event) => {
        if (event.key !== 'Tab') return;
        const focusable = [...dialog.querySelectorAll('button, a[href], input, select, textarea, summary, [tabindex="0"]')]
            .filter((element) => !element.disabled && element.getClientRects().length > 0);
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (!first) return;
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });
    dialog.addEventListener('click', (event) => {
        const rect = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) closeDialog(dialog);
    });
    dialog.addEventListener('close', () => {
        if (switchingDialogs.has(dialog)) {
            switchingDialogs.delete(dialog);
            return;
        }
        if (dialog === legalModal && legalReturnDialog) {
            const previous = legalReturnDialog;
            legalReturnDialog = null;
            openDialog(previous, dialogOpeners.get(previous));
        }
        if (dialog === successModal) {
            if (!closingSuccessFromHistory && successReturnUrl && window.location.pathname === successPath) {
                history.replaceState(null, '', successReturnUrl);
            }
            closingSuccessFromHistory = false;
            successReturnUrl = '';
        }
        const opener = dialogOpeners.get(dialog);
        if (opener?.isConnected) opener.focus({ preventScroll: true });
    });
});

registrationForms.forEach((form) => {
    let formStarted = false;
    form.addEventListener('input', (event) => {
        if (!formStarted) {
            formStarted = true;
            trackEvent('form_start', {
                source_page: form.elements.namedItem('source_page')?.value || '',
                form_location: form.elements.namedItem('form_location')?.value || '',
            });
        }
        syncRegistrationForms(form);
        const field = event.target;
        if (field?.name) {
            field.removeAttribute('aria-invalid');
            const error = form.querySelector(`[data-field-error="${CSS.escape(field.name)}"]`);
            if (error) error.textContent = '';
        }
    });
    form.addEventListener('change', () => syncRegistrationForms(form));

    const samePhone = form.querySelector('[data-zalo-same-phone]');
    const phone = form.elements.namedItem('phone');
    const zalo = form.elements.namedItem('zalo');

    samePhone?.addEventListener('change', () => {
        syncRegistrationForms(form);
    });

    phone?.addEventListener('input', () => {
        if (samePhone?.checked && zalo) zalo.value = phone.value;
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const status = form.querySelector('.form-status');
        const submit = form.querySelector('[data-submit-registration]');
        if (!status || !submit) return;

        form.querySelectorAll('[data-field-error]').forEach((error) => { error.textContent = ''; });
        form.querySelectorAll('[aria-invalid="true"]').forEach((field) => field.removeAttribute('aria-invalid'));
        if (!form.reportValidity()) return;

        submit.disabled = true;
        const originalLabel = submit.textContent;
        submit.textContent = 'Đang gửi…';
        status.hidden = true;
        status.removeAttribute('data-state');

        try {
            const response = await fetch('/api/leads', {
                method: 'POST',
                headers: { Accept: 'application/json' },
                body: new FormData(form),
            });
            const result = await response.json().catch(() => ({}));

            if (!response.ok || result.ok !== true) {
                Object.entries(result.errors || {}).forEach(([name, message]) => {
                    const field = form.elements.namedItem(name);
                    const error = form.querySelector(`[data-field-error="${CSS.escape(name)}"]`);
                    field?.setAttribute('aria-invalid', 'true');
                    if (error) error.textContent = message;
                });
                throw new Error(result.message || 'Không thể gửi thông tin lúc này. Vui lòng thử lại.');
            }

            status.textContent = result.reference ? `${result.message} Mã hồ sơ: ${result.reference}` : result.message;
            status.dataset.state = 'success';
            status.hidden = false;

            if (result.duplicate !== true) {
                trackEvent('generate_lead', {
                    source_page: form.elements.namedItem('source_page')?.value || '',
                    form_location: form.elements.namedItem('form_location')?.value || '',
                    vehicle: form.elements.namedItem('vehicle')?.value || '',
                    cooperation_type: form.elements.namedItem('cooperation_type')?.value || '',
                });
            }

            const nextToken = [...crypto.getRandomValues(new Uint8Array(16))]
                .map((value) => value.toString(16).padStart(2, '0'))
                .join('');
            registrationForms.forEach((item) => {
                const token = item.elements.namedItem('submission_token');
                if (token) token.value = nextToken;
            });
            syncRegistrationForms(form);
            showSuccessDialog(result, submit);
        } catch (error) {
            status.textContent = error instanceof Error ? error.message : 'Không thể gửi thông tin lúc này. Vui lòng thử lại.';
            status.dataset.state = 'error';
            status.hidden = false;
        } finally {
            submit.disabled = false;
            submit.textContent = originalLabel;
            if (status.dataset.state === 'error') status.focus?.({ preventScroll: true });
        }
    });
});

if (successModal?.hasAttribute('data-auto-open')) {
    successReturnUrl = '/';
    window.requestAnimationFrame(() => openDialog(successModal, document.body));
}

window.addEventListener('popstate', (event) => {
    if (successModal?.open && window.location.pathname !== successPath) {
        closingSuccessFromHistory = true;
        closeDialog(successModal);
    } else if (successModal && !successModal.open && window.location.pathname === successPath && event.state?.registrationSuccess) {
        successReturnUrl = event.state.returnUrl || '/';
        openDialog(successModal, document.body);
    }
});

let selectedParticipation = '';
let selectedParticipationOption = null;
let selectedParticipationTab = 'policies';
const participationDataNode = document.querySelector('#participation-data');
let participationOptions = [];

if (participationDataNode) {
    try {
        participationOptions = JSON.parse(participationDataNode.textContent || '[]');
    } catch {
        participationOptions = [];
    }
}

function renderParticipationTab() {
    if (!participationModal || !selectedParticipationOption) return;
    const panel = participationModal.querySelector('[data-participation-panel]');
    if (!panel) return;

    participationModal.querySelectorAll('[data-participation-tab]').forEach((tab) => {
        tab.setAttribute('aria-selected', String(tab.dataset.participationTab === selectedParticipationTab));
    });

    if (selectedParticipationTab === 'policies') {
        const list = document.createElement('dl');
        list.className = 'participation-policy-list';
        selectedParticipationOption.policies.forEach((item) => {
            const row = document.createElement('div');
            const label = document.createElement('dt');
            const value = document.createElement('dd');
            label.textContent = item.label;
            value.textContent = item.value;
            row.append(label, value);
            list.append(row);
        });
        panel.replaceChildren(list);
        return;
    }

    if (selectedParticipationTab === 'process') {
        const list = document.createElement('ol');
        list.className = 'participation-process-list';
        selectedParticipationOption.process.forEach((item, index) => {
            const row = document.createElement('li');
            const number = document.createElement('span');
            const content = document.createElement('div');
            const title = document.createElement('strong');
            const description = document.createElement('p');
            number.textContent = String(index + 1);
            title.textContent = item.title;
            description.textContent = item.description;
            content.append(title, description);
            row.append(number, content);
            list.append(row);
        });
        panel.replaceChildren(list);
        return;
    }

    const list = document.createElement('div');
    list.className = 'participation-faq-list';
    selectedParticipationOption.faqs.forEach((item, index) => {
        const detail = document.createElement('details');
        const summary = document.createElement('summary');
        const answer = document.createElement('p');
        if (index === 0) detail.open = true;
        summary.textContent = item.question;
        answer.textContent = item.answer;
        detail.append(summary, answer);
        list.append(detail);
    });
    panel.replaceChildren(list);
}

participationModal?.querySelectorAll('[data-participation-tab]').forEach((tab) => {
    tab.addEventListener('click', () => {
        selectedParticipationTab = tab.dataset.participationTab || 'policies';
        renderParticipationTab();
    });
});

document.querySelectorAll('[data-open-participation]').forEach((button) => {
    button.addEventListener('click', () => {
        const key = button.dataset.option || '';
        const option = participationOptions.find((item) => item.key === key);
        if (!option || !participationModal) return;

        selectedParticipation = key;
        const title = participationModal.querySelector('[data-participation-title]');
        const intro = participationModal.querySelector('[data-participation-intro]');
        const list = participationModal.querySelector('[data-participation-highlights]');

        if (title) title.textContent = option.title;
        if (intro) intro.textContent = option.intro;
        if (list) {
            list.replaceChildren(...option.highlights.map((text) => {
                const item = document.createElement('li');
                item.textContent = text;
                return item;
            }));
        }

        selectedParticipationOption = option;
        selectedParticipationTab = 'policies';
        renderParticipationTab();

        trackEvent('view_bike_details', { cooperation_type: key });

        openDialog(participationModal);
    });
});

document.querySelector('[data-select-participation]')?.addEventListener('click', () => {
    document.querySelectorAll('[data-cooperation-select]').forEach((select) => {
        select.value = selectedParticipation;
    });
    openDialog(registrationModal, dialogOpeners.get(participationModal));
});

const countdown = document.querySelector('[data-countdown]');
if (countdown) {
    const duration = Number(countdown.dataset.duration || 28800) * 1000;
    const storageKey = countdown.dataset.storageKey || 'xanhsm-bike-countdown-target';
    let target = 0;
    try { target = Number(sessionStorage.getItem(storageKey)); } catch { /* Private browsing may block storage. */ }

    if (!Number.isFinite(target) || target <= 0) {
        target = Date.now() + duration;
        try { sessionStorage.setItem(storageKey, String(target)); } catch { /* Keep the demo in memory. */ }
    }

    const hours = countdown.querySelector('[data-hours]');
    const minutes = countdown.querySelector('[data-minutes]');
    const seconds = countdown.querySelector('[data-seconds]');

    const updateCountdown = () => {
        const remaining = Math.max(0, target - Date.now());
        const totalSeconds = Math.floor(remaining / 1000);
        const hourValue = Math.floor(totalSeconds / 3600);
        const minuteValue = Math.floor((totalSeconds % 3600) / 60);
        const secondValue = totalSeconds % 60;

        if (hours) hours.textContent = String(hourValue).padStart(2, '0');
        if (minutes) minutes.textContent = String(minuteValue).padStart(2, '0');
        if (seconds) seconds.textContent = String(secondValue).padStart(2, '0');
    };

    updateCountdown();
    window.setInterval(updateCountdown, 1000);
}

const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileDrawer = document.querySelector('#mobile-drawer');
menuToggle?.addEventListener('click', () => {
    const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!expanded));
    menuToggle.setAttribute('aria-label', expanded ? 'Mở menu' : 'Đóng menu');
    if (mobileDrawer) mobileDrawer.hidden = expanded;
});

const supportWidget = document.querySelector('[data-support-widget]');
const supportToggle = supportWidget?.querySelector('[data-support-toggle]');
const supportActions = supportWidget?.querySelector('.support-widget__actions');

supportToggle?.addEventListener('click', () => {
    const expanded = supportToggle.getAttribute('aria-expanded') === 'true';
    supportToggle.setAttribute('aria-expanded', String(!expanded));
    if (supportActions) supportActions.hidden = expanded;
});

supportWidget?.querySelector('a[href^="tel:"]')?.addEventListener('click', () => trackEvent('click_call'));
supportWidget?.querySelector('a[target="_blank"]')?.addEventListener('click', () => trackEvent('click_zalo'));

const carousel = document.querySelector('[data-carousel]');
const track = carousel?.querySelector('[data-carousel-track]');
const cards = track ? [...track.querySelectorAll('[data-story-card]')] : [];
const currentLabel = carousel?.querySelector('[data-carousel-current]');
let currentStory = 0;
let storyTimer = 0;

function scrollToStory(index) {
    if (!track || cards.length === 0) return;
    currentStory = (index + cards.length) % cards.length;
    track.scrollTo({
        left: cards[currentStory].offsetLeft - track.offsetLeft,
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth',
    });
    if (currentLabel) currentLabel.textContent = String(currentStory + 1);
}

carousel?.querySelector('[data-carousel-prev]')?.addEventListener('click', () => scrollToStory(currentStory - 1));
carousel?.querySelector('[data-carousel-next]')?.addEventListener('click', () => scrollToStory(currentStory + 1));

function stopStoryAutoplay() {
    if (storyTimer) window.clearInterval(storyTimer);
    storyTimer = 0;
}

function startStoryAutoplay() {
    stopStoryAutoplay();
    if (
        cards.length < 2
        || !window.matchMedia('(min-width: 768px)').matches
        || window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) return;
    storyTimer = window.setInterval(() => scrollToStory(currentStory + 1), 7000);
}

carousel?.addEventListener('pointerenter', stopStoryAutoplay);
carousel?.addEventListener('pointerleave', startStoryAutoplay);
carousel?.addEventListener('focusin', stopStoryAutoplay);
carousel?.addEventListener('focusout', (event) => {
    if (!carousel.contains(event.relatedTarget)) startStoryAutoplay();
});

document.querySelectorAll('[data-open-story-image]').forEach((trigger) => {
    trigger.addEventListener('click', () => {
        const image = storyModal?.querySelector('[data-story-modal-image]');
        if (!image || !storyModal) return;
        image.src = trigger.dataset.image || '';
        image.alt = trigger.dataset.alt || 'Ảnh chia sẻ của tài xế';
        stopStoryAutoplay();
        openDialog(storyModal);
    });
});

storyModal?.addEventListener('close', startStoryAutoplay);

track?.addEventListener('scroll', () => {
    if (!track || cards.length === 0) return;
    const trackLeft = track.getBoundingClientRect().left;
    let nearest = 0;
    let nearestDistance = Number.POSITIVE_INFINITY;

    cards.forEach((card, index) => {
        const distance = Math.abs(card.getBoundingClientRect().left - trackLeft);
        if (distance < nearestDistance) {
            nearestDistance = distance;
            nearest = index;
        }
    });

    currentStory = nearest;
    if (currentLabel) currentLabel.textContent = String(nearest + 1);
}, { passive: true });

startStoryAutoplay();
window.matchMedia('(min-width: 768px)').addEventListener('change', startStoryAutoplay);
window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', startStoryAutoplay);

// Keep the floating support control clear of forms, CTA buttons and the footer.
const supportProtected = [...document.querySelectorAll('.registration-section, .countdown-strip, .faq, .site-footer, .taxi-hero__actions, .rto-hero__actions, .van-hero__actions, .participation-card .button')];
supportProtected.push(...document.querySelectorAll('.page--taxi .section-heading, .page--taxi .benefit-card, .page--taxi .document-list, .page--taxi .process-list, .page--taxi .story-carousel'));
let supportFrame = 0;
function positionSupport() {
    supportFrame = 0;
    if (!supportWidget) return;
    const bubble = supportWidget.getBoundingClientRect();
    const overlaps = supportProtected.some((element) => {
        const rect = element.getBoundingClientRect();
        return rect.left < bubble.right && rect.right > bubble.left && rect.top < bubble.bottom && rect.bottom > bubble.top;
    });
    supportWidget.toggleAttribute('data-obscured', overlaps);
    if (overlaps && supportActions) {
        supportActions.hidden = true;
        supportToggle?.setAttribute('aria-expanded', 'false');
    }
}
function scheduleSupport() {
    if (!supportFrame) supportFrame = requestAnimationFrame(positionSupport);
}
window.addEventListener('scroll', scheduleSupport, { passive: true });
window.addEventListener('resize', scheduleSupport);
window.addEventListener('load', scheduleSupport);
positionSupport();
