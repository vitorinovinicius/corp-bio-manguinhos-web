<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\File;
use App\Models\Formulario;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Diretório onde os documentos serão salvos
        $savePath = public_path('documents');

        // Verificar se o diretório existe, se não, criá-lo
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }
        
        $files = File::files($savePath);

        return view('word.index', compact('files'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('word.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Diretório onde os documentos serão salvos
        $savePath = public_path('documents');
    
        // Verificar se o diretório existe, se não, criá-lo
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }
    
        // Inicializar o objeto PhpWord
        $phpWord = new PhpWord();
        $phpWord->addNumberingStyle(
            'hNum',
            array('type' => 'multilevel', 'levels' => array(
                array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1'),
                array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
                )
            )
        );
    
        $phpWord->addTitleStyle(1, array('size' => 16), array('numStyle' => 'hNum', 'numLevel' => 0));
        $phpWord->addTitleStyle(2, array('size' => 14), array('numStyle' => 'hNum', 'numLevel' => 1));
        $phpWord->addTitleStyle(3, array('size' => 12), array('numStyle' => 'hNum', 'numLevel' => 2));
    
        // Variáveis para controlar as páginas dos sumários e conteúdos
        $paginaSumarioTitulos = 1;
        $paginaSumarioImagens = 2;
    
        // Adiciona a segunda página com o sumário de títulos
        $sectionSumarioTitulos = $phpWord->addSection();
        $sectionSumarioTitulos->addText('Sumário com Títulos');
        $sectionSumarioTitulos->addTextBreak(1);
        $sectionSumarioTitulos->addTOC(['fontStyle' => ['spaceAfter' => 60, 'size' => 12]]);
        $sectionSumarioTitulos->addPageBreak();
    
        // Adiciona a primeira página com o sumário de imagens
        $sectionSumarioImagens = $phpWord->addSection();
        $sectionSumarioImagens->addText('Sumário de Imagens');
        $sectionSumarioImagens->addTextBreak(1);
        $sectionSumarioImagens->addTOC(['fontStyle' => ['spaceAfter' => 60, 'size' => 12]]);
        $sectionSumarioImagens->addPageBreak();
    
        // Adiciona os títulos e imagens nas páginas subsequentes
        $formularios = Formulario::whereYear('ANO', Date('Y'))->get();

        // Variáveis para controlar as páginas dos sumários e conteúdos
        $paginaSumarioTitulos = 1;
        $paginaSumarioImagens = 2;

        $sectionsTitulos = [];
        $sectionsImagens = [];

        foreach ($formularios as $formulario) {
            $section = $phpWord->addSection();

            if (!isset($formulario->sub_titulo_id)) {
                $section->addTitle($formulario->descricao, 1);
                $sectionsTitulos[] = $section;

                // Verifica se é necessário iniciar uma nova página para o próximo sumário de títulos
                if ($paginaSumarioTitulos != count($sectionsTitulos)) {
                    $sectionSumarioTitulos->addPageBreak();
                    $paginaSumarioTitulos = count($sectionsTitulos);
                }
                
            } else {
                $section->addTitle($formulario->descricao, 2);
                $sectionsImagens[] = $section;

                // Verifica se é necessário iniciar uma nova página para o próximo sumário de imagens
                if ($paginaSumarioImagens != count($sectionsImagens)) {
                    $sectionSumarioImagens->addPageBreak();
                    $paginaSumarioImagens = count($sectionsImagens);
                }

                if (isset($formulario->imagem)) {
                    $sectionSumarioImagens->addImage(
                        public_path('imagens/' . $formulario->uuid . '.jpeg'),
                        [
                            'width'         => 450,
                            'height'        => 250,
                            'marginTop'     => -1,
                            'marginLeft'    => -1,
                            'wrappingStyle' => 'behind',
                            'alignment'     => 'center'
                        ]
                    );
                    $sectionSumarioImagens->addTitle('Legenda da imagem');
                }
            }
            // Adiciona um rodapé
            $footer = $section->addFooter();
            // Define a numeração das páginas no rodapé
            $footer->addPreserveText('{PAGE}', null, ['alignment' => 'right']);
        
        }
    
        // Salva o documento
        $filename = 'documento_com_sumario_' . date('His') . '.docx';
        $phpWord->save($savePath . DIRECTORY_SEPARATOR . $filename);
    
        return redirect()->route('word.index')->with('message', 'Arquivo criado com sucesso!.');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
