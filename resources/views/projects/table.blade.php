<table class="hidden">
    <thead >
        <tr >
            <th >
                نام پروژه
            </th>
            <th >
                متراژ پروژه
            </th>
            <th >
                گروه پروژه
            </th>
            <th >
                مهندس انتخابی برای پروژه
            </th>
            <th >
                پایه مهندس 
            </th>
           
        </tr>
    </thead>
    <tbody class="bg-red-50">
        @foreach ($projects as $project )
        <tr>
            <td>
                {{ $project->name }}
            </td>
            <td>
                {{ $project->metraj }}
            </td>
            <td>
                {{ $project->group }}
            </td>
            @foreach ($project->roles as $role )
                <td >
                    {{ $role->name }}
                </td>
                <td>
                    {{ $role->payeh }}
                </td> 
            @endforeach
            
        </tr>
        @endforeach
        
    </tbody>
</table>