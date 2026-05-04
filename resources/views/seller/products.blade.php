@extends('layouts.seller')
@section('title', 'Pengurusan Produk')
@section('page_title', 'Produk Saya')
@section('page_subtitle', 'Urus semua produk kedai anda')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-primary-50 border border-primary-100 text-primary-700 text-sm">{{ session('success') }}</div>
@endif
<div class="bg-white rounded-2xl border border-gray-100 animate-fade-in">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <p class="text-sm text-gray-500">{{ $products->count() }} produk</p>
        <button data-modal-open="modal-add-product" class="btn-primary text-sm !px-4 !py-2.5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Tindakan</th></tr></thead>
            <tbody>
                @forelse($products as $p)
                <tr class="cursor-pointer hover:bg-gray-50" onclick="showProduct({{ $p->id }})">
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                @if($p->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $p->images->first()->image_path) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center"><svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                            </div>
                            <span class="font-medium text-gray-900">{{ $p->name }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-gray">{{ $p->category->name }}</span></td>
                    <td class="font-semibold">RM {{ number_format($p->price, 2) }}</td>
                    <td>
                        <span class="badge {{ $p->product_status === 'sold' ? 'badge-gray' : ($p->is_active ? 'badge-success' : 'badge-danger') }}">
                            {{ $p->product_status === 'sold' ? 'Terjual' : ($p->is_active ? 'Aktif' : 'Tidak Aktif') }}
                        </span>
                    </td>
                    <td onclick="event.stopPropagation()">
                        <div class="flex items-center gap-1">
                            <button onclick="editProduct({{ $p->id }})" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary-600" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <form action="{{ route('seller.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Padam produk ini?')">@csrf @method('DELETE')
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-danger-600" title="Padam"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-8">Tiada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Product Modal --}}
<div id="modal-add-product" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Tambah Produk Baru</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label><input type="text" name="name" class="input-styled" required></div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga (RM)</label><input type="number" name="price" step="0.01" class="input-styled" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Asal (RM)</label><input type="number" name="old_price" step="0.01" class="input-styled"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" class="input-styled" required><option value="">Pilih</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" class="input-styled" rows="3"></textarea></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuantiti</label>
                    <input type="number" name="quantity" value="0" min="0" class="input-styled" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Produk</label>
                    <select name="product_status" class="input-styled">
                        <option value="available">Tersedia</option>
                        <option value="sold">Terjual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk (Maks 5)</label>
                    <input type="file" id="add-product-images" name="images[]" multiple accept="image/*" class="input-styled !py-2 !text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maks 2MB setiap satu.</p>
                    <div id="add-product-preview" class="mt-3 flex gap-2 flex-wrap"></div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div id="modal-product-detail" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Butiran Produk</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="p-6" id="product-detail-body"><p class="text-center text-gray-400">Memuatkan...</p></div>
    </div>
</div>

{{-- Edit Product Modal --}}
<div id="modal-edit-product" class="modal-overlay">
    <div class="modal-content max-w-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Produk</h3>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="edit-product-form" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label><input type="text" name="name" id="edit-p-name" class="input-styled" required></div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga (RM)</label><input type="number" name="price" id="edit-p-price" step="0.01" class="input-styled" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga Asal (RM)</label><input type="number" name="old_price" id="edit-p-old_price" step="0.01" class="input-styled"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="edit-p-category" class="input-styled" required><option value="">Pilih</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label><textarea name="description" id="edit-p-desc" class="input-styled" rows="3"></textarea></div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Kuantiti</label><input type="number" name="quantity" id="edit-p-quantity" min="0" class="input-styled" required></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Status Produk</label>
                        <select name="product_status" id="edit-p-status" class="input-styled">
                            <option value="available">Tersedia</option>
                            <option value="sold">Terjual</option>
                        </select>
                    </div>
                </div>
                <div id="edit-p-images-container"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tambah Gambar Baru</label>
                    <input type="file" id="edit-product-images" name="images[]" multiple accept="image/*" class="input-styled !py-2 !text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <div id="edit-product-preview" class="mt-3 flex gap-2 flex-wrap"></div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" data-modal-close class="btn-ghost text-sm !px-4 !py-2.5">Batal</button>
                <button type="submit" class="btn-primary text-sm !px-6 !py-2.5">Kemaskini</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showProduct(id) {
    const modal = document.getElementById('modal-product-detail');
    const body = document.getElementById('product-detail-body');
    body.innerHTML = '<p class="text-center text-gray-400">Memuatkan...</p>';
    modal.classList.add('active'); document.body.classList.add('overflow-hidden');
    fetch(`/penjual/produk/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            let imgs = d.images.length ? d.images.map(i => `<img src="${i.url}" class="w-16 h-16 rounded-lg object-cover">`).join('') : '<span class="text-sm text-gray-400">Tiada gambar</span>';
            let discount = (d.old_price && parseFloat(d.old_price) > parseFloat(d.price)) ? Math.round(((parseFloat(d.old_price) - parseFloat(d.price)) / parseFloat(d.old_price)) * 100) + '%' : '-';
            let statusLabel = d.product_status === 'sold' ? 'Terjual' : (d.is_active ? 'Aktif' : 'Tidak Aktif');
            let statusBadge = d.product_status === 'sold' ? 'badge-gray' : (d.is_active ? 'badge-success' : 'badge-danger');
            body.innerHTML = `
                <div class="flex gap-3 mb-4 flex-wrap">${imgs}</div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">${d.name}</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-400 text-xs">Kategori</p><p class="font-medium">${d.category}</p></div>
                    <div><p class="text-gray-400 text-xs">Harga</p><p class="font-bold text-primary-600">RM ${parseFloat(d.price).toFixed(2)}</p></div>
                    <div><p class="text-gray-400 text-xs">Harga Asal</p><p class="font-medium">${d.old_price ? 'RM ' + parseFloat(d.old_price).toFixed(2) : '-'}</p></div>
                    <div><p class="text-gray-400 text-xs">Diskaun</p><p class="font-medium">${discount}</p></div>
                    <div><p class="text-gray-400 text-xs">Status</p><p><span class="badge ${statusBadge}">${statusLabel}</span></p></div>
                    <div><p class="text-gray-400 text-xs">Tarikh Tambah</p><p class="font-medium">${d.created_at}</p></div>
                </div>
                ${d.description ? `<div class="mt-4"><p class="text-gray-400 text-xs mb-1">Penerangan</p><p class="text-sm text-gray-600">${d.description}</p></div>` : ''}
            `;
        });
}
function editProduct(id) {
    fetch(`/penjual/produk/${id}`, { headers: { 'Accept': 'application/json' }})
        .then(r => r.json())
        .then(d => {
            document.getElementById('edit-product-form').action = `/penjual/produk/${d.id}`;
            document.getElementById('edit-p-name').value = d.name;
            document.getElementById('edit-p-price').value = d.price;
            document.getElementById('edit-p-category').value = d.category_id;
            document.getElementById('edit-p-old_price').value = d.old_price || '';
            document.getElementById('edit-p-desc').value = d.description || '';
            document.getElementById('edit-p-status').value = d.product_status || 'available';
            document.getElementById('edit-p-quantity').value = d.quantity || 0;
            let imgHtml = d.images.length ? '<p class="text-sm font-medium text-gray-700 mb-2">Gambar Sedia Ada</p><div class="flex gap-2 flex-wrap">' + d.images.map(i => `<div class="relative group"><img src="${i.url}" class="w-16 h-16 rounded-lg object-cover"><label class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"><input type="checkbox" name="delete_images[]" value="${i.id}" class="w-4 h-4"><span class="text-white text-xs ml-1">Padam</span></label></div>`).join('') + '</div>' : '';
            document.getElementById('edit-p-images-container').innerHTML = imgHtml;
            const modal = document.getElementById('modal-edit-product');
            modal.classList.add('active'); document.body.classList.add('overflow-hidden');
        });
}

function renderPreview(input, targetId) {
    const container = document.getElementById(targetId);
    container.innerHTML = '';
    const files = Array.from(input.files || []);
    if (!files.length) return;
    files.forEach(file => {
        const url = URL.createObjectURL(file);
        const img = document.createElement('img');
        img.src = url;
        img.className = 'w-16 h-16 rounded-lg object-cover';
        img.onload = () => URL.revokeObjectURL(url);
        container.appendChild(img);
    });
}

const addImagesInput = document.getElementById('add-product-images');
if (addImagesInput) {
    addImagesInput.addEventListener('change', function() {
        renderPreview(this, 'add-product-preview');
    });
}

const editImagesInput = document.getElementById('edit-product-images');
if (editImagesInput) {
    editImagesInput.addEventListener('change', function() {
        renderPreview(this, 'edit-product-preview');
    });
}
</script>
@endsection
