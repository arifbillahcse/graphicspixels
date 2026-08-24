<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use App\Support\NotificationCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('notifications.index', [
            'notifications' => $request->user()
                ->notifications()
                ->paginate(25),
            'unread' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Mark one as read and follow it to whatever it is about.
     */
    public function read(Request $request, string $notification): RedirectResponse
    {
        $record = $request->user()->notifications()->findOrFail($notification);

        $record->markAsRead();

        $target = $record->data['url'] ?? null;

        return redirect($this->safeTarget($target));
    }

    public function readAll(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('status', 'All notifications marked as read.');
    }

    public function preferences(Request $request): View
    {
        $stored = $request->user()
            ->notificationPreferences()
            ->get()
            ->keyBy('notification_key');

        return view('notifications.preferences', [
            'grouped' => NotificationCatalog::grouped(),
            'stored' => $stored,
        ]);
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = $request->user();

        $email = (array) $request->input('email', []);
        $inApp = (array) $request->input('in_app', []);

        // Every key is written, including the ones switched off: an explicit
        // "no" has to persist, and absence means "use the catalog default".
        foreach (NotificationCatalog::keys() as $key) {
            NotificationPreference::updateOrCreate(
                ['user_id' => $user->id, 'notification_key' => $key],
                [
                    'email' => in_array($key, $email, true),
                    'in_app' => in_array($key, $inApp, true),
                ],
            );
        }

        return back()->with('status', 'Notification settings saved.');
    }

    /**
     * Only ever redirect within this application. The stored URL is generated
     * by the notification classes, but a redirect driven by stored data should
     * not be able to send somebody off-site if that ever stops being true.
     */
    private function safeTarget(?string $url): string
    {
        $home = url('/');

        if (! is_string($url) || $url === '') {
            return route('notifications.index');
        }

        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return $url;
        }

        return str_starts_with($url, $home) ? $url : route('notifications.index');
    }
}
