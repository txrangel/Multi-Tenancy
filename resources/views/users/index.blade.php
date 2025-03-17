@extends('layouts.app')
@section('content')
    @can('viewAny',App\Models\User::class)
        <div class="p-4 bg-zinc-100 dark:bg-zinc-800 shadow sm:rounded-lg space-y-2">
            @can('create',App\Models\User::class)
                <div class="space-x-4">
                    <a href="{{ route('users.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center my-8 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        {{ __('Novo Usuário') }}
                    </a>
                </div>
            @endcan
            <section class="relative overflow-auto">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                    {{ __('Lista de Usuários') }}
                </h2>
                <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
                    <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 tracking-wider">
                                {{ __('ID') }}
                            </th>
                            <th scope="col" class="px-6 py-3 tracking-wider">
                                {{ __('Nome') }}
                            </th>
                            <th scope="col" class="px-6 py-3 tracking-wider flex justify-center">
                                {{ __('Ações') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-zinc-100 dark:bg-zinc-700' : 'bg-zinc-200 dark:bg-zinc-900' }} border-b dark:border-zinc-600">
                                <th class="px-6 py-4">
                                    {{ $user->id }}
                                </th>
                                <td scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 flex justify-center space-x-4">
                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline">
                                            {{ __('Editar') }}
                                        </a>
                                    @endcan
                                    @can('manageProfiles', $user)
                                        <a href="{{ route('users.profiles.edit', $user->id) }}" class="text-green-600 dark:text-green-500 hover:underline">
                                            {{ __('Perfis') }}
                                        </a>
                                    @endcan
                                    @can('updatePassword', $user)
                                        <a href="{{ route('users.edit.password', $user->id) }}" class="text-orange-600 dark:text-orange-500 hover:underline">
                                            {{ __('Editar Senha') }}
                                        </a>
                                    @endcan
                                    @can('delete', $user)
                                        <button onclick="openDeleteModal('Você tem certeza que deseja excluir o usuário: {{ $user->name }}?', '{{ route('users.destroy', $user->id) }}')"
                                                class="text-red-600 dark:text-red-500 hover:underline">
                                            {{ __('Excluir') }}
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <!-- Adicione a paginação aqui -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
        @include('components.delete-modal')
    @endcan
@endsection