<!-- Modal Edit Produk -->
<style>
  .modal-content.custom-modal-theme {
    background: #232323;
    border-radius: 18px;
    border: 1px solid #2d2d2d;
    box-shadow: 0 8px 32px 0 rgba(201,170,255,0.18);
    color: #fff;
  }
  .modal-header.custom-modal-theme {
    border-bottom: 1px solid #2d2d2d;
    background: #232323;
    border-top-left-radius: 18px;
    border-top-right-radius: 18px;
  }
  .modal-title {
    color: #c9aaff;
    font-weight: 700;
    letter-spacing: 0.5px;
  }
  .modal-body.custom-modal-theme {
    background: #232323;
    border-bottom-left-radius: 18px;
    border-bottom-right-radius: 18px;
  }
  .form-label {
    color: #c9aaff;
    font-weight: 600;
    margin-bottom: 6px;
  }
  .form-control, .form-select {
    background: #181818;
    color: #fff;
    border: 1px solid #2d2d2d;
    border-radius: 10px;
    font-size: 1rem;
    margin-bottom: 8px;
  }
  .form-control:focus, .form-select:focus {
    border-color: #c9aaff;
    box-shadow: 0 0 0 2px rgba(201,170,255,0.15);
    background: #232323;
    color: #fff;
  }
  .btn-primary {
    background: linear-gradient(90deg, #c9aaff 0%, #8f6fff 100%);
    border: none;
    color: #232323;
    font-weight: 700;
    border-radius: 8px;
    padding: 8px 28px;
    transition: background 0.2s;
  }
  .btn-primary:hover {
    background: linear-gradient(90deg, #8f6fff 0%, #c9aaff 100%);
    color: #232323;
  }
  .btn-secondary {
    background: #2d2d2d;
    color: #fff;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    padding: 8px 22px;
  }
  .btn-secondary:hover {
    background: #181818;
    color: #c9aaff;
  }
  .custom-modal-divider {
    border-top: 1px solid #2d2d2d;
    margin: 18px 0 12px 0;
  }
  select#edit_jenis_produk {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23c9aaff" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 0.9rem center;
    background-size: 1.2em;
    padding-right: 2.2em;
  }
  select#edit_jenis_produk:focus {
    border-color: #c9aaff;
    box-shadow: 0 0 0 2px rgba(201,170,255,0.15);
  }
</style>
<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal-theme">
      <div class="modal-header custom-modal-theme">
        <h5 class="modal-title" id="modalEditProdukLabel">Edit Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <form id="formEditProduk" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="type" id="edit_jenis_produk_hidden">
        <div class="modal-body custom-modal-theme">
          <div class="mb-3">
            <label for="edit_jenis_produk" class="form-label">Jenis Produk</label>
            <select name="type" id="edit_jenis_produk" class="form-select" disabled readonly>
              <option value="ebook">Ebook</option>
              <option value="ecourse">Ecourse</option>
              <option value="buku">Buku Fisik</option>
              <option value="digital">Digital Product</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_name" class="form-label">Nama Produk</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_description" class="form-label">Deskripsi Produk</label>
            <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_price" class="form-label">Harga Produk</label>
            <input type="number" name="price" id="edit_price" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_image" class="form-label">Gambar Produk</label>
            <div class="mb-2">
              <img id="edit_image_preview" src="" alt="Preview Gambar" style="max-width:120px; max-height:120px; border-radius:8px; border:1px solid #2d2d2d;">
            </div>
            <input type="file" name="image" id="edit_image" class="form-control">
          </div>
          <!-- Field Tambahan Dinamis -->
          <div id="edit_field-ebook" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="edit_ebook_file" class="form-label">Upload File Ebook</label>
              <div class="mb-2">
                <a id="edit_ebook_file_link" href="#" target="_blank">Lihat File Ebook Lama</a>
              </div>
              <input type="file" name="ebook_file" id="edit_ebook_file" class="form-control">
            </div>
            <div class="mb-3">
              <label for="edit_ebook_pages" class="form-label">Jumlah Halaman</label>
              <input type="number" name="ebook_pages" id="edit_ebook_pages" class="form-control">
            </div>
          </div>
          <div id="edit_field-ecourse" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="edit_ecourse_url" class="form-label">URL Video Ecourse</label>
              <input type="url" name="ecourse_url" id="edit_ecourse_url" class="form-control">
            </div>
            <div class="mb-3">
              <label for="edit_ecourse_duration" class="form-label">Durasi Ecourse (menit)</label>
              <input type="number" name="ecourse_duration" id="edit_ecourse_duration" class="form-control">
            </div>
          </div>
          <div id="edit_field-buku" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="edit_buku_city" class="form-label">Kota Asal Buku</label>
              <input type="text" name="buku_city" id="edit_buku_city" class="form-control">
            </div>
            <div class="mb-3">
              <label for="edit_stock" class="form-label">Stok Produk</label>
              <input type="number" name="stock" id="edit_stock" class="form-control">
            </div>
          </div>
          <div id="edit_field-digital" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="edit_digital_file" class="form-label">Upload File Digital</label>
              <div class="mb-2">
                <a id="edit_digital_file_link" href="#" target="_blank">Lihat File Digital Lama</a>
              </div>
              <input type="file" name="digital_file" id="edit_digital_file" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer custom-modal-theme" style="border-top: 1px solid #2d2d2d; background: #232323; border-bottom-left-radius: 18px; border-bottom-right-radius: 18px;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function openEditProductModal(product) {
  console.log(product); // Debug log
  // Set action URL
  document.getElementById('formEditProduk').action = window.routeProductsUpdate.replace('PRODUCT_ID', product.id);
  // Set master fields
  document.getElementById('edit_jenis_produk').value = product.type;
  document.getElementById('edit_jenis_produk_hidden').value = product.type;
  document.getElementById('edit_name').value = product.name;
  document.getElementById('edit_description').value = product.description;
  document.getElementById('edit_price').value = product.price;
  // Gambar
  document.getElementById('edit_image_preview').src = product.image ? '/storage/' + product.image : '/assets/img/image.png';
  // Field detail
  document.getElementById('edit_field-ebook').classList.add('d-none');
  document.getElementById('edit_field-ecourse').classList.add('d-none');
  document.getElementById('edit_field-buku').classList.add('d-none');
  document.getElementById('edit_field-digital').classList.add('d-none');
  if(product.type === 'ebook' && product.ebook) {
    document.getElementById('edit_field-ebook').classList.remove('d-none');
    document.getElementById('edit_ebook_pages').value = product.ebook.ebook_pages || '';
    document.getElementById('edit_ebook_file_link').href = product.ebook.ebook_file ? ('/storage/' + product.ebook.ebook_file) : '#';
    document.getElementById('edit_ebook_file_link').innerText = product.ebook.ebook_file ? 'Lihat File Ebook Lama' : 'Belum ada file';
  }
  if(product.type === 'ecourse' && product.ecourse) {
    document.getElementById('edit_field-ecourse').classList.remove('d-none');
    document.getElementById('edit_ecourse_url').value = product.ecourse.ecourse_url || '';
    document.getElementById('edit_ecourse_duration').value = product.ecourse.ecourse_duration || '';
  }
  if(product.type === 'buku' && product.buku) {
    document.getElementById('edit_field-buku').classList.remove('d-none');
    document.getElementById('edit_buku_city').value = product.buku.city || '';
    document.getElementById('edit_stock').value = product.stock || '';
  }
  if(product.type === 'digital' && product.digital) {
    document.getElementById('edit_field-digital').classList.remove('d-none');
    document.getElementById('edit_digital_file_link').href = product.digital.digital_file ? ('/storage/' + product.digital.digital_file) : '#';
    document.getElementById('edit_digital_file_link').innerText = product.digital.digital_file ? 'Lihat File Digital Lama' : 'Belum ada file';
  }
  // Show modal
  var modal = new bootstrap.Modal(document.getElementById('modalEditProduk'));
  modal.show();
}
window.openEditProductModal = openEditProductModal;
</script> 