<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Process;
use App\Exports\ProjectsExport;
use App\Exports\ProjectsExportView;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       

        return view('projects.index', [
            'projects' => Project::with('user','roles')->latest()->get(),
        ]);
    
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
        //ابتدا ورود اطلاعات کاربر د پایگاه داده پروژه ها
        // تشخیص گروه ساختمان بر اساس متراژ
        $meter = $request->metraj;
        switch ( $meter  ) {
            case  ($meter<=500) :
                $gro = 'a';
                break;
            case  ($meter <= 1500) :
                $gro = 'b';         
                break;          
            case  ($meter <= 4000) :
                $gro = 'c';              
                break;
            case  ($meter > 4000) :
                $gro = 'd';            
                break;           
        }
        // تاید صحت اطلاعات ورودی
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'metraj' => 'required|',           
                ]);
        //ذخیره اطلاعات پروژه در پایگاه داده به همراه اطلاعات کاربر وارد کننده پروژه
        $validated['group'] = $gro;  
        $request->user()->projects()->create($validated);
        
        //پایان ثبت اطلاعات کاربر در پایگگاه داده پروژه ها

        // انتخاب مهندسی که واجد شرایط و مناسب دریافت  پروژه است
        
        $proj = Project::latest()->first();  // انتخاب آخرین پروژه
        $roles = Role::with('projects')->get(); 

             
        //  با در نظر داشتن پایه مهندسین تعین مهندسی که مجموع کارکردش از همه کمتر باشه  
        $i = 0;
        $s = 0; //variable for sum
        $arr = [];
        $t = 0;// حالت ابتدایی کا مهندس تا بحال پروژه ای نگرفته
        //کمترین  متراژ مهندسان
        foreach($roles as $role){
             //ابتدا به مهندسی که تازه وارد است یک پروژه میدهیم
           if ($role->projects->count() == 0){
                    $role->projects()->attach($proj->id);
                    $t =1;
                    break;
                }

                $d=0;
                // وزن دهی به مهندس بر اساس رتبه نظام مهندسی
                switch($role->payeh){
                    case 3 :
                        $d = 2.5;
                        break;
                    case 2 :
                        $d = 1.66;
                        break;    
                    case 1 :
                        $d = 1.25;
                        break;
                    case 'ارشد' :
                        $d = 1;
                        break;
                }
            $s = 0; //variable for sum
            foreach($role->projects as  $project){
               
                $s += $project->metraj; 

            } 
            $s = $s * $d; //وزن دهی بر اساس پایه
           
        $arr[$role->id]=$s;  
        $i += 1;
        }
        $minId =1;

        if (count($arr) != 0 ) {
        $minId =  min(array_keys($arr, min($arr))); 
        }

        $role = Role::find($minId);
        
        if ($t == 0){
            $role->projects()->attach($proj->id);
            
        }
 

        return redirect(route('projects.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show',[
            'project' => Project::findOrFail($project->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project) 
    {
        // $this->authorize('update', $project);

        
 
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
         //ابتدا ورود اطلاعات کاربر د پایگاه داده پروژه ها
        // تشخیص گروه ساختمان بر اساس متراژ
        $meter = $request->metraj;
        switch ( $meter  ) {
            case  ($meter<=500) :
                $gro = 'a';
                break;
            case  ($meter <= 1500) :
                $gro = 'b';         
                break;          
            case  ($meter <= 4000) :
                $gro = 'c';              
                break;
            case  ($meter > 4000) :
                $gro = 'd';            
                break;           
        }
        // تاید صحت اطلاعات ورودی
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'metraj' => 'required|',           
                ]);
        //ذخیره اطلاعات پروژه در پایگاه داده به همراه اطلاعات کاربر وارد کننده پروژه
        $validated['group'] = $gro;  
        
        $project->update($validated);
    
        return redirect(route('projects.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        $project->roles()->detach($project->id);
 
        return redirect(route('projects.index'));
    }
    /**
     * 
     * export xlsx file for excel.
     */
    public function export() 
    {
        return Excel::download(new ProjectsExport, 'projects.xlsx');
    }

    public function export_view() 
    {
        return Excel::download(new ProjectsExportView, 'projects.xlsx');
    }
}
