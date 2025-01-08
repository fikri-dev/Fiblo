<form wire:submit="{{ $action }}" method="POST" enctype="multipart/form-data" class="relative">
    {{-- Update indicator --}}
    <div class="fixed top-0 text-gray-600 z-50 translate-y-8 h-7 overflow-hidden">
        <div wire:loading.class="-translate-y-1/2" 
        class="flex flex-col items-start transition-transform duration-500 ease-in-out">
            <div class="flex items-center space-x-2">
                <i class="bi bi-cloud-check-fill text-slate-800"></i>
                <div>Saved</div>
            </div>
            <div class="flex items-center space-x-2">
                <i class="bi bi-arrow-clockwise animate-spin"></i>
                <div>Saving...</div>
            </div>
        </div>
    </div>

    {{-- Publish button --}}
    <div class="fixed top-0 translate-x-[700px]  z-50 flex justify-end mt-7">
        <x-_button>
            <i class="bi bi-arrow-up-short"></i>
            {{ $button ?? 'Tambah' }}
        </x-_button>
    </div>
    
    {{-- Banner --}}
    <div class="mb-3">
        <div
            class="relative w-full h-48 sm:h-96 bg-slate-100 active:bg-slate-200 transition rounded-xl flex items-center justify-center overflow-hidden">
            @if ($form->image)
                <img src="{{ config('app.url').$form->image }}" class="block img-fluid rounded-lg w-full h-full object-cover object-center absolute">
            @endif
            @if ($form->image instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile )
                @if ($form->image->getClientOriginalExtension() == "png" || "jpg")
                    <img src="{{ $form->image->temporaryUrl() }}" class="img-fluid rounded-lg w-full h-full object-cover object-center absolute">
                @endif
            @endif
            <i class="bi bi-camera-fill font-bold text-4xl text-slate-500"></i>
            <input wire:model.live="form.image" class="absolute h-full w-full opacity-0 form-control img-input @error('form.image') is-invalid @enderror" type="file" id="form.image"
                name="form.image">
            <div
                class="absolute bottom-0 left-0 right-0 h-10 bg-black bg-opacity-50 flex items-center justify-center font-semibold text-white backdrop-blur-xl pointer-events-none">
                Ubah
            </div>
        </div>
        <x-_error name="form.image"></x-_error>
    </div>

    {{-- Title --}}
    <div class="mb-3">
        <input wire:model.live.debounce.500ms="form.title" type="text" id="form.title" name="form.title" placeholder="Judul"
            class="bg-inherit text-2xl sm:text-4xl border-0 w-full focus:ring-0 font-semibold" autofocus>
        <x-_error name="form.title"></x-_error>
    </div>

    <h1 wire:loading wire:target="updatingBody" >hey</h1>

    {{-- Body --}}
    <div wire:ignore class="mb-3" style="min-height: 500px;">
        <input type="hidden" name="form.body" id="form.body" required>
        <trix-editor 
        class="text-xl border-0 text-slate-800 outline-none"
        input="form.body"
        x-data
        x-on:trix-change="$dispatch('input', event.target.value)"
        x-ref="trix"
        wire:model.live.debounce.500ms="form.body"
        wire:key="uniqueKey"
        placeholder="Tulis cerita kamu..." 
        >
        </trix-editor>
        <x-_error name="form.body"></x-_error>
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label for="category" class="form-label">Topik</label>
        <select wire:model.live.debounce.500ms="form.category_id" class="form-select @error('form.category_id') is-invalid @enderror" name="form.category_id">
            <option selected disabled>Pilih Topik</option>
            @forelse ($categories as $category)
            <option wire:key="{{ $category->id }}" value="{{ $category->id }}" {{ $category->id == old('category_id', isset($post) ? $post->category_id : null) ? 'selected' : ''
                }}>{{
                $category->name }}
            </option>
            @empty
            <option disabled>Kamu belum punya category ☹️</option>
            @endforelse
        </select>
        <x-_error name="form.category_id"></x-_error>
    </div>

    {{-- Slug --}}
    <div class="form-floating">
        <input wire:model.live.debounce.500ms="form.slug" class="-mb-1 form-control" type="text" id="form.slug" name="form.slug" placeholder="Slug" autofocus>
        <label for="form.slug" class="form-label">Slug</label>
        @error('form.slug')
        <div class="text-red-400 bg-red-100 text-sm font-semibold inline-block px-2 py-1 rounded-xl my-1">{{ $message }}
        </div>
        @enderror
    </div>
</form>
