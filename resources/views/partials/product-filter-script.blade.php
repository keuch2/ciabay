@once
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productFilter', ({ endpoint, slugs, baseUrl }) => ({
                endpoint,
                baseUrl,
                selected: Array.isArray(slugs) ? [...slugs] : [],
                loading: false,
                init() {
                    this.syncFromUrl();
                    window.addEventListener('popstate', () => {
                        this.syncFromUrl();
                        this.fetchResults();
                    });
                },
                syncFromUrl() {
                    const u = new URL(window.location);
                    const raw = u.searchParams.get('categorias') || u.searchParams.get('categoria') || '';
                    this.selected = raw ? raw.split(',').map(s => s.trim()).filter(Boolean) : [];
                },
                pushUrl(page = 1) {
                    const u = new URL(window.location);
                    u.searchParams.delete('categoria');
                    if (this.selected.length) u.searchParams.set('categorias', this.selected.join(','));
                    else u.searchParams.delete('categorias');
                    if (page > 1) u.searchParams.set('page', String(page));
                    else u.searchParams.delete('page');
                    history.pushState(null, '', u);
                },
                async toggle(slug) {
                    const i = this.selected.indexOf(slug);
                    if (i >= 0) this.selected.splice(i, 1);
                    else this.selected.push(slug);
                    this.pushUrl(1);
                    await this.fetchResults();
                },
                async clear() {
                    this.selected = [];
                    this.pushUrl(1);
                    await this.fetchResults();
                },
                onResultsClick(ev) {
                    const a = ev.target.closest('a[href]');
                    if (!a) return;
                    // Only intercept pagination links (inside the pagination nav)
                    if (!a.closest('.redcase-pagination, .brand-catalog-pagination')) return;
                    ev.preventDefault();
                    const u = new URL(a.href);
                    const page = parseInt(u.searchParams.get('page') || '1', 10);
                    this.pushUrl(page);
                    this.fetchResults();
                    this.$root.scrollIntoView({ behavior: 'smooth', block: 'start' });
                },
                async fetchResults() {
                    this.loading = true;
                    try {
                        const params = new URLSearchParams();
                        if (this.selected.length) params.set('categorias', this.selected.join(','));
                        const page = new URL(window.location).searchParams.get('page');
                        if (page) params.set('page', page);
                        const sep = this.endpoint.includes('?') ? '&' : '?';
                        const r = await fetch(this.endpoint + sep + params.toString(), {
                            headers: { 'Accept': 'application/json' },
                        });
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        const data = await r.json();
                        this.$refs.results.innerHTML = data.html;
                    } catch (e) {
                        console.error('[productFilter] fetch failed', e);
                    } finally {
                        this.loading = false;
                    }
                },
            }));
        });
    </script>
    @endpush
@endonce
