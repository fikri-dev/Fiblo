<div>
    <x-slot name="style">
        <link rel="stylesheet" href="/css/trix.css">
    </x-slot>

    <div class="w-full sm:w-2/3 mb-5 mx-auto">
        <livewire:components.post-input-form :form="$form" :categories="$categories" action="store" button="publish" />
    </div>

    <x-slot name="script">
        <script src="/js/trix.js"></script>
    </x-slot>
</div>
