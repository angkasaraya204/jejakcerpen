<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cerita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Category Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Filter Kategori</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('stories.index') }}" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 text-sm {{ request()->missing('category') ? 'bg-blue-500 text-white' : '' }}">
                            Semua
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('stories.index', ['category' => $category->slug]) }}" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 text-sm {{ request('category') == $category->slug ? 'bg-blue-500 text-white' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Stories List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Cerita Terbaru</h3>

                    @if($stories->count() > 0)
                        <div class="space-y-6">
                            @foreach($stories as $story)
                                <div class="border-b pb-4 mb-4 last:border-0">
                                    <h3 class="text-xl font-bold mb-2">
                                        <a href="{{ route('stories.show', $story) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $story->title }}
                                        </a>
                                    </h3>
                                    <div class="text-sm text-gray-600 mb-2">
                                        <span class="bg-gray-200 px-2 py-1 rounded-full text-xs">{{ $story->category->name }}</span>
                                        • {{ $story->published_at->format('d M Y, H:i') }}
                                        • Oleh:
                                            @if($story->anonymous)
                                                 Anonim
                                            @else
                                                {{ optional($story->user)->name ?? 'Anonim' }}
                                            @endif
                                        • {{ $story->comments->count() }} komentar
                                    </div>
                                    <p class="text-gray-700">
                                        {{ Str::limit(strip_tags($story->content), 200) }}
                                    </p>
                                    <div class="mt-2">
                                        <a href="{{ route('stories.show', $story) }}" class="text-blue-600 hover:underline text-sm">
                                            Baca selengkapnya →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $stories->links() }}
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada cerita tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
