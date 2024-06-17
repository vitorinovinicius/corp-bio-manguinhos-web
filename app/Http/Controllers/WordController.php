<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\TOC;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Imagem;


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

    public function store($formulario)
    {
        // Diretório onde os documentos serão salvos
        $savePath = public_path('relatórios');

        // Verificar se o diretório existe, se não, criá-lo
        if (!File::isDirectory($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }

        // Inicializar o objeto PhpWord
        $phpWord = new PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);
        $phpWord->addNumberingStyle(
            'hNum',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1'),
                    array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                    array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
                    array('pStyle' => 'Heading4', 'format' => 'decimal', 'text' => '%1.%2.%3.%4'),
                    array('pStyle' => 'Heading5', 'format' => 'decimal', 'text' => '%1.%2.%3.%4.%5'),
                    array('pStyle' => 'Heading6', 'format' => 'decimal', 'text' => '%1.%2.%3.%4.%5.%6'),
                )
            )
        );

        $phpWord->addTitleStyle(1, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 0));
        $phpWord->addTitleStyle(2, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 1));
        $phpWord->addTitleStyle(3, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 2));
        $phpWord->addTitleStyle(4, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 3));
        $phpWord->addTitleStyle(5, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 4));
        $phpWord->addTitleStyle(6, array('size' => 10), array('numStyle' => 'hNum', 'numLevel' => 5));
        $fonte = [
            "name" => "Arial"
        ];
        $estilo = [
            "tabLeader" => TOC::TAB_LEADER_UNDERSCORE,
        ];

        // Adiciona o primeiro sumário com títulos de texto
        $section1 = $phpWord->addSection();
        $section1->addText('Sumário');
        $section1->addTOC($fonte, $estilo);
        $section1->addTextBreak(1);

        $section1 = $phpWord->addSection();
        $section1->addText('Lista de figuras');
        $section1->addTextBreak(1);

        $section1 = $phpWord->addSection();
        $section1->addText('Lista de gráficos');
        $section1->addTextBreak(1);

        $section1 = $phpWord->addSection();
        $section1->addText('Lista de tabelas');
        $section1->addTextBreak(1);
        $section1->addPageBreak();

        // Mapeia as tags de imagem para seus IDs reais
        $tagsToImages = [];
        foreach ($formulario->secoes as $formularioSecao) {
            if ($formularioSecao->secao_imagem->count()) {
                foreach ($formularioSecao->secao_imagem as $imagem) {
                    $imagemObj = Imagem::where(['id' => $imagem->imagem_id])->first();
                    if ($imagemObj) {
                        $tagsToImages['[img' . $imagem->id . ']'] = $imagemObj;
                    }
                }
            }
        }

        // Adiciona as seções hierarquicamente
        $rootSections = $formulario->secoes->where('secao_id', null);
        foreach ($rootSections as $rootSection) {
            $this->addSectionRecursively($section1, $rootSection, $tagsToImages, 0);
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

        return redirect()->route('admin.index')->with('message', 'Arquivo criado com sucesso!');
    }

    /**
     * Adiciona seções recursivamente ao documento.
     *
     * @param \PhpOffice\PhpWord\Element\Section $section
     * @param FormularioSecao $formularioSecao
     * @param array $tagsToImages
     * @param int $level
     */
    private function addSectionRecursively($section, $formularioSecao, $tagsToImages, $level)
    {
        // Adiciona o título da seção com o nível correto
        $section->addTitle($formularioSecao->descricao, $level + 1);

        // Processa o texto para encontrar e substituir as tags de imagem
        $textoPartes = preg_split('/(\[img\d+\])/', $formularioSecao->texto, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($textoPartes as $parte) {
            if (preg_match('/\[img(\d+)\]/', $parte, $matches)) {
                $imagemId = (int)$matches[1];
                if (isset($tagsToImages['[img' . $imagemId . ']'])) {
                    $imagemObj = $tagsToImages['[img' . $imagemId . ']'];
                    // Adiciona a imagem
                    $section->addImage(
                        public_path($imagemObj->url_imagem),
                        [
                            'width' => 450,
                            'height' => 250,
                            'marginTop' => -1,
                            'marginLeft' => -1,
                            'wrappingStyle' => 'behind',
                            'alignment' => 'center'
                        ]
                    );

                    // Adiciona a legenda da imagem
                    $textrun = $section->addTextRun(['alignment' => Jc::CENTER]);
                    $textrun->addText($imagemObj->type() . ' '); // Tipo da imagem (Figura, Gráfico, Tabela)
                    $textrun->addText($this->createSEQField($imagemObj->type())); // Número de sequência
                    $textrun->addText(': ' . $imagemObj->legenda);
                }
            } else {
                // Adiciona a parte do texto
                $section->addText($parte);
            }
        }

        // Adiciona as seções filhas recursivamente
        foreach ($formularioSecao->filhos as $childSection) {
            $this->addSectionRecursively($section, $childSection, $tagsToImages, $level + 1);
        }
    }

    private $seqCounters = [
        'Figura' => 1,
        'Gráfico' => 1,
        'Tabela' => 1
    ];

    /**
     * Cria o campo SEQ para legendas.
     *
     * @param string $identifier O identificador do campo SEQ (e.g., 'Figura', 'Gráfico', 'Tabela')
     * @return string O XML do campo SEQ
     */
    private function createSEQField($identifier)
    {
        if (!isset($this->seqCounters[$identifier])) {
            $this->seqCounters[$identifier] = 1;
        }

        $seqNumber = $this->seqCounters[$identifier]++;
        return '<w:fldSimple w:instr=" SEQ ' . $identifier . ' \* ARABIC "><w:r><w:t>' . $seqNumber . '</w:t></w:r></w:fldSimple>';
    }
}

