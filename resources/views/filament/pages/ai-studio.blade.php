<x-filament-panels::page>
    <form wire:submit="generate" class="space-y-6">
        {{ $this->form }}
        <x-filament::button type="submit">Generate</x-filament::button>
    </form>

    @if ($output)
        <div class="mt-8 rounded-xl bg-gray-50 p-6 dark:bg-gray-800">
            <h3 class="mb-3 text-lg font-semibold">Output</h3>
            <div class="prose dark:prose-invert max-w-none whitespace-pre-wrap">{{ $output }}</div>
        </div>
    @endif
</x-filament-panels::page>
