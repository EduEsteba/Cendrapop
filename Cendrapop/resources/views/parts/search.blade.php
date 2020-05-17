<div class="search-area py-4">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<div class="col-12  text-center text-sm-right mb-4">
					<a class="btn btn-primary" href="{{ route('shop') }}">Mostrar tots els productes</a>
				</div>
				<div class="search-wrapper">
					<div class="input-group search-container">
						<input type="text" id="search-input" class="form-control search-input" name="str" placeholder="Search Products" aria-label="Buscar productes" aria-describedby="button-addon2">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button" id="button-addon2"><span class="lnr lnr-magnifier"></span></button>
						</div>
					</div>
					<ul class="result-list px-4 list-group list-group-flush"></ul>
				</div>
			</div>
		</div>
	</div>
</div>

