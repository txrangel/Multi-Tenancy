@extends('layouts.app')
@section('content')
    @can('managePermissions', $profile)
        <div class="p-4 bg-zinc-100 dark:bg-zinc-800 shadow sm:rounded-lg space-y-2">
            <section class="relative overflow-auto">
                <header>
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Editar Permissões do Perfil: ') }} {{ $profile->name }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Selecione as permissões que deseja atrelar ao profile.') }}
                    </p>
                </header>
                <form action="{{ route('profiles.permissions.update', $profile->id) }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <label for="permissions" class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-5 font-medium text-zinc-900">Selecione as Permissões:</label>
                        <ul class="grid w-full gap-2 md:grid-cols-3">
                            @foreach ($permissions as $permission)
                                <li>
                                    <!-- Botão de checkbox -->
                                    <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]"
                                        value="{{ $permission->id }}" class="hidden peer"
                                        {{ $profile->permissions->contains($permission->id) ? 'checked' : '' }}>

                                        <label for="permission_{{ $permission->id }}"
                                            class="select-none transition-all duration-200 ease-in-out flex w-full justify-end h-12 overflow-hidden shadow-md text-zinc-900 bg-zinc-300 border-2 border-zinc-200 rounded-lg cursor-pointer peer-checked:bg-blue-700 relative">
                                            <div class="w-5/6 bg-zinc-300 flex items-center justify-between p-2 rounded-sm">
                                                <div class="w-full text-md font-semibold line-clamp-3 break-words">{{ $permission->name }}</div>
                                            </div>
                                        </label>
                                    <x-input-error class="mt-2" :messages="$errors->get('permissions.*')" />
                                </li>                                
                            @endforeach
                        </ul>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Atualizar') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
    @endcan
@endsection