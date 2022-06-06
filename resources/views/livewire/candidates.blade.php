<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Candidates
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
            <div class="grid grid-cols-2 gap-2">
                <div>
                    @if (auth()->user()->roles()->first()->id != 3)
                    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create Candidate</button>
                    @endif
                </div>
                <div class="flex justify-end">
                    <input
                    wire:model.debounce.600ms="search"
                    type="text"
                    class="px-1 py-1 border border-gray-300 outline-none focus:border-gray-400 my-3"
                    placeholder="Search.."
                    />

                </div>
            </div>
            @if($isOpen)
                @include('livewire.candidate-form')
            @endif
            @if($isOpenView)
                @include('livewire.candidate-view')
            @endif
            <table class="table-fixed w-full mt-8 border-b border-gray-200 shadow">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 w-20">No.</th>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-50">Name</th>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-50">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $candidate)
                    <tr>
                        <td class="px-4 py-2 border-b border-gray-200 text-right">{{ (($page - 1) * $limit) + $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $candidate->name }}</td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <div class="flex flex-wrap justify-end">
                                <button wire:click="view({{ $candidate->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mx-1 rounded">View</button>
                                @if (auth()->user()->roles()->first()->id != 3)
                                <button wire:click="edit({{ $candidate->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-1 rounded">Edit</button>
                                <button
                                wire:click="$emit('triggerDelete', {{ $candidate->id }}, '{{ $candidate->name }}')"
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
                {{ $candidates->links() }}
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
