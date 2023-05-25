<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * Class NotificationController
 * @package App\Http\Controllers
 */
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Algemene Wallboard Meldingen'; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/notifications', 'label' => 'Algemene Wallboard Meldingen', 'classes' => 'active'],
        ];

        $notifications = Notification::paginate();

        return view('notification.index', compact('notifications'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('i', (request()->input('page', 1) - 1) * $notifications->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Nieuwe Algemene Wallboard Melding Maken'; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/notifications', 'label' => 'Algemene Wallboard Meldingen', 'classes' => ''],
            ['url' => '/notifications/create', 'label' => 'Algemene Wallboard Melding Maken', 'classes' => 'active'],
        ];

        $notification = new Notification();
        return view('notification.create', compact('notification'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Notification::$rules);

        $notification = Notification::create($request->all());

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Algemene Wallboard Melding #'.$id; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/notifications', 'label' => 'Algemene Wallboard Meldingen', 'classes' => ''],
            ['url' => '/notifications/'.$id, 'label' => $pageTitle, 'classes' => 'active'],
        ];

        $notification = Notification::find($id);

        return view('notification.show', compact('notification'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::find($id);

        return view('notification.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        request()->validate(Notification::$rules);

        $notification->update($request->all());

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $notification = Notification::find($id)->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully');
    }

    public function getNotifications()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }
}
