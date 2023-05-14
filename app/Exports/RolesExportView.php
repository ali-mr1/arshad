<?php

namespace App\Exports;

use App\Models\Role;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RolesExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $roles = Role::with('projects')->latest()->get();
        $projects = Project::all();
        return view('roles.table', [
            'roles' => $roles,
            'projects'=>$projects,
        ]);
    }
}
