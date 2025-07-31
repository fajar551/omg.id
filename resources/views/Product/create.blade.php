<h1>Tambah Produk</h1>
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Nama Produk" required><br>
    
    <select name="type" id="type" required>
        <option value="">Pilih Jenis Produk</option>
        <option value="ebook">Ebook</option>
        <option value="ecourse">Ecourse</option>
        <option value="buku">Buku Fisik</option>
        <option value="digital">Digital Product</option>
    </select><br>
    
    <textarea name="description" placeholder="Deskripsi Produk"></textarea><br>
    <input type="number" name="price" placeholder="Harga" required><br>
    
    <div id="stock-field">
        <input type="number" name="stock" id="stock" placeholder="Stok" min="0"><br>
    </div>
    
    <input type="file" name="image" accept="image/*"><br>
    <button type="submit">Simpan</button>
</form>

<script>
// Wait for jQuery to be available
function initializeProductFormScripts() {
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, retrying in 100ms...');
        setTimeout(initializeProductFormScripts, 100);
        return;
    }
    
    console.log('jQuery is available, initializing product form scripts...');
    
    $(document).ready(function() {
        const typeSelect = document.getElementById('type');
        const stockField = document.getElementById('stock-field');
        const stockInput = document.getElementById('stock');
        
        function toggleStockField() {
            const selectedType = typeSelect.value;
            if (stockField) {
                // Sembunyikan stok jika digital, ebook, atau ecourse
                stockField.style.display = (selectedType === 'digital' || selectedType === 'ebook' || selectedType === 'ecourse') ? 'none' : 'block';
                
                // Set required attribute based on type
                if (stockInput) {
                    stockInput.required = (selectedType === 'buku');
                }
            }
        }
        
        if (typeSelect) {
            typeSelect.addEventListener('change', toggleStockField);
            // Initial call
            toggleStockField();
        }
    });
}

// Initialize scripts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeProductFormScripts();
});

// Also try to initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeProductFormScripts);
} else {
    initializeProductFormScripts();
}
</script>
