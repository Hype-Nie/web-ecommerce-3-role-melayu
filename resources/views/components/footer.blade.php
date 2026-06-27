{{-- ══════════ FOOTER ══════════ --}}
<footer class="bg-white border-t border-gray-200 mt-auto pt-16 pb-12">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-[12px] gap-y-10">
            {{-- Brand & About --}}
            <div>
                <a href="{{ route('landing') }}" class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
                    <span class="text-[14px] font-bold text-black tracking-tight">Campus<span class="text-primary-600">Buy</span></span>
                </a>
                <p class="text-[11px] text-gray-500 mb-4 max-w-xs leading-relaxed tracking-tight">Marketplace eksklusif kampus anda. Jual-beli dengan mudah, selamat dan pantas melalui WhatsApp.</p>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-[12px] font-medium text-black mb-3 tracking-tight">Pautan Pantas</h4>
                <ul class="flex flex-col gap-[4px] text-[11px] text-gray-500 tracking-tight">
                    <li><a href="{{ route('landing') }}" class="hover:text-black transition-colors">Laman Utama</a></li>
                    <li><a href="{{ route('produk.index') }}" class="hover:text-black transition-colors">Semua Produk</a></li>
                    <li><a href="#" class="hover:text-black transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-black transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[12px] font-medium text-black mb-3 tracking-tight">Perkhidmatan</h4>
                <ul class="flex flex-col gap-[4px] text-[11px] text-gray-500 tracking-tight">
                    <li><a href="{{ route('register') }}" class="hover:text-black transition-colors">Daftar Pelanggan</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-black transition-colors">Daftar Penjual</a></li>
                    <li><a href="#" class="hover:text-black transition-colors">Polisi Privasi</a></li>
                    <li><a href="#" class="hover:text-black transition-colors">Terma & Syarat</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-[12px] font-medium text-black mb-3 tracking-tight">Langgan Berita</h4>
                <form class="flex w-full max-w-xs">
                    <input type="email" placeholder="E-mel anda" class="w-full px-[12px] py-[8px] rounded-l-[8px] border border-gray-200 border-r-0 text-[11px] text-black outline-none focus:border-black transition-colors">
                    <button type="button" class="px-[12px] py-[8px] bg-black text-white text-[11px] font-medium rounded-r-[8px] hover:bg-gray-800 transition-colors">
                        Langgan
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-16 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-[11px] text-gray-400 tracking-tight">&copy; {{ date('Y') }} CampusBuy. Hak cipta terpelihara.</p>
            <div class="flex items-center gap-[8px]">
                <div class="px-[6px] py-[2px] border border-gray-200 rounded-[4px] text-[9px] font-medium text-gray-500">WA</div>
                <div class="px-[6px] py-[2px] border border-gray-200 rounded-[4px] text-[9px] font-medium text-gray-500">COD</div>
                <div class="px-[6px] py-[2px] border border-gray-200 rounded-[4px] text-[9px] font-medium text-gray-500">TNG</div>
            </div>
        </div>
    </div>
</footer>
