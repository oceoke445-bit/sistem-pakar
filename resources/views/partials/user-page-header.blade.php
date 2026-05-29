@props(['title', 'firstName' => 'Pengguna'])

<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">{{ $title }}</h1>
    <div class="flex shrink-0 items-center gap-3 self-start">
        <span class="text-sm font-semibold text-slate-700">Halo, {{ $firstName }}</span>
        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-slate-500">
            <i class="bi bi-person-fill text-lg"></i>
        </span>
    </div>
</div>
