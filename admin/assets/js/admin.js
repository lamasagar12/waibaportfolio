document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sg-sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
    }
    const toast = document.getElementById('sg-toast');
    if (toast) setTimeout(() => toast.remove(), 4000);

    document.querySelectorAll('[data-char-counter]').forEach(el => {
        const target = document.querySelector(el.dataset.charCounter);
        const min = parseInt(el.dataset.min || 0);
        const max = parseInt(el.dataset.max || 999);
        const update = () => {
            const len = (target?.value || '').length;
            el.textContent = len + ' / ' + max;
            el.className = 'sg-char-counter text-xs ' + (len >= min && len <= max ? 'good' : len > max ? 'bad' : 'warn');
        };
        target?.addEventListener('input', update);
        update();
    });

    document.querySelectorAll('[data-slug-from]').forEach(el => {
        const source = document.querySelector(el.dataset.slugFrom);
        if (!source) return;
        source.addEventListener('input', () => {
            if (!el.dataset.manual) {
                el.value = source.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-|-$/g, '');
            }
        });
        el.addEventListener('input', () => el.dataset.manual = '1');
    });

    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
        });
    });
});

function sgSeoPreview(prefix) {
    const title = document.getElementById(prefix + '_meta_title')?.value || document.getElementById(prefix + '_title')?.value || '';
    const desc = document.getElementById(prefix + '_meta_description')?.value || '';
    const slug = document.getElementById(prefix + '_slug')?.value || '';
    const base = document.getElementById('sg-base-url')?.value || '';
    const t = document.getElementById(prefix + '-google-title');
    const u = document.getElementById(prefix + '-google-url');
    const d = document.getElementById(prefix + '-google-desc');
    if (t) t.textContent = title || 'Page Title';
    if (u) u.textContent = base + (slug ? '/' + slug : '');
    if (d) d.textContent = desc || 'Meta description preview...';
}

function sgDeleteModal(formId) {
    if (confirm('This action cannot be undone. Delete?')) {
        document.getElementById(formId)?.submit();
    }
}
