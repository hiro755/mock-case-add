@extends('layouts.app')

@section('content')
<div class="mypage-wrapper">

    <div class="profile-header aligned-layout">
        <div class="user-info-horizontal">
            <div class="icon-wrapper">
                <img
                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-icon.png') }}"
                    alt="プロフィール画像"
                    class="profile-image"
                >
            </div>

            <div>
                <div class="user-name">{{ $user->name }}</div>

                <div class="user-rating">
                    @php $rating = $user->average_rating ?? 0; @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <span class="{{ $i < round($rating) ? 'filled-star' : 'empty-star' }}">★</span>
                    @endfor
                </div>
            </div>
        </div>

        <div class="edit-button-container">
            <a href="{{ route('profile.edit') }}" class="edit-button">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-wrapper">
        <button class="tab-button active" data-tab="exhibited">出品した商品</button>
        <button class="tab-button" data-tab="purchased">購入した商品</button>
        <button class="tab-button" data-tab="in-progress">
            取引中の商品
            @if($unreadCount > 0)
                <span class="unread-count">{{ $unreadCount }}</span>
            @endif
        </button>
    </div>

    <div class="full-width-border"></div>

    {{-- 出品した商品 --}}
    <div class="tab-content active" id="exhibited">
        <div class="item-grid">
            @forelse ($exhibited as $product)
                <div class="item-card">
                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="item-image">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                            @elseif (!empty($product->img_url))
                                <img src="{{ asset($product->img_url) }}" alt="商品画像">
                            @else
                                <div class="text-center py-5">画像なし</div>
                            @endif
                        </div>
                        <div class="item-name">{{ $product->name }}</div>
                    </a>
                </div>
            @empty
                <p>出品した商品はまだありません。</p>
            @endforelse
        </div>
    </div>

    {{-- 購入した商品 --}}
    <div class="tab-content" id="purchased">
        <div class="item-grid">
            @forelse ($purchased as $product)
                <div class="item-card">
                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="item-image">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                            @elseif (!empty($product->img_url))
                                <img src="{{ asset($product->img_url) }}" alt="商品画像">
                            @else
                                <div class="text-center py-5">画像なし</div>
                            @endif
                        </div>
                        <div class="item-name">{{ $product->name }}</div>
                    </a>
                </div>
            @empty
                <p>購入した商品はまだありません。</p>
            @endforelse
        </div>
    </div>

    {{-- 取引中の商品 --}}
    <div class="tab-content" id="in-progress">
        <div class="item-grid">
            @forelse ($inProgress as $product)
                <div class="item-card">
                    <a href="{{ route('chat.show', $product->id) }}">
                        <div class="item-image" style="position: relative;">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                            @elseif (!empty($product->img_url))
                                <img src="{{ asset($product->img_url) }}" alt="商品画像">
                            @else
                                <div class="text-center py-5">画像なし</div>
                            @endif

                            @if ($product->unread_count > 0)
                                <div class="notification-badge">
                                    {{ $product->unread_count }}
                                </div>
                            @endif
                        </div>

                        <div class="item-name">
                            {{ $product->name }}
                            @if ($product->user_id === $user->id)
                                <span class="role-badge seller">出品</span>
                            @else
                                <span class="role-badge buyer">購入</span>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <p>取引中の商品はまだありません。</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-button");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach(button => {
        button.addEventListener("click", () => {
            const targetId = button.dataset.tab;

            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));

            button.classList.add("active");
            document.getElementById(targetId).classList.add("active");
        });
    });
});
</script>
@endsection