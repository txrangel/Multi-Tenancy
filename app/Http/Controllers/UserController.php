<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordCreateUpdate;
use App\Http\Requests\UserCreateUpdate;
use App\Services\PasswordService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    public function index(): View
    {
        $users = $this->service->getPaginate();
        return view(view: 'users.index', data: compact(var_name: 'users'));
    }
    public function create(): View
    {
        return view(view: 'users.create');
    }
    public function edit(int $id): View
    {
        $user  = $this->service->findById(id: $id);
        return view(view: 'users.edit', data: compact(var_name: 'user'));
    }
    public function editPassword(int $id): View
    {
        $user  = $this->service->findById(id: $id);
        return view(view: 'users.editPassword', data: compact(var_name: 'user'));
    }
    public function store(UserCreateUpdate $request,PasswordService $passwordService): RedirectResponse
    {
        try {
            $this->service->create(data: $request->all(),passwordService: $passwordService);
            return Redirect::route(route: 'users.index')->with(key: 'success', value: 'Perfil criado com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
    public function update(UserCreateUpdate $request,int $id): RedirectResponse
    {
        try {
            $this->service->update(id: $id, data: $request->all());
            return Redirect::route(route: 'users.index')->with(key: 'success', value: 'Perfil atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
    public function updatePassword(PasswordCreateUpdate $request,int $id,PasswordService $passwordService): RedirectResponse
    {
        try {
            $data['password'] = $passwordService->make(password: $request->password);
            $this->service->update(id: $id, data: $data);
            return Redirect::route(route: 'users.index')->with(key: 'success', value: 'Senha atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            return Redirect::route(route: 'users.index')->with(key: 'success', value: 'Perfil excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
    public function editProfiles(int $id,ProfileService $service): View
    {
        $profiles = $service->getAllProfiles();
        $user  = $this->service->findById(id: $id);
        return view(view: 'users.profiles.edit', data: compact(var_name: ['user', 'profiles']));
    }

    public function updateProfiles(Request $request, int $id): RedirectResponse
    {
        try {
            $profileIds = $request->input('profiles', []);
            $user       = $this->service->findById(id: $id);
            $this->service->syncProfiles($user, $profileIds);
            return redirect()->route('users.index')->with('success', 'Perfis dos usuários alterados com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
}