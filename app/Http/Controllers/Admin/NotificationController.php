<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;

class NotificationController extends Controller
{
    /**
     * [FITUR] Mengambil dan mengembalikan daftar notifikasi admin terbaru dalam format JSON.
     */
    public function apiNotifications()
    {
        $notifications = AdminNotification::recent(20)->get()->map(fn($n) => [
            'id'       => $n->id,
            'type'     => $n->type,
            'title'    => $n->title,
            'body'     => $n->body,
            'icon'     => $n->icon,
            'link_tab' => $n->link_tab,
            'ref_id'   => $n->ref_id,
            'is_read'  => !is_null($n->read_at),
            'time_ago' => $n->created_at->diffForHumans(),
        ]);
        $unread = AdminNotification::unread()->count();
        return response()->json(['notifications' => $notifications, 'unread' => $unread]);
    }

    /**
     * [FITUR] Menandai notifikasi admin tertentu sebagai telah dibaca.
     */
    public function apiNotificationRead($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->markRead();
        $unread = AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    }

    /**
     * [FITUR] Menandai semua notifikasi admin yang belum dibaca sebagai telah dibaca.
     */
    public function apiNotificationsReadAll()
    {
        AdminNotification::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true, 'unread' => 0]);
    }

    /**
     * [FITUR] Menghapus semua notifikasi admin yang telah dibaca dari database.
     */
    public function apiNotificationsClear()
    {
        AdminNotification::whereNotNull('read_at')->delete();
        $unread = AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    }
}
