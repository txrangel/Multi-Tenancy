@extends('layouts.app')
@section('content')
    @can('update', $permission)
        <div class="p-4 bg-zinc-100 dark:bg-zinc-800 shadow sm:rounded-lg space-y-2">
            <section class="relative overflow-auto">
                <header>
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Editar Permissão') }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Atualize as informações da permissão conforme necessário.') }}
                    </p>
                </header>
                <form method="post" action="{{ route('permissions.update', $permission->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $permission->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Atualizar') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    @endcan
@endsection