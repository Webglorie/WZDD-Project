<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $agendaItems = AgendaItem::all(); // Ophalen van agenda-items (je kunt dit aanpassen aan je eigen logica)
        $menuItems = MenuItem::whereNull('parent_id')->get();

        return view('dashboard.index', compact('agendaItems', 'menuItems'));
    }
}
