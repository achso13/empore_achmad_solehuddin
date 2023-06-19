<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Buku::all();

        return response()->json([
            "success" => true,
            "message" => "Books fetched successfully",
            "data" => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'judul_buku' => ['required', 'string', 'max:255'],
                'tahun_terbit' => ['required', 'date_format:Y'],
                'penulis' => ['required', 'string', 'max:255'],
                'stok' => ['required', 'integer'],
            ]);

            $book = Buku::create($validatedData);

            $request->session()->flash('success', 'Buku berhasil dibuat');
            $request->session()->reflash();

            return response()->json([
                "success" => true,
                "message" => "Book created successfully",
                "data" => $book
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                "message" => "Create book failed",
                'error' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $books = Buku::findOrFail($id);
            return response()->json([
                "success" => true,
                "message" => "Book fetched successfully",
                "data" => $books
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Book id not found"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Buku::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Book id not found"
            ], 404);
        }

        try {
            $validatedData = $request->validate([
                'judul_buku' => ['required', 'string', 'max:255'],
                'tahun_terbit' => ['required', 'date_format:Y'],
                'penulis' => ['required', 'string', 'max:255'],
                'stok' => ['required', 'integer'],
            ]);

            $request->session()->flash('success', 'Buku berhasil diupdate');
            $request->session()->reflash();

            Buku::where("id", $id)->update($validatedData);

            return response()->json([
                "success" => true,
                "message" => "Book updated successfully",
                "data" => Buku::find($id)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                "message" => "Update book failed",
                'error' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Buku::findOrFail($id);
            Buku::destroy($id);

            session()->flash('success', 'Buku berhasil dihapus');
            session()->reflash();

            return response()->json([
                "success" => true,
                "message" => "Book deleted successfully"
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Book id not found"
            ]);
        }
    }
}
