@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
	<div class="page-content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<br>
						<div class="single-sidebar-widget mb-3">
							<h3 class="sidebar-title d-none d-lg-block">{{ __('Categories') }}</h3>
							<nav class="navbar-expand-lg">
							<div class="form-group">
    								<select class="form-control" id="exampleFormControlSelect1">
										@foreach ($categories as $category)
											<option onClick="window.location = '{{ route('shop', ['category' => $category->id]) }}'"><a>{{ $category->title }}</option>
										@endforeach
    								</select>
  							</div>
								
								
							</nav>

						</div>
				</div>
				<div class="col-lg-9">
					<div class="shop-header mb-20">
						<div class="row">
							<!--<div class="col-lg-6 col-md-6 col-sm-12 mb-sm-20 d-flex align-items-center">
								<p class="result-show-message">{{ __('Mostrant') }} {{ $products->firstItem() }}–{{ $products->lastItem() }} de {{ $products->total() }} {{ __(' resultats') }}</p>
							</div>-->
							<div class="col-lg-6 col-md-6 col-sm-12 d-flex flex-column flex-sm-row justify-content-start justify-content-md-end align-items-sm-center">

								<div class="sort-by-dropdown d-flex mb-xs-10">
									<div>
										<strong>{{ __('Ordenar per preu:') }}</strong>
										<a href="{{ route('shop', ['category'=> request()->category, 'sort' => 'low_high']) }}">{{ __('De petit a gran') }}</a> |
										<a href="{{ route('shop', ['category'=> request()->category, 'sort' => 'high_low']) }}">{{ __('De gran a petit') }}</a>

									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row shop-product-wrap py-5">
						@if ($products->count() == 0)
							<div class="col-12">
								@guest
									<p>{{ __('No hi ha productes en aquesta categoría ') }}<a href="{{ route('login') . '?previous=' . Request::fullUrl() }}">{{ __('Comença a vendra, JA!') }}</a></p>
								@else
									<p>{{ __('No hi ha productes en aquesta categoría ') }}<a href="{{ url('products/new') }}">{{ __('Comença a vendra, JA!') }}</a></p>
								@endguest
							</div>
						@else
							@foreach($products as $product)
								<div class="col-sm-6 col-md-3">
									<div class="feature-product">
										<div class="image">
											<a href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1">
												<img src="/uploads/products/{{ $product->images->first()->file_name }}" class="img-fluid" alt="" style="width: 100%; height: 100%;">
											</a>
										</div>
										<div class="content">
											<p class="product-title"><a href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1">{{ $product->title }}</a></p>
											<p class="price">{{ $product->price }}€</p>
										</div>
									</div>
								</div>
							@endforeach
						@endif
					</div>
					<div class="row">
						<div class="d-block m-auto">
							<div class="pagination-content">
								{{ $products->links() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
