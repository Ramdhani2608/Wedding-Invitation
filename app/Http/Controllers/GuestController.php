<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function config()
    {
        return response()->json([
            'code' => 200,
            'data' => [
                'tenor_key' => env('TENOR_KEY'),
            ],
        ]);
    }

    public function index(Request $request)
    {
        $per = (int) $request->query('per', 10);

        $guests = Guestbook::latest()
            ->take($per)
            ->get()
            ->map(function ($guest) {
                return [
                    'uuid' => $guest->uuid,
                    'own' => $guest->uuid,

                    'name' => $guest->nama_tamu,
                    'phone' => $guest->no_hp,
                    'comment' => $guest->ucapan,

                    'presence' => $guest->keterangan === 'hadir',
                    'is_presence' => $guest->keterangan === 'hadir',

                    'created_at' => $guest->created_at->format('d M Y H:i'),
                    'comments' => [],
                    'like_count' => 0,
                    'is_admin' => false,
                    'is_parent' => true,
                    'gif_url' => null,
                    'ip' => null,
                    'user_agent' => null,
                ];
            });

        return response()->json([
            'code' => 200,
            'data' => [
                'lists' => $guests,
                'count' => Guestbook::count(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tamu' => 'required|string|min:2|max:50',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'ucapan' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:50',
            'foto' => 'nullable|string|max:2000',
        ]);

        $guest = Guestbook::create([
            'uuid' => (string) Str::uuid(),
            'nama_tamu' => $validated['nama_tamu'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'ucapan' => $validated['ucapan'] ?? '',
            'keterangan' => 'hadir',
            'foto' => $validated['foto'] ?? null,
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'Ucapan berhasil dikirim',
            'data' => [
                'uuid' => $guest->uuid,
                'own' => $guest->uuid,

                'name' => $guest->nama_tamu,
                'phone' => $guest->no_hp,
                'comment' => $guest->ucapan,

                'presence' => $guest->keterangan === 'hadir',
                'is_presence' => $guest->keterangan === 'hadir',

                'created_at' => $guest->created_at->format('d M Y H:i'),
                'comments' => [],
                'like_count' => 0,
                'is_admin' => false,
                'is_parent' => true,
                'gif_url' => null,
            ],
        ], 201);
    }

    public function update(Request $request, string $uuid)
    {
        $guest = Guestbook::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'nama_tamu' => 'nullable|string|min:2|max:50',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'ucapan' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:50',
            'foto' => 'nullable|string|max:2000',
        ]);

        if (array_key_exists('nama_tamu', $validated)) {
            $guest->nama_tamu = $validated['nama_tamu'];
        }

        if (array_key_exists('no_hp', $validated)) {
            $guest->no_hp = $validated['no_hp'];
        }

        if (array_key_exists('alamat', $validated)) {
            $guest->alamat = $validated['alamat'];
        }

        if (array_key_exists('ucapan', $validated)) {
            $guest->ucapan = $validated['ucapan'];
        }

        if (array_key_exists('keterangan', $validated)) {
            $guest->keterangan = $validated['keterangan'];
        }

        if (array_key_exists('foto', $validated)) {
            $guest->foto = $validated['foto'];
        }

        $guest->save();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Speech updated successfully',
            'data' => [
                'status' => true,

                'uuid' => $guest->uuid,
                'own' => $guest->uuid,

                'name' => $guest->nama_tamu,
                'phone' => $guest->no_hp,
                'address' => $guest->alamat,
                'comment' => $guest->ucapan,
                'presence' => $guest->keterangan === 'hadir',
                'is_presence' => $guest->keterangan === 'hadir',

                'created_at' => $guest->created_at->format('d M Y H:i'),
                'comments' => [],
                'like_count' => 0,
                'is_admin' => false,
                'is_parent' => true,
                'gif_url' => null,
                'ip' => null,
                'user_agent' => null,
            ],
        ]);
    }

    public function destroy(string $uuid)
    {
        $guest = Guestbook::where('uuid', $uuid)->first();

        if (!$guest) {
            return response()->json([
                'code' => 404,
                'data' => [
                    'status' => false,
                ],
            ], 404);
        }

        $guest->delete();

        return response()->json([
            'code' => 200,
            'data' => [
                'status' => true,
            ],
        ]);
    }
}
