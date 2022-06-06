<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends BaseController
{

    /**
     * @OA\Get(
     *      path="/api/candidates",
     *      operationId="getCandidateList",
     *      tags={"CandidateList"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Get list of candidates",
     *      description="",
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request.",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function index()
    {
        return CandidateResource::collection(Candidate::all());
    }

    /**
     * @OA\Post(
     *      path="/api/candidates",
     *      operationId="postCandidateCreate",
     *      tags={"CandidateCreate"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Create a candidate",
     *      description="",
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "education", "birthday", "experience", "last_position", "applied_position", "skills", "email", "phone", "resume"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="education", type="text"),
     *               @OA\Property(property="birthday", type="text"),
     *               @OA\Property(property="experience", type="text"),
     *               @OA\Property(property="last_position", type="text"),
     *               @OA\Property(property="applied_position", type="text"),
     *               @OA\Property(property="skills", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="phone", type="text"),
     *               @OA\Property(property="resume", type="text")
     *            ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful Operation.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request.",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'education' => 'required',
                'birthday' => 'required|date',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'skills' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'resume' => 'required',
            ]);
            if ($validator->fails())
                throw new ApiErrorException([
                    'message' => 'Validation Errors.',
                    'errors' => $validator->errors()
                ], 400);

            $resume = base64_decode($request->resume);
            $resumeName = md5($request->name . '-' . uniqid('uploads_'));
            $resumeTemp = storage_path("app/upload-tmp/{$resumeName}");
            file_put_contents($resumeTemp, $resume);

            /* checking image extension */
            if (mime_content_type($resumeTemp) != 'application/pdf') {
                unlink($resumeTemp);
                throw new ApiErrorException([
                    'message' => 'Validation Errors.',
                    'errors' => [
                        'resume' => ['Resume must be the base_64 encoded PDF (mimetype: application/pdf).']
                    ]
                ], 400);
            }
            if (filesize($resumeTemp) > 5242880) { // 1MB = 1048576 bytes
                unlink($resumeTemp);
                throw new ApiErrorException([
                    'message' => 'Validation Errors.',
                    'errors' => [
                        'resume' => ['File size cannot exceed (must be 5MB).']
                    ]
                ], 400);
            };
            unlink($resumeTemp);
            file_put_contents(storage_path("app/uploads/{$resumeName}.pdf"), $resume);

            $candidate = new Candidate();
            $candidate->name = $request->name;
            $candidate->education = $request->education;
            $candidate->birthday = $request->birthday;
            $candidate->experience = $request->experience;
            $candidate->last_position = $request->last_position;
            $candidate->applied_position = $request->applied_position;
            $candidate->skills = $request->skills;
            $candidate->email = $request->email;
            $candidate->phone = $request->phone;
            $candidate->resume = "{$resumeName}.pdf";
            $candidate->save();

            return response()->json([
                'status_code' => 201,
                'status_message' => 'Candidate Created Successfully.',
                'data' => new CandidateResource($candidate)
            ], 201);
        } catch (ApiErrorException $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getData()->message,
                'errors' => $e->getData()->errors
            ], $this->responseErrorCode($e->getCode()));
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getMessage()
            ], $this->responseErrorCode($e->getCode()));
        }
    }

    /**
     * @OA\Get(
     *      path="/api/candidates/{id}",
     *      operationId="getCandidateDetail",
     *      tags={"CandidateDetail"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Get the candidate details",
     *      description="",
     *      @OA\Parameter(
     *         description="ID of Candidate",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found.",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $candidate = Candidate::find($id);
            if (is_null($candidate)) throw new \Exception('Candidate Not Found.', 404);

            return new CandidateResource($candidate);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getMessage()
            ], $this->responseErrorCode($e->getCode()));
        }
    }

    /**
     * @OA\Put(
     *      path="/api/candidates/{id}",
     *      operationId="putCandidateUpdate",
     *      tags={"CandidateUpdate"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Update a candidate",
     *      description="",
     *      @OA\Parameter(
     *         description="ID of Candidate",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *      ),
     *      @OA\RequestBody(
     *         @OA\JsonContent(),
     *
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found.",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function update(Request $request, $id)
    {
        try {
            $candidate = Candidate::find($id);
            if (is_null($candidate)) throw new \Exception('Candidate Not Found.', 404);

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'education' => 'required',
                'birthday' => 'required|date',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'skills' => 'required',
                'email' => 'required|email',
                'phone' => 'required'
            ]);
            if ($validator->fails())
                throw new ApiErrorException([
                    'message' => 'Validation Errors.',
                    'errors' => $validator->errors()
                ], 400);

            $candidate->name = $request->name;
            $candidate->education = $request->education;
            $candidate->birthday = $request->birthday;
            $candidate->experience = $request->experience;
            $candidate->last_position = $request->last_position;
            $candidate->applied_position = $request->applied_position;
            $candidate->skills = $request->skills;
            $candidate->email = $request->email;
            $candidate->phone = $request->phone;
            // $candidate->resume = $request->resume;
            $candidate->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Candidate Updated Successfully.',
                'data' => new CandidateResource($candidate)
            ]);
        } catch (ApiErrorException $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getData()->message,
                'errors' => $e->getData()->errors
            ], $this->responseErrorCode($e->getCode()));
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getMessage()
            ], $this->responseErrorCode($e->getCode()));
        }
    }

     /**
     * @OA\Delete(
     *      path="/api/candidates/{id}",
     *      operationId="deleteCandidate",
     *      tags={"DeleteCandidate"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Update a candidate",
     *      description="",
     *      @OA\Parameter(
     *         description="ID of Candidate",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated.",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found.",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function destroy($id)
    {
        try {
            $candidate = Candidate::find($id);
            $candidate->delete();
            @unlink(storage_path("app/uploads/{$candidate->resume}"));

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Candidate Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getMessage()
            ], $this->responseErrorCode($e->getCode()));
        }
    }
}
