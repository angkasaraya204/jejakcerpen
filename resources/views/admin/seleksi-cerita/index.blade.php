@extends('layouts.master')
@section('title', 'Seleksi Cerita')
@section('content')
<div class="page-header">
    <h3 class="page-title"> Seleksi Cerita </h3>
</div>
{{-- Alert Section --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @if($stories->count() > 0)
                <form action="{{ route('story-selections.bulk-action') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-inline-block">
                            <label for="bulk-action" class="sr-only">Pilih Aksi</label>
                            <select name="action" id="bulk-action" class="form-control form-control-sm" required>
                                <option value="">Pilih Aksi Massal</option>
                                <option value="approve">Setujui</option>
                                <option value="reject">Tolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary ml-2">Terapkan</button>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th> # </th>
                                    <th> Judul </th>
                                    <th> Oleh </th>
                                    <th> Alias </th>
                                    <th> Kategori </th>
                                    <th> Tanggal Kirim </th>
                                    <th> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stories as $story)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="story_ids[]" class="story-checkbox" value="{{ $story->id }}">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> {{ $story->title }} </td>

                                        {{-- CHANGE: Menyesuaikan kolom Penulis --}}
                                        <td>
                                            @if($story->anonymous)
                                                Anonim
                                            @else
                                                {{ $story->user->name }}
                                            @endif
                                        </td>

                                        {{-- CHANGE: Menambahkan data untuk kolom Alias --}}
                                        <td>
                                            @if($story->anonymous)
                                                {{ $story->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td> {{ $story->category->name }} </td>
                                        <td> {{ $story->created_at->format('d M Y') }} </td>
                                        <td>
                                            <a href="{{ route('stories.show', $story) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="mt-3">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Tidak ada cerita yang menunggu persetujuan.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const storyCheckboxes = document.querySelectorAll('.story-checkbox');
    const form = document.querySelector('form');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            storyCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    storyCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                selectAllCheckbox.checked = false;
            } else if (document.querySelectorAll('.story-checkbox:checked').length === storyCheckboxes.length) {
                selectAllCheckbox.checked = true;
            }
        });
    });

    // Optional: Mencegah submit jika tidak ada checkbox yang dipilih
    if(form) {
        form.addEventListener('submit', function(e) {
            const checkedCheckboxes = document.querySelectorAll('.story-checkbox:checked').length;
            if (checkedCheckboxes === 0) {
                e.preventDefault();
                alert('Silakan pilih setidaknya satu cerita untuk menerapkan aksi.');
            }
        });
    }
});
</script>
@endpush
