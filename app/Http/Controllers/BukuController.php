<?php

namespace App\Http\Controllers;

use App\DataTables\BukuDataTable;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth:admin,user");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BukuDataTable $dataTable)
    {
        $data["title"] = "Buku";
        return $dataTable->render("buku.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = "Tambah Buku";
        return view("buku.create", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            "title" => "Edit Buku",
            "buku" => Buku::findOrFail($id)
        ];

        return view("buku.edit", $data);
    }
}
