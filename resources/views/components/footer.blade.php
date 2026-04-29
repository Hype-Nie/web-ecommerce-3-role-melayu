{{-- ══════════ FOOTER ══════════ --}}
<footer class="bg-gray-900 text-gray-300 mt-auto">
    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div class="lg:col-span-1">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-white">Kedai<span class="text-primary-400">Ku</span></span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed mb-6">Platform e-dagang terbaik di Malaysia. Beli-belah dengan mudah, selamat dan pantas.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641 0 12.017 0z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Pautan Pantas</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('landing') }}" class="hover:text-primary-400 transition-colors">Laman Utama</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">Soalan Lazim</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Perkhidmatan</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('register') }}" class="hover:text-primary-400 transition-colors">Daftar Pelanggan</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-primary-400 transition-colors">Daftar Penjual</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">Polisi Privasi</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition-colors">Terma & Syarat</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Langgan Berita</h4>
                <p class="text-sm text-gray-400 mb-4">Dapatkan tawaran eksklusif dan promosi terkini.</p>
                <form class="flex gap-2">
                    <input type="email" placeholder="E-mel anda" class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                    <button type="button" class="px-4 py-2.5 rounded-xl gradient-primary text-white text-sm font-semibold hover:shadow-lg hover:shadow-primary-600/25 transition-all duration-300 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} CampusBy. Hak cipta terpelihara.</p>
            <div class="flex items-center gap-6 text-sm text-gray-500">
                <span>Pembayaran Selamat</span>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-6 rounded bg-white/10 flex items-center justify-center text-[9px] font-bold text-gray-400">VISA</div>
                    <div class="w-10 h-6 rounded bg-white/10 flex items-center justify-center text-[9px] font-bold text-gray-400">MC</div>
                    <div class="w-10 h-6 rounded bg-white/10 flex items-center justify-center text-[9px] font-bold text-gray-400">FPX</div>
                </div>
            </div>
        </div>
    </div>
</footer>
