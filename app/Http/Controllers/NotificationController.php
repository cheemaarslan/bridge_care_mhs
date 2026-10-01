<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $notifications = Auth::user()->notifications()->get();
        return view('notification.index', compact('notifications'));
    }
    public function destroy(Request $request)
    {
        Auth::user()->notifications()->where('id', $request->id)->delete();
        return response(200);
    }
    public function mark_as_read(Request $request)
    {
        Auth::user()
        ->unreadNotifications
        ->when($request->input('id'), function ($query) use ($request) {
            return $query->where('id', $request->input('id'));
        })
        ->markAsRead();

        return response(200);
    }
    public function mark_all_as_read()
    {

        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return back();
    }
    public function unread(){
        $notifications = Auth::user()->unreadNotifications()->get();
        return response($notifications);
    }
}
