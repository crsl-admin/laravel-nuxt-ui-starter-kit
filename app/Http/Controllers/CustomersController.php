<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class CustomersController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('viewAny', Customer::class);

        return Inertia::render('Customers');
    }
}
