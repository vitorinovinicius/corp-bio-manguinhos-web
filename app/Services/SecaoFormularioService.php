<?php

namespace App\Services;

use App\Repositories\SecaoFormularioRepository;
use App\Repositories\FormularioRepository;
use App\Repositories\RelatorioRepository;
use App\Repositories\EmailRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Swift_SmtpTransport;
use App\Models\Role;
use Swift_Mailer;

Class SecaoFormularioService
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
     * @var EmailRepository
     */
    private $emailRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * SecaoFormularioService constructor.
     * @param SecaoFormularioRepository $secaoFormularioRepository
     * @param FormularioRepository $formularioRepository
     * @param RelatorioRepository $relatorioRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        SecaoFormularioRepository $secaoFormularioRepository,
        FormularioRepository $formularioRepository,
        RelatorioRepository $relatorioRepository,
        EmailRepository $emailRepository,
        UserRepository $userRepository
    )
    {
        $this->secaoFormularioRepository = $secaoFormularioRepository;
        $this->formularioRepository = $formularioRepository;
        $this->relatorioRepository = $relatorioRepository;
        $this->emailRepository = $emailRepository;
        $this->userRepository = $userRepository;
    }
    public function store($request)
    {
        $data = $request->all();
        $data['formulario_id'] = $data['formulario_id'];
        $data['setor_id'] = $data['setor_id'];
        $data['descricao'] = $data['descricao'];

        if(!isset($data['descricao'])){
            return response()->json([
                'status' => 400,
                'message' => 'Seção sem descrição, insira um descrição à seção'
            ]);
        }

        if(!isset($data['setor_id'])){
            return response()->json([
                'status' => 400,
                'message' => 'Seção sem setor, insira um setor à seção'
            ]);
        }

        try {
            \DB::beginTransaction();
            $secao = $this->secaoFormularioRepository->create($data);

            $formulario = $this->formularioRepository->where('id', $secao->formulario_id)->first();
            
            if($formulario->status == 2){
                $formulario->update(
                    [
                        'status' => 1
                    ]
                );
            }

            \DB::commit();
    
            return response()->json([
                'status'    => 200,
                'message'   => 'Seção salva com sucesso!'
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Falha ao salvar seção!',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update($request, $secao)
    {
        $data = $request->all();

        if(!isset($data['user_id'])){
            return redirect()->back()->with('error', 'Selecione um responsável para esta seção.');
        }elseif($data['user_id'] == $secao->user_id){
            return redirect()->back()->with('error', 'Usuário já selecionado.');
        }

        $secao->update($data);

        if($secao->user_id){
            $remetente = $this->userRepository->where('id', $data['gerente_id'])->first();
            $destinatario = $this->userRepository->where('id', $secao->user_id)->first();
            $email = $this->send_email($destinatario, $remetente, $secao, 2); //email de vinculo
            if($email->getStatusCode() == 200){
                $secao->update([
                    'status' => 0,
                    'email_status' => 1
                ]);
    
                return redirect()->back()->with('message', 'E-mail enviado com sucesso.');
            }else{
                return redirect()->back()->with('error', 'E-mail não enviado.');
            }
        }

        return redirect()->back()->with('message', 'Seção atualizada com sucesso.');
    }

    public function atualiza_texto($request, $secao)
    {
        $data = $request->all();
        
        $secao->update([
            'texto' => $data['texto']
        ]);

        return redirect()->back()->with('message', 'Seção atualizada com sucesso.');
    }

    public function status($secao, $status)
    {

        if($status == 5){ // seção finalizada
            
            $enviado = $this->send_email($secao->usuario, auth()->user(), $secao, $status);

            if($enviado->getStatusCode() == 200){
                $secao->update([
                    'email_status' => 1,
                    'status' => 4
                ]);

                return redirect()->route('forms.show', $secao->formulario->uuid)->with('message', 'E-mail enviado com sucesso.');
            }else{
                return redirect()->route('forms.show', $secao->formulario->uuid)->with('error', 'E-mail não enviado.');
            }
            
        }elseif($status == 6){
            $secao->formulario->update([
                'status' => 1
            ]);

            $secao->update([
                'email_status' => 2,
                'status' => 2
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Status atualizado com sucesso'
            ]);
        }

        $admins = Role::where('id', 2)->get();
        foreach ($admins as $admin){
            foreach($admin->role_users as $role_user){
                if($status !== 5 || $status !== 6){
                    $email = $this->send_email($role_user->user, $secao->usuario,  $secao, $status);
                    if($email->getStatusCode() == 200){
                        $secao->update([
                            'email_status' => 1
                        ]);        
                        return redirect()->route('forms.show', $secao->formulario->uuid)->with('message', 'E-mail enviado com sucesso.');
                    }else{
                        return redirect()->route('forms.show', $secao->formulario->uuid)->with('error', 'E-mail não enviado.');
                    }
                }
            }
        }       
    }

    public function correcao($request,$secao, $usuario)
    {
        $data = $request->all();
        $email = $this->emailRepository->updateOrCreate([
            'remetente_id' => isset($data['remetente_id'])?$data['remetente_id']:auth()->user()->id,
            'destinatario_id' => isset($data['destinatario_id'])?$data['destinatario_id']:$usuario->id,
            'secao_formulario_id' => $secao->id
        ]);

        return view('forms.correcao', compact('secao', 'usuario', 'email'));
    }

    public function email_correcao($request,$secao, $destinatario)
    {
        $data = $request->all();

        if(!isset($data['corpo'])){
            return redirect()->route('sec_forms.correcao', [$secao->uuid, $destinatario->uuid])->with('error', 'Não é possivel enviar o e-mail sem o conteúdo no corpo do e-mail.', 422);
        }

        $anexoPath = null;
        if ($request->hasFile('anexo')) {
            $anexo = $request->file('anexo');
            $anexoPath = $anexo->store('anexos_temp', 'public'); // Armazena o arquivo temporariamente na pasta public/anexos_temp
        }

        $this->emailRepository->updateOrCreate([
            'remetente_id' => isset($data['remetente_id'])?$data['remetente_id']:auth()->user()->id,
            'destinatario_id' => isset($data['destinatario_id'])?$data['destinatario_id']:$destinatario->id,
            'secao_formulario_id' => $secao->id,
            'corpo' => isset($data['corpo'])?$data['corpo']:null
        ]);

        $enviado = $this->send_email($destinatario, auth()->user(), $secao, 3, $data['corpo'], $anexoPath); //email de correção

        if($enviado->getStatusCode() == 200){
            $secao->update([
                'email_status' => 1
            ]);

            return redirect()->route('forms.show', $secao->formulario->uuid)->with('message', 'E-mail enviado com sucesso.');
        }else{
            return redirect()->route('forms.show', $secao->formulario->uuid)->with('error', 'E-mail não enviado.');
        }
    }

    public function consulta_ajax($secaoFormulario)
    {
        $secoes = $secaoFormulario->secoes;
        $data_secoes = array();
        foreach ($secoes as $secao){
            $data_secoes[] = [
                'id' => $secao->id,
                'secao_id' => $secao->secao_id,
                'setor_nome' => $secao->setor()->where('id', $secao->setor_id)->pluck('name')->first()?:'',
                'usuario_nome' => $secao->usuario()->where('id', $secao->user_id)->pluck('name')->first()?:'',
                'descricao' => $secao->descricao?:'',
                'texto' => $secao->texto?:'',
                'limite_caracteres' => $secao->limite_caracteres?:'',
                'status' => $secao->status(), //0 - Pendente, 1 - Em andamento, 2 - analisando, 3 - Em correção, 4 - Concluído
            ];
        }

        return response()->json([
            'secoes' => $data_secoes
        ], 200);
    }

    public function enviado()
    {
        $enviados = $this->secaoFormularioRepository->where('email_status', 1)->paginate();

        return view('forms.enviados', compact('enviados'));
    }

    public function todos_email()
    {
        $secoes = $this->secaoFormularioRepository->paginate();

        return view('forms.all_email', compact('secoes'));
    }

    public function confirmado()
    {
        $confirmados = $this->secaoFormularioRepository->where('email_status', 2)->paginate();

        return view('forms.confirmados', compact('confirmados'));
    }

    private function send_email($destinatario, $remetente, $secao, $status, $corpo = null, $anexo = null)
    {
        try {
            $host =         env('MAIL_HOST');
            $port =         env('MAIL_PORT');
            $encryption =   env('MAIL_ENCRYPTION');
            $username =     env('MAIL_USERNAME');
            $password =     env('MAIL_PASSWORD');

            $transport = new Swift_SmtpTransport($host, $port, $encryption);
            $transport->setUsername($username);
            $transport->setPassword($password);

            $new_mail = new Swift_Mailer($transport);

            Mail::setSwiftMailer($new_mail);

            if($status == 1 && $secao->status !== 3){ //seção em andamento e status finalizado
                $viewName = 'mail.finalizado';
                $subject = $secao->formulario->descricao." - Bio-Manguinhos";
                $usuario = $destinatario;
                $destinatario = $destinatario->email;
                $remetente = $remetente;
                
            }elseif($status == 2){ //seção em correção e status finalizado
                
                $viewName = 'mail.vinculo';
                $subject = $secao->formulario->descricao." - Bio-Manguinhos: ".$secao->descricao;
                $usuario = $destinatario;
                $destinatario = $destinatario->email;
                $remetente = $remetente;
    
            }elseif($status == 3){
                $viewName = 'mail.correcao';
                $subject = $secao->formulario->descricao." - Bio-Manguinhos: ".$secao->descricao;
                $usuario = $destinatario;
                $destinatario = $destinatario->email;
                $remetente = $remetente;

            }elseif($secao->status == 3 && $status == 1){ //seção em correção e status finalizado
                
                $viewName = 'mail.corrigido';
                $subject = $secao->formulario->descricao." - Bio-Manguinhos: ".$secao->descricao;
                $usuario = $destinatario;
                $destinatario = $destinatario->email;
                $remetente = $remetente;
    
            }elseif($status == 5){ //status de aprovação
                $viewName = 'mail.aprovado';
                $subject = $secao->formulario->descricao." - Bio-Manguinhos: ".$secao->descricao;
                $usuario = $destinatario;
                $destinatario = $destinatario->email;
                $remetente = $remetente;
            }

            Mail::to($destinatario)->send(new SendMail($viewName, $usuario, $subject, $remetente, $secao, $corpo, $anexo));

            // Remover o arquivo temporário após o envio do e-mail
            if ($anexo && \Storage::disk('public')->exists($anexo)) {
                \Storage::disk('public')->delete($anexo);
            }

            return response()->json([
                'message' => 'E-mail enviado com sucesso!'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'E-mail não enviado! Erro: '. $e->getMessage()
            ], 422);
        }
    }
}