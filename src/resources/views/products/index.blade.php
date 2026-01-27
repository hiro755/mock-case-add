@extends('layouts.app')

@section('content')
    <div class="tab-wrapper">
        <div class="tab-links">
            <a href="{{ url('/?tab=recommend') }}" class="tab-link {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
            <a href="{{ url('/?tab=mylist') }}" class="tab-link {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
        </div>
    </div>

    <div class="full-width-border"></div>

    <div class="container product-list-container">
        @if ($products->isEmpty())
            <p>該当する商品はありません。</p>
        @else
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <a href="{{ route('item.show', ['id' => $product->id]) }}" class="product-box">
                            <img
                                src="{{ asset('storage/' . ($product->image ?? $product->image_path)) }}"
                                alt="商品画像"
                                class="product-image"
                                onerror="this.onerror=null; this.src='{{ asset('images/noimage.png') }}';"
                            >
                            <p class="product-name">
                                {{ $product->name }}
                                @if ($product->is_sold)
                                    <span class="badge bg-secondary">Sold</span>
                                @endif
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection