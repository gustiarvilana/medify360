<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function unread(): JsonResponse
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications()->latest()->take(10)->get()->map(fn($n) => [
            'id' => $n->id,
            'type' => $n->data['type'] ?? 'info',
            'message' => $this->formatMessage($n->data),
            'time' => $n->created_at->diffForHumans(),
            'url' => $this->notifUrl($n->data),
        ]);

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markRead(string $id): JsonResponse
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['ok' => true]);
    }

    public function markAllRead(): JsonResponse
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['ok' => true]);
    }

    private function formatMessage(array $data): string
    {
        return match($data['type'] ?? '') {
            'cendol' => 'Mendapat Cendol dari ' . ($data['pengirim'] ?? 'User'),
            'bata' => 'Status laporan "' . ($data['tipe'] ?? '-') . '" menjadi ' . ($data['status'] ?? '-'),
            default => 'Notifikasi baru',
        };
    }

    private function notifUrl(array $data): string
    {
        return match($data['type'] ?? '') {
            'cendol' => route('laporan'),
            'bata' => route('laporan'),
            default => '#',
        };
    }

    public function updatePreferences(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notif_cendol' => 'boolean',
            'notif_bata' => 'boolean',
        ]);

        User::where('id', auth()->id())->update($validated);

        return response()->json(['ok' => true]);
    }
}
