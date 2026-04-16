<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Header --}}
                    <div class="flex items-center gap-3 mb-8">
                        <a href="{{ route('product.index') }}" 
                           class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Edit Product</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                Update details for <span class="font-medium text-gray-700 dark:text-gray-300">{{ $product->name }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Form Delete (Hidden) --}}
                    <form id="delete-product-form" action="{{ route('product.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>

                    {{-- Form Edit --}}
                    <form action="{{ route('product.update', $product->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Product Name <span class="text-red-500"></span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" 
                                   placeholder="e.g. Wireless Headphones"
                                   class="w-full px-4 py-2.5 rounded-lg border text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('name') ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300 dark:border-gray-600' }}">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity & Price --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Quantity <span class="text-red-500"></span>
                                </label>
                                <input type="number" id="quantity" name="qty" value="{{ old('qty', $product->qty) }}" 
                                       placeholder="0" min="0"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('qty') ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300 dark:border-gray-600' }}">
                                @error('qty')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Price (Rp) <span class="text-red-500"></span>
                                </label>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" 
                                       placeholder="0" min="0" step="0.01"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('price') ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300 dark:border-gray-600' }}">
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Owner --}}
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Owner <span class="text-red-500"></span>
                            </label>
                            <select id="user_id" name="user_id" 
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('user_id') ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300 dark:border-gray-600' }}">
                                <option value="">-- Select Owner --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id', $product->user_id) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 mt-8">
                            <button type="button" 
                                    onclick="if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-product-form').submit();"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Product
                            </button>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('product.index') }}" 
                                   class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150 ease-in-out">
                                    Save Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
