<p>{{ $product->name }} の取引が完了しました。</p>
<p>購入者: {{ $product->buyer->name }}</p>
<p>価格: ¥{{ number_format($product->price) }}</p>