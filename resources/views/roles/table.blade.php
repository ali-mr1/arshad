<table dir="ltr" class="border-collapse text-center table 	 bg-white table-auto border border-slate-400 pl-6 rounded-md ...">
    <caption class="caption-top">
      لیست مهندسین و سوابق پروژه ها
      </caption>
    <thead>
        <tr class="justify-between ">
            <th class="border border-slate-300  px-6 py-2 ..."> تنظیمات </th>
           
            <th class="border border-slate-300  px-6 py-2 ...">  تعداد D </th>
            <th class="border border-slate-300 px-6 py-2 ...">  تعداد  C </th>
            <th class="border border-slate-300 px-6 py-2 ...">   تعداد  B    </th>
            <th class="border border-slate-300 px-6 py-2 ...">تعداد  A</th>
            <th class="border border-slate-300 px-6 py-2 ..."> تعداد پروژ ها</th>
            <th class="border border-slate-300 px-6 py-2...">متراژ کل </th>
            <th class="border border-slate-300 px-6 py-2 ..."> نام مهندس</th>
        </tr>
    </thead>
    <tbody  class="">
    @foreach ($roles as $role)    
    <tr>
        <td class="border border-slate-300 ...">

            @if ($role->user->is(auth()->user()))
            <a href="{{ route('roles.edit', $role) }}" class="text-center hover:text-violet-700 ">ویرایش</a>
            <form method="POST" action="{{ route('roles.destroy', $role) }}">
                @csrf
                @method('delete')
                <button href="route('roles.destroy', $role)" onclick="event.preventDefault(); this.closest('form').submit();" class="text-center hover:text-red-800 ">حذف</button>
            </form>


          
            @endif


        </td>
           @php
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;
                $e = 0;
            @endphp
        @foreach ($role->projects as $project )
         
            @switch($project->group)
                @case('e') 
                    @php
                        $e +=1;
                    @endphp                              
                    @break
                @case('d')
                    @php
                        $d +=1;
                    @endphp                                 
                    @break
                @case('c')
                    @php
                        $c +=1;
                    @endphp                               
                    @break
                @case('b')
                    @php
                        $b +=1;
                    @endphp                             
                    @break
                @case('a')
                    @php
                        $a +=1;
                    @endphp                               
                    @break
                @default                               
            @endswitch
            
        @endforeach
       
        <td class="border border-slate-300 ...">{{ $d }}</td>
        <td class="border border-slate-300 ...">{{ $c }}</td>
        <td class="border border-slate-300 ...">{{ $b }}</td>
        <td class="border border-slate-300 ...">{{ $a }}</td>
    
        <td class="border border-slate-300 ...">{{$role->projects->count()}}</td>
        <td class="border border-slate-300 ...">
        {{ $role->projects->sum(function ($project) {
              return $project->metraj;}) }}
        </td>
        <td class="border border-slate-300 ..."> {{ $role->name }} </td>
    </tr>   
  
 
    @endforeach

    </tbody> 
</table>