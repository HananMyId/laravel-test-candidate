<div class="z-10 ease-out duration-400">
    <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <div class="fixed inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>?
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <table class="table-fixed w-full mt-8 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
                <tbody>
                    <tr>
                        <th class="px-4 py-3 border-t border-b border-gray-200 bg-gray-100">Name</th>
                        <td class="px-4 py-2 border-t border-b border-gray-200">{{ $name }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Education</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $education }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Birthday</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $birthday }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Experience</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $experience }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Last Position</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $last_position }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Applied Position</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $applied_position }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Top 5 Skills</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $skills }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Email</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $email }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Phone</th>
                        <td class="px-4 py-2 border-b border-gray-200">{{ $phone }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-200 bg-gray-100">Resume</th>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <a href="#" wire:click.prevent="download('{{ $resume }}')" class="inline-flex text-blue-500">
                                <svg class="h-5 w-5"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <polyline points="9 14 12 17 15 14" /></svg>
                                Download
                            </a>
                        </td>
                    </tr>
                <tbody>
            </table>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="closeModalView()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Close
                    </button>
                </span>
            </div>
        </div>
    </div>
    </div>
</div>
