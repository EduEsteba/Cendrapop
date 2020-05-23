@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
		<div class="container">
			<div class="alert">
				@include('alerts')
			</div>
			<div class="row">
				<div class="col-md-5 col-lg-5 col-sm-5">
					<div class="product-images">
						@if ( count($product->images) > 0)
							<div class="image-thumbs row">
								@foreach ($product->images as $image)
										<img class="border zoom  " src="/uploads/products/{{ $image->file_name }}" id="logo" class="img-thumbnail">
									
								@endforeach
							</div>
						@endif
					</div>
				</div>
				<div class="col-md-5">
						<h1 class="product-title my-4">{{ $product->title }}</h1>
						<p class="product-owner">{{ __('Venut per') }} {{ $product->user->name}}</p>
						<p class="comment-links d-inline-block mb-4">
							<a href="#comments"><span class="far fa-comment"></span> {{ __('Comentaris') }} ({{ count($messages) }}) </a>
							<a href="#comments"><span class="fas fa-pencil-alt"></span>{{ __('Esciure un missatge') }}</a>
						</p>
						<p class="product-price mb-4">{{ $product->price }}€</p>
						<p class="product-description mb-15">{{ $product->description }}</p>
						<hr>
						<p>Producte creat el {{ $product->created_at->format('d M Y') }}</p>
					
				</div>
			</div>
			<br>
			<div id="comments" class="row comments">
				<div class="col-12">
					<div class="card">
						<h5 class="card-header">{{ __('Comentaris') }} ({{ count($messages) }})</h5>
						<div class="card-body">
							@if ( count($messages) > 0)
								@foreach($messages as $message)
									<div class="comment-wrapper mb-4">
										<div class="comment-content">
											<div class="comment-author"><p>{{ $message->user->name }}  {{ $message->created_at->format('d M Y') }}</p></div>
											
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
							<div class="form-group">
								@guest
									<p>Necesites estar logejat per poder comentar</p>
									<a class="btn btn-primary" href="{{ route('login') . '?previous=' . Request::fullUrl() }}">{{ __('Login') }}</a>
									<a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
								@else
									<form method="post" action="{{ url('/message/add') }}">
										@csrf
										<div class="comment-form " rows="3">
											<div class="d-none" aria-hidden="true">
												<input name="product_id" id="product_id" value="{{ $product->id }}">
											</div>
											<div class="">
												<textarea class="form-control" name="content" id="content" placeholder="Comentari" required ></textarea>
											</div>
											<div class="md-form">
											<br>
											<div class="">
												<button class="btn btn-success" type="submit">Enviar comentari</button>
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

@endsection
