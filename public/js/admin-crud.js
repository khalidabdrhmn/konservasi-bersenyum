(() => {
    const page = location.pathname.split('/').filter(Boolean).pop();
    const definitions = {
        'management-periods': {
            key: 'period', plural: 'periods', table: 'periodTableBody', modal: 'periodModal', form: 'periodForm', id: 'periodId',
            search: 'searchPeriod', add: 'addPeriodBtn', save: 'savePeriodBtn', fields: ['name', 'start_date', 'end_date', 'description'],
            row: (item, number) => `<tr><td>${number}</td><td>${escapeHtml(item.name)}</td><td>${date(item.start_date)}</td><td>${date(item.end_date)}</td><td>${item.is_active ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge badge-inactive">Tidak Aktif</span>'}</td>${actions(item.id)}</tr>`,
            beforeEdit: item => { byId('is_active').checked = Boolean(item.is_active); },
            beforeSubmit: form => { if (!byId('is_active').checked) form.delete('is_active'); },
        },
        divisions: {
            key: 'division', plural: 'divisions', table: 'divisionTableBody', modal: 'divisionModal', form: 'divisionForm', id: 'divisionId',
            search: 'searchDivision', add: 'addDivisionBtn', save: 'saveDivisionBtn', fields: [['name', 'divName'], ['description', 'divDescription']],
            row: (item, number) => `<tr><td>${number}</td><td>${escapeHtml(item.name)}</td><td>${escapeHtml(item.description || '-')}</td><td>${item.member_count}</td>${actions(item.id)}</tr>`,
        },
        members: {
            key: 'member', plural: 'members', table: 'memberTableBody', modal: 'memberModal', form: 'memberForm', id: 'memberId',
            search: 'searchMember', add: 'addMemberBtn', save: 'saveMemberBtn', fields: [['management_period_id', 'memberPeriod'], ['division_id', 'memberDivision'], ['name', 'memberName'], ['position', 'memberPosition'], ['bio', 'memberBio'], ['instagram', 'memberInstagram'], ['linkedin', 'memberLinkedIn']],
            row: (item, number) => `<tr><td>${number}</td><td>${item.photo_url ? `<img src="${escapeAttribute(item.photo_url)}" class="member-thumb me-2" alt="">` : ''}${escapeHtml(item.name)}</td><td>${escapeHtml(item.position)}</td><td>${escapeHtml(item.period || '-')}</td><td>${escapeHtml(item.division || '-')}</td>${actions(item.id)}</tr>`,
            beforeEdit: item => preview('memberPhotoPreview', item.photo_url),
            reset: () => preview('memberPhotoPreview', null),
        },
        posts: {
            key: 'post', plural: 'posts', table: 'postTableBody', modal: 'postModal', form: 'postForm', id: 'postId',
            search: 'searchPost', add: 'addPostBtn', save: 'savePostBtn', fields: [['title', 'postTitle'], ['excerpt', 'postExcerpt'], ['content', 'postContent'], ['status', 'postStatus'], ['sort_order', 'postSortOrder']],
            row: (item, number) => `<tr><td>${number}</td><td class="post-title">${escapeHtml(item.title)}</td><td>${escapeHtml(item.excerpt || '-')}</td><td><span class="badge ${item.status === 'published' ? 'badge-published' : 'badge-draft'}">${escapeHtml(item.status)}</span></td><td>${escapeHtml(item.author || '-')}</td>${actions(item.id)}</tr>`,
            filter: () => ({ status: byId('filterPostStatus')?.value || '' }),
        },
    };

    const config = definitions[page];
    if (!config) return;
    const root = `/admin/${page}`;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    let currentPage = 1;
    let modal;

    document.addEventListener('DOMContentLoaded', () => {
        modal = new bootstrap.Modal(byId(config.modal));
        byId(config.add).addEventListener('click', openCreate);
        byId(config.form).addEventListener('submit', submit);
        byId(config.table).addEventListener('click', onAction);
        byId('paginationLinks').addEventListener('click', event => {
            const button = event.target.closest('[data-page]');
            if (button && !button.closest('.disabled')) load(Number(button.dataset.page));
        });
        byId(config.search).addEventListener('input', debounce(() => load(1), 300));
        byId('filterPostStatus')?.addEventListener('change', () => load(1));
        byId('memberPhoto')?.addEventListener('change', event => preview('memberPhotoPreview', event.target.files[0] ? URL.createObjectURL(event.target.files[0]) : null));
        load();
    });

    async function load(pageNumber = 1) {
        currentPage = pageNumber;
        const params = new URLSearchParams({ page: pageNumber, search: byId(config.search).value, ...(config.filter?.() || {}) });
        try {
            const result = await request(`${root}/data?${params}`);
            const items = result[config.plural] || [];
            const pagination = result.pagination;
            byId(config.table).innerHTML = items.length ? items.map((item, index) => config.row(item, (pagination.current_page - 1) * pagination.per_page + index + 1)).join('') : `<tr><td colspan="6" class="text-center py-5 text-secondary">Belum ada data.</td></tr>`;
            renderPagination(pagination);
        } catch (error) { show(error.message, 'danger'); }
    }

    function openCreate() { reset(); modal.show(); }
    async function onAction(event) {
        const button = event.target.closest('[data-action]');
        if (!button) return;
        const id = button.dataset.id;
        if (button.dataset.action === 'delete') {
            if (!confirm('Arsipkan data ini? Data dapat dipulihkan oleh administrator melalui database.')) return;
            try { const result = await request(`${root}/${id}`, { method: 'DELETE' }); show(result.message); load(currentPage); } catch (error) { show(error.message, 'danger'); }
            return;
        }
        reset();
        try {
            const result = await request(`${root}/${id}/edit`);
            const item = result[config.key];
            byId(config.id).value = item.id;
            fields().forEach(([name, id]) => { const input = byId(id); if (input) input.value = item[name] ?? ''; });
            config.beforeEdit?.(item);
            byId('modalTitle').textContent = `Edit ${label()}`;
            modal.show();
        } catch (error) { show(error.message, 'danger'); }
    }

    async function submit(event) {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        config.beforeSubmit?.(form);
        const id = byId(config.id).value;
        if (id) form.append('_method', 'PUT');
        clearErrors();
        const button = byId(config.save);
        button.disabled = true;
        try {
            const result = await request(id ? `${root}/${id}` : root, { method: 'POST', body: form });
            modal.hide(); show(result.message); load(id ? currentPage : 1);
        } catch (error) {
            if (error.errors) Object.entries(error.errors).forEach(([name, messages]) => setError(name, messages[0]));
            show(error.message, 'danger');
        } finally { button.disabled = false; }
    }

    function reset() {
        const form = byId(config.form); form.reset(); byId(config.id).value = ''; clearErrors();
        byId('modalTitle').textContent = `Tambah ${label()}`; config.reset?.();
    }
    function renderPagination(data) {
        const start = data.total ? (data.current_page - 1) * data.per_page + 1 : 0;
        const end = Math.min(data.current_page * data.per_page, data.total);
        byId('paginationInfo').textContent = `Menampilkan ${start}-${end} dari ${data.total} data`;
        byId('paginationLinks').innerHTML = Array.from({ length: data.last_page }, (_, index) => `<li class="page-item ${index + 1 === data.current_page ? 'active' : ''}"><button class="page-link" data-page="${index + 1}">${index + 1}</button></li>`).join('');
    }
    async function request(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest', ...(options.method && options.method !== 'GET' ? { 'X-CSRF-TOKEN': csrf } : {}) } });
        const result = await response.json().catch(() => ({}));
        if (!response.ok || result.success === false) throw Object.assign(new Error(result.message || 'Permintaan gagal diproses.'), { errors: result.errors });
        return result;
    }
    function fields() { return config.fields.map(field => Array.isArray(field) ? field : [field, field]); }
    function setError(name, message) { const field = fields().find(([fieldName]) => fieldName === name); const input = field && byId(field[1]); if (!input) return; input.classList.add('is-invalid'); input.parentElement.querySelector('.invalid-feedback')?.replaceChildren(message); }
    function clearErrors() { byId(config.form).querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid')); byId(config.form).querySelectorAll('.invalid-feedback').forEach(item => item.textContent = ''); }
    function label() { return ({ periods: 'Periode', divisions: 'Divisi', members: 'Anggota', posts: 'Berita' })[config.plural]; }
    function show(message, type = 'success') { const alert = document.createElement('div'); alert.className = `alert alert-${type} alert-dismissible fade show`; alert.textContent = message; alert.insertAdjacentHTML('beforeend', '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'); byId('alertContainer').replaceChildren(alert); }
    function preview(id, src) { const image = byId(id); if (!image) return; image.src = src || ''; image.style.display = src ? 'block' : 'none'; }
    function actions(id) { return `<td><div class="d-flex gap-2"><button class="action-btn edit-btn" data-action="edit" data-id="${id}" title="Edit"><i class="bi bi-pencil"></i></button><button class="action-btn delete-btn" data-action="delete" data-id="${id}" title="Hapus"><i class="bi bi-trash"></i></button></div></td>`; }
    function byId(id) { return document.getElementById(id); }
    function date(value) { return value ? new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(new Date(`${value}T00:00:00`)) : '-'; }
    function escapeHtml(value) { const node = document.createElement('span'); node.textContent = value ?? ''; return node.innerHTML; }
    function escapeAttribute(value) { return escapeHtml(value).replace(/`/g, '&#96;'); }
    function debounce(callback, delay) { let timer; return () => { clearTimeout(timer); timer = setTimeout(callback, delay); }; }
})();
