@extends('layouts.app')

@section('content')

<div class="container">
  <h3>ご契約情報</h3>
  <hr>

  @if($latestSubscription && $latestSubscription->stripe_status === 'active')
    {{-- 有効なサブスクリプションの場合 --}}
    <p>現在プレミアム会員です。全ての機能をご利用いただけます。</p>

    @if($latestSubscription->ends_at)
    {{-- 有効期限が設定されている場合 --}}
      <p>有効期限は「{{ $latestSubscription->ends_at->format('Y年m月d日') }}」です。</p>
    @endif

  @else
  {{-- 有効でないサブスクリプションの場合 --}}
    <p>現在プレミアム会員ではありません。一部機能が制限されています。</p>
  @endif
</div>

@endsection