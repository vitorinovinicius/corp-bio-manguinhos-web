<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 21/12/2016
 * Time: 13:15
 */

namespace App\Services;


use Artesaos\Defender\Defender;
use Artesaos\Defender\Permission;
use Artesaos\Defender\Role;
use App\Repositories\UserRepository;

class RoleService
{

    /**
     * @var Role
     */
    private $role;
    /**
     * @var Permission
     */
    private $permission;
    /**
     * @var Defender
     */
    private $defender;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(Role $role, Permission $permission, Defender $defender, UserRepository $userRepository)
    {
        $this->role = $role;
        $this->permission = $permission;
        $this->defender = $defender;
        $this->userRepository = $userRepository;
    }

    public function listRoles(){
        $roles = $this->role->orderBy('id', 'desc')->paginate();
        return view('roles.index', compact('roles'));
    }

    public function showRolePermission($role_id){
        $role = $this->role->findOrFail($role_id);
        $permissions = $this->permission->all();
        return view('roles.show', compact('role','permissions'));
    }

    public function permissionUpdate($request, $id)
    {
        $data = $request->all();
//        $user = $this->userRepository->find($id);
        $role = $this->defender->findRoleById($id);
        unset($data["_method"]);
        unset($data["_token"]);

        $permissions = array();
        $notPermissions = array();
        if(count($data) > 0){
                foreach ($data as $key=>$value){
                    $permissions[$key] = ['value' => $value];
                    if($value == "0"){
                        $notPermissions[] = $key;
                        unset($permissions[$key]);
                    }
                }
//            dd($notPermissions);
//            $user->detachPermission($notPermissions);
            $role->detachPermission($notPermissions);
//            $user->syncPermissions($permissions);
            $role->syncPermissions($permissions);
            return redirect()->route('roles.show',$id)->with('message', 'Permissões atualizadas com sucesso');
        }
    }
}