@extends('layouts.app')
@section('content')
    @can('create',App\Models\Permission::class)
        <div class="p-4 bg-zinc-100 dark:bg-zinc-800 shadow sm:rounded-lg space-y-2">
            <section class="relative overflow-auto">
                <header>
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Nova Permissão') }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Preencha as informações para cadastrar uma nova Permissão.') }}
                    </p>
                </header>
                <form method="post" action="{{ route('permissions.store') }}" class="mt-2 space-y-2 p-2">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    @endcan
@endsection