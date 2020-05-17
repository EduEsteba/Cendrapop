@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="alert mt-4">
			@include('alerts')
		</div>
		<div class="row justify-content-center py-5">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Nou producte') }}</div>

					<div class="card-body">
						<form method="POST" action="{{ url('products/add') }}" enctype="multipart/form-data">
							@csrf

							<div class="form-group row">
								<label for="title" class="col-md-4 col-form-label text-md-right">Títol del producte</label>

								<div class="col-md-6">
									<input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>

									@if ($errors->has('title'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="category_id" class="col-md-4 col-form-label text-md-right">Categoria</label>

								<div class="col-md-6">
									<select id="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id" value="{{ old('category_id') }}" required autofocus>
										@foreach($categories as $id => $title)
											<option value="{{ $id }}">
												{{ $title }}
											</option>
										@endforeach
									</select>

									@if ($errors->has('category_id'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('category_id') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="description" class="col-md-4 col-form-label text-md-right">Descripció</label>

								<div class="col-md-6">
									<textarea id="description" rows="4" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ old('description') }}</textarea>

									@if ($errors->has('description'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('description') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="price" class="col-md-4 col-form-label text-md-right">Preu</label>

								<div class="col-md-6 input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">€</span>
									</div>
									<input type="text" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" required>

									@if ($errors->has('price'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('price') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="images" class="col-md-4 col-form-label text-md-right">Imatges</label>

								<div class="col-md-6">
									<input id="images" type="file" class="form-control{{ $errors->has('images') ? ' is-invalid' : '' }}" name="images[]" value="{{ old('images') }}" required multiple>

									@if ($errors->has('images'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('images') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										Enviar
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
