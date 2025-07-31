@php $type = request('type', 'buku'); @endphp
@if($type === 'buku')
    @include('products.forms.create-buku')
@elseif($type === 'ebook')
    @include('products.forms.create-ebook')
@elseif($type === 'ecourse')
    @include('products.forms.create-ecourse')
@elseif($type === 'digital')
    @include('products.forms.create-digital')
@else
    <div class="alert alert-danger">Jenis produk tidak valid.</div>
@endif 