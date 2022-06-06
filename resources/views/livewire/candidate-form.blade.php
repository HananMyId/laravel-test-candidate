<div class="z-10 ease-out duration-400">
    <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <div class="fixed inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>?
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="inputName" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputName" placeholder="Smith" wire:model.lazy="name">
                        @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputEducation" class="block text-educationgray-700 text-sm font-bold mb-2">Education:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputEducation" placeholder="UGM Yogyakarta" wire:model.lazy="education">
                        @error('education') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputBirthday" class="block text-gray-700 text-sm font-bold mb-2">Birthday:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputBirthday" placeholder="1991-01-19" wire:model.lazy="birthday">
                        @error('birthday') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputExperience" class="block text-gray-700 text-sm font-bold mb-2">Experience:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputExperience" placeholder="5 Years" wire:model.lazy="experience">
                        @error('experience') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputLastPosition" class="block text-gray-700 text-sm font-bold mb-2">Last Position:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputLastPosition" placeholder="Backend Developer" wire:model.lazy="last_position">
                        @error('last_position') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputAppliedPosition" class="block text-gray-700 text-sm font-bold mb-2">Applied Position:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputAppliedPosition" placeholder="Senior PHP Developer" wire:model.lazy="applied_position">
                        @error('applied_position') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputSkills" class="block text-gray-700 text-sm font-bold mb-2">Top 5 Skills:</label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="2" id="inputSkills" wire:model.lazy="skills" placeholder="Laravel, Mysql, PostgreSQL, Codeigniter, Java"></textarea>
                        @error('skills') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputEmail" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputEmail" placeholder="smith@example.com" wire:model.lazy="email">
                        @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="inputPhone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputPhone" placeholder="08123456789" wire:model.lazy="phone">
                        @error('phone') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                            <label for="inputResume" class="block text-gray-700 text-sm font-bold mb-2">Resume:</label>
                            <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputResume" wire:model.lazy="resume">
                            @error('resume') <span class="text-red-500">{{ $message }}</span>@enderror
                            @if ($resumeFile)
                                <a href="#" wire:click.prevent="download('{{ $resumeFile }}')" class="inline-flex mt-2 mx-3 text-blue-500">
                                    <svg class="h-5 w-5"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <polyline points="9 14 12 17 15 14" /></svg>
                                    Download Resume
                                </a>
                            @endif

                            <div x-show="isUploading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Save
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
