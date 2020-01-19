<?php

namespace App\Api\Controllers;

use App\Mail\SendContact;
use App\Models\Submission;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/submissions/contact",
     *     tags={"submissions"},
     *     operationId="contact",
     *     summary="Store contact submission",
     *     description="Store contact submission",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Submission data",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "email", "type", "request_limit", "message"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nom"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Email"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Type",
     *                     enum={"personal", "business"}
     *                 ),
     *                 @OA\Property(
     *                     property="request_limit",
     *                     type="string",
     *                     description="Request limit",
     *                     enum={"1000", "5000", "10000", "25000"}
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     description="Address"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     description="City"
     *                 ),
     *                 @OA\Property(
     *                     property="zip",
     *                     type="string",
     *                     description="Zip"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     description="Phone"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Message"
     *                 ),
     *                 @OA\Property(
     *                     property="g-recaptcha-response",
     *                     type="string",
     *                     description="Message"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    public function contact(Request $request)
    {
        $validated = $this->validate($request, [
            'name'                 => 'required',
            'email'                => 'required|email',
            'type'                 => 'required|in:personal,business',
            'request_limit'        => 'required|in:1000,5000,10000,25000',
            'address'              => 'nullable',
            'city'                 => 'nullable',
            'zip'                  => 'nullable',
            'phone'                => 'nullable',
            'message'              => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        Submission::create(['type' => 'contact', 'data' => $request->except('g-recaptcha-response')]);
        Mail::send(new SendContact($validated));

        return [
            'message' => 'Your demand was successfully submitted !',
        ];
    }
}
