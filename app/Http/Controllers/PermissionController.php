<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateUpdate;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }
    public function index(): View
    {
        $permissions = $this->service->getPaginate();
        return view(view: 'permissions.index', data: compact(var_name: 'permissions'));
    }
    public function create(): View
    {
        return view(view: 'permissions.create');
    }
    public function edit(int $id): View
    {
        $permission  = $this->service->findById(id: $id);
        return view(view: 'permissions.edit', data: compact(var_name: 'permission'));
    }
    public function store(PermissionCreateUpdate $request): RedirectResponse
    {
        try {
            $this->service->create(data: $request->all());
            return Redirect::route(route: 'permissions.index')->with(key: 'success', value: 'Permissão criada com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
    public function update(PermissionCreateUpdate $request,int $id): RedirectResponse
    {
        try {
            $this->service->update(id: $id, data: $request->all());
            return Redirect::route(route: 'permissions.index')->with(key: 'success', value: 'Permissão atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete(id: $id);
            return Redirect::route(route: 'permissions.index')->with(key: 'success', value: 'Permissão excluída com sucesso!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
}