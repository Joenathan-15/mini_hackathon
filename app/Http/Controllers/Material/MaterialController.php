<?php

namespace App\Http\Controllers\Material;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('details', "categories")->where("user_id", Auth::id())->get();
        return response()->json($materials);
    }

    public function show(int $id)
    {
        $material = Material::findOrFail($id);
        return view('pages.materials.show', compact('material'));
    }

    public function create()
    {
        return view('pages.materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|file|mimes:pdf,doc,docx,txt,ppt,pptx',
            'price' => 'nullable|numeric',
            'categories' => 'array|nullable',
            'categories.*' => 'string|max:255'
        ], [
            'title.required' => 'judul harus diisi.',
            'file_path.required' => 'file harus diunggah.',
            'description.string' => 'deskripsi harus berupa teks.',
            'title.max' => 'judul maksimal 255 karakter.',
            'file_path.file' => 'file harus berupa file yang valid.',
            'file_path.mimes' => 'file harus berupa salah satu dari: pdf, doc, docx, txt, ppt, pptx.',
            'price.numeric' => 'harga harus berupa angka.',
        ]);

        // Simpan file ke storage
        $filePath = $request->file('file_path')->store('materials');

        // Buat material baru
        $material = Material::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'file_name' => $filePath,
            'price' => $validated['price'] ?? 0,
        ]);

        // Jika kategori dikirim
        if (!empty($validated['categories'])) {
            foreach ($validated['categories'] as $categoryName) {
                // Buat kategori jika belum ada
                $category = Category::firstOrCreate([
                    'name' => trim($categoryName)
                ]);

                // Simpan ke tabel material_details
                MaterialDetail::create([
                    'material_id' => $material->id,
                    'category_id' => $category->id,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Materi berhasil diunggah!');
    }

    public function getPurchasesMaterial()
    {
        $materials = Transaction::with('material')
            ->where('customer_id', Auth::id())
            ->get()
            ->map(function ($transaction) {
                return $transaction->material;
            });

        return response()->json($materials);
    }

    public function getMaterials(Request $request){
        $search = $request->query('search');
        $materials = Material::with('details', "categories")->when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%');
        })->get();
        return response()->json($materials);
    }
}
