<?php

namespace App\Services;


use App\Models\OccurrenceClient;
use Artesaos\Defender\Facades\Defender;
use App\Criteria\UsersSelectCriteria;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listUsers()
    {
        $this->userRepository->pushCriteria(new UsersSelectCriteria());
        $users = $this->userRepository->all();

        return $users;
    }

    public function addNewUser($request)
    {
        $data = $request->all();
        $data["password"] = bcrypt($data["password"]);

        if(Defender::is("admin")){
            $data["contractor_id"]  = Auth::user()->contractor_id;
        }else{
            if(isset($data["contractor_id"]) && $data["contractor_id"] == "0"){
                $data["contractor_id"] = null;
            }
        }


        $newUser = $this->userRepository->create($data);

        if (isset($data["signature"]) && !empty($data["signature"])) {
            $upload = $this->uploadS3($request->file("signature"), $newUser->id);
            $this->userRepository->update(['signature' => $upload], $newUser->id);
        }


        if(!in_array(Defender::findRole("gestor")->id, $data["role_id"])) {

            if (isset($data['region_id'])) {
                $newUser->regions()->attach($data['region_id']);
            }

        }

        if (isset($data['role_id'])) {
            $newUser->syncRoles($data["role_id"]);
        }
    }

    public function editUser($request, $user)
    {

        //todo: Verifica se o usuário pertence a alguma equipe
//        if(count($user->teams)){
//            return redirect()->route('users.index')->with('error', 'Usuário '.$user->name.' não pode ser alterado pois ainda pertence a alguma equipe.');
//        }

        $data = $request->all();

        if(Defender::is("admin")){
            $data["contractor_id"]  = Auth::user()->contractor_id;
        }else{
            if(isset($data["contractor_id"]) && $data["contractor_id"] == "0"){
                $data["contractor_id"] = null;
            }
        }

        $this->userRepository->update($data, $user->id);

        if (isset($data["signature"]) && !empty($data["signature"])) {
            $upload = $this->uploadS3($request->file("signature"), $user->id);
            $this->userRepository->update(['signature' => $upload], $user->id);
        }

        if (isset($data['role_id'])) {
            $user->syncRoles($data["role_id"]);
        }

        if (isset($data['region_id'])) {
            $user->regions()->sync($data['region_id']);
        }
        return redirect()->route('users.index')->with('message', 'Usuário atualizado com sucesso.');

    }

    public function deleteUser($user)
    {
        //Verifica se o usuário pertence a alguma equipe
        if($user->teams()->wherePivot('is_supervisor',1)->first()){
            return redirect()->route('users.index')->with('error', 'Usuário '.$user->name.' não pode ser deletado pois ainda pertence a alguma equipe.');
        }else{
            $user->delete();
            return redirect()->route('users.index')->with('message', 'Item deletado com sucesso.');
        }
    }

    public function updatePassword($request, $user){
        $data = $request->all();
        if($data['password'] != $data['repassword']){
            return redirect()->route('users.change_password',$user->uuid)->with('error', 'As senhas não coencidem, informe a senha novamente.');
        }
        $data['password'] = bcrypt($data['password']);
        $this->userRepository->update($data, $user->id);
        return redirect()->route('users.show',$user->uuid)->with('message', 'Senha alterada com sucesso.');
    }

    public function showUser($user){
        //Pega as equipes que o usuário participa
        $teams = $user->teams()->paginate();
        return view('users.show', compact('user','teams'));
    }

    public function all(){
        return $this->userRepository->all();
    }

    public function updateThemeColor($request)
    {
        try {
            $data = $request->all();

            $user = Auth::user();

            $color['theme'] = $data['color'];

            $this->userRepository->update($color, $user->id);

            return response()->json(["success" => "Theme recebido com sucesso"]);
        } catch (\Exception $exception) {
            return response()->json(["error" => "Erro ao processar theme"], 500);
        }
    }

    // public function associate_client($user)
    // {
    //     $occurrence_clients = $this->occurrenceClientRepository->where('contractor_id', $user->contractor_id)->get();
    //     return view('users.clients.associate_cliets', compact('user', 'occurrence_clients'));
    // }

    // public function associate_client_store($user, $request)
    // {
    //     try{
    //         $data = $request->all();

    //         $occurrenceClient = OccurrenceClient::find($data['occurrence_client_id']);
    //         $user->occurrence_clients()->save($occurrenceClient);
    //     }catch (Exception $e){
    //         return redirect()->back()->withInput()->with('error', 'Erro ao tentar associar um cliente. <br>Erro: '.$e->getMessage());
    //     }

    //     return redirect()->route('users.clients')->with('message', 'Cliente associado com sucesso.');
    // }

    public function disassociate_client_store($user, $request)
    {
        try{
            $data = $request->all();

            $user->occurrence_clients()->detach($data['occurrence_client_id']);
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar remover cliemte. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('users.clients')->with('message', 'Cliente removido com sucesso.');

    }

    private function uploadS3($arquivo, $occurrence_id)
    {
        $archivePath = "temp/";
        $fileName = md5(date("Y_m_d_h_i_s")) . "." . $arquivo->getClientOriginalExtension();
        $path = $archivePath . $fileName;
        $arquivo->move($archivePath, $fileName);
        $s3Client = Storage::disk('s3');
        $image_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $occurrence_id . "/" . $fileName;


        if (\File::exists($path)) {
            $contents = \File::get($path);
            $s3Client->put($image_name, $contents);
            \File::delete($path);
            return $s3Client->url($image_name);
        }
    }
}
