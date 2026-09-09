<?php

namespace App\Http\Controllers\Settings;

use App\Enum\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(): Response
    {
        Gate::authorize(Permissions::MANAGE_ROLE->value);

        return Inertia::render('settings/Roles/Index', [
            'roles' => Role::query()
                ->withCount('users')
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize(Permissions::MANAGE_ROLE->value);

        return Inertia::render('settings/Roles/Create');
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::findOrCreate($request->validated('name'), 'web');

        toast('Ruolo creato con successo');

        return to_route('settings.roles.index');
    }
}
