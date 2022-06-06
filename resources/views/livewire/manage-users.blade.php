<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Users
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                  <div class="flex">
                    <div>
                      <p class="text-sm">{{ session('message') }}</p>
                    </div>
                  </div>
                </div>
            @endif
            <form method="POST" wire:submit.prevent="store">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input type="text" wire:model.lazy="name" class="w-full py-2 rounded">
                    @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="email">Email</label>
                    <input type="email" wire:model.lazy="email" class="w-full py-2 rounded">
                    @error('email')<span class="text-red-600">{{ $message }}</span>@enderror
                    @if (!is_null($errorEmail))<span class="text-red-500">{{ $errorEmail }}</span>@endif
                </div>
                <div class="mt-4">
                    <label for="password">Password</label>
                    <input type="text" wire:model.lazy="password" class="w-full py-2 rounded">
                    @error('password')<span class="text-red-600">{{ $message }}</span>@enderror
                </div>
                <div class="mt-4">
                    <label for="password">Role</label>
                    <div>
                        <input wire:model="role" name="role" type="radio" value="1" /> Administrator &nbsp;
                        <input wire:model="role" name="role" type="radio" value="2" /> Senior HRD &nbsp;
                        <input wire:model="role" name="role" type="radio" value="3" /> HRD &nbsp;
                    </div>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-600 rounded">
                        Submit
                    </button>
                    <button type="button" wire:click="clear()" class="px-4 py-2 mt-4 text-white bg-green-600 rounded">
                        Clear
                    </button>
                </div>
            </form>
            <table class="table-fixed w-full mt-8 border-b border-gray-200 shadow">
                <thead>
                    <tr>
                        <th class="w-20 px-6 py-3 text-left text-gray-500 border-b border-gray-200 bg-gray-50">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-gray-500 border-b border-gray-200 bg-gray-50">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-gray-500 border-b border-gray-200 bg-gray-50">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-gray-500 border-b border-gray-200 bg-gray-50">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-gray-500 border-b border-gray-200 bg-gray-50">
                            *
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm text-gray-900">
                                        {{ (($page - 1) * $limit) + $loop->iteration }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="text-sm text-gray-900">
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="text-sm text-gray-900">
                                {{ $user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="text-sm text-gray-900">
                                {{ $user->roles()->first()->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-wrap justify-end">
                                <button wire:click="edit({{ $user->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-1 rounded">Edit</button>
                                @if (auth()->user()->id !== $user->id)
                                <button
                                    wire:click="$emit('triggerDelete', {{ $user->id }}, '{{ $user->name }}')"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-1 rounded">
                                    Delete
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<x-slot name="script">
    <script>
        Livewire.on("triggerDelete", (id, name) => {
            const proceed = confirm(`Are you sure you want to delete '${name}'`);

            if (proceed) {
                Livewire.emit("delete", id);
            }
        });
    </script>
</x-slot>
