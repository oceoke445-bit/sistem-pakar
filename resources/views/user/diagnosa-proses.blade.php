@extends('layouts.dashboard')
@section('title', 'Konsultasi Diagnosa')
@section('content')

<div class="mx-auto max-w-6xl space-y-6">
    @include('partials.user-page-header', ['title' => 'Konsultasi Diagnosa', 'firstName' => $firstName])

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @include('partials.diagnosa-stepper', ['activeStep' => 2])

        <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3.5 text-center text-sm font-medium text-blue-600">
            Sistem sedang memproses data yang Anda pilih...
        </div>

        <div class="mx-auto mt-10 flex max-w-md flex-col items-center">
            <img src="{{ asset('images/icon.png') }}" alt="Memproses diagnosa" width="192" height="192"
                 class="h-40 w-auto max-w-full object-contain drop-shadow-sm sm:h-48" />

            <div class="mt-8 w-full max-w-sm">
                <div class="h-2.5 overflow-hidden rounded-full bg-slate-200">
                    <div id="prosesBar" class="h-full rounded-full bg-blue-600 transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="prosesLabel" class="mt-3 text-center text-sm font-semibold text-slate-600">Memproses... 0%</p>
            </div>
        </div>

        <div class="mt-10 rounded-xl border border-yellow-100 bg-yellow-50/80 px-5 py-4">
            <div class="flex gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-500">
                    <i class="bi bi-lightbulb-fill text-lg"></i>
                </span>
                <div>
                    <h3 class="font-bold text-slate-900">Tahukah Anda?</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-700">
                        Metode <span class="font-semibold">Forward Chaining</span> bekerja dengan mencocokkan gejala yang Anda pilih dengan aturan (rule) yang ada untuk menemukan kerusakan yang paling mungkin terjadi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        var targetUrl = @json(route('user.hasil-diagnosa', $diagnosaId));
        var bar = document.getElementById('prosesBar');
        var label = document.getElementById('prosesLabel');
        var progress = 0;

        var timer = setInterval(function () {
            progress = Math.min(100, progress + Math.floor(Math.random() * 12) + 8);
            if (bar) bar.style.width = progress + '%';
            if (label) label.textContent = 'Memproses... ' + progress + '%';

            if (progress >= 100) {
                clearInterval(timer);
                setTimeout(function () {
                    window.location.href = targetUrl;
                }, 400);
            }
        }, 280);
    })();
</script>
@endpush

@endsection
