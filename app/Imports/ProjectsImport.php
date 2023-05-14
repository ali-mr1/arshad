<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;


class ProjectsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private $users;
    public function __construct()
    {
        $this->users = User::all(); 
    }

    public function group($metraj){
        $meter =$metraj;
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
        return $gro;
    }

    public function collection(Collection $rows)
    { 
        
       
        foreach ($rows as $row) 
        {
            $user = User::where('name',$row['karbar'])->first();
            $group = $this->group( $row['metraj']);
            $validated = [
                'name' => $row['name'],
                'metraj' => $row['metraj'],         
                'group' => $group,
                'user_id' => $user->id, 
                    ];
            Project::create($validated);
                   
            $proj = Project::where('name', $row['name'])-> latest()->first();  // انتخاب آخرین پروژه
            $roles = Role::with('projects')->get(); //لیست همه مهندسین
            
            /*
            * اگر پروژه تا 500 متر بود به ترتیب حروف الفبا اسم مهندس به هر مهندس 2 پروژه پشت سر هم تعلق میگیرد
            *
            */

            
            $minr = [];
            foreach($roles as $role){ 
                $countA = $role->projects()->where('group', 'a')->count();
                $minr[$role->id]= $countA;
                
            }
            $miId =1;
    
            if (count($minr) != 0 ) {
            $miId =  min(array_keys($minr, min($minr))); 
            }

            if($proj->metraj <= 500 && count($roles) > 0){

                for($i=1;$i<= count($roles);$i++)
                {
                    $role = Role::find($i);
                    $countA = $role->projects()->where('group', 'a')->count();
                    if($countA % 2 != 0)
                    {
                        $role->projects()->attach($proj->id);
                        
                        break;
                    }elseif($countA == 0){
                        $role->projects()->attach($proj->id);
                        break;
                    }elseif($role->id == $miId){

                        $role->projects()->attach($proj->id);
                        break;
                    }
                
                }           
            }
            else{

                    
            //  با در نظر داشتن پایه مهندسین تعین مهندسی که مجموع کارکردش از همه کمتر باشه  
            $i = 0;
            $s = 0; //variable for sum
            $arr = [];
            $t = 0;// حالت ابتدایی کا مهندس تا بحال پروژه ای نگرفته
            //کمترین  متراژ مهندسان
            foreach($roles as $role){
                //ابتدا به مهندسی که تازه وارد است یک پروژه میدهیم
            if ($role->projects->count() == 0 ){
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
            
            if ($t == 0 && count($role) > 0){
                $role->projects()->attach($proj->id);
                
            }
            }   
                
        }
    }
}


