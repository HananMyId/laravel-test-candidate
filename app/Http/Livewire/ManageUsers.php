<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Laravel\Fortify\Rules\Password;
use Livewire\WithPagination;

class ManageUsers extends Component
{
    use WithPagination;

    public $name, $email, $password, $role = 1, $user_id = null;
    public $errorEmail = null;
    public $page = 1, $limit = 10;

    protected $queryString = [
        'page' => ['except' => 1],
        'limit' => ['except' => 10],
    ];

    protected $listeners = ['delete'];

    private function resetInputFields()
    {
        $this->resetValidation();
        $this->errorEmail = null;

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 1;
        $this->user_id = null;
    }

    public function render()
    {
        return view('livewire.manage-users', ['users' => User::oldest()->paginate(10)]);
    }

    public function store()
    {
        if (is_null($this->user_id)) {
            $newUser = new CreateNewUser;
            $user = $newUser->create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]);

            DB::table('role_user')->insert([
                'role_id' => $this->role,
                'user_id' => $user->id
            ]);

            session()->flash('message', 'User Created Successfully.');
        } else {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255'
                ],
                'password' => [
                    'string', new Password
                ],
            ]);

            $isValid = true;
            $user = User::findOrFail($this->user_id);
            if ($this->email != $user->email) {
                $checkEmail = User::where('email', $this->email)->first();
                if (!is_null($checkEmail)) {
                    $this->errorEmail = 'Email already exists.';
                    $isValid = false;
                }
            }

            if ($isValid) {
                $user->name = $this->name;
                $user->email = $this->email;
                if ($this->password) $user->password = Hash::make($this->password);
                $user->save();

                $user->roles()->detach();
                DB::table('role_user')->insert([
                    'role_id' => $this->role,
                    'user_id' => $user->id
                ]);

                session()->flash('message', 'User Updated Successfully.');
            }
        }

        $this->resetInputFields();
    }

    public function clear()
    {
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = $user->roles()->first();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->user_id = $user->id;
        $this->password = '';
        $this->role = $role->id;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();

        session()->flash('message', 'User Deleted Successfully.');
    }

}
