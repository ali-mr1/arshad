<x-app-layout >
    <div dir="rtl" class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('patch')
            <textarea
                    name="name"
                    placeholder="{{ __('لطفا نام پروژه را وارد کنید') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('name', $project->name) }}</textarea>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <textarea
                    name="metraj"
                    placeholder="{{ __('لطفا متراژ پروژه را وارد کنید') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('metraj', $project->metraj) }}</textarea>
                <x-input-error :messages="$errors->get('metraj')" class="mt-2" />

                <x-primary-button class="mt-4">{{ __('ذخیره') }}</x-primary-button>
                <a class="mt-4 px-4" href="{{ route('projects.index') }}">{{ __('انصراف') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>