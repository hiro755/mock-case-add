@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">

<div class="chat-container">
    <aside class="chat-sidebar">
        <div class="sidebar-title">その他の取引</div>
        <ul class="transaction-list">
            @foreach ($transactions as $item)
                <li class="transaction-item {{ $item->id === $product->id ? 'active' : '' }}">
                    <a href="{{ route('chat.show', $item->id) }}">
                        {{ $item->name }}
                        @if ($item->unread_count > 0)
                            <span class="unread">{{ $item->unread_count }}</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <main class="chat-main">
        <div class="chat-header">
            <div class="chat-header-top">
                <div class="user-info">
                    <div class="user-icon"></div>
                    <h3 class="chat-title">
                        「{{ $otherUser->name ?? '取引相手未確定' }}」さんとの取引画面
                    </h3>
                </div>

                @if ($isBuyer && !$product->is_completed)
                    <a href="{{ route('chat.complete', $product->id) }}" class="complete-btn">取引を完了する</a>
                @endif
            </div>

            <div class="chat-product">
                <img src="{{ asset('storage/' . $product->image_path) }}" class="product-image">
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">¥{{ number_format($product->price) }}</div>
                </div>
            </div>
        </div>

        <div class="chat-messages">
            @foreach ($messages as $message)
                <div class="chat-message {{ $message->user_id === auth()->id() ? 'mine' : 'others' }}">
                    <div class="chat-bubble">
                        <div class="chat-user-icon"></div>
                        <div class="chat-text">
                            <div class="sender">{{ $message->user->name ?? '不明なユーザー' }}</div>

                            @if (session('edit_message_id') === $message->id)
                                <form action="{{ route('chat.update', [$product->id, $message->id]) }}" method="POST" class="edit-form">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="body">{{ old('body', $message->body) }}</textarea>
                                    <div class="edit-form-actions">
                                        <button type="submit" class="update-btn">更新</button>
                                        <a href="{{ route('chat.show', $product->id) }}" class="cancel-btn">キャンセル</a>
                                    </div>
                                </form>
                            @else
                                <div class="body">{{ $message->body }}</div>
                                @if ($message->image_path)
                                    <img src="{{ asset('storage/' . $message->image_path) }}" class="chat-image">
                                @endif

                                @if ($message->user_id === auth()->id())
                                    <div class="chat-actions">
                                        <form action="{{ route('chat.edit', [$product->id, $message->id]) }}" method="GET">
                                            <button class="edit-btn">編集</button>
                                        </form>
                                        <form action="{{ route('chat.destroy', [$product->id, $message->id]) }}" method="POST" onsubmit="return confirm('このメッセージを削除しますか？')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete-btn">削除</button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('chat.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="chat-form">
            @csrf
            <div class="chat-input-wrapper">
                <textarea name="body" placeholder="取引メッセージを記入してください" maxlength="400">{{ old('body') }}</textarea>
                <label class="image-upload">
                    <input type="file" name="image" accept=".jpg,.jpeg,.png">
                    画像を追加
                </label>
                <button type="submit" class="send-btn">
                    <img src="{{ asset('images/send-icon.png') }}">
                </button>
            </div>
            @error('body') <div class="error">{{ $message }}</div> @enderror
            @error('image') <div class="error">{{ $message }}</div> @enderror
        </form>

        {{-- モーダル（購入者・出品者） --}}
        @if (session('show_rating_modal') && !$hasRated)
            <div class="modal">
                <div class="modal-content">
                    <p class="modal-title">取引が完了しました。</p>
                    <p class="modal-text">今回の取引相手はいかがでしたか？</p>
                    <form action="{{ route('chat.rate', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="rating" id="rating-value">
                        <div class="modal-rating stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}">★</span>
                            @endfor
                        </div>
                        <button type="submit" class="modal-submit-btn">送信する</button>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-value');
    let selected = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlight(star.dataset.value));
        star.addEventListener('mouseout', () => highlight(selected));
        star.addEventListener('click', () => {
            selected = star.dataset.value;
            ratingInput.value = selected;
            highlight(selected);
        });
    });

    function highlight(count) {
        stars.forEach(star => {
            star.classList.toggle('selected', star.dataset.value <= count);
        });
    }
});
</script>
@endsection