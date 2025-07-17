<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function create(){
        $perm = Auth::user()->getRoleForSelectedFarm();

        if ($perm !== 'admin' && Auth::user()->isOwner !== 1) {
            return view('dashboard');
        }

        $farmId = session('selected_farm_id');
        $owner = Auth::user();

        //Pego todas as fazendas do owner atual
        $ownedFarmIds = $owner->ownedFarms()->pluck('id');
        
        //Pego todos os usuários vinculados a essas fazendas (via tabela farm_user), evitando o próprio owner
        $users = User::where('id', '!=', $owner->id)
                ->whereHas('farms', function ($query) use ($farmId) {
                    $query->where('farm_id', $farmId);
                })
                ->with(['farms' => function ($query) use ($farmId) {
                    $query->where('farm_id', $farmId);
                }])
                ->get();

        return view('user.user', compact('users'));
    }

    public function store(Request $request){
        $farmId = session('selected_farm_id');

        // Validação
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'], // REMOVIDO unique
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Verifica se já existe um usuário com este e-mail
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                // Verifica se já está vinculado à fazenda
                $alreadyLinked = $existingUser->farms()->where('farm_id', $farmId)->exists();

                if ($alreadyLinked) {
                    return redirect()->back()->with('error', 'Este usuário já está vinculado a esta fazenda.');
                }

                // Faz o vínculo à fazenda existente
                $existingUser->farms()->attach([$farmId => ['role' => $request->role]]);

                return redirect()->back()->with('success', 'Usuário já existente vinculado com sucesso à fazenda.');
            }

            // Usuário não existe, então cria
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'isOwner' => 0,
            ]);

            // Vincula à fazenda
            $user->farms()->attach([$farmId => ['role' => $request->role]]);

            return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar usuário. Verifique os dados e tente novamente.');
        }
    }

    public function update(User $user, Request $request){
        $farmId = session('selected_farm_id');


        $request->validate([
            'user-update-name' => ['required', 'string', 'max:255'],
            'user-update-email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $request->{'user-update-name'},
            'email' => $request->{'user-update-email'},
        ]);

        $farmPivotData = [];

        $farmPivotData[$farmId] = [
            'role' => $request->{'user-update-role'}, // ou use $role se tiver múltiplos roles por fazenda
        ];
        
        $user->farms()->sync($farmPivotData);

        return redirect()->route('user.create')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function delete(User $user){
        $user->delete();
        return redirect()->route('user.create')->with('success', 'Usuário deletado com sucesso!');
    }

    public function findByName(Request $request){
        $users = User::with(['farms'])
            ->when($request->findName, fn($q, $name) => $q->where('name', 'like', "%{$name}%"))
            ->get();

        return response()->json($users);
    }
}
