<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    protected $service;

    public function __construct(UserProfileService $service)
    {
        $this->service = $service;
    }
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function update(UserProfileUpdate $request): RedirectResponse
    {
        try {
            if ($this->service->update($request))
                return Redirect::route('user.profile.edit')->with(key: 'success', value: 'Perfil alterado!');
            else
                return back()->with(key: 'error', value: "Perfil não alterado!")->withInput();
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput();
        }
    }
}