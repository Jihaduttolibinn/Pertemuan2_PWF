<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Pengguna biasa hanya bisa mengubah produk miliknya sendiri. Admin bisa mengubah semua.
        return $user->id === $product->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Pengguna biasa hanya bisa menghapus produk miliknya sendiri.
        // Namun, jika pengguna tersebut adalah admin, berikan dia akses untuk menghapus produk milik siapa saja.
        return $user->id === $product->user_id || $user->role === 'admin';
    }
}
