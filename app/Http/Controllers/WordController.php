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

        $section = $phpWord->addSection();

        // Define o estilo da fonte para o sumário
        $fontStyle = ['spaceAfter' => 60, 'size' => 12];

        // Define os estilos de título
        // $phpWord->addTitleStyle(1, ['size' => 12, 'color' => '333333', 'bold' => true]);
        // $phpWord->addTitleStyle(2, ['size' => 12, 'color' => '666666']);
        // $phpWord->addTitleStyle(3, ['size' => 12, 'italic' => true]);
        // $phpWord->addTitleStyle(4, ['size' => 12]);

        // Adiciona os elementos de texto
        $section->addText('Sumário');
        $section->addTextBreak(1);

        // Adiciona o sumário #1
        $section->addTOC($fontStyle);
        $section->addTextBreak(1);

        // Adiciona os títulos
        $section->addPageBreak();        

        $formularios = Formulario::all();
        foreach ($formularios as $formulario){
            if($formulario->titulo){
                $section->addTitle($formulario->titulo, 1, '{PAGE}');
            }
            if($formulario->sub_titulo){
                $section->addTitle($formulario->sub_titulo, 2, '{PAGE}');
                
            }
        }
        // $section->addTitle('Eu sou o Título X', 1);
        // $section->addText('Texto...');
        // $section->addTextBreak(2);

        // $section->addTitle('Eu sou um Subtítulo do Título 1', 2);
        // $section->addTextBreak(2);
        // $section->addText('Mais um pouco de texto...');
        // $section->addTextBreak(2);

        // $section->addTitle('Outro Título (Título 2)', 1);
        // $section->addText('Algum texto...');
        // $section->addPageBreak();

        // $section->addTitle('Eu sou o Título 3', 1);
        // $section->addText('E mais texto...');
        // $section->addTextBreak(1);
        // $section->addTitle('Eu sou um Subtítulo do Título 3', 2);
        // $section->addText('Novamente e novamente, mais texto...');
        // $section->addTitle('Subtítulo 3.1.1', 3);
        // $section->addText('Texto');
        // $section->addTitle('Subtítulo 3.1.1.1', 4);
        // $section->addText('Texto');
        // $section->addTitle('Subtítulo 3.1.1.2', 4);
        // $section->addText('Texto');
        // $section->addTitle('Subtítulo 3.1.2', 3);
        // $section->addText('Texto');
        $section->addImage(
            public_path('images/pages/content-img-1.jpg'),
            [
                'width'         => 450,
                'height'        => 250,
                'marginTop'     => -1,
                'marginLeft'    => -1,
                'wrappingStyle' => 'behind',
                'alignment' => 'center'
            ]
        );
        $section->addTitle('Legenda da imagem');
        // Adiciona um rodapé
        $footer = $section->addFooter();

        // Define a numeração das páginas no rodapé
        $footer->addPreserveText('{PAGE}', null, ['alignment' => 'right']);
        

        // Salva o documento
        $filename = 'documento_com_sumario_'.date('His').'.docx';
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
