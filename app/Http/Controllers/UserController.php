<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource, with search.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);
        $search = $request->query('search');
        $users = $this->service->getAll($search);

        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $perPage = $users->perPage();
        $total = $users->total();

        return view('pages.admin.user.index', compact(
            'users',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', User::class);
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('create', User::class);
        $user = $this->service->store($request->validated());
        return redirect()->route('admin.users.show', $user)->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);
        return view('pages.admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        return view('pages.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('update', $user);
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
