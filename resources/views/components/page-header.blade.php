@props(['title', 'subtitle' => null, 'backRoute' => null])

<div class="page-header mb-6">
    <div class="flex flex-col">
        @if($backRoute && request()->route()->getName() != 'dashboard')
            <div class="mb-2 lg:hidden">
                <a href="{{ $backRoute }}" class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        @endif
        
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $title }}</h1>
        
        @if($subtitle)
            <p class="mt-1 text-sm text-gray-600">{{ $subtitle }}</p>
        @endif
    </div>
</div>
