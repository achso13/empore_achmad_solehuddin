<?php

namespace App\Http\Controllers;

use App\DataTables\PeminjamanDataTable;
use App\DataTables\Scopes\ActiveUser;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
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
    public function index(PeminjamanDataTable $dataTable)
    {
        $data['title'] = 'Peminjaman';
        return $dataTable->addScope(new ActiveUser())->render('peminjaman.index', $data);
    }
}
