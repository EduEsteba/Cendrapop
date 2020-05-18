
<div class="feature-products pt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 mb-4">
				<div class="section-title">
					<h2>Productes destacats</h2>
				</div>
			</div>
		</div>
		<div class="row">
		
			@foreach($products as $product)
				@if($loop->iteration > 10)
					@break
				@endif

				<div class="col-6 col-md-3">
					<div class="feature-product">
						<div class="image">
						<a href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1">
								<img src="/uploads/products/{{ $product->images->first()->file_name }}" class="img-fluid" alt="" style="width: 600px; height: 300px">
							</a>
							<a class="hover-icon view" href="{{ url('products/show') }}/{{ $product->id }}"><i class="lnr lnr-eye"></i></a>
							<a class="hover-icon heart" href="#" tabindex="-1"><i class="lnr lnr-heart"></i></a>
						</div>
						<div class="content">
							<p class="product-title"><a href="{{ url('products/show') }}/{{ $product->id }}" tabindex="-1">{{ $product->title }}</a></p>
							<p class="price">{{ $product->price }}€</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>


