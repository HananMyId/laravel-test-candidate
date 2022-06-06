<?php

namespace App\Http\Livewire;

use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Candidates extends Component
{
    use WithPagination, WithFileUploads;

    public $candidate_id = null, $name, $education, $birthday, $experience,
        $last_position, $applied_position, $skills, $email, $phone, $resume = null;
    public $isOpen = false, $isOpenView = false, $resumeFile= null;
    public $search = '', $page = 1, $limit = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'limit' => ['except' => 10],
    ];

    protected $listeners = ['delete'];

    private function resetInputFields()
    {
        $this->resetValidation();

        $this->candidate_id = null;
        $this->name = '';
        $this->education = '';
        $this->birthday = '';
        $this->experience = '';
        $this->last_position = '';
        $this->applied_position = '';
        $this->skills = '';
        $this->email = '';
        $this->phone = '';
        $this->resume = null;
    }

    public function render()
    {
        return view('livewire.candidates', [
            'candidates' => Candidate::search($this->search)
                ->latest()
                ->paginate($this->limit)
                ->withQueryString()
        ]);
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openModalView()
    {
        $this->isOpenView = true;
    }

    public function closeModalView()
    {
        $this->isOpenView = false;
    }

    public function create()
    {
        if (auth()->user()->roles()->first()->id == 3)
            session()->flash('message', 'Unauthorized.');
        else {
            $this->resetInputFields();
            $this->openModal();
        }
    }

    public function updatedResume()
    {
        $this->validate([
            'resume' => 'required|mimetypes:application/pdf|max:5120'
        ]);
        $this->resumeFile = null;
    }

    public function store()
    {
        $validation = [
            'name' => 'required',
            'education' => 'required',
            'birthday' => 'required|date',
            'experience' => 'required',
            'last_position' => 'required',
            'applied_position' => 'required',
            'skills' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ];
        if (is_null($this->candidate_id))
            $validation = array_merge(
                $validation,
                ['resume' => 'required|mimetypes:application/pdf|max:5120']
            );
        $this->validate($validation);

        if (is_null($this->candidate_id)) {
            $candidate = new Candidate();
            $resumeName = md5($this->resume->getClientOriginalName() . '-' . uniqid('uploads_'));
            $resumeExtension = $this->resume->extension();
            $resumeUploadedName = "{$resumeName}.{$resumeExtension}";
            $this->resume->storeAs('uploads', $resumeUploadedName);
            $candidate->resume = $resumeUploadedName;
        } else {
            $candidate = Candidate::find($this->candidate_id);
            if ($this->resume) {
                @unlink(storage_path("app/uploads/$candidate->resume"));
                $resumeName = md5($this->resume->getClientOriginalName() . '-' . uniqid('uploads_'));
                $resumeExtension = $this->resume->extension();
                $resumeUploadedName = "{$resumeName}.{$resumeExtension}";
                $this->resume->storeAs('uploads', $resumeUploadedName);
                $candidate->resume = $resumeUploadedName;
            }
        }
        $candidate->name = $this->name;
        $candidate->education = $this->education;
        $candidate->birthday = $this->birthday;
        $candidate->experience = $this->experience;
        $candidate->last_position = $this->last_position;
        $candidate->applied_position = $this->applied_position;
        $candidate->skills = $this->skills;
        $candidate->email = $this->email;
        $candidate->phone = $this->phone;
        $candidate->save();

        session()->flash('message',
            is_null($this->candidate_id) ? 'Candidate created successfully.' : 'Candidate updated successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        if (auth()->user()->roles()->first()->id == 3)
            session()->flash('message', 'Unauthorized.');
        else {
            $this->resetValidation();

            $candidate = Candidate::findOrFail($id);
            $this->candidate_id = $id;
            $this->name = $candidate->name;
            $this->education = $candidate->education;
            $this->birthday = $candidate->birthday;
            $this->experience = $candidate->experience;
            $this->last_position = $candidate->last_position;
            $this->applied_position = $candidate->applied_position;
            $this->skills = $candidate->skills;
            $this->email = $candidate->email;
            $this->phone = $candidate->phone;
            $this->resumeFile = $candidate->resume;

            $this->openModal();
        }
    }

    public function view($id)
    {
        $candidate = Candidate::findOrFail($id);
        $this->candidate_id = $id;
        $this->name = $candidate->name;
        $this->education = $candidate->education;
        $this->birthday = $candidate->birthday;
        $this->experience = $candidate->experience;
        $this->last_position = $candidate->last_position;
        $this->applied_position = $candidate->applied_position;
        $this->skills = $candidate->skills;
        $this->email = $candidate->email;
        $this->phone = $candidate->phone;
        $this->resume = $candidate->resume;

        $this->openModalView();
    }

    public function delete($id)
    {
        if (auth()->user()->roles()->first()->id == 3)
            session()->flash('message', 'Unauthorized.');
        else {
            $candidate = Candidate::find($id);
            $candidate->delete();
            @unlink(storage_path("app/uploads/{$candidate->resume}"));

            session()->flash('message', 'Candidate deleted successfully.');
        }
    }

    public function download($file)
    {
        return Storage::download("uploads/{$file}");
    }
}
