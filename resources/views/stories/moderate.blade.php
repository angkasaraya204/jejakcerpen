<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderasi Cerita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @role('admin')
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Cerita Menunggu Persetujuan ({{ $pendingStories->total() }})</h3>

                        @if($pendingStories->count() > 0)
                            <div class="space-y-6">
                                @foreach($pendingStories as $story)
                                    <div class="border rounded-lg p-4 bg-yellow-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-xl font-bold">{{ $story->title }}</h4>
                                                <div class="text-sm text-gray-600 mt-1">
                                                    <span class="bg-gray-200 px-2 py-1 rounded-full text-xs">{{ $story->category->name }}</span>
                                                    • {{ $story->created_at->format('d M Y, H:i') }}
                                                    • Oleh:
                                                    @if($story->anonymous)
                                                        Anonim
                                                    @else
                                                        {{ optional($story->user)->name ?? 'Anonim' }}
                                                    @endif
                                                </div>

                                                <!-- Tampilkan status sensitif jika sudah ditandai -->
                                                @if($story->is_sensitive)
                                                    <div class="mt-1">
                                                        <span class="bg-red-200 px-2 py-1 rounded-full text-xs text-red-700">Sensitif</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex space-x-2">
                                                <!-- Tombol setujui hanya muncul jika konten TIDAK sensitif -->
                                                @if(!$story->is_sensitive)
                                                <form action="{{ route('stories.approve', $story) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">
                                                        Setujui
                                                    </button>
                                                </form>
                                                @endif

                                                <!-- Tombol tolak selalu muncul untuk admin -->
                                                <form action="{{ route('stories.reject', $story) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-block align-baseline font-bold text-sm text-red-500 hover:text-red-800">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="mt-4 bg-white p-4 rounded border">
                                            <p class="text-gray-700">
                                                {{ Str::limit($story->content, 300) }}
                                                @if(strlen($story->content) > 300)
                                                    <a href="{{ route('stories.show', $story) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                                        Baca selengkapnya
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $pendingStories->links() }}
                            </div>
                        @else
                            <p class="text-gray-600">Tidak ada cerita yang menunggu persetujuan.</p>
                        @endif
                    </div>
                    @endrole

                    @role('moderator')
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Cerita Menunggu Persetujuan ({{ $pendingStories->total() }})</h3>

                        @if($pendingStories->count() > 0)
                            <div class="space-y-6">
                                @foreach($pendingStories as $story)
                                    <div class="border rounded-lg p-4 bg-yellow-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-xl font-bold">{{ $story->title }}</h4>
                                                <div class="text-sm text-gray-600 mt-1">
                                                    <span class="bg-gray-200 px-2 py-1 rounded-full text-xs">{{ $story->category->name }}</span>
                                                    • {{ $story->created_at->format('d M Y, H:i') }}
                                                    • Oleh:
                                                    @if($story->anonymous)
                                                        Anonim
                                                    @else
                                                        {{ optional($story->user)->name ?? 'Anonim' }}
                                                    @endif
                                                </div>

                                                @if($story->is_sensitive)
                                                    <div class="mt-1">
                                                        <span class="bg-red-200 px-2 py-1 rounded-full text-xs text-red-700">Sensitif</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex space-x-2">
                                                <!-- Form untuk menandai sensitif - hanya untuk moderator -->
                                                <form action="{{ route('stories.sensitive', $story) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-block align-baseline font-bold text-sm text-yellow-500 hover:text-yellow-800">
                                                        {{ $story->is_sensitive ? 'Bukan Sensitif' : 'Tandai Sensitif' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="mt-4 bg-white p-4 rounded border">
                                            <p class="text-gray-700">
                                                {{ Str::limit($story->content, 300) }}
                                                @if(strlen($story->content) > 300)
                                                    <a href="{{ route('stories.show', $story) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                                        Baca selengkapnya
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $pendingStories->links() }}
                            </div>
                        @else
                            <p class="text-gray-600">Tidak ada cerita yang menunggu persetujuan.</p>
                        @endif
                    </div>
                    @endrole
            </div>
        </div>
    </div>
</x-app-layout>
