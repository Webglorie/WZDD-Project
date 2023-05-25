<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

/**
 * Class MenuItemController
 * @package App\Http\Controllers
 */
class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Menu Items Beheren'; // H1-titel en meta-titel
        $activeMenuItem = 'menu-items'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/menu-items', 'label' => 'Menu Items Beheren', 'classes' => 'active'],
        ];
        $menuItems = MenuItem::paginate();
        $selectMenuItems = MenuItem::getNestedMenuItems();
        return view('menu-item.index', compact('menuItems', 'selectMenuItems'))
            ->with('i', (request()->input('page', 1) - 1) * $menuItems->perPage())
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $pageTitle = 'Nieuwe Menu Item Toevoegen'; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/menu-items', 'label' => 'Menu Beheren', 'classes' => ''],
            ['url' => '/menu-items/create', 'label' => $pageTitle, 'classes' => 'active'],
        ];

        $selectMenuItems = MenuItem::all();
        $menuItem = new MenuItem();
        return view('menu-item.create', compact('menuItem', 'selectMenuItems'))
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
        request()->validate(MenuItem::$rules);

        $menuItem = MenuItem::create($request->all());

        return redirect()->route('menu-items.index')
            ->with('success', 'MenuItem created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menuItem = MenuItem::find($id);


        return view('menu-item.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menuItem = MenuItem::find($id);
        $pageTitle = 'Menu Item #'.$id.' aanpassen ('.$menuItem->name.')'; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/menu-items', 'label' => 'Menu Beheren', 'classes' => ''],
            ['url' => '/menu-items/'.$id.'/edit', 'label' => $pageTitle, 'classes' => 'active'],
        ];

        $selectMenuItems = MenuItem::getNestedMenuItems();

        return view('menu-item.edit', compact('menuItem', 'selectMenuItems'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        request()->validate(MenuItem::$rules);

        $menuItem->update($request->all());

        return redirect()->route('menu-items.index')
            ->with('success', 'MenuItem updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::find($id)->delete();

        return redirect()->route('menu-items.index')
            ->with('success', 'MenuItem deleted successfully');
    }

    public function showMenu()
    {
        $menu = MenuItem::getNestedMenuItems();

        return view('menu', ['menu' => $menu]);
    }

    public function updateOrder(Request $request)
    {
        $menuItems = $request->input('menuItems');

        foreach ($menuItems as $position => $menuItemData) {
            $menuItem = MenuItem::findOrFail($menuItemData['id']);
            $menuItem->order = $position + 1;
            $menuItem->parent_id = $menuItemData['parent_id'] ?? null;
            $menuItem->save();
        }

        return response()->json(['message' => 'Menu order updated successfully']);
    }

    public function saveMenu(Request $request)
    {
        $orders = $request->input('orders');

        // Update de volgorde van de menu-items in de database
        foreach ($orders as $index => $order) {
            MenuItem::where('id', $index)->update(['order' => $order]);
        }

        // Redirect naar de menu-pagina of een andere geschikte bestemming
        return redirect()->route('menu-items.index');
    }
}
