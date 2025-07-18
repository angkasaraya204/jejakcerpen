<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|lowercase|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function getTrendingbyUser($period = 'all', $limit = 5)
    {
        $query = Story::with(['user', 'category'])
            ->where('user_id', auth()->id())
            ->withCount(['votes as upvotes_count' => function($query) {
                $query->where('vote_type', 'upvote');
            }]);

        // Filter berdasarkan periode
        switch ($period) {
            case 'daily':
                $query->where('created_at', '>=', now()->subDay());
                break;
            case 'weekly':
                $query->where('created_at', '>=', now()->subWeek());
                break;
            case 'monthly':
                $query->where('created_at', '>=', now()->subMonth());
                break;
        }

        // Urutkan berdasarkan jumlah upvote terbanyak, lalu berdasarkan yang terbaru.
        // Ambil data sesuai limit. Semua proses ini dilakukan di database.
        $trendingStories = $query->having('upvotes_count', '>', 0) // <-- Tambahkan baris ini
                 ->orderByDesc('upvotes_count')
                 ->orderByDesc('created_at')
                 ->take($limit)
                 ->get();

        return view('user.trending.index', compact('trendingStories'));
    }
}
