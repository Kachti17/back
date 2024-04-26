<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function createRole(Request $request, $name, $guardName = 'web') {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        $role = Role::create($validatedData);
        return response()->json(['message' => 'La role a été créée avec succès.', 'role' => $role], 201);
    }

    public function editRole(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
    ]);

    $role->update($validatedData);

    return response()->json(['message' => 'La role a été modifiée avec succès.', 'role' => $role], 200);
}

public function deleteRole($id)
{
    $role = Role::findOrFail($id);

    $role->delete();

    return response()->json(['message' => 'La role a été supprimée avec succès.'], 200);
}

public function showRoles()
{
    $roles = Role::all();

    return response()->json(['roles' => $roles], 200);
}


}
