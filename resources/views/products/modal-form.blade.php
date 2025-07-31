<!-- Modal Form Produk (Create) -->
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
  /* Custom select arrow for Jenis Produk */
  select#jenis_produk {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23c9aaff" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 0.9rem center;
    background-size: 1.2em;
    padding-right: 2.2em;
  }
  select#jenis_produk:focus {
    border-color: #c9aaff;
    box-shadow: 0 0 0 2px rgba(201,170,255,0.15);
  }
</style>
<div class="modal fade" id="modalFormProduk" tabindex="-1" aria-labelledby="modalFormProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content custom-modal-theme">
      <div class="modal-header custom-modal-theme">
        <h5 class="modal-title" id="modalFormProdukLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body custom-modal-theme">
          <div class="mb-3">
            <label for="jenis_produk" class="form-label">Jenis Produk</label>
            <select name="type" id="jenis_produk" class="form-select" required>
              <option value="">Pilih Jenis Produk</option>
              <option value="ebook">Ebook</option>
              <option value="ecourse">Ecourse</option>
              <option value="buku">Buku Fisik</option>
              <option value="digital">Digital Product</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Harga Produk</label>
            <input type="number" name="price" id="price" class="form-control" required value="{{ old('price') }}">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" name="image" id="image" class="form-control" required>
          </div>
          <!-- Field Tambahan Dinamis -->
          <div id="field-ebook" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="ebook_file" class="form-label">Upload File Ebook</label>
              <input type="file" name="ebook_file" id="ebook_file" class="form-control">
            </div>
            <div class="mb-3">
              <label for="ebook_pages" class="form-label">Jumlah Halaman</label>
              <input type="number" name="ebook_pages" id="ebook_pages" class="form-control">
            </div>
          </div>
          <div id="field-ecourse" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="ecourse_url" class="form-label">URL Video Ecouse</label>
              <input type="url" name="ecourse_url" id="ecourse_url" class="form-control">
            </div>
            <div class="mb-3">
              <label for="ecourse_duration" class="form-label">Durasi Ecouse (menit)</label>
              <input type="number" name="ecourse_duration" id="ecourse_duration" class="form-control">
            </div>
          </div>
          <div id="field-buku" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="buku_city" class="form-label">Kota Asal Buku</label>
              <input type="text" name="buku_city" id="buku_city" class="form-control">
            </div>
            <div class="mb-3">
              <label for="stock" class="form-label">Stok Produk</label>
              <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
            </div>
          </div>
          <div id="field-digital" class="d-none">
            <div class="custom-modal-divider"></div>
            <div class="mb-3">
              <label for="digital_file" class="form-label">Upload File Digital</label>
              <input type="file" name="digital_file" id="digital_file" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer custom-modal-theme" style="border-top: 1px solid #2d2d2d; background: #232323; border-bottom-left-radius: 18px; border-bottom-right-radius: 18px;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const jenisProduk = document.getElementById('jenis_produk');
    const fieldEbook = document.getElementById('field-ebook');
    const fieldEcourse = document.getElementById('field-ecourse');
    const fieldBuku = document.getElementById('field-buku');
    const fieldDigital = document.getElementById('field-digital');
    function updateFields() {
      fieldEbook.classList.add('d-none');
      fieldEcourse.classList.add('d-none');
      fieldBuku.classList.add('d-none');
      fieldDigital.classList.add('d-none');
      if (jenisProduk.value === 'ebook') fieldEbook.classList.remove('d-none');
      if (jenisProduk.value === 'ecourse') fieldEcourse.classList.remove('d-none');
      if (jenisProduk.value === 'buku') fieldBuku.classList.remove('d-none');
      if (jenisProduk.value === 'digital') fieldDigital.classList.remove('d-none');
    }
    jenisProduk.addEventListener('change', updateFields);
    updateFields();
  });
</script> 