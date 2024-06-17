<?php

namespace App\Services;

use App\Models\Imagem;
use App\Repositories\ImagemRepository;
use App\Repositories\SecaoImagemRepository;

class ImagemService
{
    /**
     * @var ImagemRepository
     */
    private $imagemRepository;

    /**
     * @var SecaoImagemRepository
     */
    private $secaoImagemRepository;

    /**
     * ImagemService constructor.
     * @param ImagemRepository $imagemRepository
     * @param SecaoImagemRepository $secaoImagemRepository
     */
    public function __construct(
        ImagemRepository $imagemRepository,
        SecaoImagemRepository $secaoImagemRepository
    ){
        $this->imagemRepository         = $imagemRepository;
        $this->secaoImagemRepository    = $secaoImagemRepository;
    }

    public function store($request)
    {
        $data = $request->all();        
        
        if ($request->hasFile('imagens')) {
            $imagem = $this->imagemRepository->create($data);

            $file = $request->file('imagens');
            $allowedExtensions = ['jpeg', 'jpg', 'png'];
            $fileExtension = $file->getClientOriginalExtension();

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Apenas arquivos JPEG, JPG ou PNG são permitidos.'
                ]);
            }

            $filename = $imagem->uuid . '.' . $fileExtension;
            $destinationPath = public_path('imagens');
            $file->move($destinationPath, $filename);
            $filePath = 'imagens/' . $filename;
            

            $this->secaoImagemRepository->create([
                'secao_formulario_id' => $data['secao_formulario_id'],
                'imagem_id' => $imagem->id
            ]);
            $imagem->update(['url_imagem' => $filePath]);
            
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Imagem não enviada, selecione uma imagem para enviar.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Imagem salva com sucesso.'
        ]);
    }

    public function edit($imagem)
    {        
        return view('imagens.edit', compact('imagem'));
    }

    public function update($request, $imagem)
    {
        $data = $request->all();
        $imagem->update($data);
        
        return redirect()->back()->with('message', 'Imagem atualizada com sucesso.');
    }

    public function destroy($imagem)
    {
        try {            
            \DB::beginTransaction();
            
            foreach ($imagem->secoes as $secao) {
                $texto = $secao->texto;
                $novoTexto = str_replace("[img"."$imagem->id]", '', $texto);
                $secao->update(['texto' => $novoTexto]);
            }
            
            $imagem->delete();

            \DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Imagem deletada com sucesso.'
            ]);   
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json([
                'status' => 500,
                'error' => 'Não foi possível deletar a imagem'
            ]);
        }
    }
}