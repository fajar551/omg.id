<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_creator']);
    }

    public function index()
    {
        $products = auth()->user()->products()->with(['ebook', 'ecourse', 'buku', 'digital'])->get();
        $productsJson = $products->toJson();
        return view('products.index', compact('products', 'productsJson'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => $request->type === 'buku' ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'type' => 'required|string|in:ecourse,ebook,digital,buku',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ecourse_url' => 'nullable|string',
            'ecourse_duration' => 'nullable|integer',
            'ebook_file' => 'nullable|file|mimes:pdf',
            'ebook_pages' => 'nullable|integer',
            'digital_file' => 'nullable|file',
            'buku_city' => 'nullable|string|max:255',
        ]);
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        if (in_array($request->type, ['digital', 'ebook', 'ecourse'])) {
            unset($validated['stock']);
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        // Simpan data umum
        $product = auth()->user()->products()->create(collect($validated)->except([
            'ecourse_url','ecourse_duration','ebook_file','ebook_pages','digital_file','buku_city'
        ])->toArray());
        // Simpan data khusus
        if ($request->type === 'buku') {
            $product->buku()->create([
                'city' => $request->buku_city,
            ]);
        } elseif ($request->type === 'ebook') {
            $ebook_file = null;
            if ($request->hasFile('ebook_file')) {
                $ebook_file = $request->file('ebook_file')->store('products/ebooks', 'public');
            }
            $product->ebook()->create([
                'ebook_file' => $ebook_file,
                'ebook_pages' => $request->ebook_pages,
            ]);
        } elseif ($request->type === 'ecourse') {
            $product->ecourse()->create([
                'ecourse_url' => $request->ecourse_url,
                'ecourse_duration' => $request->ecourse_duration,
            ]);
        } elseif ($request->type === 'digital') {
            $digital_file = null;
            if ($request->hasFile('digital_file')) {
                $digital_file = $request->file('digital_file')->store('products/digital', 'public');
            }
            $product->digital()->create([
                'digital_file' => $digital_file,
            ]);
        }
        try {
            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect('/product/manage')->with('success', 'Produk berhasil ditambahkan.');
        }
    }

    public function edit(int $id)
    {
        $product = auth()->user()->products()->find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan atau sudah dihapus. Silakan refresh halaman.');
        }
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, int $id)
    {
        $product = auth()->user()->products()->find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan atau sudah dihapus. Silakan refresh halaman.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => $request->type === 'buku' ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'type' => 'required|string|in:ecourse,ebook,digital,buku',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ecourse_url' => 'nullable|string',
            'ecourse_duration' => 'nullable|integer',
            'ebook_file' => 'nullable|file|mimes:pdf',
            'ebook_pages' => 'nullable|integer',
            'digital_file' => 'nullable|file',
            'buku_city' => 'nullable|string|max:255',
        ]);
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        if (in_array($request->type, ['digital', 'ebook', 'ecourse'])) {
            unset($validated['stock']);
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        // Update data umum
        $product->update(collect($validated)->except([
            'ecourse_url','ecourse_duration','ebook_file','ebook_pages','digital_file','buku_city'
        ])->toArray());
        // Update data khusus
        if ($request->type === 'buku') {
            $product->buku()->updateOrCreate(
                ['product_id' => $product->id],
                ['city' => $request->buku_city]
            );
        } elseif ($request->type === 'ebook') {
            $ebook_file = $product->ebook ? $product->ebook->ebook_file : null;
            if ($request->hasFile('ebook_file')) {
                $ebook_file = $request->file('ebook_file')->store('products/ebooks', 'public');
            }
            $product->ebook()->updateOrCreate(
                ['product_id' => $product->id],
                ['ebook_file' => $ebook_file, 'ebook_pages' => $request->ebook_pages]
            );
        } elseif ($request->type === 'ecourse') {
            $product->ecourse()->updateOrCreate(
                ['product_id' => $product->id],
                ['ecourse_url' => $request->ecourse_url, 'ecourse_duration' => $request->ecourse_duration]
            );
        } elseif ($request->type === 'digital') {
            $digital_file = $product->digital ? $product->digital->digital_file : null;
            if ($request->hasFile('digital_file')) {
                $digital_file = $request->file('digital_file')->store('products/digital', 'public');
            }
            $product->digital()->updateOrCreate(
                ['product_id' => $product->id],
                ['digital_file' => $digital_file]
            );
        }
        return redirect('/product/manage')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(int $id)
    {
        $product = auth()->user()->products()->find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan atau sudah dihapus. Silakan refresh halaman.');
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect('/product/manage')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(int $id)
    {
        $product = auth()->user()->products()->with(['ebook', 'ecourse', 'buku', 'digital'])->find($id);
        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        }
        return view('products.show', compact('product'));
    }
}
