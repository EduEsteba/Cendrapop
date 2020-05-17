@extends('layouts.app')

@section('content')
	<div class="shop-page-content pb-5">
		@include('parts.search')
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="sidebar-container shop-sidebar-container">
						<div class="single-sidebar-widget mb-3">
							<h3 class="sidebar-title d-none d-lg-block">{{ __('Categories') }}</h3>
							<nav class="navbar-expand-lg">
								<a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categories-menu" aria-controls="categories-menu" aria-expanded="false" aria-label="Toggle Categories">
									<span class="lnr lnr-menu"></span>View Categories
								</a>
								<nav class="category-menu collapse navbar-collapse" id="categories-menu">
									<ul class="category-list">
										<li><a href="{{ route('shop') }}">{{ __('All') }}</a></li>
										@foreach ($categories as $category)
											<li class=""><a href="{{ route('shop', ['category' => $category->id]) }}">{{ $category->title }}</a>
										@endforeach
									</ul>
								</nav>
							</nav>

						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="shop-header mb-20">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 mb-sm-20 d-flex align-items-center">
								<p class="result-show-message">{{ __('Showing ') }} {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} {{ __(' results') }}</p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 d-flex flex-column flex-sm-row justify-content-start justify-content-md-end align-items-sm-center">

								<div class="sort-by-dropdown d-flex align-items-center mb-xs-10">
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
									<p>{{ __('No products on this category yet. Start ') }}<a href="{{ route('login') . '?previous=' . Request::fullUrl() }}">{{ __('selling now!') }}</a></p>
								@else
									<p>{{ __('No products on this category yet. Start ') }}<a href="{{ url('products/new') }}">{{ __('selling now!') }}</a></p>
								@endguest
							</div>
						@else
							@foreach($products as $product)
								<div class="col-sm-6 col-md-4">
									<div class="feature-product">
										<div class="image">
											<a href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1">
												<img src="/uploads/products/{{ $product->images}}" class="img-fluid" alt="">
											</a>
											<a class="hover-icon view" href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1"><i class="lnr lnr-eye"></i></a>
											<a class="hover-icon heart" href="#" tabindex="-1"><i class="lnr lnr-heart"></i></a>
										</div>
										<div class="content">
											<p class="product-title"><a href="#" tabindex="-1">{{ $product->title }}</a></p>
											<p class="price">${{ $product->price }}</p>
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
