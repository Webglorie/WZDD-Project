<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Problem;
use Illuminate\Http\Request;

/**
 * Class ProblemController
 * @package App\Http\Controllers
 */
class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Lopende Problemen beheren'; // H1-titel en meta-titel
        $activeMenuItem = 'problems'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/problems', 'label' => $pageTitle, 'classes' => 'active'],
        ];

        $problems = Problem::paginate();

        return view('problems.index', compact('problems'))
            ->with('pageTitle', $pageTitle)
            ->with('activeMenuItem', $activeMenuItem)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('i', (request()->input('page', 1) - 1) * $problems->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $problem = new Problem();
        return view('problems.create', compact('problem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valideer de gegevens uit het verzoek
        request()->validate(Problem::$rules);

        Problem::create($request->all());

        return redirect()->route('problems.index')
            ->with('success', 'Problem created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Lopende Probleem #'.$id; // H1-titel en meta-titel
        $activeMenuItem = 'notifications'; // ID of naam van het actieve menu-item
        $breadcrumbs = [
            ['url' => '/', 'label' => 'Home', 'classes' => ''], // Lijst met breadcrumbs
            ['url' => '/problems', 'label' => 'Lopende Problemen beheren', 'classes' => ''],
            ['url' => '/problems/'.$id, 'label' => $pageTitle, 'classes' => 'active'],
        ];

        $problem = Problem::find($id);

        return view('problems.show', compact('problem'))
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
        $problem = Problem::find($id);

        return view('problems.edit', compact('problem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Problem $problem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Problem $problem)
    {
        request()->validate(Problem::$rules);

        $problem->update($request->all());

        return redirect()->route('problems.index')
            ->with('success', 'Problem updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $problem = Problem::find($id)->delete();

        return redirect()->route('problems.index')
            ->with('success', 'Problem deleted successfully');
    }

    public function getProblems()
    {
        $problems = Problem::all();
        return response()->json($problems);
    }
}
