<?php

namespace App\Services;


use App\Models\OccurrenceClient;
use Artesaos\Defender\Facades\Defender;
use App\Criteria\UsersSelectCriteria;
use App\Repositories\UserRepository;
use App\Repositories\UserSetoresRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserSetoresRepository
     */
    private $userSetoresRepository;

    public function __construct(UserRepository $userRepository, UserSetoresRepository $userSetoresRepository)
    {
        $this->userRepository           = $userRepository;
        $this->userSetoresRepository    = $userSetoresRepository;
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

        $newUser = $this->userRepository->create($data);

        $this->userSetoresRepository->create([
            'user_id' => $newUser->id,
            'setor_id' => $data['setor_id']
        ]);

        if (isset($data['role_id'])) {
            $newUser->syncRoles($data["role_id"]);
        }

        return redirect()->route('users.index')->with('message', 'Usuário criado com sucesso.');
    }

    public function editUser($request, $user)
    {

        $data = $request->all();

        $user->update($data);

        $this->userSetoresRepository->where(
            [
                [
                    'user_id', $user->id
                ],
                [
                    'setor_id', $user['setor_id']
                ]
            ]
        )->update([
            'user_id' => $user->id,
            'setor_id' => $data['setor_id']
        ]);

        if (isset($data['role_id'])) {
            $user->syncRoles($data["role_id"]);
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

    public function showUser($user)
    {
        $setores = $user->setores;
        return view('users.show', compact('user','setores'));
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
}