<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        $data['title'] = 'Anggota';
        return $dataTable->render('anggota.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Anggota';
        return view('anggota.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:admins'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ];

        User::create($data);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dibuat');
    }

    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Anggota',
            'user' => User::findOrFail($id)->toArray()
        ];

        return view("anggota.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id), 'unique:admins'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ];

        if (empty($data['password'])) {
            unset($data['password']);
        }

        User::where('id', $id)->update($data);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
