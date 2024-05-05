<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPassword\CheckResetCodeRequest;
use App\Http\Requests\Auth\ForgotPassword\ForgotPasswordRequest;
use App\Http\Requests\Auth\ForgotPassword\ResetPasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Mail\Auth\ForgotPassword\SendCodeMail;
use App\Repositories\ResetPasswordRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function __construct(
        private readonly ResetPasswordRepositoryInterface $passwordRepository,
        private readonly UserRepositoryInterface          $userRepository
    )
    {
    }

    public function forgotPassword(ForgotPasswordRequest $request): SuccessResource
    {
        $validated = $request->validated();
        $code = $this->passwordRepository->updateOrCreate(['email' => $validated['email']], ['code' => rand(100000, 999999)]);

        Mail::to($code->email)->send(new SendCodeMail($code));

        return SuccessResource::make([
            'message' => trans('message.email_send')
        ]);
    }

    public function checkResetCode(CheckResetCodeRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $resetData = $this->passwordRepository->findByEmail($data['email']);
        $code = intval($resetData->code);
        if ($code === $data['code']) {
            return SuccessResource::make([
                'message' => trans('message.success')
            ]);
        }
        return ErrorResource::make([
            'message' => trans('message.not_found')
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $code = $this->passwordRepository->findByEmail($data['email']);

        if (!$code) {
            return ErrorResource::make([
                'message' => trans('passwords.token')
            ]);
        }
        $user = $this->userRepository->findByEmail($data['email']);

        $this->userRepository->update($user->id, [
            'password' => $data['password']
        ]);

        $this->passwordRepository->delete($code->id);

        return SuccessResource::make([
            'message' => trans('passwords.reset')
        ]);
    }
}
