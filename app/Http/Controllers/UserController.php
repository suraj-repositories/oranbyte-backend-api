<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {



    }
    public function admin()
    {
        //
        try{
            $user = User::with('userDetail')->where('role', 'ADMIN')->first();
            if ($user && $user->userDetail) {
                $userData = array_merge($user->toArray(), $user->userDetail->toArray());
                unset($userData['user_detail']);
            } else {
                $userData = $user ? $user->toArray() : null;
            }
            return response()->json($userData);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Failed to fetch admin user',
                'message' => $e->getMessage()
            ], 500);
        }


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
