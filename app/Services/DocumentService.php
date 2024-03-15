<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Criteria\DocumentCriteria;
use App\Repositories\DocumentRepository;
use Exception;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * DocumentService constructor.
     */
    public function __construct(
        DocumentRepository $documentRepository
    )
    {
        $this->documentRepository = $documentRepository;
    }

    public function index()
    {
        $this->documentRepository->pushCriteria(new DocumentCriteria());
        $documents = $this->documentRepository->paginate();

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('documents.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('documents.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }


        $data = $request->all();

        if (isset($data["url_documento"]) || !empty($data["url_documento"])) {
            $extensao = $request->file('url_documento')->getClientOriginalExtension();
            $data["url_documento"] = $this->uploadSimpleUnique($data["url_documento"], "documents", $extensao);
        }

        try {
            $this->documentRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('documents.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update($document, $request)
    {
        $data = $request->all();

        try {
            if (isset($data["url_documento"]) || !empty($data["url_documento"])) {
                $extensao = $request->file('url_documento')->getClientOriginalExtension();
                $data["url_documento"] = $this->uploadSimpleUnique($data["url_documento"], "documents", $extensao);
            }

            $this->documentRepository->update($data, $document->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('documents.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document)
    {
        try {
            $url = str_replace("https://" . env("S3_BUCKET") . ".s3." . env("S3_REGION") . ".amazonaws.com/", "", $document->url_documento);

            $s3Client = Storage::disk('s3');
            //Deleta imagem do S3
            if ($s3Client->exists($url)) {
                if ($s3Client->delete($url)) {
                    $document->forceDelete();
                } else {
                    return redirect()->back()->with('error', 'Erro ao tentar excluir o item.');
                }
            } else {
                $document->forceDelete();
            }

        } catch (Exception $e) {
            return redirect()->route('documents.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
        }
        return redirect()->route('documents.index')->with('message', 'Item deletado com sucesso.');
    }

    private function uploadSimpleUnique($img_tmp, $path = "archive", $extension, $identificador = null)
    {

        $s3Client = Storage::disk('s3');
//        $s3Client = Storage::disk('public');

        $error = array();

        $datetime = date("Ymd_His");
        $image_name = env("S3_PATH") . get_contractor_to_s3() . $path . "/" . $datetime . "_" . $identificador . "." . $extension;

        if (\File::exists($img_tmp)) {
            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

        } else {
            $error[] = "O arquivo " . $identificador . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente";
        }

        if (count($error) > 0) {
            return $error;
        } else {
            return $url;
        }

    }
}
