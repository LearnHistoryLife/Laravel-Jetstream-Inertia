<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{


  public function __construct() {
      $this->authorizeResource(User::class);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queries = ['search','page'];

        return Inertia::render('User/Index', [
            'users_all' => User::filter($request->only($queries))->paginate(8)->withQueryString(),
            'filters' => $request->all($queries),
        ]);




        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('User/Create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {


        // dd($user);
        return Inertia::render('User/Show',compact('user'));

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // dd($user);
        return Inertia::render('User/Edit',compact('user'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $authUser = $request->user();

         $request->validate([
             'name' => ['required'],
             'email' => ['required', 'email'],
        ],[
            'required' => 'tidak boleh kosong !'
        ]);

        // $user->update([
        //     'name' => $request->name,
        //     'email' => $request->email
        // ])
            $user->update($request->only('name','email'));

            if ($authUser->hasRole('admin')) {
                $user->role = $request->role;
                $user->save();
            }
    
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
