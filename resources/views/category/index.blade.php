<x-app-layout>
    <div class="py-12 bg-[#111827] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Area --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-white">Category List</h2>
                    <p class="text-sm text-gray-400 mt-1"></p>
                </div>
                <a href="{{ route('category.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#4F46E5] hover:bg-[#4338CA] text-white text-sm font-medium rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Category
                </a>
            </div>

            {{-- Table Card Container --}}
            <div class="bg-[#1F2937] rounded-xl border border-gray-800 shadow-xl overflow-hidden">
                <table class="min-w-full text-left">
                    <thead class="bg-[#2D3748]">
                        <tr>
                            <th class="px-6 py-4 text-[11px] font-bold text-white uppercase tracking-wider w-16">
                                1
                            </th>
                            <th class="px-6 py-4 text-[11px] font-bold text-white uppercase tracking-wider">
                                NAME
                            </th>
                            <th class="px-6 py-4 text-[11px] font-bold text-white uppercase tracking-wider text-center">
                                TOTAL PRODUCT
                            </th>
                            <th class="px-6 py-4 text-[11px] font-bold text-white uppercase tracking-wider text-right">
                                ACTION
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-5 text-sm text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-5 text-sm text-white font-bold">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-5 text-sm text-white text-center font-bold">
                                    {{ $category->total_product ?? '0' }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-4 text-gray-400">
                                        <a href="{{ route('category.edit', $category->id) }}" class="hover:text-white transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:text-red-500 transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-600 italic">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
