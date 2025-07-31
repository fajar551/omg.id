<h1>Tambah Produk</h1>
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Nama Produk" required><br>
    <textarea name="description" placeholder="Deskripsi Produk"></textarea><br>
    <input type="number" name="price" placeholder="Harga" required><br>
    <input type="number" name="stock" placeholder="Stok" required><br>
    <input type="file" name="image" accept="image/*"><br>
    <button type="submit">Simpan</button>
</form>
