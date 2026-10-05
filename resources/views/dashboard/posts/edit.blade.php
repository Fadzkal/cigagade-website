<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <strong>Oops! Ada yang salah:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Autosave indicator --}}
                    <div id="autosave-indicator" class="hidden mb-3 text-xs text-green-600 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 13.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Perubahan tersimpan sementara (Draft)
                    </div>

                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="post-form">
                        @csrf
                        @method('PUT')

                        {{-- Category + Image (shared) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Thumbnail</label>
                                <input type="hidden" name="oldImage" value="{{ $post->image }}">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="mt-2 mb-2 w-full max-w-[200px] rounded-md border" alt="Thumbnail lama">
                                @else
                                    <p class="mt-2 text-sm text-gray-500 mb-2">Tidak ada gambar sebelumnya.</p>
                                @endif
                                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
                            </div>
                        </div>

                        {{-- Language Tabs --}}
                        <div class="mb-6">
                            <div class="flex border-b border-gray-200 mb-4">
                                <button type="button" id="tab-id" onclick="switchTab('id')"
                                    class="tab-btn px-5 py-2.5 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-600 -mb-px focus:outline-none transition">
                                    🇮🇩 Indonesia
                                </button>
                                <button type="button" id="tab-en" onclick="switchTab('en')"
                                    class="tab-btn px-5 py-2.5 text-sm font-semibold border-b-2 border-transparent text-gray-500 -mb-px hover:text-gray-700 focus:outline-none transition">
                                    🇬🇧 English
                                </button>
                            </div>

                            {{-- Indonesia Fields --}}
                            <div id="fields-id" class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul (Indonesia) <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title', $post->title) }}" required>
                                </div>
                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Ringkasan (Indonesia) <span class="text-red-500">*</span></label>
                                    <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Konten (Indonesia) <span class="text-red-500">*</span></label>
                                    <div id="quill-editor-id" class="mt-1 bg-white rounded-b-md border border-gray-300" style="height: 350px;">{!! old('content', $post->content) !!}</div>
                                    <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                                </div>
                            </div>

                            {{-- English Fields --}}
                            <div id="fields-en" class="space-y-4 hidden">
                                <div>
                                    <label for="title_en" class="block text-sm font-medium text-gray-700">Title (English)</label>
                                    <input type="text" name="title_en" id="title_en" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title_en', $post->title_en) }}" placeholder="English title (auto-generates EN slug for SEO)">
                                    <p class="mt-1 text-xs text-gray-500">Slug EN: <span id="slug-en-preview" class="font-mono text-indigo-600">{{ old('slug_en', $post->slug_en) ?: '-' }}</span></p>
                                </div>
                                <div>
                                    <label for="excerpt_en" class="block text-sm font-medium text-gray-700">Summary (English)</label>
                                    <textarea name="excerpt_en" id="excerpt_en" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Short English summary...">{{ old('excerpt_en', $post->excerpt_en) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Content (English)</label>
                                    <div id="quill-editor-en" class="mt-1 bg-white rounded-b-md border border-gray-300" style="height: 350px;">{!! old('content_en', $post->content_en) !!}</div>
                                    <input type="hidden" name="content_en" id="content_en" value="{{ old('content_en', $post->content_en) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Publish Date --}}
                        <div class="mb-6">
                            <label for="published_at" class="block text-sm font-medium text-gray-700">Tanggal Publish</label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('published_at', optional($post->published_at ?? $post->created_at)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition">
                                Update Berita
                            </button>
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="button" onclick="clearDraft()" class="ml-auto text-xs text-red-400 hover:text-red-600 transition">Hapus Draft</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Quill.js + Autosave --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        const DRAFT_KEY = 'post_edit_draft_{{ $post->id }}';

        // ── Quill Editors ──────────────────────────────────────────────────
        const quillID = new Quill('#quill-editor-id', { theme: 'snow', placeholder: 'Tulis isi berita di sini...' });
        const quillEN = new Quill('#quill-editor-en', { theme: 'snow', placeholder: 'Write article content here...' });

        // Restore from old() or localStorage draft
        const draft = JSON.parse(localStorage.getItem(DRAFT_KEY) || '{}');
        let isDraftLoaded = false;

        if (Object.keys(draft).length > 0) {
            if (confirm('Ditemukan draft tersimpan (perubahan terakhir belum di-submit). Apakah Anda ingin memulihkan draft tersebut?')) {
                function restoreField(inputId, draftKey) {
                    const el = document.getElementById(inputId);
                    if (el && draft[draftKey]) el.value = draft[draftKey];
                }
                ['title','excerpt','title_en','excerpt_en'].forEach(k => restoreField(k, k));
                if (draft.content) quillID.root.innerHTML = draft.content;
                if (draft.content_en) quillEN.root.innerHTML = draft.content_en;
                isDraftLoaded = true;
            } else {
                localStorage.removeItem(DRAFT_KEY);
            }
        }

        // ── Autosave ───────────────────────────────────────────────────────
        function saveDraft() {
            document.getElementById('content').value = quillID.root.innerHTML;
            document.getElementById('content_en').value = quillEN.root.innerHTML;
            const data = {
                title:      document.getElementById('title').value,
                excerpt:    document.getElementById('excerpt').value,
                title_en:   document.getElementById('title_en').value,
                excerpt_en: document.getElementById('excerpt_en').value,
                content:    quillID.root.innerHTML,
                content_en: quillEN.root.innerHTML,
            };
            localStorage.setItem(DRAFT_KEY, JSON.stringify(data));
            const ind = document.getElementById('autosave-indicator');
            ind.classList.remove('hidden');
            setTimeout(() => ind.classList.add('hidden'), 2000);
        }

        function clearDraft() {
            localStorage.removeItem(DRAFT_KEY);
            alert('Draft dihapus!');
        }

        // Auto-save every 30s + on each keyup
        setInterval(saveDraft, 30000);
        ['title','excerpt','title_en','excerpt_en'].forEach(id => {
            document.getElementById(id)?.addEventListener('keyup', saveDraft);
        });
        quillID.on('text-change', saveDraft);
        quillEN.on('text-change', saveDraft);

        // Sync Quill to hidden inputs on form submit
        document.getElementById('post-form').addEventListener('submit', () => {
            document.getElementById('content').value = quillID.root.innerHTML;
            document.getElementById('content_en').value = quillEN.root.innerHTML;
            localStorage.removeItem(DRAFT_KEY); // Clear draft on successful submit
        });

        // ── Tab Switcher ───────────────────────────────────────────────────
        function switchTab(lang) {
            ['id','en'].forEach(l => {
                document.getElementById('fields-' + l).classList.toggle('hidden', l !== lang);
                const btn = document.getElementById('tab-' + l);
                if (l === lang) {
                    btn.classList.add('border-indigo-600','text-indigo-600');
                    btn.classList.remove('border-transparent','text-gray-500');
                } else {
                    btn.classList.remove('border-indigo-600','text-indigo-600');
                    btn.classList.add('border-transparent','text-gray-500');
                }
            });
        }

        // ── Slug EN Preview ────────────────────────────────────────────────
        document.getElementById('title_en')?.addEventListener('input', function () {
            const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('slug-en-preview').textContent = slug || '-';
        });
    </script>

</x-app-layout>
