@extends('layouts.app')

@section('content')
	@include('parts.search')
	<div class="single-product-page-content pb-5">
		<div class="container">
			<div class="alert">
				@include('alerts')
			</div>
			<div class="row product-details mb-5">
				<div class="col-md-6">
					<div class="product-images">
						
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
						<p class="product-owner">{{ __('Venut per') }} {{ $product->user->username }}</p>
						<p class="comment-links d-inline-block mb-4">
							<a href="#comments"><span class="far fa-comment"></span> {{ __('Llegir comentaris') }} ({{ count($messages) }}) </a>
							<a href="#comments"><span class="fas fa-pencil-alt"></span>{{ __('Esciure un missatge') }}</a>
						</p>
						<p class="product-price mb-4">{{ $product->price }}€</p>
						<p class="product-description mb-15">{{ $product->description }}</p>
						<hr>
						<p>Producte creat el {{ $product->created_at->format('d M Y') }}</p>
					</div>
				</div>
			</div>
			<div id="comments" class="row comments">
				<div class="col-12">
					<div class="card">
						<h5 class="card-header">{{ __('Comentaris') }} ({{ count($messages) }})</h5>
						<div class="card-body">
							@if ( count($messages) > 0)
								@foreach($messages as $message)
									<div class="comment-wrapper mb-4 @if($product->user->username === $message->username) owner @endif">
										<div class="comment-content">
											<div class="comment-author"><p>{{ $message->username }}</p></div>
											<p>{{ __('Comentat el') }} {{ $message->created_at->format('d M Y') }}</p>
											<p>{{ $message->content }}</p>
										</div>
										<hr>
									</div>
								@endforeach
							@else
								<div class="no-comments">
									<p>{{ __('Cap comentari') }}</p>
								</div>
								<hr>
							@endif
							<div class="comment-form-wrapper fix">
								<h3 class="form-title">{{ __('Enviar un missatge') }}</h3>
								@guest
									<p>{{ __('Necesites estar logejat per poder comentar') }}</p>
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
												<label for="message">{{ __('El teu missatge:') }}</label>
												<textarea name="content" id="content" placeholder="Message" required></textarea>
											</div>
											<div class="md-form">

											<div class="col-12">
												<button class="btn btn-success" type="submit">{{ __('Enviar missatge:') }}</button>
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
