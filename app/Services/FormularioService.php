<?php

namespace App\Services;

use App\Repositories\SecaoFormularioRepository;
use App\Repositories\UserSetoresRepository;
use App\Repositories\FormularioRepository;
use App\Repositories\RelatorioRepository;
use App\Repositories\SetorRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Models\SecaoFormulario;
use App\Mail\SendMailStart;
use Swift_SmtpTransport;
use App\Models\Setor;
use Swift_Mailer;
use Exception;

class FormularioService
{
    /**
     * @var SecaoFormularioRepository
     */
    private $secaoFormularioRepository;

    /**
     * @var FormularioRepository
     */
    private $formularioRepository;

    /**
     * @var RelatorioRepository
     */
    private $relatorioRepository;

    /**
     * @var UserSetoresRepository
     */
    private $userSetoresRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SetorRepository
     */
    private $setorRepository;

    /**
     * FormService constructor.
     * @param SecaoFormularioRepository $secaoFormularioRepository
     * @param RelatorioRepository $relatorioRepository
     * @param UserSetoresRepository $relatorioRepository
     * @param UserRepository $relatorioRepository
     * @param SetorRepository $setorRepository
     */
    public function __construct(
        SecaoFormularioRepository $secaoFormularioRepository,
        FormularioRepository $formularioRepository,
        RelatorioRepository $relatorioRepository,
        UserSetoresRepository $userSetoresRepository,
        UserRepository $userRepository,
        SetorRepository $setorRepository
    ){
        $this->secaoFormularioRepository    = $secaoFormularioRepository;
        $this->formularioRepository         = $formularioRepository;
        $this->relatorioRepository          = $relatorioRepository;
        $this->userSetoresRepository        = $userSetoresRepository;
        $this->userRepository               = $userRepository;
        $this->setorRepository              = $setorRepository;
    }

    public function index($request)
    {
        $roles = \Auth::user()->roles;
        foreach ($roles as $role) {
            if($role == 'colaborador'){
                $verificaSecao =  $this->formularioRepository->where('user_id', \Auth::user()->id)->exists();
                if(!$verificaSecao){
                    return redirect()->back()->withInput()->with('error', 'Nenhuma seção vinculada ao usuário');
                }
            }
        }
        $forms = $this->formularioRepository->orderBy('id','asc')->paginate();
        return view('forms.index', compact('forms'));

    }

    public function preenchimento($formulario)
    {
        return view('forms.preenchimento', compact('formulario'));
    }

    public function vincula($formulario)
    {
        $setores = $this->setorRepository->all();
        return view('forms.vincula', compact('formulario', 'setores'));
    }

    public function create()
    {
        
        $teams = Setor::all();

        return view('forms.create', compact('teams'));
    }

    public function store($request)
    {                
        $data = $request->all();

        $relatorio = $this->relatorioRepository->create(
            [
                'descricao' => $data['descricao_relatorio'],
            ]
        );

        $formulario = $this->formularioRepository->create([
            'relatorio_id' => $relatorio->id,
            'descricao' => $data['descricao_formulario'],
            'ano' => $data['ano'],
            'status' => 0
        ]);

        return redirect()->route('forms.show', $formulario->uuid)->with('message', 'Formulário criado com sucesso.');
    }


    public function show($formulario)
    {
        $formularioConcluido = true;
        if($formulario->secoes->count()){
            foreach ($formulario->secoes as $secao) {
                if ($secao->status != 4) {
                    $formularioConcluido = false;
                    break; // Se encontrar uma seção com status diferente de 4, podemos parar de verificar
                }
            }
        }else{
            $formularioConcluido = false;
        }

        if($formularioConcluido){
            $formulario->update([
                'status' => 2
            ]);
        }

        $setores = Setor::all();
        $titulos = $formulario->secoes;
        $subTitulos = $formulario->secoes;

        return view('forms.show', compact('formulario', 'setores', 'titulos', 'subTitulos'));
    }

    public function edit($formulario)
    {
        $teams = Setor::all();
        $titulos = SecaoFormulario::all();
        $subTitulos = SecaoFormulario::all();
        return view('forms.edit', compact('formulario', 'teams', 'titulos', 'subTitulos'));
    }

    public function update($form, $request)
    {
        $data = $request->all();

        try {
            $this->formularioRepository->update($data, $form->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.index')->with('message', 'Item atualizado com sucesso.');
    }

    public function destroy($formulario)
    {
        try {
            foreach ($formulario->secoes as $secao){
                $secao->delete();
            } 
            $formulario->update([
                'ano' => null
            ]);

            $formulario->delete();
            return redirect()->route('forms.index')->with('message', 'Item deletado com sucesso.');

        } catch (Exception $e) {
            return redirect()->route('forms.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
    }

    public function iniciar($usuario, $formulario)
    {
        if($usuario->id !== auth()->user()->id){
            return redirect()->route('forms.index')->with('error', 'Somente o responsável pode confirmar e-mail e iniciar à seção.');
        }

        foreach($usuario->setores as $setor){
            foreach ($formulario->secoes as $secao){
                if($secao->setor_id == $setor->id){
                    $secao->update([
                        'email_status' => 2
                    ]);
                    
                    return redirect()->route('forms.index')->with('message', 'E-mail confirmado e setor informado sobre o formulário relacionadas.');
                }
            }
        }

        return redirect()->route('forms.index')->with('message', 'E-mail confirmado e seção iniciada.');
    }

    public function inicia_ajax($formulario)
    {
        // Obtém todas as seções do formulário
        $secoes = $this->secaoFormularioRepository->where('formulario_id', $formulario->id)->get();

        $emailEnviado = false;

        foreach ($secoes as $secao) {
            $setores = $secao->setor;
            if ($setores->users) {

                foreach ($setores->users as $usuario) {
                    if ($usuario && $usuario->roles->contains('name', 'gestor')) {
                        $envio = $this->send_email($formulario, $usuario, $secao);

                        if (json_decode($envio->getStatusCode(), true) == 200) {
                            $emailEnviado = true;
                        } else {
                            return redirect()->route('forms.index')->with('error', 'E-mail não enviado para ' . $usuario->email . '!');
                        }
                    }
                }
            }
        }

        if ($emailEnviado) {            

            $this->formularioRepository->update([
                'status' => 1
            ], $formulario->id);

            $this->secaoFormularioRepository->update([
                'email_status' => 1
            ], $secao->id);
            return response()->json([
                'status' => 200,
                'message' => 'Todos os e-mails foram enviados com sucesso!'
            ]);
        } else {            
            return response()->json([
                'status' => 400,
                'message' => 'Nenhum e-mail foi enviado!'
            ]);
        }
    }

    public function confirmacao($user, $secao)
    {
        if($user->uuid !== auth()->user()->uuid){
            return redirect()->route('forms.index')->with('error', 'Somente o responsável pode confirmar o e-mail recebido.');
        }
        
        try{
            if($secao->status == 0){
                $status = 1;
            }elseif($secao->status == 1){
                $status = 2;
            }elseif($secao->status == 2){
                $status = 3;
            }elseif($secao->status == 3){
                $status = 2;
            }elseif($secao->status == 4){
                $status = 4;
            }

            $secao->update([
                'status' => $status,
                'email_status' => 2
            ]);            
            return redirect()->route('forms.index')->with('message', 'E-mail confirmado!.');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    private function send_email($formulario, $user, $secao)
    {
        try {
            $host = env('MAIL_HOST');
            $port = env('MAIL_PORT');
            $encryption = env('MAIL_ENCRYPTION');
            $username = env('MAIL_USERNAME');
            $password = env('MAIL_PASSWORD');

            $transport = new Swift_SmtpTransport($host, $port, $encryption);
            $transport->setUsername($username);
            $transport->setPassword($password);

            $new_mail = new Swift_Mailer($transport);

            Mail::setSwiftMailer($new_mail);

            if ($user->email) {
                $to = $user->email;
            } else {
                $to = "";
            }
            $viewName = 'mail.send_relatorio_anual';
            $subject = "Relatorio anual - Bio-Manguinhos";

            Mail::to($to)->send(new SendMailStart($viewName, $user, $subject, $formulario));

            return response()->json([
                'message' => 'E-mail enviado com sucesso!'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'E-mail não enviado! Error: ' . $e->getMessage()
            ], 422);
        }
    }
    
}
