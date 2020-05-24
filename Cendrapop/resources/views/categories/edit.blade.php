@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
	<div class="container">
		<div class="alert mt-4">
			@include('alerts')
		</div>
		<div class="row justify-content-center py-5">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Editar Categoria</div>

					<div class="card-body">
						<form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
							@csrf

							<div class="form-group row">
								<label for="title" class="col-md-4 col-form-label text-md-right"> Títol</label>

								<div class="col-md-6">
									<input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $category->title }}" required autofocus>

									@if ($errors->has('title'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group row mb-0 justify-content-center">
								<div class="col-md-3">
									<button type="submit" class="btn btn-success btn-block">
									<i class="fas fa-edit"></i> Actualitzar
									</button>
								</div>
								<div class="col-md-3">
									<a href="{{ route('categories.show') }}" class="btn btn-danger btn-block">
									<i class="fas fa-trash"></i> Cancelar
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

