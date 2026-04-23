{{-- Global media library picker modal --}}
{{-- Usage: dispatch a CustomEvent('open-media-picker', { detail: { onSelect: (path) => {...} } }) --}}
<div x-data="mediaPicker()"
     x-show="open"
     x-cloak
     @open-media-picker.window="openPicker($event.detail)"
     @keydown.escape.window="close()"
     class="fixed inset-0 z-[9998] flex items-center justify-center p-4"
     style="background: rgba(0,0,0,0.5);">
    <div @click.outside="close()" class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl"
         style="max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Biblioteca de Media</h3>
                <p class="text-xs text-gray-500">Seleccioná una imagen existente o subí una nueva.</p>
            </div>
            <button type="button" @click="close()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="px-6 py-3 border-b border-gray-200 bg-gray-50 space-y-2">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 text-sm">
                    @foreach([['all','Todo'],['upload','Subidos'],['asset','Assets']] as [$k, $label])
                        <button type="button" @click="tab = '{{ $k }}'; folder = ''"
                                :class="tab === '{{ $k }}' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'"
                                class="px-3 py-1 rounded-full text-xs font-medium">{{ $label }}</button>
                    @endforeach
                </div>
                <input type="search" x-model="q" placeholder="Buscar por nombre…"
                       class="rounded-lg border-gray-300 text-sm flex-1">
                <input type="file" accept="image/*" @change="uploadNew($event)" class="hidden" x-ref="pickerFileInput">
                <button type="button" @click="$refs.pickerFileInput.click()" :disabled="uploading"
                        class="bg-green-600 text-white text-xs font-medium px-3 py-1.5 rounded hover:bg-green-700 disabled:opacity-60">
                    <span x-show="!uploading">+ Subir nuevo</span>
                    <span x-show="uploading">Subiendo…</span>
                </button>
            </div>
            <div class="flex items-center gap-1 flex-wrap">
                <span class="text-[10px] text-gray-400 mr-1">Carpeta:</span>
                <button type="button" @click="folder = ''"
                        :class="folder === '' ? 'bg-gray-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'"
                        class="px-2 py-0.5 rounded text-[11px] font-medium">Todas</button>
                <template x-for="f in folders()" :key="f">
                    <button type="button" @click="folder = f"
                            :class="folder === f ? 'bg-gray-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'"
                            class="px-2 py-0.5 rounded text-[11px] font-medium" x-text="f"></button>
                </template>
            </div>
        </div>

        <div class="p-6 bg-gray-50" style="flex: 1 1 auto; overflow-y: auto; min-height: 0;">
            <div x-show="loading" class="text-center text-sm text-gray-500 py-8">Cargando biblioteca…</div>
            <div x-show="!loading && filtered().length === 0" class="text-center text-sm text-gray-500 py-8">Sin resultados.</div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px;">
                <template x-for="file in filtered()" :key="file.path">
                    <button type="button" @click="pick(file)"
                            class="group bg-white rounded-lg border border-gray-200 hover:border-blue-500 hover:shadow-md transition text-left"
                            style="overflow: hidden;">
                        <div class="bg-gray-50" style="width: 100%; aspect-ratio: 1/1;">
                            <img :src="file.url" loading="lazy" alt=""
                                 style="width: 100%; height: 100%; object-fit: contain; display: block;">
                        </div>
                        <div class="px-2 py-1.5">
                            <p class="text-xs text-gray-700 truncate" :title="file.path" x-text="file.path.split('/').pop()"></p>
                            <div class="flex items-center justify-between mt-0.5">
                                <span class="text-[10px] text-gray-400" x-text="(file.size / 1024).toFixed(1) + ' KB'"></span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded"
                                      :class="file.source === 'asset' ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-700'"
                                      x-text="file.source"></span>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mediaPicker', () => ({
        open: false,
        tab: 'upload',
        q: '',
        folder: '',
        files: [],
        loading: false,
        uploading: false,
        onSelect: null,

        async openPicker(detail) {
            this.onSelect = detail?.onSelect || null;
            this.q = '';
            this.folder = '';
            this.tab = 'upload';
            this.open = true;
            await this.load();
        },

        close() {
            this.open = false;
            this.onSelect = null;
            this.q = '';
            this.folder = '';
        },

        folders() {
            const seen = new Set();
            this.files.forEach(f => {
                if (this.tab !== 'all' && f.source !== this.tab) return;
                const parts = f.path.split('/');
                if (parts.length > 1) seen.add(parts.slice(0, -1).join('/'));
            });
            return [...seen].sort();
        },

        async load() {
            this.loading = true;
            try {
                const res = await fetch(@json(route('admin.media.browse')), {
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json();
                this.files = data.files || [];
            } catch (e) {
                this.files = [];
            } finally {
                this.loading = false;
            }
        },

        filtered() {
            const q = this.q.toLowerCase();
            return this.files.filter(f => {
                if (this.tab !== 'all' && f.source !== this.tab) return false;
                if (this.folder && !f.path.startsWith(this.folder + '/')) return false;
                if (q && !f.path.toLowerCase().includes(q)) return false;
                return true;
            });
        },

        pick(file) {
            if (this.onSelect) this.onSelect(file.path);
            this.close();
        },

        async uploadNew(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.uploading = true;
            const fd = new FormData();
            fd.append('files[]', file);
            fd.append('folder', 'uploads');
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').content;
                const res = await fetch(@json(route('admin.media.upload')), {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: fd,
                });
                const data = await res.json();
                if (data.success && data.files?.[0]) {
                    // Auto-select the freshly-uploaded file and close
                    if (this.onSelect) this.onSelect(data.files[0].path);
                    this.close();
                }
            } catch (e) {
                alert('Error al subir archivo.');
            } finally {
                this.uploading = false;
                event.target.value = '';
            }
        },
    }));
});
</script>
@endonce
