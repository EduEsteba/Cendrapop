@extends('layouts.app')

@section('content')
	@include('partials.search')
	<div class="single-product-page-content pb-5">
		<div class="container">
			<div class="alert">
				@include('alerts')
			</div>
			<div class="row product-details mb-5">
				<div class="col-md-6">
					<div class="product-images">
						<div class="image-main mb-2 border">
							<img src="/uploads/products/{{ $product->images->first()->file_name }}" id="selected">
						</div>
						@if ( count($product->images) > 0)
							<div class="image-thumbs row">
								@foreach ($product->images as $image)
									<div class="col-3">
										<img class="border" src="/uploads/products/{{ $image->file_name }}">
									</div>
								@endforeach
							</div>
						@endif
					</div>
				</div>
				<div class="col-md-6">
					<div class="single-product-details-container">
						<p class="product-title my-4">{{ $product->title }}</p>
						<p class="product-owner">{{ __('Sold By ') }} {{ $product->user->username }}</p>
						<p class="comment-links d-inline-block mb-4">
							<a href="#comments"><span class="far fa-comment"></span> {{ __('Read Messages') }} ({{ count($messages) }}) </a>
							<a href="#comments"><span class="fas fa-pencil-alt"></span>{{ __('Write a Message') }}</a>
						</p>
						<p class="product-price mb-4">${{ $product->price }}</p>
						<p class="product-description mb-15">{{ $product->description }}</p>
						<hr>
						<p class="wishlist-link mb-30"><a href="#"> <i class="fa fa-heart"></i>{{ __('Add to Wishlist') }}</a></p>
						<p>Product Active Since {{ $product->created_at->format('d M Y') }}</p>
					</div>
				</div>
			</div>
			<div id="comments" class="row comments">
				<div class="col-12">
					<div class="card">
						<h5 class="card-header">{{ __('Comments ') }} ({{ count($messages) }})</h5>
						<div class="card-body">
							@if ( count($messages) > 0)
								@foreach($messages as $message)
									<div class="comment-wrapper mb-4 @if($product->user->username === $message->username) owner @endif">
										<div class="comment-content">
											<div class="comment-author"><p>{{ $message->username }}</p></div>
											<p>{{ __('Posted in ') }} {{ $message->created_at->format('d M Y') }}</p>
											<p>{{ $message->content }}</p>
										</div>
										<hr>
									</div>
								@endforeach
							@else
								<div class="no-comments">
									<p>{{ __('No Messages') }}</p>
								</div>
								<hr>
							@endif
							<div class="comment-form-wrapper fix">
								<h3 class="form-title">{{ __('Send a Message') }}</h3>
								@guest
									<p>{{ __('You must be logged in to post a message') }}</p>
									<a class="btn btn-primary" href="{{ route('login') . '?previous=' . Request::fullUrl() }}">{{ __('Login') }}</a>
									<a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
								@else
									<form method="post" action="{{ url('/message/add') }}">
										@csrf
										<div class="comment-form row">
											<div class="d-none" aria-hidden="true">
												<input name="product_id" id="product_id" value="{{ $product->id }}">
											</div>
											<div class="col-12 mb-4">
												<label for="message">{{ __('Your Message:') }}</label>
												<textarea name="content" id="content" placeholder="Message" required></textarea>
											</div>
											<div class="col-12">
												<button class="btn btn-primary" type="submit">{{ __('Send Message:') }}</button>
											</div>
										</div>
									</form>
								@endguest
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
