<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function createPermission(Request $request, $name, $guardName = 'web') {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
        $permission = Permission::create($validatedData);
        return response()->json(['message' => 'La permission a été créée avec succès.', 'permission' => $permission], 201);
    }

    public function editPermission(Request $request, $id)
{
    $permission = Permission::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:permissions,name,'.$permission->id,
    ]);

    $permission->update($validatedData);

    return response()->json(['message' => 'La permission a été modifiée avec succès.', 'permission' => $permission], 200);
}

public function deletePermission($id)
{
    $permission = Permission::findOrFail($id);

    $permission->delete();

    return response()->json(['message' => 'La permission a été supprimée avec succès.'], 200);
}

public function showPermissions()
{
    $permissions = Permission::all();

    return response()->json(['permissions' => $permissions], 200);
}

public function givePermissionToRole(Request $request)
{
    $validatedData = $request->validate([
        'roleName' => 'required|string',
        'permissionName' => 'required|string',
    ]);

    $roleName = $validatedData['roleName'];
    $permissionName = $validatedData['permissionName'];

    $role = Role::where('name', $roleName)->first();
    if (!$role) {
        return response()->json(['message' => 'Le rôle spécifié n\'existe pas.'], 404);
    }

    $permission = Permission::where('name', $permissionName)->first();
    if (!$permission) {
        return response()->json(['message' => 'La permission spécifiée n\'existe pas.'], 404);
    }

    if ($role->hasPermissionTo($permission)) {
        return response()->json(['message' => 'Le rôle a déjà cette permission.'], 400);
    }

    $role->givePermissionTo($permission);

    return response()->json(['message' => 'La permission a été ajoutée au rôle avec succès.', 'role' => $role, 'permission' => $permission], 200);
}



public function removePermissionFromRole(Request $request)
{
    $validatedData = $request->validate([
        'roleName' => 'required|string',
        'permissionName' => 'required|string',
    ]);

    $roleName = $validatedData['roleName'];
    $permissionName = $validatedData['permissionName'];

    $role = Role::where('name', $roleName)->first();
    if (!$role) {
        return response()->json(['message' => 'Le rôle spécifié n\'existe pas.'], 404);
    }

    $permission = Permission::where('name', $permissionName)->first();
    if (!$permission) {
        return response()->json(['message' => 'La permission spécifiée n\'existe pas.'], 404);
    }

    if (!$role->hasPermissionTo($permission)) {
        return response()->json(['message' => 'Le rôle n\'a pas cette permission.'], 400);
    }

    $role->revokePermissionTo($permission);

    return response()->json(['message' => 'La permission a été retirée du rôle avec succès.', 'role' => $role, 'permission' => $permission], 200);
}



public function filterPermissionsByRoleId($roleId)
{
    $role = Role::find($roleId);
    if (!$role) {
        return response()->json(['message' => 'Le rôle spécifié n\'existe pas.'], 404);
    }

    $permissions = $role->permissions;

    return response()->json(['message' => 'Permissions filtrées avec succès.', 'permissions' => $permissions], 200);
}


}
