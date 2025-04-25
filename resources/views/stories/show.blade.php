<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($story->is_sensitive)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Konten Sensitif</p>
                            <p>Cerita ini mengandung konten yang mungkin tidak sesuai untuk semua pembaca.</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <span class="bg-gray-200 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $story->category->name }}</span>
                        @if($story->status === 'pending')
                            <span class="bg-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-0.5 rounded-full">Menunggu Persetujuan</span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold mb-4">{{ $story->title }}</h1>

                    <div class="text-gray-600 text-sm mb-6">
                        <p>
                            Ditulis oleh:
                            @if($story->anonymous)
                                Anonim
                            @else
                                {{ optional($story->user)->name ?? 'Anonim' }}
                            @endif
                            • {{ $story->published_at ? $story->published_at->format('d M Y, H:i') : $story->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($story->content)) !!}
                    </div>

                    <!-- Voting -->
                    <div class="flex items-center space-x-4 mb-8">
                        <form action="{{ route('stories.vote', $story) }}" method="POST">
                            @csrf
                            <input type="hidden" name="vote_type" value="like">
                            <button type="submit" class="flex items-center text-gray-700 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span>{{ $story->votes()->where('vote_type', 'like')->count() }}</span>
                            </button>
                        </form>
                        <form action="{{ route('stories.vote', $story) }}" method="POST">
                            @csrf
                            <input type="hidden" name="vote_type" value="dislike">
                            <button type="submit" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2" />
                                </svg>
                                <span>{{ $story->votes()->where('vote_type', 'dislike')->count() }}</span>
                            </button>
                        </form>
                    </div>

                    @if(Auth::check() && Auth::user()->hasAnyRole(['admin', 'moderator']) && $story->status === 'pending')
                        <div class="flex space-x-4 mb-6 p-4 bg-yellow-50 rounded-lg">
                            <form action="{{ route('stories.approve', $story) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('stories.reject', $story) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                                    Tolak
                                </button>
                            </form>

                            <form action="{{ route('stories.sensitive', $story) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                                    {{ $story->is_sensitive ? 'Hapus Tanda Sensitif' : 'Tandai Sensitif' }}
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="mt-10">
                        <h3 class="text-xl font-bold mb-6">Komentar ({{ $story->comments->count() }})</h3>

                        <!-- Comment Form -->
                        <div class="mb-8">
                            <form action="{{ route('comments.store', $story) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Tambahkan Komentar:</label>
                                    <textarea id="content" name="content" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="anonymous" class="form-checkbox h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-gray-700">Komentari sebagai anonim</span>
                                    </label>
                                </div>

                                <button type="submit" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                    Kirim Komentar
                                </button>
                            </form>
                        </div>

                        <!-- Comments List -->
                        <div class="space-y-6">
                            @forelse($story->comments->where('parent_id', null) as $comment)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="mb-2">
                                        <span class="font-semibold">{{ $comment->anonymous ? 'Anonim' : $comment->user->name ?? 'Pengunjung' }}</span>
                                        <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>

                                        @hasanyrole(['user','moderator'])
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-xs hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endhasanyrole
                                    </div>

                                    <p class="text-gray-700">{{ $comment->content }}</p>

                                    <!-- Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-4 ml-6 space-y-3">
                                            @foreach($comment->replies as $reply)
                                                <div class="bg-white p-3 rounded-lg">
                                                    <div class="mb-1">
                                                        <span class="font-semibold">{{ $reply->anonymous ? 'Anonim' : $reply->user->name ?? 'Pengunjung' }}</span>
                                                        <span class="text-gray-500 text-sm ml-2">{{ $reply->created_at->diffForHumans() }}</span>

                                                        @hasanyrole(['user','moderator'])
                                                            <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 text-xs hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        @endhasanyrole
                                                    </div>

                                                    <p class="text-gray-700">{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Reply Form -->
                                    <div class="mt-3">
                                        <form action="{{ route('comments.store', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                                            <div class="flex">
                                                <input type="text" name="content" class="flex-1 rounded-l border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Balas komentar ini..." required>
                                                <button type="submit" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Balas</button>
                                            </div>

                                            <div class="mt-1">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="anonymous" class="form-checkbox h-4 w-4 text-blue-600">
                                                    <span class="ml-2 text-gray-700 text-xs">Balas sebagai anonim</span>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada komentar. Jadilah yang pertama untuk berkomentar!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
