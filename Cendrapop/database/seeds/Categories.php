<?php
use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Categories tretes de Wallapop
        
            DB::table('categories')->insert([
                'title' => 'Coches',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Motos',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Motor y Accesoris',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Moda y Accesoris',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Inmboliaria',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'TV, Audio i Fotografia',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Mòbils',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Informática i Electrónica',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Esports i Oci',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Bicicleta',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Consoles i Videojocs',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Llar i Jardí',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Electrodomestics',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Cine, LLibres i Musica',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Nens i infants',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Coleccionisme',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Materials de construcció',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Industria i Agrícultura',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            DB::table('categories')->insert([
                'title' => 'Altres',
                'created_at'=> date_create(),
                'updated_at'=> date_create(),
            ]);
            

        
    }
}
