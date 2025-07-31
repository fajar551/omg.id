<h1>Produk Saya</h1>
<a href="{{ route('products.create') }}">Tambah Produk</a>

<ul>
    @foreach ($products as $product)
        <li>
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Produk" width="100">
            @endif
        </li>
    @endforeach
</ul>
