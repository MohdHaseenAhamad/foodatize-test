<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component {
    public $users,$updateUser = false, $addUser = false;
//    protected $listeners = [
//        'deleteUserListner' => 'deleteUser'
//    ];

    public function render() {

        $this->users = User::select('id', 'name', 'phone_number', 'email', 'phone_status AS status')->get();
        return view('livewire.admin.users');
    }

    public function deleteUser($id) {

        try {
            User::find($id)->delete();
            session()->flash('success', "User Deleted Successfully!!");

        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
        }
    }
    /**
     * Open Add User form
     * @return void
     */
    public function addUser()
    {
//        $this->resetFields();
        $this->addUser = true;
        $this->updateUser = false;
    }
}
