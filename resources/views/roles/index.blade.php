<x-app-layout>
    <div dir="rtl" class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <textarea
                name="name"
                placeholder="{{ __('لطفا نام مهندس را وارد کنید') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('name') }}</textarea>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
           
            <div>
                <p>پایه نظام مهندسی را انتخاب کنید</p>
                <select name="payeh" id="">
                <option value="1">1 (پیش فرض)</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="ارشد">ارشد</option>
            </select>
            </div>
            
            <x-input-error :messages="$errors->get('payeh')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('ثبت') }}</x-primary-button>
        </form>


        <div>
            <div class="panel-heading py-4"></div>
            <div class="panel-body ">
                <a href="{{ route('roles.export_view') }}" class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">  دانلود <svg fill="white" class="h-6 w-7 inline-block align-center" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Microsoft Excel</title><path d="M23 1.5q.41 0 .7.3.3.29.3.7v19q0 .41-.3.7-.29.3-.7.3H7q-.41 0-.7-.3-.3-.29-.3-.7V18H1q-.41 0-.7-.3-.3-.29-.3-.7V7q0-.41.3-.7Q.58 6 1 6h5V2.5q0-.41.3-.7.29-.3.7-.3zM6 13.28l1.42 2.66h2.14l-2.38-3.87 2.34-3.8H7.46l-1.3 2.4-.05.08-.04.09-.64-1.28-.66-1.29H2.59l2.27 3.82-2.48 3.85h2.16zM14.25 21v-3H7.5v3zm0-4.5v-3.75H12v3.75zm0-5.25V7.5H12v3.75zm0-5.25V3H7.5v3zm8.25 15v-3h-6.75v3zm0-4.5v-3.75h-6.75v3.75zm0-5.25V7.5h-6.75v3.75zm0-5.25V3h-6.75v3Z"/></svg>  </a>
                <br><br>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block  min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="">
                               @include('roles.table', $roles)
                            </div>
                        </div>
                    </div>                    
                </div>           
            </div>             
        </div>
{{-- 
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

        @foreach ($roles as $role)

                
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <small class="ml-2 text-sm text-gray-600"> {{ $role->created_at->format('j M Y, g:i a') }}</small>
                                <span class="text-gray-800">نام مهندس: {{ $role->name }} , </span>
                                <span class="text-gray-800">پایه: {{ $role->payeh }} </span>
                                
                            </div>
                        </div>
                        @foreach ($role->projects as $rol)
                        
                            <p class="mt-4 text-lg text-gray-900">نام پروژه : {{$rol->name }}</p>
                            <p class="mt-4 text-lg text-gray-900">متراژ پروژه : {{ $rol->group }}</p>
                       <small class="ml-2 text-sm text-gray-600">{{ $rol->created_at->format('j M Y, g:i a') }} تاریخ ثبت پروژه در سیستم   </small>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
</x-app-layout>