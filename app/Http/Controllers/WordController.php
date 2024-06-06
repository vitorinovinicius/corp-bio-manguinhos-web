<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\TOC;
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
        $savePath = public_path('relatórios');

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
        $savePath = public_path('relatórios');

        // Verificar se o diretório existe, se não, criá-lo
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }

        // Inicializar o objeto PhpWord
        $phpWord = new PhpWord();
        $phpWord->getSettings()->setUpdateFields( true );        
        $phpWord->addNumberingStyle(
            'hNum',
                array(
                    'type' => 'multilevel',
                    'levels' => array(
                        array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1'),
                        array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                        array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
                    )
                )
        );

        $phpWord->addTitleStyle(1, array('size' => 16), array('numStyle' => 'hNum', 'numLevel' => 0));
        $phpWord->addTitleStyle(2, array('size' => 14), array('numStyle' => 'hNum', 'numLevel' => 1));
        $phpWord->addTitleStyle(3, array('size' => 12), array('numStyle' => 'hNum', 'numLevel' => 2));
        $fonte = [
            "name" => "Arial"
        ];
        $estilo = [
            "tabLeader" => TOC::TAB_LEADER_UNDERSCORE,
        ];

        // Adiciona o primeiro sumário com títulos de texto
        $section1 = $phpWord->addSection();
        $section1->addText('Sumário com Títulos de Texto');
        $section1->addTextBreak(1);
        $section1->addTOC($fonte, $estilo);
        $section1->addPageBreak();

        // Adiciona os títulos e imagens nas páginas subsequentes
        $formularios = Formulario::whereYear('ANO', Date('Y'))->get();
        $imageCaptionCounter = 1;
        foreach ($formularios as $formulario) {
            if (!isset($formulario->sub_titulo_id)) {
                // Adiciona título de texto
                $section1->addTitle($formulario->descricao, 1);
            } else {
                // Adiciona título de imagem
                $section1->addTitle($formulario->descricao, 2);
            }

            if (isset($formulario->imagem)) {
                // Adiciona imagem
                $section1->addImage(
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
                // Adiciona a legenda da imagem
                $section1->addText('Legenda da Imagem ' . $imageCaptionCounter . ': ' . $formulario->legenda);
                $imageCaptionCounter++;
            }
        }

        // Adiciona um rodapé
        $footer = $section1->addFooter();
        // Define a numeração das páginas no rodapé
        $footer->addPreserveText('{PAGE}', null, ['alignment' => 'right']);
        
        // Salva o documento
        $filename = 'Relatório_Corporativo_' . date('Y') . '.docx';
        if (file_exists($savePath . DIRECTORY_SEPARATOR . $filename)) {
            unlink($savePath . DIRECTORY_SEPARATOR . $filename);
        }
        $phpWord->save($savePath . DIRECTORY_SEPARATOR . $filename);

        return redirect()->route('word.index')->with('message', 'Arquivo criado com sucesso!');
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
