<?php

namespace App\Http\Controllers;

use App\DataTables\PengajuanDataTable;
use App\DataTables\Scopes\ActiveUser;
use App\Models\Buku;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
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
    public function index(PengajuanDataTable $dataTable)
    {
        $data['title'] = 'Pengajuan';
        return $dataTable->addScope(new ActiveUser())->render('pengajuan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bukuId)
    {
        $data = [
            'title' => 'Tambah Pengajuan',
            'buku' => Buku::findOrFail($bukuId)->toArray()
        ];
        return view('pengajuan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bukuId)
    {
        $request->validate([
            'tanggal_peminjaman' => ['required', 'date:YYYY-MM-DD', 'before_or_equal:tanggal_pengembalian'],
            'tanggal_pengembalian' => ['required', 'date:YYYY-MM-DD', 'after_or_equal:tanggal_peminjaman'],
        ]);

        $data = [
            'id_buku' => $bukuId,
            'id_user' => Auth::guard('user')->user()->id,
            'tanggal_peminjaman' => $request['tanggal_peminjaman'],
            'tanggal_pengembalian' => $request['tanggal_pengembalian']
        ];

        Pengajuan::create($data);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat');
    }

    /**
     * Update the specified resource in storage.
     */
    public function status($id, $status)
    {
        $pengajuan = Pengajuan::findOrFail($id)->toArray();
        $buku = Buku::findOrFail($pengajuan['id_buku'])->toArray();

        $data = [
            'status' => $status,
            'stok' => $buku['stok']
        ];

        $statusList = ["pending", "approved", "rejected", "returned"];

        $validator = Validator::make($data, [
            'status' => ['required', Rule::in($statusList)],
            'stok' => ['required', 'numeric', 'min:1']
        ]);

        if ($validator->fails()) {
            return redirect()->route('pengajuan.index')->with('failed', "Pengajuan gagal diubah");
        }

        Pengajuan::where('id', $id)->update(['status' => $status]);

        if ($status === "approved") {
            Buku::where("id", $buku['id'])->update(['stok' => $buku['stok'] - 1]);
        } else if ($status === "returned") {
            Buku::where("id", $buku['id'])->update(['stok' => $buku['stok'] + 1]);
        }

        return redirect()->route('pengajuan.index')->with('success', "Pengajuan berhasil diubah [$status]");
    }
}
