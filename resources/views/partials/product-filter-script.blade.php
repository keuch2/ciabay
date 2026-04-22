@once
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productFilter', ({ endpoint, slugs, baseUrl }) => ({
                endpoint,
                baseUrl,
                selected: Array.isArray(slugs) ? [...slugs] : [],
                search: '',
                searchTimer: null,
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
                    this.search = u.searchParams.get('q') || '';
                },
                pushUrl(page = 1) {
                    const u = new URL(window.location);
                    u.searchParams.delete('categoria');
                    if (this.selected.length) u.searchParams.set('categorias', this.selected.join(','));
                    else u.searchParams.delete('categorias');
                    if (this.search.trim()) u.searchParams.set('q', this.search.trim());
                    else u.searchParams.delete('q');
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
                onSearchInput() {
                    clearTimeout(this.searchTimer);
                    this.searchTimer = setTimeout(() => {
                        this.pushUrl(1);
                        this.fetchResults();
                    }, 320);
                },
                onSearchClear() {
                    this.search = '';
                    this.pushUrl(1);
                    this.fetchResults();
                },
                onResultsClick(ev) {
                    const a = ev.target.closest('a[href]');
                    if (!a) return;
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
                        if (this.search.trim()) params.set('q', this.search.trim());
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

            Alpine.data('catScroll', () => ({
                showPrev: false,
                showNext: false,
                init() {
                    const track = this.$refs.track;
                    if (!track) return;
                    this._update(track);
                    track.addEventListener('scroll', () => this._update(track), { passive: true });
                    new ResizeObserver(() => this._update(track)).observe(track);
                },
                _update(track) {
                    this.showPrev = track.scrollLeft > 2;
                    this.showNext = track.scrollLeft + track.clientWidth < track.scrollWidth - 2;
                },
                prev() {
                    this.$refs.track.scrollBy({ left: -220, behavior: 'smooth' });
                },
                next() {
                    this.$refs.track.scrollBy({ left: 220, behavior: 'smooth' });
                },
            }));
        });
    </script>
    @endpush
@endonce
