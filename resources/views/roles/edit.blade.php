<x-app-layout>
    <div dir="rtl" class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('roles.update',$role) }}">
            @csrf
            @method('patch')
            <textarea
                name="name"
                placeholder="{{ __('لطفا نام مهندس را وارد کنید') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('name', $role->name) }}</textarea>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
           
            <div>
                <p>پایه نظام مهندسی را انتخاب کنید</p>
                <select name="payeh" id="">
                <option value="1" {{ $role->payeh == 1 ? 'selected' : ''  }}>1</option>
                <option value="2" {{ $role->payeh == 2 ? 'selected' : ''  }}>2</option>
                <option value="3" {{ $role->payeh == 3 ? 'selected' : ''  }}>3</option>
                <option value="ارشد" {{ $role->payeh == 'ارشد' ? 'selected' : ''  }}>ارشد</option>
            </select>
            </div>
            
            <x-input-error :messages="$errors->get('payeh')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('ذخیره') }}</x-primary-button>
            <a class="mt-4 px-4" href="{{ route('roles.index') }}">{{ __('انصراف') }}</a>
        </form>
    </div>
</x-app-layout>