<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Exports\RolesExport;
use App\Exports\RolesExportView;
use Maatwebsite\Excel\Facades\Excel;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,Role $role)
    {
        
        $roles = Role::with('projects')->latest()->get();

        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource. 
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'payeh' => 'required|string|max:4',
        ]);
 
         $request->user()->roles()->create($validated);
 
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit',['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'payeh' => 'required|string|max:4',
        ]);
 
         $role->update($validated);
 
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $role->projects()->detach($role->id);

        return redirect(route('roles.index'));
    }
     /**
     * 
     * export xlsx file for excel.
     */
    public function export() 
    {
        return Excel::download(new RolesExport, 'roles.xlsx');
    }

    public function export_view() 
    {
        return Excel::download(new RolesExportView, 'roles.xlsx');
    }
 
}
