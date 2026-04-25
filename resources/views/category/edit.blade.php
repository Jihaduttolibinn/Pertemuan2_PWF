<x-app-layout>
    <div class="py-12 bg-[#111827] min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg border border-gray-800">
                <div class="p-8">
                    
                    {{-- Header Section --}}
                    <div class="flex items-center gap-4 mb-8">
                        <a href="{{ route('category.index') }}" class="p-2 rounded-lg bg-gray-800 text-gray-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-xl font-bold text-white tracking-tight">Edit Category</h2>
                    </div>

                    <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">
                                Category Name
                            </label>
                            <input type="text" name="name" id="name" 
                                class="block w-full px-4 py-3 bg-[#0F172A] border border-gray-800 rounded-lg text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-gray-600 focus:border-gray-600 transition"
                                placeholder="Enter category name"
                                value="{{ old('name', $category->name) }}"
                                required>
                            @error('name')
                                <p class="mt-2 text-xs text-red-500 font-medium px-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="total_product" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">
                                Total Product
                            </label>
                            <input type="text" name="total_product" id="total_product" 
                                class="block w-full px-4 py-3 bg-[#0F172A] border border-gray-800 rounded-lg text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-gray-600 focus:border-gray-600 transition"
                                placeholder="0"
                                value="{{ old('total_product', $category->products_count) }}">
                            @error('total_product')
                                <p class="mt-2 text-xs text-red-500 font-medium px-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-800">
                            <a href="{{ route('category.index') }}" 
                               class="px-5 py-2 text-sm font-medium text-gray-400 hover:text-white transition">
                                Abort
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-white text-gray-900 text-sm font-bold rounded-lg hover:bg-gray-200 transition active:scale-95 shadow-lg">
                                Apply Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
