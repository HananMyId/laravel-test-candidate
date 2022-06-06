<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    private $data = [
        [
            'name' => 'Smith',
            'education' => 'UGM Yogyakarta',
            'birthday' => '1991-01-19',
            'experience' => '5 Years',
            'last_position' => 'Backend Developer',
            'applied_position' => 'Senior PHP Developer',
            'skills' => 'Laravel, Mysql, PostgreSQL, Codeigniter, Java',
            'email' => 'smith@example.com',
            'phone' => '08123456789'
        ],
        [
            'name' => 'Rama',
            'education' => 'Universitas Indonesia',
            'birthday' => '1992-11-14',
            'experience' => '10 Years',
            'last_position' => 'Human Resources',
            'applied_position' => 'Finance',
            'skills' => 'Laravel, Mysql, PostgreSQL, Codeigniter, Java',
            'email' => 'rama@example.com',
            'phone' => '0814798260'
        ],
        [
            'name' => 'Maggie Archer',
            'education' => 'Rutgers University',
            'birthday' => '1993-10-04',
            'experience' => '2 Years',
            'last_position' => 'Marketing',
            'applied_position' => 'Executive Director',
            'skills' => 'Marketing, IT, Human Resources, Finance, Accounting',
            'email' => 'maggie@example.com',
            'phone' => '08172687902'
        ],
        [
            'name' => 'Hanna',
            'education' => 'Duke University',
            'birthday' => '1980-11-14',
            'experience' => '10 Years',
            'last_position' => 'Executive Director',
            'applied_position' => 'Executive Director',
            'skills' => 'Marketing, IT, Human Resources, Finance, Accounting',
            'email' => 'hanna@example.com',
            'phone' => '08158543209'
        ],
        [
            'name' => 'Marigold',
            'education' => 'Harvard University',
            'birthday' => '1998-03-23',
            'experience' => '15 Years',
            'last_position' => 'Backend Developer',
            'applied_position' => 'Senior PHP Developer',
            'skills' => 'Marketing, IT, Human Resources, Finance, Accounting',
            'email' => 'marigold@example.com',
            'phone' => '08123456789'
        ],
    ];

    public function testCandidateResumeMustBePdf()
    {
        $user = User::factory()->create();

        $data = array_merge(
            $this->data[0],
            ['resume' => file_get_contents(storage_path('samples/plain.txt'))]
        );

        $this->actingAs($user, 'api')
            ->json('POST', 'api/candidates', $data, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'status_code' => 400,
                'status_message' => 'Validation Errors.',
                'errors' => [
                    'resume' => ['Resume must be the base_64 encoded PDF (mimetype: application/pdf).']
                ]
            ], false)
        ;
    }

    public function testCandidateCreatedSuccessfully()
    {
        $user = User::factory()->create();

        $candidate = $this->data[rand(0, count($this->data) - 1)];
        $data = array_merge(
            $candidate,
            ['resume' => file_get_contents(storage_path('samples/pdf-base64.txt'))]
        );

        $this->actingAs($user, 'api')
            ->json('POST', 'api/candidates', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                'status_code' => 201,
                'status_message' => 'Candidate Created Successfully.',
                'data' => $candidate
            ], false)
        ;
    }

    public function testCandidateListedSuccessfully()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api')
            ->json('GET', 'api/candidates', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'education',
                        'birthday',
                        'experience',
                        'last_position',
                        'applied_position',
                        'skills',
                        'email',
                        'phone',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function testRetrieveCandidateNotFound()
    {
        $user = User::factory()->create();
        $id = 1001;

        $this->actingAs($user, 'api')
            ->json('GET', "api/candidates/{$id}", ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                'status_code' => 404,
                'status_message' => 'Candidate Not Found.',
            ]);
    }

    public function testRetrieveCandidateSuccessfully()
    {
        $user = User::factory()->create();
        $candidates = Candidate::whereRaw('1=1')->get();
        $id = $candidates->last()->id;

        $this->actingAs($user, 'api')
            ->json('GET', "api/candidates/{$id}", ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'education',
                    'birthday',
                    'experience',
                    'last_position',
                    'applied_position',
                    'skills',
                    'email',
                    'phone',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testCandidateUpdatedSuccessfully()
    {
        $user = User::factory()->create();

        $candidates = Candidate::whereRaw('1=1')->get();
        $id = $candidates->last()->id;

        $candidate = $this->data[rand(0, count($this->data) - 1)];

        $this->actingAs($user, 'api')
            ->json('PUT', "api/candidates/{$id}", $candidate, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
                'status_message' => 'Candidate Updated Successfully.',
                'data' => $candidate
            ], false)
        ;
    }

    public function testCandidateDeletedSuccessfully()
    {
        $user = User::factory()->create();
        $candidates = Candidate::whereRaw('1=1')->get();
        $id = $candidates->last()->id;

        $this->actingAs($user, 'api')
            ->json('DELETE', "api/candidates/{$id}", ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
                'status_message' => 'Candidate Deleted Successfully.',
            ]);

    }
}
