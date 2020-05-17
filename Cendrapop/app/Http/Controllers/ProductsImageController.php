<?php 

namespace App\Http\Controllers;

use App\ProductsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductsImageController extends Controller 
{

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
	  $image = ProductsImage::find($id);
	  $image_path = public_path() . '/uploads/products/' . $image->file_name;
	  File::delete($image_path);

	  $image->delete();

	  return back();
  }
  
}
