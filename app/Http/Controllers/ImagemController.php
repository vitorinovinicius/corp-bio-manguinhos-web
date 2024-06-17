<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImagemService;

class ImagemController extends Controller
{
    /**
	 * @var ImagemService
	 */
	private $imagemService;

    /**
     * TeamController constructor.
     * @param ImagemService $imagemService
     */
    public function __construct(ImagemService $imagemService)
	{
		$this->imagemService = $imagemService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->imagemService->store($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($imagem)
    {
        return $this->imagemService->edit($imagem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $imagem)
    {
        return $this->imagemService->update($request,$imagem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($imagem)
    {
        return $this->imagemService->destroy($imagem);
    }
}
