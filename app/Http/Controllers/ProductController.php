<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $products = Product::with('user')->get();
        } else {
            $products = Product::where('user_id', Auth::id())
                ->orWhereHas('user', function ($query) {
                    $query->where('role', 'admin');
                })
                ->with('user')
                ->get();
        }
        
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-product');
        $users = User::all();
        return view('product.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-product');
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal harus 5 karakter.',
            'qty.required' => 'Jumlah (QTY) wajib diisi.',
            'qty.integer' => 'Jumlah harus berupa angka bulat.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'user_id.required' => 'Pemilik produk wajib dipilih.',
        ]);

        Product::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $product);
        $users = User::all();
        return view('product.edit', compact('product', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $product);
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal harus 5 karakter.',
            'qty.required' => 'Jumlah (QTY) wajib diisi.',
            'qty.integer' => 'Jumlah harus berupa angka bulat.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'user_id.required' => 'Pemilik produk wajib dipilih.',
        ]);

        $product->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $product);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
    }
}
